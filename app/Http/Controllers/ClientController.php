<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $Clients = Client::where('user_id', auth()->id())->get();
        return view('Clients.index', compact('Clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'note' => 'nullable|string',
        ]);

        $Client = new Client();
        $Client->name = $request->name;
        $Client->address = $request->address;
        $Client->phone = $request->phone;
        $Client->note = $request->note;
        $Client->user_id = auth()->id();
        $Client->save();

        return redirect()->back();
    }


    public function update(Request $request, Client $Client)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'note' => 'nullable|string',
        ]);


        $Client->update($request->all());

        return redirect()->route('Clients.index')->with('success', 'تم تحديث الزبون بنجاح.');
    }


    public function destroy(Client $Client)
    {

        if ($Client->user_id !== auth()->id()) {
            return redirect()->route('Clients.index')->with('error', 'لا يمكنك حذف هذا العميل');
        }

        $Client->delete();
        return redirect()->back()->with('success', 'تم حذف العميل بنجاح');
    }
}
