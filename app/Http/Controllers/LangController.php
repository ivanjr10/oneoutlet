<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App;
use Auth;
  
class LangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('lang');
    }
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function change(Request $request)
    {
        App::setLocale($request->lang);
        if(Auth::user() && (strpos(url()->previous(),'admin') || strpos(url()->previous(),'vendor'))) {
            session()->put('language-admin', $request->lang);
        } else {
            session()->put('language', $request->lang);
        }
  
        return redirect()->back();
    }
}