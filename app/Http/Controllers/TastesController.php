<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Taste;
    
    //=======================================================================
    class TastesController extends Controller
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
                $Tastes = Taste::where("id", "LIKE", "%$keyword%")->orWhere("id", "LIKE", "%$keyword%")->orWhere("taste_type", "LIKE", "%$keyword%")->orWhere("taste_name", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                $Tastes = Taste::paginate($perPage);
                
            }          
            return view("Tastes.index", compact("Tastes"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("Tastes.create");
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
				"taste_type" => "nullable|integer", //integer('taste_type')->nullable()
				"taste_name" => "nullable", //string('taste_name')->nullable()

            ]);
            $requestData = $request->all();
            
            Taste::create($requestData);
    
            return redirect("Tastes")->with("flash_message", "Tastes added!");
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
            $Tastes = Taste::findOrFail($id);
    
            return view("Tastes.show", compact("Tastes"));
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
            $Tastes = Taste::findOrFail($id);
    
            return view("Tastes.edit", compact("Tastes"));
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
				"taste_type" => "nullable|integer", //integer('taste_type')->nullable()
				"taste_name" => "nullable", //string('taste_name')->nullable()

            ]);
            $requestData = $request->all();
            
            $Tastes = Taste::findOrFail($id);
            $Tastes->update($requestData);
    
            return redirect("Tastes")->with("flash_message", "Tastes updated!");
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
            Taste::destroy($id);
    
            return redirect("Tastes")->with("flash_message", "Tastes deleted!");
        }
    }
    //=======================================================================
    
    