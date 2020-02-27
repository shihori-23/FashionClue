<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Review;
    
    //=======================================================================
    class ReviewsController extends Controller
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
                $Reviews = Review::where("id", "LIKE", "%$keyword%")->orWhere("id", "LIKE", "%$keyword%")->orWhere("answer_id", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                $Reviews = Review::paginate($perPage);
                
            }          
            return view("Reviews.index", compact("Reviews"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("Reviews.create");
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

            ]);
            $requestData = $request->all();
            
            Review::create($requestData);
    
            return redirect("Reviews")->with("flash_message", "Reviews added!");
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
            $Reviews = Review::findOrFail($id);
    
            return view("Reviews.show", compact("Reviews"));
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
            $Reviews = Review::findOrFail($id);
    
            return view("Reviews.edit", compact("Reviews"));
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

            ]);
            $requestData = $request->all();
            
            $Reviews = Review::findOrFail($id);
            $Reviews->update($requestData);
    
            return redirect("Reviews")->with("flash_message", "Reviews updated!");
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
            Review::destroy($id);
    
            return redirect("Reviews")->with("flash_message", "Reviews deleted!");
        }
    }
    //=======================================================================
    
    