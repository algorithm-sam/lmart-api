<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Relative extends Model
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

    public function patients()
    {
        return $this->belongsToMany(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
