<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Currency;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CurrenciesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'fields' => array('name', 'symbol'),
            'rows'   => Currency::orderBy('name', 'asc')->get()
            );
        return view('admin.currencies.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'fields' => array('name', 'symbol'),
            );
        return view('admin.currencies.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = new Currency;
        $client->name = $request->name;
        $client->symbol = $request->symbol;
        $client->save();
        return redirect('admin/currencies');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        $data = array(
            'fields' => array('name', 'symbol'),
            'row'    => $currency
            );
        return view('admin.currencies.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {
        $currency->update([
            'name'    => $request->name,
            'address' => $request->symbol
        ]);
        return redirect('admin/currencies');
    }

    /**
     * Show a confirm delete message.
     * 
     * @param int $id 
     * @return \Illuminate\Http\Response
     */
    public function confirmDelete(Currency $currency)
    {
        $data = array(
            'row' => $currency
            );
        return view('admin.currencies.confirmDelete', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();
        return redirect('admin/currencies');
    }
}
