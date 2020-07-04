<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(3);
        return view('admin.categories.index',compact('categories'));
    }
    // public function trash()
    // {
    //     $categories = Category::paginate(3);
    //     return view('admin.categories.index',compact('categories'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.categories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) 
    {
        $request->validate([
            'title'=>'required|min:5'
            // 'slug' =>'required|min:5'
        ]);
        $categories=Category::create($request->only('title','description'));
        $categories->childrens()->attach($request->parent_id);
        return back()->with('message','Category Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource. 
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        
        $categories = Category::where('id','!=',$category->id)->get();
        return view('admin.categories.create',['categories' => $categories ,'category' =>$category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {

        $request->validate([
            'title'=>'required|min:5'
            // 'slug' =>'required|min:5'
        ]);
        $category->title = $request->title;
        $category->description = $request->description;
        // detach all parent catagory
        $category->childrens()->detach();
        // attach selected parent category
        $category->childrens()->attach($request->parent_id);
        // save Current record into database
        $saved =$category->save();
        // return back to the add/edit 
        return back()->with('message','Record Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category->childrens()->detach() && $category->forcedelete()){
            return back()->with('message','Record Successfully Deleted!');
        }else{
            return back()->with('message','Error Deleteing Record !!');
        }
    }
}
