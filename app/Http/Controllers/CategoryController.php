<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = CategoryModel::orderByDesc('id')->paginate(5);

        if ($key = request()->key) {
            $categories = CategoryModel::orderByDesc('id')->where('name', 'like', '%' . $key . '%')->paginate(10);
        }

        return view('admin/category.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('admin/category.new');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => "required|max:100|unique:category_models",
            'feature' => "required",
            'avatar' => 'mimes:jpeg, bmp, png, gif, jpg'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return redirect()->route('category.create')->withErrors($validator)->withInput();
        else {
            $category = new CategoryModel;
            $category->name = $request->name;
            $category->feature = $request->feature;
            $category->description = $request->description;

            $category->save();

            return redirect()->route('category.index');
        }
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        $category = CategoryModel::findOrFail($id);
        return view('admin/category.edit', ['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:30',
            'feature' => "required",
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return redirect()->route('category.edit', ['category' => $id])->withErrors($validator)->withInput();
        else {
            $category = CategoryModel::find($id);
            $category->name = $request->name;
            $category->feature = $request->feature;
            $category->description = $request->description;

            $category->save();

            return redirect()->route('category.index');
        }
    }

    public function destroy($id)
    {
        $category = CategoryModel::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index');
    }
}
