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

    public function setInvoicedAttribute($value)
    {
        $this->attributes['invoiced'] = date('Y-m-d', strtotime($value));
    }

    public function setDueAttribute($value)
    {
        $this->attributes['due'] = ($value != '') ? date('Y-m-d', strtotime($value)) : NULL;
    }

    public function setPaidAttribute($value)
    {
        $this->attributes['paid'] = ($value != '') ? date('Y-m-d', strtotime($value)) : NULL;
    }

    public function getInvoicedAttribute($value)
    {
        return ($value != '') ? date('d-m-Y', strtotime($value)) : NULL;
    }

    public function getDueAttribute($value)
    {
        return ($value != '') ? date('d-m-Y', strtotime($value)) : NULL;
    }

    public function getPaidAttribute($value)
    {
        return ($value != '') ? date('d-m-Y', strtotime($value)) : NULL;
    }
}
