<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\TasteUser;
    
    //=======================================================================
    class TasteUsersController extends Controller
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
                $TasteUses = TasteUse::where("id", "LIKE", "%$keyword%")->orWhere("id", "LIKE", "%$keyword%")->orWhere("user_id", "LIKE", "%$keyword%")->orWhere("taste_id", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                $TasteUses = TasteUse::paginate($perPage);
                
            }          
            return view("TasteUses.index", compact("TasteUses"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("TasteUses.create");
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
				"user_id" => "nullable|integer", //integer('user_id')->nullable()
				"taste_id" => "nullable|integer", //integer('taste_id')->nullable()

            ]);
            $requestData = $request->all();
            
            TasteUse::create($requestData);
    
            return redirect("TasteUses")->with("flash_message", "TasteUses added!");
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
            $TasteUses = TasteUse::findOrFail($id);
    
            return view("TasteUses.show", compact("TasteUses"));
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
            $TasteUses = TasteUse::findOrFail($id);
    
            return view("TasteUses.edit", compact("TasteUses"));
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
				"user_id" => "nullable|integer", //integer('user_id')->nullable()
				"taste_id" => "nullable|integer", //integer('taste_id')->nullable()

            ]);
            $requestData = $request->all();
            
            $TasteUses = TasteUse::findOrFail($id);
            $TasteUses->update($requestData);
    
            return redirect("TasteUses")->with("flash_message", "TasteUses updated!");
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
            TasteUse::destroy($id);
    
            return redirect("TasteUses")->with("flash_message", "TasteUses deleted!");
        }
    }
    //=======================================================================
    
    