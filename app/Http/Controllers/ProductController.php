<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {

        $products = Product::where('user_id', auth()->id())->get();
        return view('products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
            'note' => 'nullable|string',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->note = $request->note;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->user_id = auth()->id();
        $product->save();

        return redirect()->back();
    }


    public function update(Request $request, Product $product)
    {

        if ($product->user_id !== auth()->id()) {
            return redirect()->route('products.index')->with('error', 'لا يمكنك تعديل هذا المنتج');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
            'note' => 'nullable|string',
        ]);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->note = $request->note;

        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->back()->with('success', 'تم تحديث المنتج بنجاح');
    }

    public function destroy(Product $product)
    {

        if ($product->user_id !== auth()->id()) {
            return redirect()->route('products.index')->with('error', 'لا يمكنك حذف هذا المنتج');
        }


        if ($product->image) {
            Storage::delete($product->image);
        }


        $product->delete();

        return redirect()->route('products.index')->with('success', 'تم حذف المنتج بنجاح');
    }
}
