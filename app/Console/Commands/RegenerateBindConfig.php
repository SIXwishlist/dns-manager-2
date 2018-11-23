<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Domain;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class RegenerateBindConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'regenerate-bind-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $configDir = config('filesystems.disks.bind.root');
        $content = <<<EOT
// File created by DNS Manager


EOT;
        $content2 = $content;
        $master = config('dns.master');

        Domain::chunk(200, function ($domains) use (&$content, &$content2, $configDir, $master) {
            foreach ($domains as $domain) {
                $content .= <<<EOT
zone "{$domain->name_ascii}" {
\t\ttype master;
\t\tfile "$configDir/zones/db.{$domain->name_ascii}";
};


EOT;
                $content2 .= <<<EOT
zone "{$domain->name_ascii}" {
\t\ttype slave;
\t\tfile "$configDir/zones/db.{$domain->name_ascii}";
\t\tmasters { $master; };  # ns1 private IP
};


EOT;


                $domain->increment('soa_serial');
                $recordGroups = $domain->records->groupBy('type');

                $zoneContent = <<<EOT
\$ORIGIN {$domain->name_ascii}.
@\t{$domain->soa_ttl}\tIN\tSOA\t{$domain->name_ascii}.\troot.{$domain->name_ascii}.\t(
\t\t{$domain->soa_serial}\t; serial
\t\t{$domain->soa_refresh}\t; refresh
\t\t{$domain->soa_retry}\t; retry
\t\t{$domain->soa_expire}\t; expire
\t\t{$domain->soa_ttl})\t; minimum




EOT;

                // NS Records
                $zoneContent .= <<<EOT
;; NS Records

EOT;

                foreach (config('dns.nameservers') as $nameserver) {
                    $zoneContent .= "{$domain->name_ascii}.\t300\tIN\tNS\t{$nameserver}.\n";
                }

                $zoneContent .= "\n\n";

                foreach ($recordGroups as $type => $records) {
                    if (count($records) > 0)
                    {
                        $zoneContent .= ";; $type Records\n";

                        foreach ($records as $record) {
                            if ($record->ttl == 0) {
                                $record->ttl = 300;
                            }
                            
                            if ($record->name != '@') {
                                $record->name = $record->name . '.' . $domain->name_ascii . '.';
                            }
                    
                            if ($record->type == 'CNAME' or $record->type == 'MX') {
                                $record->content = $record->content . '.';
                            }

                            switch ($record->type) {
                                case 'MX':
                                    $zoneContent .= "{$record->name}\t{$record->ttl}\tIN\t{$record->type}\t{$record->priority}\t{$record->content}\n";
                                    break;

                                default:
                                    $zoneContent .= "{$record->name}\t{$record->ttl}\tIN\t{$record->type}\t{$record->content}\n";
                                    break;
                            }
                        }

                        $zoneContent .= "\n\n";
                    }
                }

                // Write config
                if (!Storage::disk('bind')->put('zones/db.' . $domain->name_ascii, $zoneContent)) {
                    throw new Exception("Can't write zone file", 1);
                }
            }
        });

        if (!Storage::disk('bind')->put('named.conf.custom', $content)) {
            throw new Exception("Can't write config file", 1);
        }

        if (!Storage::disk('bind_slave')->put('named.conf.custom', $content2)) {
            throw new Exception("Can't write config file", 1);
        }

        // Restart Bind
        @shell_exec('service bind9 restart');
    }
}
