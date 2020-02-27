<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\BookmarkAnswer;
    
    //=======================================================================
    class BookmarkAnswersController extends Controller
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
                $BookmarkAnswes = BookmarkAnswe::where("id", "LIKE", "%$keyword%")->orWhere("id", "LIKE", "%$keyword%")->orWhere("answer_id", "LIKE", "%$keyword%")->orWhere("user_id", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                $BookmarkAnswes = BookmarkAnswe::paginate($perPage);
                
            }          
            return view("BookmarkAnswes.index", compact("BookmarkAnswes"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("BookmarkAnswes.create");
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
				"answer_id" => "nullable|integer", //integer('answer_id')->nullable()
				"user_id" => "nullable|integer", //integer('user_id')->nullable()

            ]);
            $requestData = $request->all();
            
            BookmarkAnswe::create($requestData);
    
            return redirect("BookmarkAnswes")->with("flash_message", "BookmarkAnswes added!");
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
            $BookmarkAnswes = BookmarkAnswe::findOrFail($id);
    
            return view("BookmarkAnswes.show", compact("BookmarkAnswes"));
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
            $BookmarkAnswes = BookmarkAnswe::findOrFail($id);
    
            return view("BookmarkAnswes.edit", compact("BookmarkAnswes"));
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
				"answer_id" => "nullable|integer", //integer('answer_id')->nullable()
				"user_id" => "nullable|integer", //integer('user_id')->nullable()

            ]);
            $requestData = $request->all();
            
            $BookmarkAnswes = BookmarkAnswe::findOrFail($id);
            $BookmarkAnswes->update($requestData);
    
            return redirect("BookmarkAnswes")->with("flash_message", "BookmarkAnswes updated!");
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
            BookmarkAnswe::destroy($id);
    
            return redirect("BookmarkAnswes")->with("flash_message", "BookmarkAnswes deleted!");
        }
    }
    //=======================================================================
    
    