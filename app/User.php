<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use App\Models\Patient;
use App\Models\Doctor;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];



    public function tokens()
    {
        return $this->hasMany('App\Models\Token');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }


    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }

        return false;
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                return $this->hasRole($role);
            }
        } else {
            return $this->hasRole($roles);
        }
    }

    public function isPatient()
    {
        if ($this->hasRole('patient')) {
            return Patient::where('user_id', $this->id)->first();
        }
        return false;
    }

    public function isDoctor()
    {
        if ($this->hasRole('doctor')) {
            return Doctor::where('user_id', $this->id)->first();
        }
        return false;
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }
}
