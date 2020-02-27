<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Answer;
    
    //=======================================================================
    class AnswersController extends Controller
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
                $Answers = Answer::where("id", "LIKE", "%$keyword%")->orWhere("id", "LIKE", "%$keyword%")->orWhere("user_id", "LIKE", "%$keyword%")->orWhere("text", "LIKE", "%$keyword%")->orWhere("url", "LIKE", "%$keyword%")->orWhere("image", "LIKE", "%$keyword%")->orWhere("post_id", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                $Answers = Answer::paginate($perPage);
                
            }          
            return view("Answers.index", compact("Answers"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("Answers.create");
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
				"text" => "nullable", //string('text')->nullable()
				"url" => "nullable", //string('url')->nullable()
				"image" => "nullable", //string('image')->nullable()
				"post_id" => "nullable|integer", //integer('post_id')->nullable()

            ]);
            $requestData = $request->all();
            
            Answer::create($requestData);
    
            return redirect("Answers")->with("flash_message", "Answers added!");
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
            $Answers = Answer::findOrFail($id);
    
            return view("Answers.show", compact("Answers"));
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
            $Answers = Answer::findOrFail($id);
    
            return view("Answers.edit", compact("Answers"));
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
				"text" => "nullable", //string('text')->nullable()
				"url" => "nullable", //string('url')->nullable()
				"image" => "nullable", //string('image')->nullable()
				"post_id" => "nullable|integer", //integer('post_id')->nullable()

            ]);
            $requestData = $request->all();
            
            $Answers = Answer::findOrFail($id);
            $Answers->update($requestData);
    
            return redirect("Answers")->with("flash_message", "Answers updated!");
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
            Answer::destroy($id);
    
            return redirect("Answers")->with("flash_message", "Answers deleted!");
        }
    }
    //=======================================================================
    
    