@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12 space-y-12">

    {{-- Breadcrumb Navigation --}}
    <nav class="text-xs uppercase tracking-widest text-[#6B3A1F]/70 flex flex-wrap items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-rose-600 transition-colors font-bold">Home</a> 
        <span class="opacity-50">/</span>
        <a href="{{ route('products.index') }}" class="hover:text-rose-600 transition-colors font-bold">Products</a> 
        @if($product->category)
            <span class="opacity-50">/</span>
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-rose-600 transition-colors font-bold">
                {{ $product->category->name }}
            </a> 
        @endif
        <span class="opacity-50">/</span>
        <span class="font-extrabold text-rose-600">{{ $product->name }}</span>
    </nav>

    {{-- Product details card --}}
    <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs overflow-hidden">
        <div class="flex flex-col md:flex-row">
            
            {{-- Image Panel --}}
            <div class="md:w-1/2 relative bg-[#FDF6EC] flex items-center justify-center min-h-[350px] md:min-h-[500px]">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                     class="w-full h-full object-cover" onerror="this.src='https://placehold.co/600x500/F2C4B0/6B3F2A?text=🎂'">
                
                {{-- Heart Wishlist button --}}
                @auth
                <form action="{{ route('wishlist.toggle', $product) }}" method="POST" class="absolute top-6 right-6 z-10">
                    @csrf
                    @php $wishlisted = auth()->user()->wishlists->contains($product->id); @endphp
                    <button type="submit" class="w-12 h-12 rounded-full bg-white/90 backdrop-blur-xs flex items-center justify-center shadow-md hover:scale-105 transition-all text-xl" title="Toggle Wishlist">
                        {{ $wishlisted ? '❤️' : '🤍' }}
                    </button>
                </form>
                @endauth
            </div>

            {{-- Info Panel --}}
            <div class="md:w-1/2 p-8 sm:p-12 flex flex-col justify-center space-y-6">
                
                <div class="space-y-2">
                    @if($product->category)
                    <span class="inline-flex items-center bg-rose-50 text-rose-600 text-[10px] font-extrabold uppercase tracking-widest px-3 py-1 rounded-full">
                        {{ $product->category->name }}
                    </span>
                    @endif
                    
                    <h1 class="font-display text-3xl sm:text-4xl font-extrabold text-[#3D1A08] leading-tight">
                        {{ $product->name }}
                    </h1>

                    {{-- Stars Rating Indicator --}}
                    <div class="flex items-center gap-2 text-xs font-bold text-[#6B3A1F]">
                        <div class="flex text-amber-400 text-sm">
                            @for($i = 1; $i <= 5; $i++)
                                <span>{{ $i <= round($product->average_rating) ? '★' : '☆' }}</span>
                            @endfor
                        </div>
                        <span class="underline">({{ $product->reviews_count }} customer reviews)</span>
                    </div>
                </div>

                <div class="flex items-baseline gap-2">
                    <span class="text-3xl sm:text-4xl font-display font-extrabold text-rose-600">
                        ₦{{ number_format($product->price, 0) }}
                    </span>
                    <span class="text-[10px] text-[#6B3A1F]/50 uppercase tracking-widest font-extrabold">Tax included</span>
                </div>

                <div class="text-xs sm:text-sm text-[#6B3A1F]/80 leading-relaxed font-semibold">
                    {{ $product->description }}
                </div>

                {{-- Custom Variants indicator --}}
                <div class="space-y-2 border-t border-[#FDF6EC] pt-4">
                    <span class="text-[10px] uppercase tracking-wider text-[#6B3A1F]/60 font-extrabold block">Bake Customizations</span>
                    <div class="flex gap-2">
                        <span class="px-3 py-1.5 rounded-xl border border-rose-500 bg-rose-50/50 text-[10px] font-extrabold text-rose-600 cursor-pointer">Standard Sweetness</span>
                        <span class="px-3 py-1.5 rounded-xl border border-[#F5E6D0]/40 text-[10px] font-extrabold text-[#6B3A1F] cursor-pointer hover:border-rose-300">Less Sugar</span>
                        <span class="px-3 py-1.5 rounded-xl border border-[#F5E6D0]/40 text-[10px] font-extrabold text-[#6B3A1F] cursor-pointer hover:border-rose-300">Gluten-Free Flour</span>
                    </div>
                </div>

                @if($product->isInStock())
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-xs font-bold text-emerald-600">Freshly Baked & In Stock ({{ $product->stock }} left)</span>
                    </div>

                    <form action="{{ route('cart.add', $product) }}" method="POST" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                        @csrf
                        <div class="flex items-center border border-[#F5E6D0] rounded-full overflow-hidden bg-white shadow-inner self-start">
                            <button type="button" onclick="changeQty(-1)"
                                    class="px-5 py-3 text-lg font-extrabold text-[#6B3A1F] hover:bg-[#FDF6EC] active:bg-[#F5E6D0] transition-colors">−</button>
                            <input type="number" name="quantity" id="qty" value="1" min="1" max="{{ min($product->stock, 50) }}" readonly
                                   class="w-12 text-center bg-transparent border-none focus:outline-none text-sm font-bold text-[#3D1A08]">
                            <button type="button" onclick="changeQty(1)"
                                    class="px-5 py-3 text-lg font-extrabold text-[#6B3A1F] hover:bg-[#FDF6EC] active:bg-[#F5E6D0] transition-colors">+</button>
                        </div>
                        <button type="submit" class="btn-primary py-4 px-8 shadow-md hover:shadow-lg flex items-center justify-center gap-2 rounded-2xl flex-grow text-xs uppercase tracking-widest font-extrabold transition-all">
                            Add to Cart 🧁
                        </button>
                    </form>
                @else
                    <div class="bg-rose-50 border border-rose-100 p-4 rounded-2xl space-y-1">
                        <span class="text-xs font-extrabold text-rose-600 block">⚠️ Restocking Shortly</span>
                        <p class="text-[10px] text-rose-700 leading-relaxed">This item is currently sold out. Check back later or follow our listings for organic restocks.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- Reviews section --}}
    <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-8 sm:p-12 space-y-10">
        <h2 class="font-display text-2xl sm:text-3xl font-extrabold text-[#3D1A08] border-b border-[#F5E6D0]/50 pb-4">Customer Reviews</h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            {{-- Left column: Ratings summary stats --}}
            <div class="space-y-4 text-center lg:text-left bg-[#FDF6EC]/40 p-6 rounded-3xl border border-[#F5E6D0]/20 self-start">
                <span class="text-5xl font-display font-extrabold text-[#3D1A08] block">{{ $product->average_rating }}</span>
                
                <div class="flex text-amber-400 text-lg justify-center lg:justify-start">
                    @for($i = 1; $i <= 5; $i++)
                        <span>{{ $i <= round($product->average_rating) ? '★' : '☆' }}</span>
                    @endfor
                </div>
                
                <p class="text-xs text-[#6B3A1F]/70 font-semibold block">Based on {{ $product->reviews_count }} verified shopper ratings.</p>
            </div>

            {{-- Right column: List of reviews --}}
            <div class="lg:col-span-2 space-y-6">
                @if($product->reviews->isEmpty())
                    <div class="text-center py-8 opacity-60">
                        <span class="text-4xl">⭐</span>
                        <p class="text-xs font-bold text-[#6B3A1F] mt-2">No shopper comments yet. Be the first to share your sweet opinion!</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($product->reviews as $review)
                        <div class="border-b border-[#FDF6EC] pb-4 space-y-1.5">
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-[#3D1A08]">{{ $review->user->name }}</span>
                                <span class="text-[10px] text-[#6B3A1F]/60">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            
                            <div class="flex text-amber-400 text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                @endfor
                            </div>
                            
                            @if($review->comment)
                            <p class="text-xs text-[#6B3A1F]/80 leading-relaxed font-semibold">{{ $review->comment }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @endif

                {{-- Write a Review Form --}}
                <div class="border-t border-[#F5E6D0]/40 pt-6 space-y-4">
                    <h3 class="font-display font-bold text-lg text-[#3D1A08]">Share Your Experience</h3>
                    
                    @auth
                    <form action="{{ route('products.reviews.store', $product) }}" method="POST" class="space-y-4">
                        @csrf
                        
                        {{-- Star rating radio group selector --}}
                        <div class="space-y-1">
                            <label class="text-[10px] uppercase tracking-wider text-[#6B3A1F]/60 font-extrabold block">Your Rating</label>
                            <div class="flex gap-3 text-2xl text-amber-400 cursor-pointer">
                                @for($i = 1; $i <= 5; $i++)
                                <label class="hover:scale-110 transition-transform">
                                    <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required>
                                    <span class="peer-checked:hidden">☆</span>
                                    <span class="hidden peer-checked:inline">★</span>
                                </label>
                                @endfor
                            </div>
                        </div>

                        {{-- Comment message --}}
                        <div class="relative">
                            <textarea name="comment" id="comment" rows="3" required placeholder=" "
                                      class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all"></textarea>
                            <label for="comment" 
                                   class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 transition-all peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">
                                Your Experience/Comment
                            </label>
                        </div>

                        <button type="submit" class="btn-primary py-3 px-6 rounded-xl text-[10px] uppercase tracking-wider font-extrabold">
                            Publish Review
                        </button>
                    </form>
                    @else
                    <div class="bg-[#FDF6EC]/40 p-5 rounded-2xl border border-[#F5E6D0]/30 text-center space-y-3">
                        <p class="text-xs text-[#6B3A1F] font-semibold">Please log in to your account to write a product review.</p>
                        <a href="{{ route('login') }}" class="inline-block btn-primary text-[10px] py-2.5 px-6 rounded-full uppercase tracking-wider font-extrabold shadow-sm">
                            Sign In Now
                        </a>
                    </div>
                    @endauth
                </div>

            </div>

        </div>
    </div>

    {{-- Related Products --}}
    @if($related->count())
    <div class="space-y-6">
        <div class="flex flex-col">
            <h2 class="font-display text-2xl sm:text-3xl font-extrabold text-[#3D1A08] mb-2">Related Products</h2>
            <div class="w-16 h-1 bg-rose-600 rounded-full"></div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($related as $product)
                @include('products._card', ['product' => $product])
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
    function changeQty(delta) {
        const input = document.getElementById('qty');
        const maxVal = parseInt(input.getAttribute('max')) || 50;
        const newVal = Math.max(1, Math.min(maxVal, parseInt(input.value) + delta));
        input.value = newVal;
    }
</script>
@endsection
