<div class="card flex flex-col">
    <a href="{{ route('products.show', $product) }}" class="block overflow-hidden">
        <img src="{{ $product->image_url }}"
             alt="{{ $product->name }}"
             class="w-full h-48 object-cover transition-transform duration-300 hover:scale-105"
             onerror="this.src='https://placehold.co/400x300/F2C4B0/6B3F2A?text=🎂'">
    </a>
    <div class="p-4 flex flex-col flex-1">
        <span class="text-xs font-bold uppercase tracking-wider mb-1" style="color:var(--gold)">
            {{ $product->category->name ?? '' }}
        </span>
        <a href="{{ route('products.show', $product) }}">
            <h3 class="font-display font-bold text-base mb-1 hover:text-rose-700 transition-colors" style="color:var(--charcoal)">
                {{ $product->name }}
            </h3>
        </a>
        <p class="text-xs opacity-60 mb-3 flex-1 line-clamp-2">{{ $product->description }}</p>
        <div class="flex items-center justify-between mt-auto">
            <span class="font-bold text-lg" style="color:var(--rose)">₦{{ number_format($product->price, 0) }}</span>
            @if($product->status === 'available')
                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn-primary text-xs py-2 px-4">Add to Cart</button>
                </form>
            @else
                <span class="badge badge-out">Out of Stock</span>
            @endif
        </div>
    </div>
</div>
