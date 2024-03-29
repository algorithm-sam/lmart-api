<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    ];

    protected $with = ['user'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    protected $hidden = [];

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class);
    }

    public function relatives()
    {
        return $this->belongsToMany(Relative::class);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function diagnosis()
    {
        return $this->hasMany(Diagnosis::class);
    }

    public function treatments()
    {
        return $this->hasMany(Treatment::class);
    }
}
