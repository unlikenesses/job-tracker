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
        $clients = Client::orderBy('name', 'asc')->get();
        foreach ($clients as $client) {
            $client_arr[$client->id] = $client->name;
        }
        $data = [
            'rows'    => Project::orderBy('name', 'asc')->get(),
            'clients' => $client_arr
            ];
        return view('admin.projects.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required']);
        $project = new Project($request->all());
        $project->save();
        return redirect('projects');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', ['row' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $this->validate($request, ['name' => 'required']);
        $project->update($request->all());
        return redirect('projects');
    }

    /**
     * Show a confirm delete message.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function confirmDelete(Project $project)
    {
        return view('admin.projects.confirmDelete', ['row' => $project]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect('projects');
    }

    /**
     * Return JSON string of projects for a given client ID.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getProjectsByClient(Request $request)
    {
        $projects = Project::where('client_id', $request->clientId)->orderBy('name', 'asc')->get();
        return response()->json($projects);
    }
}
