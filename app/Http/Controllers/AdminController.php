<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

use App\Page;
use App\Text;
use App\Team;
use App\Image;
use App\Contact;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{

    public function index()
    {
        return view('admin.index');
    }

    public function sort(Request $request)
    {
    	$input = $request->input();
    	$order = $input['order'];
    	$table = $input['table'];
    	$pos = 1;
    	foreach ($order as $row) {
    		$id = str_replace('row_', '', $row);
    		DB::table($table)->where('id', $id)->update(['pos' => $pos]);
    		$pos++;
    	}
    }
}
