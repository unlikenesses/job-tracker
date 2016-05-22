<?php

namespace App\Http\Controllers;

use Auth;
use App\Page;
use App\Text;
use App\Team;
use App\Image;
use App\Contact;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function index()
    {
        $data = array(
            'text'   => Text::where('page_id', 2)->first(),
            'images' => Image::where('page_id', 2)->get()
        );
        return view('public.about', $data);
    }

    public function our_business()
    {
        $data = array(
            'business_text_1' => Text::where('id', 11)->first(),
            'business_text_2' => Text::where('id', 12)->first(),
            'business_text_3' => Text::where('id', 13)->first(),
            'tfi_text_1'      => Text::where('id', 14)->first(),
            'tfi_text_2'      => Text::where('id', 15)->first(),
            'tfi_text_3'      => Text::where('id', 16)->first(),
            'images'          => Image::where('page_id', 3)->get()
        );
        return view('public.business', $data);
    }

    public function our_approach()
    {
        $data = array(
            'text'   => Text::where('page_id', 4)->first(),
            'images' => Image::where('page_id', 4)->get(),
            'video'  => TRUE
        );
        return view('public.approach', $data);
    }

    public function contact_us()
    {
        $data = array(
            'text'    => Text::where('page_id', 5)->first(),
            'images'  => Image::where('page_id', 5)->get(),
            'contact' => Contact::get()
        );
        return view('public.contact', $data);
    }

    public function terms()
    {
        $data = array(
            'text'    => Text::where('page_id', 7)->first(),
            'images'  => Image::where('page_id', 7)->get()
        );
        return view('public.smallprint', $data);
    }

    public function privacy()
    {
        $data = array(
            'text'    => Text::where('page_id', 8)->first(),
            'images'  => Image::where('page_id', 8)->get()
        );
        return view('public.smallprint', $data);
    }
    
    public function disclosures()
    {
        $data = array(
            'text'    => Text::where('page_id', 9)->first(),
            'images'  => Image::where('page_id', 9)->get()
        );
        return view('public.smallprint', $data);
    }

    public function docs()
    { 
        $user = auth()->guard('investors')->user();
        $data = array(
            'user'   => $user,
            'docs'   => $user->docs,
            'images' => Image::where('page_id', 6)->get()
        );
        return view('public.docs', $data);
    }

    public function investor_login(Request $request)
    {
        if (Auth::guard('investors')->attempt(['name' => $request->username, 'password' => $request->password]))
        {
            return redirect('investor-documents');
        }
        else
        {
            $data = array(
                'images' => Image::where('page_id', 6)->get()
            );
            return view('auth.investor_login', $data);
        }
    }

    public function investor_logout()
    {
        Auth::guard('investors')->logout();
        return redirect('/');
    }
}
