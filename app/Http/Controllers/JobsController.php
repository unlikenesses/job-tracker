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
        $clients_full = Client::orderBy('name', 'asc')->get();
        $clients = array();
        foreach ($clients_full as $client)
        {
            $clients[$client->id] = $client->name;
        }
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
            'fields'           => array('client_id', 'project_id', 'name', 'started', 'completed', 'amount'),
            'rows'             => Job::orderBy('created_at', 'desc')->get(),
            'clients'          => $clients,
            'projects'         => $projects,
            'currency_symbols' => $currency_symbols,
            'title'            => 'All'
            );
        return view('admin.jobs.index', $data);
    }

    public function open()
    {
        $clients_full = Client::orderBy('name', 'asc')->get();
        $clients = array();
        foreach ($clients_full as $client)
        {
            $clients[$client->id] = $client->name;
        }
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
            'fields'           => array('client_id', 'project_id', 'name', 'started', 'completed', 'amount'),
            'rows'             => Job::open()->orderBy('created_at', 'desc')->get(),
            'clients'          => $clients,
            'projects'         => $projects,
            'currency_symbols' => $currency_symbols,
            'title'            => 'Open'
            );
        return view('admin.jobs.index', $data);   
    }

    public function completed()
    {
        $clients_full = Client::orderBy('name', 'asc')->get();
        $clients = array();
        foreach ($clients_full as $client)
        {
            $clients[$client->id] = $client->name;
        }
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
            'fields'           => array('client_id', 'project_id', 'name', 'started', 'completed', 'amount'),
            'rows'             => Job::completed()->notInvoiced()->orderBy('created_at', 'desc')->get(),
            'clients'          => $clients,
            'projects'         => $projects,
            'currency_symbols' => $currency_symbols,
            'title'            => 'Completed, Not Invoiced'
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = array(
            'fields'     => array('client_id', 'project_id', 'name', 'started', 'completed', 'amount', 'currency_id'),
            'clients'    => Client::orderBy('name', 'asc')->get(),
            'projects'   => Project::orderBy('name', 'asc')->get(),
            'currencies' => Currency::orderBy('name', 'desc')->get(),
            'row'        => Job::findOrFail($id)
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
    public function update(Request $request, $id)
    {
        $row = Job::findOrFail($id);

        $row->update([
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
    public function confirmDelete($id)
    {
        $row = Job::findOrFail($id);
        $data = array(
            'table'        => 'images',
            'item'         => 'Image',
            'displayField' => 'image',
            'row'          => $row,
            'page_id'      => $row->page_id
            );
        return view('admin.jobs.confirmDelete', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Job::findOrFail($id);
        $row->delete();
        return redirect('admin/jobs');
    }
}
