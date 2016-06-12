<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Job;
use App\Client;
use App\Project;
use App\Currency;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class JobsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Job::orderBy('created_at', 'desc')->get();
        $data = [
            'rows'   => $rows,
            'title'  => 'All',
            'values' => $this->totalValue($rows)
            ];
        return view('admin.jobs.index', $data);
    }

    /**
     * Display a list of open jobs.
     *
     * @return \Illuminate\Http\Response
     */
    public function open()
    {
        $rows = Job::open()->orderBy('created_at', 'desc')->get();
        $data = [
            'rows'   => $rows,
            'title'  => 'Open',
            'values' => $this->totalValue($rows)
            ];
        return view('admin.jobs.index', $data);
    }

    /**
     * Display a list of completed jobs.
     *
     * @return \Illuminate\Http\Response
     */
    public function completed()
    {
        $rows = Job::completed()->notInvoiced()->orderBy('created_at', 'desc')->get();
        $data = [
            'rows'   => $rows,
            'title'  => 'Completed, Not Invoiced',
            'values' => $this->totalValue($rows)
            ];
        return view('admin.jobs.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.jobs.create');
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
            'started'   => 'required|date',
            'completed' => 'date',
            'amount'    => 'numeric'
        ]);
        $job = new Job($request->all());
        $job->save();
        return redirect('jobs');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        return view('admin.jobs.edit', ['row' => $job]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        $this->validate($request, [
            'name'      => 'required',
            'started'   => 'required|date',
            'completed' => 'date',
            'amount'    => 'numeric'
        ]);
        $job->update($request->all());
        return redirect('jobs');
    }

    /**
     * Show a confirm delete message.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function confirmDelete(Job $job)
    {
        return view('admin.jobs.confirmDelete', ['row' => $job]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        $job->delete();
        return redirect('jobs');
    }

    /**
     * Calculate total amount of given array of jobs.
     *
     * @param array $jobs
     * @return string
     */
    public function totalValue($jobs)
    {
        $totals = '';
        $values = array();
        $currencies = Currency::get();
        foreach ($currencies as $currency) {
            $currencyAmount = 0;
            foreach ($jobs as $job) {
                if ($job->currency_id == $currency->id) $currencyAmount += $job->amount;
            }
            $values[$currency->symbol] = $currencyAmount;
        }
        foreach ($values as $symbol => $amount) {
            if ($amount > 0) $totals .= $symbol . $amount . ', ';
        }
        return trim($totals, ', ');
    }
}
