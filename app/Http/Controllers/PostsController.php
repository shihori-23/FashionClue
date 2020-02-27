<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Post;
    
    //=======================================================================
    class PostsController extends Controller
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
                $Posts = Post::where("id", "LIKE", "%$keyword%")->orWhere("id", "LIKE", "%$keyword%")->orWhere("category", "LIKE", "%$keyword%")->orWhere("text", "LIKE", "%$keyword%")->orWhere("user_id", "LIKE", "%$keyword%")->orWhere("image", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                $Posts = Post::paginate($perPage);
                
            }          
            return view("Posts.index", compact("Posts"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("Posts.create");
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
				"category" => "nullable", //string('category')->nullable()
				"text" => "nullable", //text('text')->nullable()
				"user_id" => "nullable|integer", //integer('user_id')->nullable()
				"image" => "nullable", //string('image')->nullable()

            ]);
            $requestData = $request->all();
            
            Post::create($requestData);
    
            return redirect("Posts")->with("flash_message", "Posts added!");
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
            $Posts = Post::findOrFail($id);
    
            return view("Posts.show", compact("Posts"));
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
            $Posts = Post::findOrFail($id);
    
            return view("Posts.edit", compact("Posts"));
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
				"category" => "nullable", //string('category')->nullable()
				"text" => "nullable", //text('text')->nullable()
				"user_id" => "nullable|integer", //integer('user_id')->nullable()
				"image" => "nullable", //string('image')->nullable()

            ]);
            $requestData = $request->all();
            
            $Posts = Post::findOrFail($id);
            $Posts->update($requestData);
    
            return redirect("Posts")->with("flash_message", "Posts updated!");
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
            Post::destroy($id);
    
            return redirect("Posts")->with("flash_message", "Posts deleted!");
        }
    }
    //=======================================================================
    
    