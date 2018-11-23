<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreDomain;
use App\User;
use App\Model\Domain;
use App\Model\Record;
use App\Jobs\CreateZone;
use App\Mail\DomainAdded;
use App\Mail\RequestChangeNSRecord;
use Illuminate\Support\Facades\Mail;

class DomainController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->is_admin) {
            $domains = Domain::orderBy('created_at', 'desc');
        } else {
            $domains = Domain::where('owner_id', auth()->id())->orderBy('created_at', 'desc');
        }

        if ($request->has('q')) {
            $domains = $domains->where('name', 'like', '%' . $request->input('q') . '%');
        }

        $domains = $domains->paginate(20);

        return view('domain/list', compact('domains'));
    }

    public function add(Request $request)
    {
        $users = User::all();

        return view('domain/add', compact('users'));
    }

    public function store(StoreDomain $request)
    {
        $data = $request->all();
        $data['name_ascii'] = idn_to_ascii($data['name']);
        $opassword = '';

        if ($data['password']) {
            $opassword = $data['password'];
            $data['password'] = bcrypt($data['password']);
        }

        $data['soa_serial'] = 1;
        $data['soa_refresh'] = 7200;
        $data['soa_retry'] = 3600;
        $data['soa_expire'] = 86400;
        $data['soa_ttl'] = 3600;

        $domain = new Domain($data);

        if (auth()->user()->is_admin and isset($data['user_id']) and $data['user_id']) {
            $domain->owner()->associate($data['user_id']);
        } else {
            $domain->owner()->associate($request->user());
        }

        $domain->save();
        $domain->owner()->increment('domain_count');

        dispatch(new CreateZone($domain));
        Mail::to($request->user())
            ->queue(new DomainAdded($domain, $opassword));

        return redirect()->route('domain::list');
    }

    public function dns2(Request $request)
    {
        $domain = auth()->guard('domain')->user();
        $records = Record::where('domain_id', $domain->id)->orderBy('type', 'asc')->orderBy('created_at', 'desc')->paginate(50);

        return view('domain/dns-records', compact('domain', 'records'));
    }

    public function dns(Domain $domain, Request $request)
    {
        $this->authorize('update-domain', $domain);

        $records = Record::where('domain_id', $domain->id)->orderBy('type', 'asc')->orderBy('created_at', 'desc')->paginate(50);

        return view('domain/dns-records', compact('domain', 'records'));
    }

    public function updateNSRecord(Domain $domain, Request $request)
    {
        Mail::to('imhuytq@gmail.com')
            ->queue(new RequestChangeNSRecord($domain, $request->input('ns1'), $request->input('ns2'), $request->input('note')));

        return redirect()->back()->withStatus('Gửi yêu cầu thành công');
    }
}
