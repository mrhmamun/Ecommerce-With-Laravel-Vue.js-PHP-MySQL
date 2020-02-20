<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{


    public function index(){
        $categories = Category::all();
        return view('admin.category.category', [
            'categories' => $categories
        ]);
    }



    public function addCategory(){
        return view('admin.category.add-category');
    }



    public function saveCategory(Request $request){
//opt:1
//        Category::create($request->all());

        //validation

      $request->validate([
           'cat_name' => 'required',
           'cat_desc' => 'required',
           'status' => 'regex:/^([0-1]+)$/'
       ]);


        //opt:2
        $category = new Category();
        $category->cat_name = $request->cat_name;
        $category->cat_desc = $request->cat_desc;
        $category->status = $request->status;
        $category->save();
        //opt:3
//        DB::table('categories')->insert([
//            'cat_name' =>$request->cat_name,
//            'cat_desc' =>$request->cat_desc,
//            'status' =>$request->status,
//        ]);

        return back()->with('message', 'Category Saved Successfully');

    }

    public function unpublishCategory($id){
        $category = Category::find($id);
        $category->status=0;
        $category->save();
        return back();
    }
    public function publishCategory($id){
        $category = Category::find($id);
        $category->status=1;
        $category->save();
        return back();
    }
    public function editCategory($id){
        $category = Category::find($id);
        return view('admin.category.edit-category', ['category'=>$category]);
    }
    public function updateCategory(Request $request){

        $category = Category::find($request->id);
        $category->cat_name = $request->cat_name;
        $category->cat_desc = $request->cat_desc;
        $category->status = $request->status;
        $category->save();

        return back()->with('message', 'Category Updated Successfully');


    }

    public  function deleteCategory($id){
        $category = Category::find($id);
        $category->delete();
        return back()->with('message', 'Category Deleted Successfully');
    }
}
