<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Job;
use App\Bank;
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
        $rows = Invoice::latest()->get();
        $data = [
            'rows'   => $rows,
            'title'  => 'All',
            'values' => $this->totalValue($rows)
            ];
        return view('admin.invoices.index', $data);
    }

    /**
     * Display a list of overdue invoices.
     *
     * @return \Illuminate\Http\Response
     */
    public function overdue()
    {
        $rows = Invoice::overdue()->orderBy('name', 'desc')->get();
        $data = [
            'rows'   => $rows,
            'title'  => 'Overdue',
            'values' => $this->totalValue($rows)
            ];
        return view('admin.invoices.index', $data);
    }

    /**
     * Display a list of not due invoices.
     *
     * @return \Illuminate\Http\Response
     */
    public function not_due()
    {
        $rows = Invoice::notDue()->orderBy('name', 'desc')->get();
        $data = [
            'rows'   => $rows,
            'title'  => 'Not Due',
            'values' => $this->totalValue($rows)
            ];
        return view('admin.invoices.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'new_invoice_number' => $this->newNumber(),
            'invoiced'           => date('d-m-Y'),
            'due'                => $this->dueDate()
            ];
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
        $this->validate($request, [
            'name'      => 'required',
            'invoiced'  => 'required|date',
            'due'       => 'required|date',
            'amount'    => 'numeric'
        ]);
        $invoice = new Invoice($request->all());
        $invoice->save();
        if ($request->jobs) {
            $this->updateInvoiceJobs($request, $invoice->id);
        }
        return redirect('invoices');
    }

    /**
     * Update the invoice-relevant fields of jobs.
     *
     * @param request $request
     * @param string $invoiceId
     * @return void
     */
    public function updateInvoiceJobs($request, $invoiceId)
    {
        foreach ($request->jobs as $jobId) {
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
        $data = [
            'invoice_jobs' => Job::inInvoice($invoice->id)->get(),
            'row'          => $invoice
            ];
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
        $this->validate($request, [
            'name'      => 'required',
            'invoiced'  => 'required|date',
            'due'       => 'required|date',
            'amount'    => 'numeric'
        ]);
        $previousJobs = Job::inInvoice($invoice->id)->get();
        $invoice->update($request->all());
        foreach ($previousJobs as $job) {
            if ($request->jobs == null || ! in_array($job->id, $request->jobs)) {
                $job->update([
                    'invoiced'   => null,
                    'invoice_id' => null
                ]);
            }
        }
        if ($request->jobs) {
            $this->updateInvoiceJobs($request, $invoice->id);
        }
        return redirect('invoices');
    }

    /**
     * Show a confirm delete message.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function confirmDelete(Invoice $invoice)
    {
        $data = [
            'row'    => $invoice,
            'client' => Client::find($invoice->client_id)->name,
        ];
        return view('admin.invoices.confirmDelete', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $previousJobs = Job::inInvoice($invoice->id)->get();
        foreach ($previousJobs as $job) {
            $job->update([
                'invoiced'   => null,
                'invoice_id' => null
            ]);
        }
        $invoice->delete();
        return redirect('invoices');
    }

    /**
     * Return a new invoice number.
     *
     * @return string
     */
    public function newNumber()
    {
        $invoice_year = '';
        $invoice_number = 0;
        $current_year = date('Y');
        $invoice = Invoice::where('name', 'LIKE', "%$current_year%")->orderBy('name', 'desc')->first();
        if ($invoice) {
            list($invoice_year, $invoice_number) = explode('-', $invoice->name);
        }
        if ($invoice_year == $current_year) {
            $new_invoice_year = $invoice_year;
            $new_invoice_number = sprintf('%03d', (intval($invoice_number) + 1));
        } else {
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
    public function dueDate()
    {
        $due = date('d-m-Y', strtotime('+30 days'));
        if (date('N', strtotime('+30 days')) == 6) {
            $due = date('d-m-Y', strtotime('+32 days'));
        }
        if (date('N', strtotime('+30 days')) == 7) {
            $due = date('d-m-Y', strtotime('+31 days'));
        }
        return $due;
    }

    /**
     * Export a given invoice as PDF.
     *
     * @param Invoice $invoice
     * @return PDF download
     */
    public function export(Invoice $invoice)
    {
        $data = [
            'invoice' => $invoice,
            'address' => Text::findOrFail(1),
            'client'  => Client::findOrFail($invoice->client_id),
            'jobs'    => Job::inInvoice($invoice->id)->orderBy('completed', 'asc')->get()
            ];
        $bank = Bank::findOrFail($invoice->bank_id);
        $footer = Text::findOrFail(2);
        PDF::setOption('footer-html', '<!doctype html><body style="font-family:Arial">' . $bank->details . $footer->body . '</body></html>');
        $pdf = PDF::loadView('admin.pdf.invoice', $data);
        return $pdf->download($invoice->name . '.pdf');
    }

    /**
     * Calculate total amount of given array of invoices.
     *
     * @param array $invoices
     * @return string
     */
    public function totalValue($invoices)
    {
        $totals = '';
        $currencies = Currency::get();
        foreach ($currencies as $currency) {
            $currencyAmount = 0;
            foreach ($invoices as $invoice) {
                if ($invoice->currency_id == $currency->id) {
                    $currencyAmount += $invoice->amount;
                }
            }
            $values[$currency->symbol] = $currencyAmount;
        }
        foreach ($values as $symbol => $amount) {
            if ($amount > 0) {
                $totals .= $symbol . $amount . ', ';
            }
        }
        return trim($totals, ', ');
    }

    /**
     * Search invoices for posted keyword.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $searchTerm = $request->searchTerm;
        $searchResults = Invoice::Search($searchTerm)->select(['invoices.*', 'clients.name as clientName'])->get();
        $data = [
            'rows'   => $searchResults,
            'title'  => 'Search Results for "' . $searchTerm . '"',
            'values' => $this->totalValue($searchResults)
            ];
        return view('admin.invoices.index', $data);
    }
}
