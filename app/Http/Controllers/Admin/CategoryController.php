<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Categories';
        $emptyMessage = 'No category found';
        $categories = Category::latest()->paginate(getPaginate());

        return view('admin.category.index', compact('pageTitle', 'emptyMessage', 'categories'));
    }

    public function categoryStore(Request $request, $id=0)
    {
        if($id == 0)
        {
            $request->validate([
                'name' => 'required|string||unique:categories',
                'icon' => 'required'
            ]);
        }else{
            $request->validate([
                'name' => 'required',
                'icon' => 'required'
            ]);
        }

        $category = new Category();
        $message =  'Category created successfully';

        if($id){

            $check = Category::whereNot('id', $id)->where('name', $request->name)->count();

            if($check > 0)
            {
                $notify[] = ['error', 'Category name already exists'];
                return redirect()->back()->withNotify($notify);
            }

            $category = Category::findOrFail($id);
            $category->status = $request->status ? 1 : 0;
            $message = 'Category updated successfully';
        }

        $category->name = $request->name;
        $category->icon = $request->icon;
        $category->status = $request->status ? 1 : 0;
        $category->save();

        $notify[] = ['success', $message];
        return redirect()->back()->withNotify($notify);

    }
}
