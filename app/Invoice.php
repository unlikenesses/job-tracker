<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
    	'client_id', 'name', 'invoiced', 'due', 'paid', 'currency_id', 'amount'
    ];

    public function client()
    {
    	return $this->belongsTo(Client::class);
    }

    public function jobs()
    {
    	return $this->hasMany(Job::class);
    }

    public function scopeOverdue($query)
    {
        return $query->whereNotNull('invoiced')->whereNull('paid')->where('due', '<', date('Y-m-d'));
    }

    public function scopeNotDue($query)
    {
        return $query->whereNotNull('invoiced')->whereNull('paid')->where('due', '>', date('Y-m-d'));
    }
}
