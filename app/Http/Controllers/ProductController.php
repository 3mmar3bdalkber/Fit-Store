<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $products = product::all();
        return view('products.create');
    }

    public function store(ProductRequest $request)
    {
        $file1 = $request->file('image1');
        $imageName1 = time() . '_' . $file1->getClientOriginalName();
        $file1->move(public_path('product_images'), $imageName1);

        $file2 = $request->file('image2');
        $imageName2 = time() . '_' . $file2->getClientOriginalName();
        $file2->move(public_path('product_images'), $imageName2);

        Product::create([
            'name' => $request->name,
            'color' => $request->color,
            'price' => $request->price,
            'sale' => $request->sale,
            'collection' => $request->collection,
            'gender' => $request->gender,
            'category' => $request->category,
            'image1' => $imageName1,
            'image2' => $imageName2,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $recommended = Product::where('category', $product->category)
                              ->where('id', '!=', $product->id)
                              ->take(4)
                              ->get();

        return view('admin.products.show', compact('product', 'recommended'));
    }

    public function search(Request $request)
    {
        $query = $request->input('word');
        $products = Product::where('name', 'LIKE', "%{$query}%")->get();
        return view('products.search', compact('products', 'query'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

   
        if ($request->hasFile('image1')) {
            $file1 = $request->file('image1');
            $imageName1 = time().'_'.$file1->getClientOriginalName();
            $file1->move(public_path('product_images'), $imageName1);
            $product->image1 = $imageName1;
        }


        if ($request->hasFile('image2')) {
            $file2 = $request->file('image2');
            $imageName2 = time().'_'.$file2->getClientOriginalName();
            $file2->move(public_path('product_images'), $imageName2);
            $product->image2 = $imageName2;
        }

        $product->update([
            'name' => $request->name,
            'color' => $request->color,
            'price' => $request->price,
            'sale' => $request->sale,
            'collection' => $request->collection,
            'gender' => $request->gender,
            'category' => $request->category,
            'quantity' => $request->quantity,
            'image1' => $product->image1,
            'image2' => $product->image2,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

   
        if (!empty($product->image1)&&file_exists(public_path('product_images/' . $product->image2))) {
            unlink(public_path('product_images/'.$product->image1));
        }
        if (!empty($product->image2)&&file_exists(public_path('product_images/' . $product->image2))) {
            unlink(public_path('product_images/'.$product->image2));
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
