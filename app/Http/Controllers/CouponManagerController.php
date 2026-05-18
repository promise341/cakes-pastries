<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponManagerController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->get();
        return view('admin.coupons', compact('coupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'        => 'required|string|max:50|unique:coupons,code',
            'type'        => 'required|in:fixed,percent',
            'value'       => 'required|numeric|min:0',
            'total_limit' => 'required|integer|min:1',
            'expires_at'  => 'required|date',
        ]);

        Coupon::create([
            'code'        => strtoupper($request->code),
            'type'        => $request->type,
            'value'       => $request->value,
            'total_limit' => $request->total_limit,
            'expires_at'  => $request->expires_at,
            'used_count'  => 0,
        ]);

        return back()->with('success', "Coupon Code '{$request->code}' successfully generated!");
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code'        => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'type'        => 'required|in:fixed,percent',
            'value'       => 'required|numeric|min:0',
            'total_limit' => 'required|integer|min:1',
            'expires_at'  => 'required|date',
        ]);

        $coupon->update([
            'code'        => strtoupper($request->code),
            'type'        => $request->type,
            'value'       => $request->value,
            'total_limit' => $request->total_limit,
            'expires_at'  => $request->expires_at,
        ]);

        return back()->with('success', "Coupon Code '{$coupon->code}' has been updated.");
    }

    public function destroy(Coupon $coupon)
    {
        $code = $coupon->code;
        $coupon->delete();
        return back()->with('success', "Coupon Code '{$code}' deleted.");
    }
}
