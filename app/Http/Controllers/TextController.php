<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Text;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TextController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	return view('admin.text', ['text' => Text::where('id', $id)->first()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Text $text)
    {
        $text->update($request->all());
        return redirect('text/' . $text->id);
    }
}
