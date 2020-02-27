<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\AnswerNotices;
    
    //=======================================================================
    class AnswerNoticesController extends Controller
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
                $AnswerNotics = AnswerNotic::where("id", "LIKE", "%$keyword%")->orWhere("id", "LIKE", "%$keyword%")->orWhere("review_owner_id", "LIKE", "%$keyword%")->orWhere("role", "LIKE", "%$keyword%")->orWhere("user_id", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                $AnswerNotics = AnswerNotic::paginate($perPage);
                
            }          
            return view("AnswerNotics.index", compact("AnswerNotics"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("AnswerNotics.create");
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
				"review_owner_id" => "nullable|integer", //integer('review_owner_id')->nullable()
				"role" => "nullable|integer", //integer('role')->nullable()
				"user_id" => "nullable|integer", //integer('user_id')->nullable()

            ]);
            $requestData = $request->all();
            
            AnswerNotic::create($requestData);
    
            return redirect("AnswerNotics")->with("flash_message", "AnswerNotics added!");
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
            $AnswerNotics = AnswerNotic::findOrFail($id);
    
            return view("AnswerNotics.show", compact("AnswerNotics"));
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
            $AnswerNotics = AnswerNotic::findOrFail($id);
    
            return view("AnswerNotics.edit", compact("AnswerNotics"));
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
				"review_owner_id" => "nullable|integer", //integer('review_owner_id')->nullable()
				"role" => "nullable|integer", //integer('role')->nullable()
				"user_id" => "nullable|integer", //integer('user_id')->nullable()

            ]);
            $requestData = $request->all();
            
            $AnswerNotics = AnswerNotic::findOrFail($id);
            $AnswerNotics->update($requestData);
    
            return redirect("AnswerNotics")->with("flash_message", "AnswerNotics updated!");
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
            AnswerNotic::destroy($id);
    
            return redirect("AnswerNotics")->with("flash_message", "AnswerNotics deleted!");
        }
    }
    //=======================================================================
    
    