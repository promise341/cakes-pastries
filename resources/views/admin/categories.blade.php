@extends('layouts.app')
@section('title', 'Categories Management')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12 space-y-10" x-data="{ openAdd: false, editingId: null }">

    {{-- Welcome Admin --}}
    <div class="flex items-center gap-3 border-b border-[#F5E6D0]/50 pb-6">
        <span class="text-4xl">📂</span>
        <div>
            <h1 class="font-display text-3xl font-extrabold text-[#3D1A08]">Pastries Category Console</h1>
            <p class="text-xs text-[#6B3A1F]/70 mt-1">Organize sweet delicacies into luxury catalog categories for customer filtering ease.</p>
        </div>
    </div>

    {{-- Admin Navigation Strip --}}
    <div class="flex gap-3 overflow-x-auto pb-2 border-b border-[#FDF6EC] text-[10px] uppercase tracking-wider font-extrabold text-[#6B3A1F]">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-white border border-[#F5E6D0] hover:bg-[#FDF6EC] hover:scale-105 transition-transform shrink-0">📈 Dashboard</a>
        <a href="{{ route('admin.products.index') }}" class="px-4 py-2.5 rounded-xl bg-white border border-[#F5E6D0] hover:bg-[#FDF6EC] hover:scale-105 transition-transform shrink-0">🧁 Products</a>
        <a href="{{ route('admin.categories.index') }}" class="px-4 py-2.5 rounded-xl bg-[#3D1A08] text-[#F5E6D0] hover:scale-105 transition-transform shrink-0">📂 Categories</a>
        <a href="{{ route('admin.coupons.index') }}" class="px-4 py-2.5 rounded-xl bg-white border border-[#F5E6D0] hover:bg-[#FDF6EC] hover:scale-105 transition-transform shrink-0">🎫 Coupons</a>
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 rounded-xl bg-white border border-[#F5E6D0] hover:bg-[#FDF6EC] hover:scale-105 transition-transform shrink-0">👥 Users Access</a>
    </div>

    {{-- Trigger & Form --}}
    <div class="flex justify-between items-center">
        <h2 class="font-display text-2xl font-bold text-[#3D1A08]">Pastries Categories</h2>
        <button @click="openAdd = !openAdd" class="btn-primary py-2.5 px-6 rounded-xl text-[10px] uppercase tracking-widest font-extrabold">
            + New Category
        </button>
    </div>

    {{-- Add Category Form --}}
    <div x-show="openAdd" class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-8 space-y-4 animate-fadein">
        <h3 class="font-display font-bold text-lg text-[#3D1A08]">Register New Category</h3>
        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="relative">
                <input type="text" name="name" id="cat_name" required placeholder=" "
                       class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                <label for="cat_name" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">Category Name (e.g. Birthday Cakes)</label>
            </div>

            <div class="relative">
                <textarea name="description" id="cat_desc" rows="2" placeholder=" "
                          class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all"></textarea>
                <label for="cat_desc" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">Description</label>
            </div>

            <button type="submit" class="btn-primary py-3 px-6 rounded-xl text-[10px] uppercase tracking-wider font-extrabold">
                Create Category
            </button>
        </form>
    </div>

    {{-- Category Listing Table --}}
    <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6">
        <div class="overflow-x-auto rounded-2xl border border-[#FDF6EC]">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#FDF6EC] text-[#6B3A1F]/80 uppercase font-extrabold tracking-wider border-b border-[#F5E6D0]/50">
                        <th class="p-4">Category Name</th>
                        <th class="p-4">Slug Identifier</th>
                        <th class="p-4">Description</th>
                        <th class="p-4">Products Linked</th>
                        <th class="p-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#FDF6EC]">
                    @foreach($categories as $cat)
                    <tr class="hover:bg-[#FDF6EC]/10 transition-all">
                        <td class="p-4 font-bold text-[#3D1A08]">
                            {{ $cat->name }}
                        </td>
                        <td class="p-4 font-semibold text-[#6B3A1F]">
                            {{ $cat->slug }}
                        </td>
                        <td class="p-4 text-[#6B3A1F]/80 leading-relaxed font-semibold">
                            {{ $cat->description ?: 'No detailed descriptions.' }}
                        </td>
                        <td class="p-4 font-bold text-[#3D1A08]">
                            {{ $cat->products_count }} items
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center items-center gap-3">
                                <button @click="editingId = (editingId === {{ $cat->id }} ? null : {{ $cat->id }})" 
                                        class="px-3 py-1.5 rounded-full border border-[#F5E6D0] hover:bg-[#FDF6EC] text-[#6B3A1F] font-extrabold transition-all">
                                    Edit
                                </button>
                                
                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Remove category permanently?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 font-extrabold">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- Edit Panel Drawer Inline --}}
                    <tr x-show="editingId === {{ $cat->id }}" class="bg-[#FDF6EC]/20 animate-fadein" style="display:none">
                        <td colspan="5" class="p-6">
                            <form action="{{ route('admin.categories.update', $cat) }}" method="POST" class="space-y-4">
                                @csrf @method('PUT')
                                
                                <div class="relative">
                                    <input type="text" name="name" id="edit_name_{{ $cat->id }}" required value="{{ $cat->name }}"
                                           class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-white border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all">
                                    <label for="edit_name_{{ $cat->id }}" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60">Category Name</label>
                                </div>

                                <div class="relative">
                                    <textarea name="description" id="edit_desc_{{ $cat->id }}" rows="2"
                                              class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-white border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all">{{ $cat->description }}</textarea>
                                    <label for="edit_desc_{{ $cat->id }}" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60">Description</label>
                                </div>

                                <button type="submit" class="btn-primary py-2.5 px-6 rounded-xl text-[10px] uppercase tracking-wider font-extrabold">
                                    Save Category Updates
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
