<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Client;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ClientsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'fields' => array('name', 'address'),
            'rows'   => Client::orderBy('name', 'asc')->get()
            );
        return view('admin.clients.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'fields'  => array('name', 'address'),
            );
        return view('admin.clients.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = new Client;
        $client->name = $request->name;
        $client->address = $request->address;
        $client->save();
        return redirect('admin/clients');
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
            'fields' => array('name', 'address'),
            'row'    => Client::findOrFail($id)
            );
        return view('admin.clients.edit', $data);
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
        $row = Client::findOrFail($id);
        $row->update([
            'name' => $request->name,
            'address' => $request->address
        ]);
        return redirect('admin/clients');
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
            'row' => Client::findOrFail($id)
            );
        return view('admin.clients.confirmDelete', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Client::findOrFail($id);
        $row->delete();
        return redirect('admin/clients');
    }

    private function _get_latest_pos($page_id)
    {
        $page = Image::orderBy('pos', 'desc')->where('page_id', $page_id)->first();
        if ($page) return $page->pos;
    }
}
