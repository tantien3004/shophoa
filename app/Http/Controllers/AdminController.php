<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    
    public function index()
    {
        $products = ProductModel::orderByDesc('id')->paginate(12);
        $categories = CategoryModel::orderByDesc('id')->get();
        return view('admin.app', ['products' => $products, 'categories' => $categories]);
    }

    
    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.account.index', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:50',
            'sex' => 'required',
            'email' => 'required|string|email|max:255',
            'avatar' => 'mimes:jpeg, bmp, png, gif, jpg'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return redirect()->route('accountadmin.edit', ['accountadmin' => $id])->withErrors($validator)->withInput();
        else {

            $user = User::findOrFail($id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->DOB = $request->DOB;
            $user->sex = $request->sex;
            $user->address = $request->address;

            $user->save();

            $file = $request->avatar;
            if ($file)
                $file->move("./uploads_admin/", "$id.jpg");

            return redirect()->route('accountadmin.index');
        }
    }

    public function destroy($id)
    {
        
    }
}
