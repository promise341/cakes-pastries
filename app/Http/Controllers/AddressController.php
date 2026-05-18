<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city'           => 'required|string|max:100',
            'state'          => 'required|string|max:100',
            'postal_code'    => 'nullable|string|max:20',
            'is_default'     => 'nullable|boolean',
        ]);

        $user = Auth::user();
        $isDefault = $request->boolean('is_default');

        if ($isDefault) {
            $user->addresses()->update(['is_default' => false]);
        }

        // Create new address
        $user->addresses()->create([
            'customer_name'  => $request->customer_name,
            'phone'          => $request->phone,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city'           => $request->city,
            'state'          => $request->state,
            'postal_code'    => $request->postal_code,
            'is_default'     => $isDefault || $user->addresses()->count() === 0, // make default if first address
        ]);

        return back()->with('success', 'New delivery address was added to your book!');
    }

    public function update(Request $request, Address $address)
    {
        abort_if($address->user_id !== Auth::id(), 403);

        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city'           => 'required|string|max:100',
            'state'          => 'required|string|max:100',
            'postal_code'    => 'nullable|string|max:20',
            'is_default'     => 'nullable|boolean',
        ]);

        $isDefault = $request->boolean('is_default');

        if ($isDefault) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        $address->update([
            'customer_name'  => $request->customer_name,
            'phone'          => $request->phone,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city'           => $request->city,
            'state'          => $request->state,
            'postal_code'    => $request->postal_code,
            'is_default'     => $isDefault || $address->is_default, // preserve default if already default
        ]);

        return back()->with('success', 'Delivery address has been updated!');
    }

    public function destroy(Address $address)
    {
        abort_if($address->user_id !== Auth::id(), 403);

        $wasDefault = $address->is_default;
        $address->delete();

        // If default address was deleted, set another address as default
        if ($wasDefault && Auth::user()->addresses()->count() > 0) {
            Auth::user()->addresses()->first()->update(['is_default' => true]);
        }

        return back()->with('success', 'Address was successfully removed.');
    }
}
