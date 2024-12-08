<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    public function index(){
        $products = Product::all();
        $categories = Category::all();
        return view('front.index', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function details(Product $product){
        $other_products = Product::where('id', '!=', $product->id)->get();
        $creator_id = $product->creator_id;
        $creator_products = Product::where('creator_id', $creator_id)->get();
        return view('front.details', [
            'product' => $product,
            'other_products' => $other_products,
            'creator_products' => $creator_products
        ]);
    }

    public function category(Category $category){
        $product_categories = Product::where('category_id', $category->id)->get();
        return view('front.category', [
            'category' => $category,
            'product_categories' => $product_categories
        ]);
    }

    public function search(Request $request){
        $keyword = $request->input('keyword');

        $products = Product::query()

        ->where('name', 'LIKE', '%' . $keyword . '%')
        ->orWhereHas('category', function ($query) use ($keyword){
            $query->where('name', 'LIKE', '%' . $keyword . '%');
        })->get();
        
        return view('front.search', [
            'products' => $products
        ]);
    }
}
