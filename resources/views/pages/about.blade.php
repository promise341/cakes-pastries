@extends('layouts.app')
@section('title', 'Our Story')

@section('content')
<div class="space-y-20 py-12 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
    
    {{-- Editorial Hero --}}
    <div id="aboutHero" class="text-center space-y-6 opacity-0 translate-y-4">
        <span class="text-xs uppercase tracking-widest font-extrabold text-rose-500 bg-rose-50 px-3 py-1 rounded-full">Est. 2020</span>
        <h1 class="font-display text-4xl sm:text-6xl font-extrabold text-[#3D1A08] leading-tight">Crafting Sweet Moments<br>With Pure Love</h1>
        <p class="text-[#6B3A1F]/70 max-w-2xl mx-auto text-sm sm:text-base font-medium leading-relaxed">
            Welcome to Cakes & Pastries, where every delicacy is a handcrafted masterpiece. We believe in using premium organic ingredients to turn flour, butter, and sugar into sweet memories.
        </p>
    </div>

    {{-- Editorial Double Image Grid with Info --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div class="space-y-6 animate-left opacity-0">
            <span class="text-xs uppercase tracking-widest font-extrabold text-rose-500">The Philosophy</span>
            <h2 class="font-display text-3xl sm:text-4xl font-bold text-[#3D1A08]">Only Premium Organic Ingredients</h2>
            <p class="text-xs sm:text-sm text-[#6B3A1F]/80 leading-relaxed font-medium">
                Our kitchen is dedicated to absolute quality. We source our milk from sustainable pastures, our butter is fresh-churned, and our cocoa is ethically selected premium Belgian chocolate. We strictly avoid artificial preservatives or high-fructose corn syrup, ensuring every bite is rich, light, and naturally flavorful.
            </p>
            <div class="flex items-center gap-4 pt-2">
                <div class="flex items-center -space-x-2">
                    <span class="w-8 h-8 rounded-full bg-rose-200 border border-white flex items-center justify-center text-xs">🥛</span>
                    <span class="w-8 h-8 rounded-full bg-amber-200 border border-white flex items-center justify-center text-xs">🥚</span>
                    <span class="w-8 h-8 rounded-full bg-rose-300 border border-white flex items-center justify-center text-xs">🍫</span>
                </div>
                <span class="text-xs font-bold text-[#3D1A08]">100% Wholesome Ingredients Guaranteed</span>
            </div>
        </div>
        <div class="relative rounded-3xl overflow-hidden border border-[#F5E6D0]/50 shadow-lg group">
            <img src="https://placehold.co/800x600/3D1A08/F5E6D0?text=Premium+Ingredients" 
                 alt="Kitchen Baking Ingredients" 
                 class="w-full h-96 object-cover transition-transform duration-700 group-hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
            <div class="absolute bottom-6 left-6 text-white space-y-1">
                <p class="font-display font-extrabold text-lg">Pure Belgian Cocoa</p>
                <p class="text-[10px] uppercase tracking-wider text-rose-200 font-bold">Chef's Selected Favorites</p>
            </div>
        </div>
    </div>

    {{-- Value Cards --}}
    <div class="space-y-8">
        <h3 class="font-display text-3xl font-bold text-center text-[#3D1A08]">Our Core Standards</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-8 rounded-3xl border border-[#F5E6D0]/40 shadow-xs space-y-4 hover:shadow-md transition-all duration-300">
                <span class="text-3xl">🧑‍🍳</span>
                <h4 class="font-display text-xl font-bold text-[#3D1A08]">Handcrafted</h4>
                <p class="text-xs text-[#6B3A1F]/70 leading-relaxed font-semibold">Every cake is mixed, layered, and decorated entirely by hand by our passionate pasty chefs.</p>
            </div>
            <div class="bg-white p-8 rounded-3xl border border-[#F5E6D0]/40 shadow-xs space-y-4 hover:shadow-md transition-all duration-300">
                <span class="text-3xl">🌿</span>
                <h4 class="font-display text-xl font-bold text-[#3D1A08]">Pure Organic</h4>
                <p class="text-xs text-[#6B3A1F]/70 leading-relaxed font-semibold">Zero artificial colors, zero trans-fats. Sweetened naturally using premium wild honey and fine brown sugar.</p>
            </div>
            <div class="bg-white p-8 rounded-3xl border border-[#F5E6D0]/40 shadow-xs space-y-4 hover:shadow-md transition-all duration-300">
                <span class="text-3xl">📦</span>
                <h4 class="font-display text-xl font-bold text-[#3D1A08]">Fresh Delivery</h4>
                <p class="text-xs text-[#6B3A1F]/70 leading-relaxed font-semibold">Packed in eco-friendly climate-controlled insulated luxury boxes to ensure perfect freshness at your doorstep.</p>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // editorial entrance triggers
        gsap.to('#aboutHero', { opacity: 1, y: 0, duration: 0.8, ease: 'power3.out' });
        gsap.to('.animate-left', { opacity: 1, duration: 0.8, delay: 0.2, ease: 'power3.out' });
    });
</script>
@endsection
