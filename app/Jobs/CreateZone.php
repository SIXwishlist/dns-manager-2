<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Model\Domain;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CreateZone implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $domain;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Domain $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->domain->last_zone_update !== null
            and $this->domain->last_zone_update->gte($this->domain->updated_at)
        ) {
            return;
        }

        $this->domain->increment('soa_serial');
        $recordGroups = $this->domain->records->groupBy('type');

        $content = <<<EOT
\$ORIGIN {$this->domain->name_ascii}.
@\t{$this->domain->soa_ttl}\tIN\tSOA\t{$this->domain->name_ascii}.\troot.{$this->domain->name_ascii}.\t(
\t\t{$this->domain->soa_serial}\t; serial
\t\t{$this->domain->soa_refresh}\t; refresh
\t\t{$this->domain->soa_retry}\t; retry
\t\t{$this->domain->soa_expire}\t; expire
\t\t{$this->domain->soa_ttl})\t; minimum




EOT;

        // NS Records
        $content .= <<<EOT
;; NS Records

EOT;

        foreach (config('dns.nameservers') as $nameserver) {
            $content .= "{$this->domain->name_ascii}.\t300\tIN\tNS\t{$nameserver}.\n";
        }

        $content .= "\n\n";

        foreach ($recordGroups as $type => $records) {
            if (count($records) > 0)
            {
                $content .= ";; $type Records\n";

                foreach ($records as $record) {
                    if ($record->ttl == 0) {
                        $record->ttl = 300;
                    }

                    if ($record->name != '@') {
                        $record->name = $record->name . '.' . $this->domain->name_ascii . '.';
                    }
                    
                    if ($record->type == 'CNAME' or $record->type == 'MX') {
                        $record->content = $record->content . '.';
                    }

                    switch ($record->type) {
                        case 'MX':
                            $content .= "{$record->name}\t{$record->ttl}\tIN\t{$record->type}\t{$record->priority}\t{$record->content}\n";
                            break;

                        default:
                            $content .= "{$record->name}\t{$record->ttl}\tIN\t{$record->type}\t{$record->content}\n";
                            break;
                    }
                }

                $content .= "\n\n";
            }
        }

        // Write config
        if (!Storage::disk('bind')->put('zones/db.' . $this->domain->name_ascii, $content)) {
            throw new Exception("Can't write zone file", 1);
        }

        $this->domain->last_zone_update = Carbon::now();
        $this->domain->save();

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
