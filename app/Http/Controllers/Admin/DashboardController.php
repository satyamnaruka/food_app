<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    { 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
	 
    public function index(){
 
        $users=\App\Models\User::where('user_type','Customer')->count();
        $servicePartner=\App\Models\User::where('user_type','ServicePartner')->count();

        return view('admin.dashboard',compact('users','servicePartner'));
    } 
    
}