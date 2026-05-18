@extends('layouts.app')
@section('title', 'Coupons Management')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12 space-y-10" x-data="{ openAdd: false, editingId: null }">

    {{-- Welcome Admin --}}
    <div class="flex items-center gap-3 border-b border-[#F5E6D0]/50 pb-6">
        <span class="text-4xl">🎫</span>
        <div>
            <h1 class="font-display text-3xl font-extrabold text-[#3D1A08]">Discount Coupon Manager</h1>
            <p class="text-xs text-[#6B3A1F]/70 mt-1">Configure fixed or percent markdown promo codes to boost shoppers conversion rates.</p>
        </div>
    </div>

    {{-- Admin Navigation Strip --}}
    <div class="flex gap-3 overflow-x-auto pb-2 border-b border-[#FDF6EC] text-[10px] uppercase tracking-wider font-extrabold text-[#6B3A1F]">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-white border border-[#F5E6D0] hover:bg-[#FDF6EC] hover:scale-105 transition-transform shrink-0">📈 Dashboard</a>
        <a href="{{ route('admin.products.index') }}" class="px-4 py-2.5 rounded-xl bg-white border border-[#F5E6D0] hover:bg-[#FDF6EC] hover:scale-105 transition-transform shrink-0">🧁 Products</a>
        <a href="{{ route('admin.categories.index') }}" class="px-4 py-2.5 rounded-xl bg-white border border-[#F5E6D0] hover:bg-[#FDF6EC] hover:scale-105 transition-transform shrink-0">📂 Categories</a>
        <a href="{{ route('admin.coupons.index') }}" class="px-4 py-2.5 rounded-xl bg-[#3D1A08] text-[#F5E6D0] hover:scale-105 transition-transform shrink-0">🎫 Coupons</a>
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 rounded-xl bg-white border border-[#F5E6D0] hover:bg-[#FDF6EC] hover:scale-105 transition-transform shrink-0">👥 Users Access</a>
    </div>

    {{-- Trigger & Form --}}
    <div class="flex justify-between items-center">
        <h2 class="font-display text-2xl font-bold text-[#3D1A08]">Discount Coupons</h2>
        <button @click="openAdd = !openAdd" class="btn-primary py-2.5 px-6 rounded-xl text-[10px] uppercase tracking-widest font-extrabold">
            + Generate Coupon
        </button>
    </div>

    {{-- Add Coupon Form --}}
    <div x-show="openAdd" class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-8 space-y-4 animate-fadein">
        <h3 class="font-display font-bold text-lg text-[#3D1A08]">Generate Discount Code</h3>
        <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="relative">
                    <input type="text" name="code" id="coup_code" required placeholder=" "
                           class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] uppercase focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                    <label for="coup_code" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">Promo Code (e.g. SWEET20)</label>
                </div>

                <div class="relative">
                    <select name="type" id="coup_type" required
                            class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                        <option value="percent">Percentage Discount (%)</option>
                        <option value="fixed">Fixed Reduction Amount (₦)</option>
                    </select>
                    <label for="coup_type" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 pointer-events-none">Discount Type</label>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="relative">
                    <input type="number" name="value" id="coup_val" required min="0" placeholder=" "
                           class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                    <label for="coup_val" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">Discount Value</label>
                </div>

                <div class="relative">
                    <input type="number" name="total_limit" id="coup_limit" required min="1" placeholder=" "
                           class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                    <label for="coup_limit" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">Total Limit Uses</label>
                </div>

                <div class="relative">
                    <input type="date" name="expires_at" id="coup_expires" required placeholder=" "
                           class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                    <label for="coup_expires" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 pointer-events-none">Expiration Date</label>
                </div>
            </div>

            <button type="submit" class="btn-primary py-3 px-6 rounded-xl text-[10px] uppercase tracking-wider font-extrabold">
                Generate Promo Code
            </button>
        </form>
    </div>

    {{-- Coupons Listing Table --}}
    <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6">
        <div class="overflow-x-auto rounded-2xl border border-[#FDF6EC]">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#FDF6EC] text-[#6B3A1F]/80 uppercase font-extrabold tracking-wider border-b border-[#F5E6D0]/50">
                        <th class="p-4">Promo Code</th>
                        <th class="p-4">Discount Applied</th>
                        <th class="p-4">Redemption Count</th>
                        <th class="p-4">Validity</th>
                        <th class="p-4">Expires On</th>
                        <th class="p-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#FDF6EC]">
                    @foreach($coupons as $c)
                    <tr class="hover:bg-[#FDF6EC]/10 transition-all">
                        <td class="p-4 font-bold text-[#3D1A08] uppercase">
                            {{ $c->code }}
                        </td>
                        <td class="p-4 font-extrabold text-rose-600">
                            {{ $c->type === 'percent' ? $c->value . '%' : '₦' . number_format($c->value, 0) }}
                        </td>
                        <td class="p-4 font-bold text-[#6B3A1F]">
                            {{ $c->used_count }} / {{ $c->total_limit }} claims
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase {{ $c->isValid() ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-rose-50 text-rose-500 border border-rose-100' }}">
                                {{ $c->isValid() ? 'Active & Valid' : 'Expired/Depleted' }}
                            </span>
                        </td>
                        <td class="p-4 font-semibold text-[#6B3A1F]/80">
                            {{ $c->expires_at->format('M d, Y') }}
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center items-center gap-3">
                                <button @click="editingId = (editingId === {{ $c->id }} ? null : {{ $c->id }})" 
                                        class="px-3 py-1.5 rounded-full border border-[#F5E6D0] hover:bg-[#FDF6EC] text-[#6B3A1F] font-extrabold transition-all">
                                    Edit
                                </button>
                                
                                <form action="{{ route('admin.coupons.destroy', $c) }}" method="POST" onsubmit="return confirm('Delete this coupon code?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 font-extrabold">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- Edit Panel Drawer Inline --}}
                    <tr x-show="editingId === {{ $c->id }}" class="bg-[#FDF6EC]/20 animate-fadein" style="display:none">
                        <td colspan="6" class="p-6">
                            <form action="{{ route('admin.coupons.update', $c) }}" method="POST" class="space-y-4">
                                @csrf @method('PUT')
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="relative">
                                        <input type="text" name="code" id="edit_code_{{ $c->id }}" required value="{{ $c->code }}"
                                               class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-white border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] uppercase focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all">
                                        <label for="edit_code_{{ $c->id }}" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60">Promo Code</label>
                                    </div>
                                    <div class="relative">
                                        <select name="type" id="edit_type_{{ $c->id }}" required
                                                class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-white border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all">
                                            <option value="percent" {{ $c->type === 'percent' ? 'selected' : '' }}>Percentage Discount (%)</option>
                                            <option value="fixed" {{ $c->type === 'fixed' ? 'selected' : '' }}>Fixed Reduction Amount (₦)</option>
                                        </select>
                                        <label for="edit_type_{{ $c->id }}" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60">Discount Type</label>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="relative">
                                        <input type="number" name="value" id="edit_value_{{ $c->id }}" required min="0" value="{{ $c->value }}"
                                               class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-white border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all">
                                        <label for="edit_value_{{ $c->id }}" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60">Value</label>
                                    </div>
                                    <div class="relative">
                                        <input type="number" name="total_limit" id="edit_limit_{{ $c->id }}" required min="1" value="{{ $c->total_limit }}"
                                               class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-white border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all">
                                        <label for="edit_limit_{{ $c->id }}" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60">Total limit</label>
                                    </div>
                                    <div class="relative">
                                        <input type="date" name="expires_at" id="edit_expires_{{ $c->id }}" required value="{{ $c->expires_at->format('Y-m-d') }}"
                                               class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-white border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all">
                                        <label for="edit_expires_{{ $c->id }}" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60">Expiration Date</label>
                                    </div>
                                </div>

                                <button type="submit" class="btn-primary py-2.5 px-6 rounded-xl text-[10px] uppercase tracking-wider font-extrabold">
                                    Save Coupon Updates
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
