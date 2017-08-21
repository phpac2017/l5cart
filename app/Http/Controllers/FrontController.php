<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Product;
use App\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\Redirect;
use Cart;

class FrontController extends Controller {

    var $brands;
    var $categories;
    var $products;
    var $title;
    var $description;

    public function __construct() {
        $this->brands = Brand::all(array('name'));
        $this->categories = Category::all(array('name'));
        $this->products = Product::all(array('id','name','price'));
    }

    public function index() {
        return view('blog', array('title' => 'Welcome','description' => '','page' => 'home', 'brands' => $this->brands, 'categories' => $this->categories, 'products' => $this->products));
    }

    public function products() {
        return view('products', array('title' => 'Products Listing','description' => '','page' => 'products', 'brands' => $this->brands, 'categories' => $this->categories, 'products' => $this->products));
    }

    public function product_details($id) {
        $product = Product::find($id);
        return view('product_details', array('product' => $product, 'title' => $product->name,'description' => '','page' => 'products', 'brands' => $this->brands, 'categories' => $this->categories, 'products' => $this->products));
    }

    public function product_categories($name) {
        return view('products', array('title' => 'Welcome','description' => '','page' => 'products', 'brands' => $this->brands, 'categories' => $this->categories, 'products' => $this->products));
    }

    public function product_brands($name, $category = null) {
        return view('products', array('title' => 'Welcome','description' => '','page' => 'products', 'brands' => $this->brands, 'categories' => $this->categories, 'products' => $this->products));
    }

    public function blog() {
        return view('blog', array('title' => 'Welcome','description' => '','page' => 'blog', 'brands' => $this->brands, 'categories' => $this->categories, 'products' => $this->products));
    }

    public function blog_post($id) {
        return view('blog_post', array('title' => 'Welcome','description' => '','page' => 'blog', 'brands' => $this->brands, 'categories' => $this->categories, 'products' => $this->products));
    }

    public function contact_us() {
        return view('contact_us', array('title' => 'Welcome','description' => '','page' => 'contact_us'));
    }

    public function login() {
        return view('login', array('title' => 'Welcome','description' => '','page' => 'home'));
    }

    public function logout() {
        return view('login', array('title' => 'Welcome','description' => '','page' => 'home'));
    }

    public function cart() {

        //update/ add new item to cart
        if (Request::isMethod('post')) {
            $product_id = Request::get('product_id');
            $product = Product::find($product_id);
            Cart::add(array('id' => $product_id, 'name' => $product->name, 'qty' => 1, 'price' => $product->price));
        }

        //increment the quantity
        if (Request::get('product_id') && (Request::get('increment')) == 1) {
            $id = Request::get('product_id');
            //$rowId = Cart::search(array('id' => Request::get('product_id')));
            $rowId1 = Cart::search(function ($cart, $key) use($id) {
               return $cart->id == $id;
            })->first()->toArray();
            $rowId = $rowId1['rowId'];
            $item = Cart::get($rowId);
            Cart::update($rowId, $item->qty + 1);
        }

        //decrease the quantity
        if (Request::get('product_id') && (Request::get('decrease')) == 1) {
            //$rowId = Cart::search(array('id' => Request::get('product_id')));
            $id = Request::get('product_id');
            //$rowId = Cart::search(array('id' => Request::get('product_id')));
            $rowId1 = Cart::search(function ($cart, $key) use($id) {
               return $cart->id == $id;
            })->first()->toArray();
            $rowId = $rowId1['rowId'];
            $item = Cart::get($rowId);

            Cart::update($rowId, $item->qty - 1);
        }

        //destroy the item
        if (Request::get('p_id')) {
            //$rowId = Cart::search(array('id' => Request::get('product_id')));
            $id = Request::get('p_id');
            //$rowId = Cart::search(array('id' => Request::get('product_id')));
            $rowId1 = Cart::search(function ($cart, $key) use($id) {
               return $cart->id == $id;
            })->first()->toArray();
            $rowId = $rowId1['rowId'];
            $item = Cart::get($rowId);

            Cart::remove($rowId);
        }

        $cart = Cart::content();

        return view('cart', array('cart' => $cart, 'title' => 'Welcome', 'description' => '', 'page' => 'home'));
        //return view('cart', array('title' => 'Welcome','description' => '','page' => 'home'));
    }

    public function checkout() {
        return view('checkout', array('title' => 'Welcome','description' => '','page' => 'home'));
    }

    public function search($query) {
        return view('products', array('title' => 'Welcome','description' => '','page' => 'products'));
    }
}