<div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-[#F5E6D0]/40 transition-all duration-300 hover:shadow-xl hover:-translate-y-1.5 flex flex-col h-full">
    {{-- Product Image --}}
    <a href="{{ route('products.show', $product) }}" class="block overflow-hidden relative group">
        <img src="{{ $product->image_url }}"
             alt="{{ $product->name }}"
             class="w-full h-52 object-cover transition-transform duration-500 group-hover:scale-105"
             onerror="this.src='https://placehold.co/400x300/F2C4B0/6B3F2A?text=🎂'">
        
        {{-- Category Label overlay --}}
        @if($product->category)
        <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-sm text-[#8B4513] text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full shadow-sm">
            {{ $product->category->name }}
        </span>
        @endif
    </a>

    {{-- Content --}}
    <div class="p-5 flex flex-col flex-grow">
        <a href="{{ route('products.show', $product) }}" class="group">
            <h3 class="font-display font-bold text-lg mb-2 text-[#3D1A08] group-hover:text-rose-600 transition-colors line-clamp-1">
                {{ $product->name }}
            </h3>
        </a>
        
        <p class="text-xs text-[#6B3A1F]/80 mb-4 line-clamp-2 leading-relaxed flex-grow">
            {{ $product->description }}
        </p>

        {{-- Footer --}}
        <div class="flex items-center justify-between mt-auto pt-3 border-t border-[#FDF6EC]">
            <div class="flex flex-col">
                <span class="text-[10px] uppercase tracking-wider text-[#6B3A1F]/60">Price</span>
                <span class="font-display font-bold text-xl text-rose-600">₦{{ number_format($product->price, 0) }}</span>
            </div>

            @if($product->isInStock())
                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn-primary text-xs py-2.5 px-4 shadow-sm hover:shadow-md flex items-center gap-1.5 rounded-full transition-all">
                        <span>🛒</span> Add to Cart
                    </button>
                </form>
            @else
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-600 border border-rose-100">
                    Out of Stock
                </span>
            @endif
        </div>
    </div>
</div>
