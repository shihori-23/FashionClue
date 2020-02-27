<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\BookmarkPost;
    
    //=======================================================================
    class BookmarkPostsController extends Controller
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
                $BookmarkPoss = BookmarkPos::where("id", "LIKE", "%$keyword%")->orWhere("id", "LIKE", "%$keyword%")->orWhere("post_id", "LIKE", "%$keyword%")->orWhere("user_id", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                $BookmarkPoss = BookmarkPos::paginate($perPage);
                
            }          
            return view("BookmarkPoss.index", compact("BookmarkPoss"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("BookmarkPoss.create");
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
				"user_id" => "nullable|integer", //integer('user_id')->nullable()

            ]);
            $requestData = $request->all();
            
            BookmarkPos::create($requestData);
    
            return redirect("BookmarkPoss")->with("flash_message", "BookmarkPoss added!");
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
            $BookmarkPoss = BookmarkPos::findOrFail($id);
    
            return view("BookmarkPoss.show", compact("BookmarkPoss"));
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
            $BookmarkPoss = BookmarkPos::findOrFail($id);
    
            return view("BookmarkPoss.edit", compact("BookmarkPoss"));
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
				"user_id" => "nullable|integer", //integer('user_id')->nullable()

            ]);
            $requestData = $request->all();
            
            $BookmarkPoss = BookmarkPos::findOrFail($id);
            $BookmarkPoss->update($requestData);
    
            return redirect("BookmarkPoss")->with("flash_message", "BookmarkPoss updated!");
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
            BookmarkPos::destroy($id);
    
            return redirect("BookmarkPoss")->with("flash_message", "BookmarkPoss deleted!");
        }
    }
    //=======================================================================
    
    