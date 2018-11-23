<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Model\Domain;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getMaxDomainsAttribute($value)
    {
        if (is_null($value)) {
            return '∞';
        }

        return $value;
    }

    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getMaxRecordsAttribute($value)
    {
        if (is_null($value)) {
            return '∞';
        }

        return $value;
    }
    
    /**
     * Get the comments for the blog post.
     */
    public function domains()
    {
        return $this->hasMany(Domain::class, 'owner_id', 'id');
    }
}
