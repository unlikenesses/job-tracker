<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Client;
use App\Project;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProjectsController extends Controller
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
        $data = array(
            'fields'  => array('client_id', 'name'),
            'rows'    => Project::orderBy('name', 'asc')->get(),
            'clients' => $clients
            );
        return view('admin.projects.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'fields' => array('client_id', 'name'),
            'clients' => Client::orderBy('name', 'asc')->get()
            );
        return view('admin.projects.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $project = new Project;
        $project->client_id = $request->client_id;
        $project->name = $request->name;
        $project->save();
        return redirect('admin/projects');
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
            'fields'  => array('client_id', 'name'),
            'row'     => Project::findOrFail($id),
            'clients' => Client::orderBy('name', 'asc')->get()
            );
        return view('admin.projects.edit', $data);
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
        $row = Project::findOrFail($id);
        $row->update([
            'client_id' => $request->client_id,
            'name'      => $request->name
        ]);
        return redirect('admin/projects');
    }

    /**
     * Show a confirm delete message.
     * 
     * @param int $id 
     * @return \Illuminate\Http\Response
     */
    public function confirmDelete($id)
    {
        $data = array(
            'row' => Project::findOrFail($id)
            );
        return view('admin.projects.confirmDelete', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Project::findOrFail($id);
        $row->delete();
        return redirect('admin/projects');
    }
}
