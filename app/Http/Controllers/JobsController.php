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
        $data = array(
            'rows'  => Job::orderBy('created_at', 'desc')->get(),
            'title' => 'All'
            );
        return view('admin.jobs.index', $data);
    }

    public function open()
    {
        $data = array(
            'rows'  => Job::open()->orderBy('created_at', 'desc')->get(),
            'title' => 'Open'
            );
        return view('admin.jobs.index', $data);   
    }

    public function completed()
    {
        $data = array(
            'rows'  => Job::completed()->notInvoiced()->orderBy('created_at', 'desc')->get(),
            'title' => 'Completed, Not Invoiced'
            );
        return view('admin.jobs.index', $data);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'fields'     => array('client_id', 'project_id', 'name', 'started', 'completed', 'amount', 'currency_id'),
            'clients'    => Client::orderBy('name', 'asc')->get(),
            'projects'   => Project::orderBy('name', 'asc')->get(),
            'currencies' => Currency::orderBy('name', 'desc')->get()
            );
        return view('admin.jobs.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $job = new Job;
        $job->client_id = $request->client_id;
        $job->project_id = $request->project_id;
        $job->name = $request->name;
        $job->started = date('Y-m-d', strtotime($request->started));
        $job->completed = ($request->completed != '') ? date('Y-m-d', strtotime($request->completed)) : NULL;
        $job->amount = $request->amount;
        $job->currency_id = $request->currency_id;
        $job->save();
        return redirect('admin/jobs');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        $data = array(
            'fields'     => array('client_id', 'project_id', 'name', 'started', 'completed', 'amount', 'currency_id'),
            'clients'    => Client::orderBy('name', 'asc')->get(),
            'projects'   => Project::orderBy('name', 'asc')->get(),
            'currencies' => Currency::orderBy('name', 'desc')->get(),
            'row'        => $job
            );
        return view('admin.jobs.edit', $data);
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
        $job->update([
            'client_id'   => $request->client_id,
            'project_id'  => $request->project_id,
            'name'        => $request->name,
            'started'     => date('Y-m-d', strtotime($request->started)),
            'completed'   => ($request->completed != '') ? date('Y-m-d', strtotime($request->completed)) : NULL,
            'amount'      => $request->amount,
            'currency_id' => $request->currency_id,
        ]);

        return redirect('admin/jobs');
    }

    /**
     * Show a confirm delete message.
     * 
     * @param int $id 
     * @return \Illuminate\Http\Response
     */
    public function confirmDelete(Job $job)
    {
        $data = array(
            'row' => $job
            );
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
        return redirect('admin/jobs');
    }
}
