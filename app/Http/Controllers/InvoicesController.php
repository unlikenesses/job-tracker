<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Job;
use App\Client;
use App\Invoice;
use App\Project;
use App\Currency;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class InvoicesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'rows' => Invoice::orderBy('name', 'desc')->get()
            );
        return view('admin.invoices.index', $data);
    }

    public function overdue()
    {
        $data = array(
            'rows' => Invoice::overdue()->orderBy('name', 'desc')->get()
            );
        return view('admin.invoices.index', $data);
    }

    public function not_due()
    {
        $data = array(
            'rows' => Invoice::notDue()->orderBy('name', 'desc')->get()
            );
        return view('admin.invoices.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects_full = Project::orderBy('name', 'asc')->get();
        $projects = array();
        foreach ($projects_full as $project)
        {
            $projects[$project->id] = $project->name;
        }
        $currencies_full = Currency::orderBy('name', 'desc')->get();
        $currency_symbols = array();
        foreach ($currencies_full as $currency)
        {
            $currency_symbols[$currency->id] = $currency->symbol;
        }
        $data = array(
            'fields'     => array('name', 'invoiced', 'due', 'paid', 'amount', 'currency_id'),
            'jobs'       => Job::completed()->notInvoiced()->orderBy('completed', 'desc')->get(),
            'clients'    => Client::orderBy('name', 'asc')->get(),
            'currencies' => Currency::orderBy('name', 'desc')->get(),
            'projects'   => $projects,
            'currency_symbols' => $currency_symbols,
            'new_invoice_number' => $this->new_number(),
            'invoiced' => date('d-m-Y'),
            'due' => $this->due_date()
            );
        return view('admin.invoices.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $invoice = new Invoice;
        $client_id = 0;
        foreach ($request->jobs as $job_id)
        {
            $job = Job::findOrFail($job_id);
            $client_id = $job->client_id;
        }
        $invoice->client_id = $client_id;
        $invoice->name = $request->name;
        $invoice->invoiced = date('Y-m-d', strtotime($request->invoiced));
        $invoice->due = ($request->due != '') ? date('Y-m-d', strtotime($request->due)) : NULL;
        $invoice->paid = ($request->paid != '') ? date('Y-m-d', strtotime($request->paid)) : NULL;
        $invoice->amount = $request->amount;
        $invoice->currency_id = $request->currency_id;
        $invoice->save();
        // Now update the jobs:
        foreach ($request->jobs as $job_id)
        {
            $job = Job::findOrFail($job_id);
            $job->update([
                'invoiced'   => date('Y-m-d', strtotime($request->invoiced)),
                'invoice_id' => $invoice->id
            ]);
        }
        return redirect('admin/invoices');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $projects_full = Project::orderBy('name', 'asc')->get();
        $projects = array();
        foreach ($projects_full as $project)
        {
            $projects[$project->id] = $project->name;
        }
        $currencies_full = Currency::orderBy('name', 'desc')->get();
        $currency_symbols = array();
        foreach ($currencies_full as $currency)
        {
            $currency_symbols[$currency->id] = $currency->symbol;
        }
        $row = Invoice::findOrFail($id);
        $data = array(
            'fields'           => array('name', 'invoiced', 'due', 'paid', 'amount', 'currency_id'),
            'jobs'             => Job::completed()->notInvoiced()->orderBy('completed', 'desc')->get(),
            'invoice_jobs'     => Job::inInvoice($row->id)->get(),
            'clients'          => Client::orderBy('name', 'asc')->get(),
            'currencies'       => Currency::orderBy('name', 'desc')->get(),
            'projects'         => $projects,
            'currency_symbols' => $currency_symbols,
            'row'              => $row
            );
        return view('admin.invoices.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $row = Invoice::findOrFail($id);
        $client_id = 0;
        foreach ($request->jobs as $job_id)
        {
            $job = Job::findOrFail($job_id);
            $client_id = $job->client_id;
        }
        $row->update([
            'client_id'   => $client_id,
            'name'        => $request->name,
            'invoiced'    => date('Y-m-d', strtotime($request->invoiced)),
            'due'         => ($request->due != '') ? date('Y-m-d', strtotime($request->due)) : NULL,
            'paid'        => ($request->paid != '') ? date('Y-m-d', strtotime($request->paid)) : NULL,
            'amount'      => $request->amount,
            'currency_id' => $request->currency_id,
        ]);
        // Now update the jobs:
        // First remove any that were on this invoice:
        $previousJobs = Job::inInvoice($row->id)->get();
        foreach ($previousJobs as $job)
        {
            if ( ! in_array($job->id, $request->jobs))
            {
                $job->update([
                    'invoiced'   => NULL,
                    'invoice_id' => NULL
                ]);
            }
        }
        // Now add the invoice to the sent jobs:
        foreach ($request->jobs as $job_id)
        {
            $job = Job::findOrFail($job_id);
            $job->update([
                'invoiced'   => date('Y-m-d', strtotime($request->invoiced)),
                'invoice_id' => $id
            ]);
        }
        return redirect('admin/invoices');
    }

    /**
     * Show a confirm delete message.
     * 
     * @param int $id 
     * @return \Illuminate\Http\Response
     */
    public function confirmDelete($id)
    {
        $row = Invoice::findOrFail($id);
        $data = array(
            'row'          => $row
            );
        return view('admin.invoices.confirmDelete', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Update relevant jobs:
        $previousJobs = Job::inInvoice($id)->get();
        foreach ($previousJobs as $job)
        {
            $job->update([
                'invoiced'   => NULL,
                'invoice_id' => NULL
            ]);
        }
        $row = Invoice::findOrFail($id);
        $row->delete();
        return redirect('admin/invoices');
    }

    public function new_number()
    {
        $invoice_year = '';
        $invoice_number = 0;
        $current_year = date('Y');
        $invoice = Invoice::where('name', 'LIKE', "%$current_year%")->orderBy('name', 'desc')->first();
        if ($invoice)
        {
            list($invoice_year, $invoice_number) = explode('-', $invoice->name);
        } 
        if ($invoice_year == $current_year)
        {
            $new_invoice_year = $invoice_year;
            $new_invoice_number = sprintf('%03d', (intval($invoice_number) + 1));
        }
        else
        {
            $new_invoice_year = $current_year;
            $new_invoice_number = '001';
        }
        return $new_invoice_year . '-' . $new_invoice_number;
    }

    public function due_date()
    {
        $due = date('d-m-Y', strtotime('+30 days'));
        if (date('N', strtotime('+30 days')) == 6) $due = date('d-m-Y', strtotime('+32 days'));
        if (date('N', strtotime('+30 days')) == 7) $due = date('d-m-Y', strtotime('+31 days'));
        return $due;
    }

    public function export($id)
    {
        $invoice = Invoice::findOrFail($id);

    }
}