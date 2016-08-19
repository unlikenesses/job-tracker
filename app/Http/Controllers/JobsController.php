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
        // Ordering hints from http://stackoverflow.com/a/31711803
        $allRows = Job::orderBy(\DB::raw('-completed'), 'asc')->get();
        $rows = Job::orderBy(\DB::raw('-completed'), 'asc')->paginate(10);
        $data = [
            'rows'   => $rows,
            'title'  => 'All',
            'values' => $this->totalValue($allRows)
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
        $allRows = Job::open()->latest()->get();
        $rows = Job::open()->latest()->paginate(10);
        $data = [
            'rows'   => $rows,
            'title'  => 'Open',
            'values' => $this->totalValue($allRows)
            ];
        return view('admin.jobs.index', $data);
    }

    /**
     * Display a list of completed, uninvoiced jobs.
     *
     * @return \Illuminate\Http\Response
     */
    public function completed()
    {
        $allRows = Job::completed()->notInvoiced()->latest()->get();
        $rows = Job::completed()->notInvoiced()->latest()->paginate(10);
        $data = [
            'rows'   => $rows,
            'title'  => 'Completed, Not Invoiced',
            'values' => $this->totalValue($allRows)
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
        $data = [
            'row'     => $job,
            'client'  => Client::find($job->client_id)->name,
            'project' => Project::find($job->project_id)->name
        ];
        return view('admin.jobs.confirmDelete', $data);
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
        $currencies = Currency::get();
        foreach ($currencies as $currency) {
            $currencyAmount = 0;
            foreach ($jobs as $job) {
                if ($job->currency_id == $currency->id) {
                    $currencyAmount += $job->amount;
                }
            }
            $values[$currency->symbol] = $currencyAmount;
        }
        foreach ($values as $symbol => $amount) {
            if ($amount > 0) $totals .= $symbol . $amount . ', ';
        }
        return trim($totals, ', ');
    }

    /**
     * Search jobs for posted keyword.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $searchTerm = $request->searchTerm;
        $allSearchResults = Job::Search($searchTerm)->select(['jobs.*'])->get();
        // dd($allSearchResults);
        $searchResults = Job::Search($searchTerm)->select(['jobs.*'])->paginate(10);
        $data = [
            'rows'   => $searchResults,
            'title'  => 'Search Results for "' . $searchTerm . '"',
            'values' => $this->totalValue($allSearchResults)
            ];
        return view('admin.jobs.index', $data);
    }

    /**
     * Return JSON array of jobs for a posted clientId.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $rows = Job::forClient($request->clientId)->get();
        foreach ($rows as $row) {
            $response[] = [
                'id'             => $row->id,
                'client'         => Client::find($row->client_id)->name,
                'project'        => Project::find($row->project_id)->name,
                'name'           => $row->name,
                'started'        => $row->started,
                'completed'      => $row->completed,
                'currencySymbol' => Currency::find($row->currency_id)->symbol,
                'amount'         => $row->amount
            ];
        }
        return response()->json($response);
    }
}
