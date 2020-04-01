<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Admin;
    
    //=======================================================================
    class AdminsController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\View\View
         */
        public function index(Request $request)
        {
            $keyword = $request->get("search");
            $perPage = 25;
    
            if (!empty($keyword)) {
                $Admins = Admin::where("id", "LIKE", "%$keyword%")->orWhere("id", "LIKE", "%$keyword%")->orWhere("email", "LIKE", "%$keyword%")->orWhere("password", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                $Admins = Admin::paginate($perPage);
                
            }          
            return view("Admins.index", compact("Admins"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("Admins.create");
        }
    
        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         */
        public function store(Request $request)
        {
            $this->validate($request, [
				"email" => "nullable", //string('email')->nullable()
				"password" => "nullable", //string('password')->nullable()

            ]);
            $requestData = $request->all();
            
            Admin::create($requestData);
    
            return redirect("Admins")->with("flash_message", "Admins added!");
        }
    
        /**
         * Display the specified resource.
         *
         * @param  int  $id
         *
         * @return \Illuminate\View\View
         */
        public function show($id)
        {
            $Admins = Admin::findOrFail($id);
    
            return view("Admins.show", compact("Admins"));
        }
    
        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         *
         * @return \Illuminate\View\View
         */
        public function edit($id)
        {
            $Admins = Admin::findOrFail($id);
    
            return view("Admins.edit", compact("Admins"));
        }
    
        /**
         * Update the specified resource in storage.
         *
         * @param  int  $id
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         */
        public function update(Request $request, $id)
        {
            $this->validate($request, [
				"email" => "nullable", //string('email')->nullable()
				"password" => "nullable", //string('password')->nullable()

            ]);
            $requestData = $request->all();
            
            $Admins = Admin::findOrFail($id);
            $Admins->update($requestData);
    
            return redirect("Admins")->with("flash_message", "Admins updated!");
        }
    
        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         *
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         */
        public function destroy($id)
        {
            Admin::destroy($id);
    
            return redirect("Admins")->with("flash_message", "Admins deleted!");
        }
    }
    //=======================================================================
    
    