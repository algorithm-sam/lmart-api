<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'specialization', 'department'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function patients()
    {
        return $this->belongsToMany(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
