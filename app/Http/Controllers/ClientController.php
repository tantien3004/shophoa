<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Cart;
use Illuminate\Support\Facades\Redirect;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $products = ProductModel::orderBy('id', 'DESC')->paginate(12);
        $categories = CategoryModel::orderBy('id', 'DESC')->get();

        return view('home.profile_client', ['user' => $user, 'categories' => $categories, 'products' => $products]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            return redirect()->route('profile.edit', ['profile' => $id])->withErrors($validator)->withInput();
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
                $file->move("./uploads_user/", "$id.jpg");

            return redirect()->route('profile.edit', ['profile' => $user->id])->with('success', 'Cập nhật thông tin thành công!');
        }
    }

    public function save_cart(Request $request)
    {
        $productId = $request->productid_hidden;
        $quantity = $request->qty;

        $product_info = DB::table('product_models')->where('id', $productId)->first();

        $data['id'] = $product_info->id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->name;
        $data['price'] = $product_info->price;
        $data['weight'] = $product_info->price;
        $data['options']['image'] = $product_info->id;
        Cart::add($data);

        return Redirect::to('/show-cart');
    }

    public function show_cart()
    {
        $categories = CategoryModel::orderBy('id', 'DESC')->get();

        return view('home.client.show_cart', ['categories' => $categories]);
    }

    public function update_cart_quantity(Request $request)
    {
        $rowId = $request->rowId_cart;
        $qty = $request->cart_quantity;
        Cart::update($rowId, $qty);
        return Redirect::to('/show-cart');
    }

    public function delete_to_cart($rowId)
    {

        Cart::update($rowId, 0);
        return Redirect::to('/show-cart');
    }

    public function checkout()
    {
        $categories = CategoryModel::orderBy('id', 'DESC')->get();
        return view('home.client.checkout', ['categories' => $categories]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
