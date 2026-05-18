@extends('layouts.app')
@section('title', 'Bakery Catalog')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12 space-y-10">

    {{-- Title Banner --}}
    <div class="text-center md:text-left border-b border-[#F5E6D0]/50 pb-6">
        <h1 class="font-display text-4xl sm:text-5xl font-extrabold text-[#3D1A08] leading-tight">Bakery Catalog</h1>
        <p class="text-xs sm:text-sm text-[#6B3A1F]/70 mt-1">Savor our premium organic pastries, gourmet cakes, and handmade confectionery.</p>
    </div>

    {{-- Responsive Layout Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
        
        {{-- Sidebar Filters Panel --}}
        <aside class="space-y-6 lg:sticky lg:top-24">
            
            {{-- Category Filter Card --}}
            <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6 space-y-4">
                <h2 class="font-display font-bold text-[#3D1A08] text-sm uppercase tracking-wider">Treat Categories</h2>
                <div class="flex flex-wrap lg:flex-col gap-2">
                    <a href="{{ route('products.index', request()->except('category')) }}" 
                       class="px-4 py-2 rounded-xl text-xs font-bold transition-all border {{ !request('category') ? 'bg-[#3D1A08] text-[#F5E6D0] border-transparent' : 'bg-[#FDF6EC] text-[#6B3A1F] border-[#F5E6D0]/30 hover:bg-[#F5E6D0]/20' }}">
                        All Delicacies
                    </a>
                    @foreach($categories as $cat)
                    <a href="{{ route('products.index', array_merge(request()->query(), ['category' => $cat->slug])) }}" 
                       class="px-4 py-2 rounded-xl text-xs font-bold transition-all border {{ request('category') === $cat->slug ? 'bg-[#3D1A08] text-[#F5E6D0] border-transparent' : 'bg-[#FDF6EC] text-[#6B3A1F] border-[#F5E6D0]/30 hover:bg-[#F5E6D0]/20' }}">
                        {{ $cat->name }} ({{ $cat->products_count }})
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Price Range Filter Card --}}
            <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6 space-y-4">
                <h2 class="font-display font-bold text-[#3D1A08] text-sm uppercase tracking-wider font-extrabold">Price Limits</h2>
                <form method="GET" action="{{ route('products.index') }}" class="space-y-3">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                    
                    <div class="grid grid-cols-2 gap-2">
                        <div class="relative">
                            <input type="number" name="price_min" id="price_min" value="{{ request('price_min') }}" placeholder="Min" 
                                   class="w-full px-3 py-2 text-xs font-bold rounded-xl bg-[#FDF6EC] border border-[#F5E6D0]/40 focus:outline-none focus:ring-2 focus:ring-rose-500 text-[#3D1A08]">
                        </div>
                        <div class="relative">
                            <input type="number" name="price_max" id="price_max" value="{{ request('price_max') }}" placeholder="Max"
                                   class="w-full px-3 py-2 text-xs font-bold rounded-xl bg-[#FDF6EC] border border-[#F5E6D0]/40 focus:outline-none focus:ring-2 focus:ring-rose-500 text-[#3D1A08]">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-primary w-full py-2.5 justify-center rounded-xl text-[10px] uppercase tracking-wider font-extrabold">
                        Apply Range
                    </button>
                </form>
            </div>

        </aside>

        {{-- Catalog List and Tools --}}
        <div class="lg:col-span-3 space-y-6">
            
            {{-- Search & Sorting Toolbar --}}
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-4 rounded-3xl border border-[#F5E6D0]/40 shadow-xs">
                
                {{-- Search Box --}}
                <form method="GET" action="{{ route('products.index') }}" class="w-full sm:max-w-xs flex gap-2">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search sweet items..." 
                           class="flex-grow px-4 py-2.5 text-xs font-semibold rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/40 text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                    <button type="submit" class="btn-primary py-2.5 px-4 rounded-2xl text-[10px] uppercase font-extrabold shadow-sm">
                        Find
                    </button>
                </form>

                {{-- Sort Dropdown selector --}}
                <div class="w-full sm:w-auto flex items-center justify-end gap-2 text-xs font-semibold text-[#6B3A1F]">
                    <span>Sort By:</span>
                    <select onchange="location = this.value;" 
                            class="px-3 py-2 rounded-xl bg-[#FDF6EC] border border-[#F5E6D0]/40 text-[#3D1A08] font-bold focus:outline-none focus:ring-2 focus:ring-rose-500 cursor-pointer">
                        <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'name_asc'])) }}" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Default (A-Z)</option>
                        <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'price_asc'])) }}" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'price_desc'])) }}" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'newest'])) }}" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest Releases</option>
                    </select>
                </div>

            </div>

            {{-- Products Grid list --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @forelse($products as $product)
                    @include('products._card', ['product' => $product])
                @empty
                    <div class="col-span-full text-center py-16 bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs">
                        <span class="text-5xl">🔍</span>
                        <h3 class="font-display text-xl font-bold text-[#3D1A08] mt-4 mb-2">No delicacies found</h3>
                        <p class="text-xs text-[#6B3A1F]/70 max-w-xs mx-auto mb-6">Try refining your search query or price limits, or browse another category.</p>
                        <a href="{{ route('products.index') }}" class="btn-primary py-3 px-8 rounded-full text-xs uppercase tracking-widest font-extrabold shadow-sm">
                            Reset Filters
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Custom styled Pagination --}}
            <div class="pt-6">
                {{ $products->links() }}
            </div>

        </div>

    </div>

</div>
@endsection
