<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function index()
    {

        $orders = Order::where('user_id', auth()->id())->with('client')->get();
        $clients = Client::all();
        $products = Product::all();


        $totalOrdersCount = $orders->count();
        $totalOrdersAmount = $orders->sum('total');

        return view('orders.index', compact('orders', 'clients', 'products', 'totalOrdersCount', 'totalOrdersAmount'));
    }


    public function show($id)
    {

        $order = Order::where('id', $id)->where('user_id', auth()->id())->with('products')->firstOrFail();

        return view('orders.show', compact('order'));
    }


    public function getOrders()
    {
        $orders = Order::where('user_id', auth()->id())->with('client')->get();
        return response()->json(['orders' => $orders]);
    }


    public function store(Request $request)
{

    $request->validate([
        'client_id' => 'required|exists:clients,id',
        'date' => 'required|date',
        'total' => 'required|numeric|min:0',
        'products' => 'required|array',
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|numeric|min:0.01',
        'products.*.price' => 'required|numeric|min:0',
        'products.*.total_price' => 'required|numeric|min:0',
    ]);

    try {

        $order = Order::create([
            'client_id' => $request->client_id,
            'date' => $request->date,
            'total' => $request->total,
            'user_id' => auth()->id(),
        ]);


        foreach ($request->products as $product) {
            $order->products()->attach($product['product_id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'total_price' => $product['total_price'],
            ]);
        }

        return response()->json([
            'success' => true,
            'orderRows' => view('orderRows', ['orders' => Order::all()])->render(),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'تم حفظ الطلب بنجاح',
            'error' => $e->getMessage(),
        ], 500);
    }
}



public function edit($id)
    {
        $order = Order::where('id', $id)->where('user_id', auth()->id())->with('products')->firstOrFail();
        $products = Product::all();
        return view('orders.edit', compact('order', 'products'));
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'client' => 'required|exists:clients,id',
            'date' => 'required|date',
            'totalOrderPrice' => 'required|numeric|min:0',
            'products' => 'required|array',
            'quantities' => 'required|array',
        ]);

        try {

            $order = Order::where('id', $id)->where('user_id', auth()->id())->firstOrFail();


            $order->update([
                'client_id' => $validatedData['client'],
                'date' => $validatedData['date'],
                'total' => $validatedData['totalOrderPrice'],
            ]);


            $order->products()->detach();
            foreach ($validatedData['products'] as $index => $productId) {
                $order->products()->attach($productId, [
                    'quantity' => $validatedData['quantities'][$index],
                ]);
            }

            return redirect()->route('orders.index')->with('success', 'تم تحديث الطلب بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء تحديث الطلب');
        }
    }


    public function destroy($id)
    {
        $order = Order::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'تم حذف الطلب بنجاح');
    }


    public function search(Request $request)
    {
        $query = $request->input('query', '');


        $orders = Order::where('user_id', auth()->id())
        ->with('client')
            ->whereHas('client', function ($q) use ($query) {
                $q->where('name', 'like', "$query%");
            })
            ->get();

        return response()->json($orders);
    }
}
