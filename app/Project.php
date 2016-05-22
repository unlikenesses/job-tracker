<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
    	'client_id', 'name'
    ];

    public function client()
    {
    	return $this->belongsTo(Client::class);
    }

    public function jobs()
    {
    	return $this->hasMany(Job::class);
    }
}
