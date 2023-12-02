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


    public function edit($id) {
        $data = User::find($id);
        //dd($data);
        return view('user.useredit',compact('data'));
    }


    public function update(Request $request,$id) {
        //dd($request->all());
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'email' => 'required|email',
            'password' => 'nullable'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
            }

           $data['name'] = $request->nama;
           $data['email'] = $request->email;

           if ($request->password) {
            $data['password'] = Hash::make($request->password);
           }

           //update
           User::whereId($id)->update($data);

           return redirect()->route('index');

    }

    public function delete(Request $request,$id){
         
            User::find($id)->delete();


            return redirect()->route('index')->with('Berhasil dihapus.');
        
    }

}

