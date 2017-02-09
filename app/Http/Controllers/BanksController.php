<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Bank;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class BanksController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.banks.index', ['rows' => Bank::orderBy('name', 'asc')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banks.create');
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
        $bank = new Bank($request->all());
        $bank->save();

        return redirect('banks');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        return view('admin.banks.edit', ['row' => $bank]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
        $this->validate($request, ['name' => 'required']);
        $bank->update($request->all());

        return redirect('banks');
    }

    /**
     * Show a confirm delete message.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function confirmDelete(Bank $bank)
    {
        return view('admin.banks.confirmDelete', ['row' => $bank]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        $bank->delete();
        
        return redirect('banks');
    }
}
