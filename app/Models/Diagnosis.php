<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reason', 'diagnosis', 'complaint_id'
    ];

    protected $with = ['complaint', 'treatments'];

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

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }


    public function treatments()
    {
        return $this->hasMany(Treatment::class);
    }
}
