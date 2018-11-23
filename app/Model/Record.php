<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'name', 'content', 'ttl', 'priority'];

    /**
     * Get the domain that owns the record.
     */
    public function domain()
    {
        return $this->belongsTo(Domain::class, 'domain_id', 'id');
    }
}
