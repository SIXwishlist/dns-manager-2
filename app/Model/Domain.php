<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\User;

class Domain extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'name_ascii', 'password', 'soa_serial', 'soa_refresh', 'soa_retry', 'soa_expire', 'soa_ttl', 'last_zone_update'];

    protected $dates = ['last_zone_update'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name_ascii';
    }

    /**
     * Get the owner that owns the domain.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    /**
     * Get the comments for the blog post.
     */
    public function records()
    {
        return $this->hasMany(Record::class);
    }

    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getIsLoginAllowedAttribute($value)
    {
        if ($this->getAttribute('password')) {
            return true;
        }

        return false;
    }
}
