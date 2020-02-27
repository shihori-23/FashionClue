<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\PostNotice;
    
    //=======================================================================
    class PostNoticesController extends Controller
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
                $PostNotics = PostNotic::where("id", "LIKE", "%$keyword%")->orWhere("id", "LIKE", "%$keyword%")->orWhere("post_id", "LIKE", "%$keyword%")->orWhere("answer_owner_id", "LIKE", "%$keyword%")->orWhere("role", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                $PostNotics = PostNotic::paginate($perPage);
                
            }          
            return view("PostNotics.index", compact("PostNotics"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("PostNotics.create");
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
				"post_id" => "nullable|integer", //integer('post_id')->nullable()
				"answer_owner_id" => "nullable|integer", //integer('answer_owner_id')->nullable()
				"role" => "nullable|integer", //integer('role')->nullable()

            ]);
            $requestData = $request->all();
            
            PostNotic::create($requestData);
    
            return redirect("PostNotics")->with("flash_message", "PostNotics added!");
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
            $PostNotics = PostNotic::findOrFail($id);
    
            return view("PostNotics.show", compact("PostNotics"));
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
            $PostNotics = PostNotic::findOrFail($id);
    
            return view("PostNotics.edit", compact("PostNotics"));
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
				"post_id" => "nullable|integer", //integer('post_id')->nullable()
				"answer_owner_id" => "nullable|integer", //integer('answer_owner_id')->nullable()
				"role" => "nullable|integer", //integer('role')->nullable()

            ]);
            $requestData = $request->all();
            
            $PostNotics = PostNotic::findOrFail($id);
            $PostNotics->update($requestData);
    
            return redirect("PostNotics")->with("flash_message", "PostNotics updated!");
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
            PostNotic::destroy($id);
    
            return redirect("PostNotics")->with("flash_message", "PostNotics deleted!");
        }
    }
    //=======================================================================
    
    