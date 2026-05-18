@forelse($products as $product)
    @include('products._card', ['product' => $product])
@empty
    <div class="col-span-full text-center py-16 opacity-50">
        <div class="text-5xl mb-4">🔍</div>
        <p class="font-display text-xl">No products found.</p>
        <a href="{{ route('products.index') }}" class="btn-outline mt-4 text-sm">Clear filters</a>
    </div>
@endforelse
