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
        $job = new Job($request->all());
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
        return view('admin.jobs.edit', array('row' => $job));
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
        $job->update($request->all());
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
        return view('admin.jobs.confirmDelete', array('row' => $job));
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
