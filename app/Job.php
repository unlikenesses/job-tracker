<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
    	'client_id', 'project_id', 'name', 'started', 'completed', 'invoiced', 'invoice_id', 'currency_id', 'amount'
    ];

    public static function nomenclature() {
        return [
            'client_id'   => 'Client',
            'project_id'  => 'Project',
            'currency_id' => 'Currency'
        ];
    }

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

    public function scopeInInvoice($query, $invoiceId)
    {
        return $query->where('invoice_id', $invoiceId);
    }

    public function scopeForClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    public function scopeSearch($query, $keyword)
    {
        if ($keyword != '') {
            $query->where('projects.name', 'LIKE', '%' . $keyword . '%')->join('projects', 'jobs.project_id', '=', 'projects.id')->orWhere('jobs.name', 'LIKE', '%' . $keyword . '%');
        }
        return $query;
    }

    public function setStartedAttribute($value)
    {
        $this->attributes['started'] = date('Y-m-d', strtotime($value));
    }

    public function setCompletedAttribute($value)
    {
        $this->attributes['completed'] = ($value != '') ? date('Y-m-d', strtotime($value)) : NULL;
    }

    public function getStartedAttribute($value)
    {
        return ($value != '') ? date('d-m-Y', strtotime($value)) : NULL;
    }

    public function getCompletedAttribute($value)
    {
        return ($value != '') ? date('d-m-Y', strtotime($value)) : NULL;
    }
}
