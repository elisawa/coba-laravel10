<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index(){
        $data = User::get();

        //return view('index',compact('data'));
        return view('index',compact('data'));
    }

    public function create(){
        return view('user.usercreate');
    }

    public function store(Request $request){
       
        
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()) {
             return redirect()->back()->withErrors($validator)->withInput();
             }

            $data['name'] = $request->nama;
            $data['email'] = $request->email;
            $data['password'] = Hash::make($request->password);
            
            
            User::create($data);

           return redirect()->route('index');
            //dd($request->all());
    }
}

