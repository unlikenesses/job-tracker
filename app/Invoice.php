<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
    	'client_id', 'name', 'invoiced', 'due', 'paid', 'currency_id', 'amount', 'bank_id'
    ];

    public static function nomenclature() {
        return [
            'client_id'   => 'Client',
            'currency_id' => 'Currency',
            'bank_id'     => 'Bank'
        ];
    }

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

    public function scopeSearch($query, $keyword)
    {
        if ($keyword != '') {
            $query->where('invoices.name', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('clients.name', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('jobs.name', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('projects.name', 'LIKE', '%' . $keyword . '%')
                  ->join('jobs', 'invoices.id', '=', 'jobs.invoice_id')
                  ->join('projects', 'jobs.project_id', '=', 'projects.id')
                  ->join('clients', 'invoices.client_id', '=', 'clients.id');
        }
        return $query;
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
