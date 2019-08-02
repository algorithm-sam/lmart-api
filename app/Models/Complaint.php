<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // 'complaint',
    protected $guarded = [];

    protected $with = ['patient', 'diagnosis'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function diagnosis()
    {
        return $this->hasMany(Diagnosis::class);
    }
}
