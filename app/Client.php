<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
    	'name', 'address'
    ];

    public static function nomenclature() {
        return [];
    }

    public function projects()
    {
    	return $this->hasMany(Project::class);
    }

    public function jobs()
    {
    	return $this->hasMany(Job::class);
    }

    public function invoices()
    {
    	return $this->hasMany(Invoice::class);
    }
}
