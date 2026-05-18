@extends('layouts.app')
@section('title', 'All Products')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">

    {{-- Page header --}}
    <div class="mb-8">
        <h1 class="font-display text-4xl font-bold" style="color:var(--charcoal)">Our Products</h1>
        <p class="opacity-60 mt-1">Browse our full range of cakes, small chops & drinks.</p>
    </div>

    <div class="flex flex-col md:flex-row gap-8">

        {{-- SIDEBAR FILTERS --}}
        <aside class="md:w-56 shrink-0">
            <div class="bg-white rounded-2xl shadow-sm p-5 sticky top-24">
                <h2 class="font-bold text-sm uppercase tracking-wider mb-4" style="color:var(--gold)">Categories</h2>
                <ul class="space-y-2 text-sm">
                    <li>
                        <a href="{{ route('products.index') }}"
                           class="block px-3 py-2 rounded-lg transition-colors {{ !request('category') ? 'font-bold' : 'hover:bg-rose-50' }}"
                           style="{{ !request('category') ? 'background:#F2C4B0; color:var(--brown)' : '' }}">
                            All Products
                        </a>
                    </li>
                    @foreach($categories as $cat)
                    <li>
                        <a href="{{ route('products.index', ['category' => $cat->slug]) }}"
                           class="block px-3 py-2 rounded-lg transition-colors {{ request('category') === $cat->slug ? 'font-bold' : 'hover:bg-rose-50' }}"
                           style="{{ request('category') === $cat->slug ? 'background:#F2C4B0; color:var(--brown)' : '' }}">
                            {{ $cat->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <div class="flex-1">

            {{-- Search bar --}}
            <form method="GET" action="{{ route('products.index') }}" class="mb-6 flex gap-2">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search products..."
                       id="search-input"
                       class="flex-1 border border-gray-200 rounded-full px-5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300">
                <button type="submit" class="btn-primary text-sm">Search</button>
                @if(request('search'))
                    <a href="{{ route('products.index', request()->except('search')) }}" class="btn-outline text-sm">Clear</a>
                @endif
            </form>

            {{-- Results count --}}
            <p class="text-sm opacity-60 mb-4">
                Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
            </p>

            {{-- Product grid --}}
            <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @include('products._grid')
            </div>

            {{-- Pagination --}}
            <div class="mt-10">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Live search with debounce
    let debounceTimer;
    document.getElementById('search-input').addEventListener('input', function () {
        clearTimeout(debounceTimer);
        const query = this.value;
        debounceTimer = setTimeout(() => {
            const params = new URLSearchParams(window.location.search);
            if (query) { params.set('search', query); } else { params.delete('search'); }

            fetch(`{{ route('products.index') }}?${params.toString()}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(data => {
                document.getElementById('product-grid').innerHTML = data.html;
            });
        }, 350);
    });
</script>
@endpush
