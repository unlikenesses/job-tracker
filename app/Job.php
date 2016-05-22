<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
    	'client_id', 'project_id', 'name', 'started', 'completed', 'invoiced', 'invoice_id', 'currency_id', 'amount'
    ];

    public function client()
    {
    	return $this->belongsTo(Client::class);
    }

    public function project()
    {
    	return $this->belongsTo(Project::class);
    }

    public function invoice()
    {
    	return $this->belongsTo(Invoice::class);
    }

    public function scopeOpen($query)
    {
        return $query->whereNull('completed');
    }

    public function scopeCompleted($query)
    {
        return $query->whereNotNull('completed');
    }

    public function scopeNotInvoiced($query)
    {
        return $query->whereNull('invoiced');
    }

    public function scopeInInvoice($query, $invoice_id)
    {
        return $query->where('invoice_id', $invoice_id);
    }
}
