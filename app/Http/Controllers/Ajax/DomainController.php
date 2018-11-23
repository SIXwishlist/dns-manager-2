<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecord;
use App\Http\Requests\AddDomainPassword;
use App\Model\Domain;
use App\Model\Record;
use App\Jobs\UpdateZone;

class DomainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['storeDNSRecord', 'deleteDNSRecord']]);
    }

    public function storeDNSRecord(Domain $domain, StoreRecord $request)
    {
        if (!auth()->check() and !auth()->guard('domain')->check()) {
            return abort(403);
        }

        if (auth()->check()) {
            if (!auth()->user()->can('update-domain', $domain)) {
                if (!auth()->guard('domain')->check() or !auth()->guard('domain')->user()->can('update-domain', $domain)) {
                    return abort(403);
                }
            }
        } else {
            if (!auth()->guard('domain')->check() or !auth()->guard('domain')->user()->can('update-domain', $domain)) {
                return abort(403);
            }
        }

        $data = $request->all();

        $record = new Record($data);
        $record->domain()->associate($domain);
        $record->save();
        $domain->increment('record_count');
        $domain->owner->increment('record_count');

        dispatch(new UpdateZone($domain));

        return $record;
    }

    public function deleteDNSRecord(Domain $domain, Record $record, Request $request)
    {
        if (!auth()->check() and !auth()->guard('domain')->check()) {
            return abort(403);
        }

        if (auth()->check()) {
            if (!auth()->user()->can('update-domain', $domain)) {
                if (!auth()->guard('domain')->check() or !auth()->guard('domain')->user()->can('update-domain', $domain)) {
                    return abort(403);
                }
            }
        } else {
            if (!auth()->guard('domain')->check() or !auth()->guard('domain')->user()->can('update-domain', $domain)) {
                return abort(403);
            }
        }

        $record->delete();
        $domain->decrement('record_count');
        $domain->owner->decrement('record_count');

        dispatch(new UpdateZone($domain));

        return ['success' => true];
    }

    public function updateDNSRecord(Domain $domain, Record $record, Request $request)
    {
        if (!auth()->check() and !auth()->guard('domain')->check()) {
            return abort(403);
        }

        if (auth()->check()) {
            if (!auth()->user()->can('update-domain', $domain)) {
                if (!auth()->guard('domain')->check() or !auth()->guard('domain')->user()->can('update-domain', $domain)) {
                    return abort(403);
                }
            }
        } else {
            if (!auth()->guard('domain')->check() or !auth()->guard('domain')->user()->can('update-domain', $domain)) {
                return abort(403);
            }
        }

        $record->update($request->all());

        dispatch(new UpdateZone($domain));

        return ['success' => true];
    }

    public function delete(Domain $domain, Request $request)
    {
        $this->authorize('delete-domain', $domain);

        $domain->delete();
        $domain->owner->decrement('domain_count');
        $domain->owner->decrement('record_count', $domain->record_count);

        return ['success' => true];
    }

    public function addPassword(Domain $domain, AddDomainPassword $request)
    {
        $this->authorize('update-domain', $domain);

        $domain->password = bcrypt($request->input('password'));
        $domain->save();

        return ['success' => true];
    }

    public function removePassword(Domain $domain)
    {
        $this->authorize('update-domain', $domain);

        $domain->password = null;
        $domain->save();

        return ['success' => true];
    }
}
