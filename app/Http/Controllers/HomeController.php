<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = ProductModel::orderbyDesc('id')->paginate(11);
        $categories = CategoryModel::orderbyDesc('id')->get();

        return view('home', ['products' => $products, 'categories' => $categories]);
    }

    public function productDetail($id)
    {
        $product = ProductModel::findOrFail($id);
        $categories = CategoryModel::orderbyDesc('id')->get();

        // foreach ($product as $key => $value) {
        //     $category_id = $value->category_id;
        // }

        return view('home.detail', ['product' => $product, 'categories' => $categories]);
    }

    public function blog()
    {
        $product = ProductModel::all();
        $categories = CategoryModel::orderbyDesc('id')->get();
        return view('home.blog', ['product' => $product, 'categories' => $categories]);
    }

    public function contact()
    {
        $product = ProductModel::all();
        $categories = CategoryModel::orderbyDesc('id')->get();
        return view('home.contact', ['product' => $product, 'categories' => $categories]);
    }

    public function category_page($id)
    {
        $products = ProductModel::orderbyDesc('id')->where('category_id', $id)->get();
        $categories = CategoryModel::orderbyDesc('id')->get();
        $category = CategoryModel::findOrFail($id);

        return view('home.category_page', ['products' => $products, 'categories' => $categories, 'category' => $category]);
    }
}
