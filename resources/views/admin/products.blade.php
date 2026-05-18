@extends('layouts.app')
@section('title', 'Products Management')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12 space-y-10" x-data="{ openAdd: false, editingId: null }">

    {{-- Welcome Admin --}}
    <div class="flex items-center gap-3 border-b border-[#F5E6D0]/50 pb-6">
        <span class="text-4xl">🧁</span>
        <div>
            <h1 class="font-display text-3xl font-extrabold text-[#3D1A08]">Pastries Catalog</h1>
            <p class="text-xs text-[#6B3A1F]/70 mt-1">Add, modify, and delete delicate treats, control active pricing and real-time bakery stock.</p>
        </div>
    </div>

    {{-- Admin Navigation Strip --}}
    <div class="flex gap-3 overflow-x-auto pb-2 border-b border-[#FDF6EC] text-[10px] uppercase tracking-wider font-extrabold text-[#6B3A1F]">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-white border border-[#F5E6D0] hover:bg-[#FDF6EC] hover:scale-105 transition-transform shrink-0">📈 Dashboard</a>
        <a href="{{ route('admin.products.index') }}" class="px-4 py-2.5 rounded-xl bg-[#3D1A08] text-[#F5E6D0] hover:scale-105 transition-transform shrink-0">🧁 Products</a>
        <a href="{{ route('admin.categories.index') }}" class="px-4 py-2.5 rounded-xl bg-white border border-[#F5E6D0] hover:bg-[#FDF6EC] hover:scale-105 transition-transform shrink-0">📂 Categories</a>
        <a href="{{ route('admin.coupons.index') }}" class="px-4 py-2.5 rounded-xl bg-white border border-[#F5E6D0] hover:bg-[#FDF6EC] hover:scale-105 transition-transform shrink-0">🎫 Coupons</a>
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 rounded-xl bg-white border border-[#F5E6D0] hover:bg-[#FDF6EC] hover:scale-105 transition-transform shrink-0">👥 Users Access</a>
    </div>

    {{-- Trigger & Form --}}
    <div class="flex justify-between items-center">
        <h2 class="font-display text-2xl font-bold text-[#3D1A08]">Active Pastry Delicacies</h2>
        <button @click="openAdd = !openAdd" class="btn-primary py-2.5 px-6 rounded-xl text-[10px] uppercase tracking-widest font-extrabold">
            + New Delicacy
        </button>
    </div>

    {{-- Add Product Form --}}
    <div x-show="openAdd" class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-8 space-y-4 animate-fadein">
        <h3 class="font-display font-bold text-lg text-[#3D1A08]">Bake a New Product Entry</h3>
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="relative">
                    <input type="text" name="name" id="prod_name" required placeholder=" "
                           class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                    <label for="prod_name" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">Product Name</label>
                </div>

                <div class="relative">
                    <select name="category_id" id="prod_cat" required
                            class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <label for="prod_cat" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 pointer-events-none">Select Category</label>
                </div>
            </div>

            <div class="relative">
                <textarea name="description" id="prod_desc" rows="3" required placeholder=" "
                          class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all"></textarea>
                <label for="prod_desc" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">Decadent Description</label>
            </div>

            <div class="relative">
                <input type="file" name="image" id="prod_image" accept="image/*"
                       class="w-full px-4 py-3.5 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:uppercase file:tracking-wider file:font-extrabold file:bg-rose-50 file:text-rose-600 hover:file:bg-rose-100 transition-all cursor-pointer">
                <p class="text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 mt-2 ml-2">Product Image (Optional) - Max 4MB</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="relative">
                    <input type="number" name="price" id="prod_price" required min="0" placeholder=" "
                           class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                    <label for="prod_price" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">Price (₦)</label>
                </div>
                <div class="relative">
                    <input type="number" name="stock" id="prod_stock" required min="0" placeholder=" "
                           class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                    <label for="prod_stock" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">Bake Stock Count</label>
                </div>
                <div class="relative">
                    <select name="status" id="prod_status" required
                            class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                        <option value="active">Active Listing</option>
                        <option value="inactive">Inactive/Restocking</option>
                    </select>
                    <label for="prod_status" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 pointer-events-none">Status</label>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-extrabold text-[#3D1A08]">
                    <input type="checkbox" name="featured" value="1" class="rounded border-[#F5E6D0] text-rose-500 focus:ring-rose-500">
                    <span>Feature on Homepage Carousel ⭐</span>
                </label>
            </div>

            <button type="submit" class="btn-primary py-3.5 px-8 rounded-2xl text-[10px] uppercase tracking-wider font-extrabold">
                Publish Pastry
            </button>
        </form>
    </div>

    {{-- Products Listing Table --}}
    <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6">
        <div class="overflow-x-auto rounded-2xl border border-[#FDF6EC]">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#FDF6EC] text-[#6B3A1F]/80 uppercase font-extrabold tracking-wider border-b border-[#F5E6D0]/50">
                        <th class="p-4">Pastry Details</th>
                        <th class="p-4">Category</th>
                        <th class="p-4">Pricing</th>
                        <th class="p-4">Stock</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#FDF6EC]">
                    @foreach($products as $p)
                    <tr class="hover:bg-[#FDF6EC]/10 transition-all">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $p->image_url }}" class="w-10 h-10 rounded-xl object-cover bg-[#FDF6EC]" onerror="this.src='https://placehold.co/50?text=🎂'">
                                <div>
                                    <h4 class="font-bold text-[#3D1A08]">{{ $p->name }}</h4>
                                    @if($p->featured)
                                    <span class="inline-block bg-amber-50 text-amber-600 text-[8px] font-extrabold uppercase px-2 py-0.5 rounded-full border border-amber-100">Featured</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="p-4 font-semibold text-[#6B3A1F]">
                            {{ $p->category ? $p->category->name : 'Unassigned' }}
                        </td>
                        <td class="p-4 font-display font-extrabold text-rose-600 text-sm">
                            ₦{{ number_format($p->price, 0) }}
                        </td>
                        <td class="p-4 font-bold text-[#3D1A08]">
                            {{ $p->stock }} available
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase {{ $p->status === 'active' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-rose-50 text-rose-500 border border-rose-100' }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center items-center gap-3">
                                <button @click="editingId = (editingId === {{ $p->id }} ? null : {{ $p->id }})" 
                                        class="px-3 py-1.5 rounded-full border border-[#F5E6D0] hover:bg-[#FDF6EC] text-[#6B3A1F] font-extrabold transition-all">
                                    Edit Details
                                </button>
                                
                                <form action="{{ route('admin.products.destroy', $p) }}" method="POST" onsubmit="return confirm('Remove this pastry permanently?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 font-extrabold">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- Edit Panel Drawer Inline --}}
                    <tr x-show="editingId === {{ $p->id }}" class="bg-[#FDF6EC]/20 animate-fadein" style="display:none">
                        <td colspan="6" class="p-6">
                            <form action="{{ route('admin.products.update', $p) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf @method('PUT')
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="relative">
                                        <input type="text" name="name" id="edit_name_{{ $p->id }}" required value="{{ $p->name }}"
                                               class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-white border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all">
                                        <label for="edit_name_{{ $p->id }}" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60">Product Name</label>
                                    </div>
                                    <div class="relative">
                                        <select name="category_id" id="edit_cat_{{ $p->id }}" required
                                                class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-white border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all">
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ $p->category_id === $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="edit_cat_{{ $p->id }}" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60">Category</label>
                                    </div>
                                </div>

                                <div class="relative">
                                    <textarea name="description" id="edit_desc_{{ $p->id }}" rows="2" required
                                              class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-white border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all">{{ $p->description }}</textarea>
                                    <label for="edit_desc_{{ $p->id }}" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60">Description</label>
                                </div>

                                <div class="relative">
                                    <input type="file" name="image" id="edit_image_{{ $p->id }}" accept="image/*"
                                           class="w-full px-4 py-3.5 rounded-2xl bg-white border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:uppercase file:tracking-wider file:font-extrabold file:bg-rose-50 file:text-rose-600 hover:file:bg-rose-100 transition-all cursor-pointer">
                                    <p class="text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 mt-2 ml-2">Update Image (Leave blank to keep current) - Max 4MB</p>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="relative">
                                        <input type="number" name="price" id="edit_price_{{ $p->id }}" required min="0" value="{{ $p->price }}"
                                               class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-white border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all">
                                        <label for="edit_price_{{ $p->id }}" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60">Price (₦)</label>
                                    </div>
                                    <div class="relative">
                                        <input type="number" name="stock" id="edit_stock_{{ $p->id }}" required min="0" value="{{ $p->stock }}"
                                               class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-white border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all">
                                        <label for="edit_stock_{{ $p->id }}" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60">Stock Count</label>
                                    </div>
                                    <div class="relative">
                                        <select name="status" id="edit_status_{{ $p->id }}" required
                                                class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-white border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all">
                                            <option value="active" {{ $p->status === 'active' ? 'selected' : '' }}>Active Listing</option>
                                            <option value="inactive" {{ $p->status === 'inactive' ? 'selected' : '' }}>Inactive/Restocking</option>
                                        </select>
                                        <label for="edit_status_{{ $p->id }}" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60">Status</label>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">
                                    <label class="flex items-center gap-2 cursor-pointer text-xs font-extrabold text-[#3D1A08]">
                                        <input type="checkbox" name="featured" value="1" {{ $p->featured ? 'checked' : '' }} class="rounded border-[#F5E6D0] text-rose-500 focus:ring-rose-500">
                                        <span>Feature on Homepage Carousel ⭐</span>
                                    </label>
                                </div>

                                <button type="submit" class="btn-primary py-2.5 px-6 rounded-xl text-[10px] uppercase tracking-wider font-extrabold">
                                    Save Pastry Updates
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
