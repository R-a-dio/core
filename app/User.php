<?php

namespace App;

use App\Traits\AliasedFields;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, AliasedFields;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * alias => original.
     *
     * @var array
     */
    protected $aliases = [
        'password' => 'pass',
        'username' => 'user',
        'dj_id' => 'djid',
    ];

    /**
     * The types we should cast attributes to
     *
     * @var array
     */
    protected $casts = [
        'admin' => 'boolean',
    ];

    /**
     * The DJ associated with this user.
     *
     * It should be a HasOne relationship; blame Vin.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dj()
    {
        return $this->belongsTo(DJ::class, 'djid');
    }
}
