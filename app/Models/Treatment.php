<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id', 'prescription', 'diagnosis_id'
    ];

    protected $with = ['patient'];

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
}
