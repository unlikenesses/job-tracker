<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PDF;
use App\Job;
use App\Text;
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
            'rows'  => Invoice::orderBy('created_at', 'desc')->get(),
            'title' => 'All'
            );
        return view('admin.invoices.index', $data);
    }

    public function overdue()
    {
        $data = array(
            'rows'  => Invoice::overdue()->orderBy('name', 'desc')->get(),
            'title' => 'Overdue'
            );
        return view('admin.invoices.index', $data);
    }

    public function not_due()
    {
        $data = array(
            'rows'  => Invoice::notDue()->orderBy('name', 'desc')->get(),
            'title' => 'Not Due'
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
        $data = array(
            'new_invoice_number' => $this->new_number(),
            'invoiced'           => date('d-m-Y'),
            'due'                => $this->due_date()
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
        $invoice = new Invoice($request->all());
        $invoice->save();
        $this->updateInvoiceJobs($request, $invoice->id);        
        return redirect('admin/invoices');
    }

    public function updateInvoiceJobs($request, $invoiceId)
    {
        foreach ($request->jobs as $jobId)
        {
            $job = Job::findOrFail($jobId);
            $job->update([
                'invoiced'   => date('Y-m-d', strtotime($request->invoiced)),
                'invoice_id' => $invoiceId
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {   
        $data = array(
            'invoice_jobs' => Job::inInvoice($invoice->id)->get(),
            'row'          => $invoice
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
    public function update(Request $request, Invoice $invoice)
    {
        $invoice->update($request->all());
        $previousJobs = Job::inInvoice($invoice->id)->get();
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
        $this->updateInvoiceJobs($request, $invoice->id);
        return redirect('admin/invoices');
    }

    /**
     * Show a confirm delete message.
     * 
     * @param int $id 
     * @return \Illuminate\Http\Response
     */
    public function confirmDelete(Invoice $invoice)
    {
        return view('admin.invoices.confirmDelete', array('row' => $invoice));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        // Update relevant jobs:
        $previousJobs = Job::inInvoice($invoice->id)->get();
        foreach ($previousJobs as $job)
        {
            $job->update([
                'invoiced'   => NULL,
                'invoice_id' => NULL
            ]);
        }
        $invoice->delete();
        return redirect('admin/invoices');
    }

    /**
     * Return a new invoice number.
     * 
     * @return string
     */
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

    /**
     * Calculate the due date of an invoice.
     * 
     * @return string
     */
    public function due_date()
    {
        $due = date('d-m-Y', strtotime('+30 days'));
        if (date('N', strtotime('+30 days')) == 6) $due = date('d-m-Y', strtotime('+32 days'));
        if (date('N', strtotime('+30 days')) == 7) $due = date('d-m-Y', strtotime('+31 days'));
        return $due;
    }

    public function export(Invoice $invoice)
    {
        $data = array(
            'invoice' => $invoice,
            'address' => Text::findOrFail(1),
            'client'  => Client::findOrFail($invoice->client_id),
            'jobs'    => Job::inInvoice($invoice->id)->get()
        );
        $footer = Text::findOrFail(2);
        PDF::setOption('footer-html', '<!doctype html><body style="font-family:Arial">' . $footer->body . '</body></html>');
        $pdf = PDF::loadView('admin.pdf.invoice', $data);
        return $pdf->download($invoice->name . '.pdf');
    }
}