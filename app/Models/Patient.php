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

    protected $with = ['user', 'complaints'];

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
}
