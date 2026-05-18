@extends('layouts.app')
@section('title', 'Frequently Asked Questions')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-16 space-y-12">
    
    {{-- Header --}}
    <div class="text-center space-y-3">
        <span class="text-xs uppercase tracking-widest font-extrabold text-rose-500 bg-rose-50 px-3 py-1 rounded-full">Support Desk</span>
        <h1 class="font-display text-4xl sm:text-5xl font-extrabold text-[#3D1A08]">Got Questions?</h1>
        <p class="text-xs sm:text-sm text-[#6B3A1F]/70">Find swift answers to our most popular inquiries about ingredients, deliveries, and wedding catering below.</p>
    </div>

    {{-- Interactive Alpine Accordion Group --}}
    <div class="space-y-4" x-data="{ active: null }">
        
        {{-- FAQ Item 1 --}}
        <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs overflow-hidden transition-all duration-200"
             :class="active === 1 ? 'shadow-md border-rose-200' : ''">
            <button @click="active = (active === 1 ? null : 1)"
                    class="w-full px-6 py-5 flex justify-between items-center text-left font-display font-bold text-sm sm:text-base text-[#3D1A08]">
                <span>🧁 How fresh are your cakes and pastries?</span>
                <span class="text-lg text-rose-500 font-extrabold transition-transform duration-200" :class="active === 1 ? 'rotate-45' : ''">+</span>
            </button>
            <div x-show="active === 1" x-transition.opacity.duration.300ms
                 class="px-6 pb-5 text-xs sm:text-sm text-[#6B3A1F]/80 leading-relaxed font-semibold border-t border-[#FDF6EC] pt-4">
                Absolutely fresh! We do not freeze or warehouse bake inventory. Every cake, cupcake, or croissant is baked on the exact morning of your selected delivery date, ensuring that when it arrives at your table, the butter is light and the crusts are crispy.
            </div>
        </div>

        {{-- FAQ Item 2 --}}
        <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs overflow-hidden transition-all duration-200"
             :class="active === 2 ? 'shadow-md border-rose-200' : ''">
            <button @click="active = (active === 2 ? null : 2)"
                    class="w-full px-6 py-5 flex justify-between items-center text-left font-display font-bold text-sm sm:text-base text-[#3D1A08]">
                <span>🎂 Do you offer custom inscriptions or design scripting?</span>
                <span class="text-lg text-rose-500 font-extrabold transition-transform duration-200" :class="active === 2 ? 'rotate-45' : ''">+</span>
            </button>
            <div x-show="active === 2" x-transition.opacity.duration.300ms
                 class="px-6 pb-5 text-xs sm:text-sm text-[#6B3A1F]/80 leading-relaxed font-semibold border-t border-[#FDF6EC] pt-4">
                Yes, absolutely! During the checkout steps or on product detail selections, you can add custom order instructions (e.g. "Happy Birthday Sarah!" or "No Nuts"). For completely bespoke layouts (like custom multi-tier wedding cakes), please reach out to our team directly via our contact inquiry form.
            </div>
        </div>

        {{-- FAQ Item 3 --}}
        <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs overflow-hidden transition-all duration-200"
             :class="active === 3 ? 'shadow-md border-rose-200' : ''">
            <button @click="active = (active === 3 ? null : 3)"
                    class="w-full px-6 py-5 flex justify-between items-center text-left font-display font-bold text-sm sm:text-base text-[#3D1A08]">
                <span>🚚 What are your delivery hours and logistics ranges?</span>
                <span class="text-lg text-rose-500 font-extrabold transition-transform duration-200" :class="active === 3 ? 'rotate-45' : ''">+</span>
            </button>
            <div x-show="active === 3" x-transition.opacity.duration.300ms
                 class="px-6 pb-5 text-xs sm:text-sm text-[#6B3A1F]/80 leading-relaxed font-semibold border-t border-[#FDF6EC] pt-4">
                We deliver daily from 8:00 AM to 7:00 PM using insulated climate-controlled dispatch boxes to safeguard chocolate items from melting. We cover all primary suburbs and urban areas. Precise delivery fees are calculated directly on the checkout summary screen based on your address.
            </div>
        </div>

        {{-- FAQ Item 4 --}}
        <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs overflow-hidden transition-all duration-200"
             :class="active === 4 ? 'shadow-md border-rose-200' : ''">
            <button @click="active = (active === 4 ? null : 4)"
                    class="w-full px-6 py-5 flex justify-between items-center text-left font-display font-bold text-sm sm:text-base text-[#3D1A08]">
                <span>🌿 Do you offer gluten-free, eggless, or vegan categories?</span>
                <span class="text-lg text-rose-500 font-extrabold transition-transform duration-200" :class="active === 4 ? 'rotate-45' : ''">+</span>
            </button>
            <div x-show="active === 4" x-transition.opacity.duration.300ms
                 class="px-6 pb-5 text-xs sm:text-sm text-[#6B3A1F]/80 leading-relaxed font-semibold border-t border-[#FDF6EC] pt-4">
                Yes, we cater to all specialty diet restrictions! We have a dedicated range of vegan, eggless, and organic gluten-free options clearly marked inside our Catalog listings. Please check the ingredient lists on details or feel free to message our support desk for custom formulations.
            </div>
        </div>

        {{-- FAQ Item 5 --}}
        <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs overflow-hidden transition-all duration-200"
             :class="active === 5 ? 'shadow-md border-rose-200' : ''">
            <button @click="active = (active === 5 ? null : 5)"
                    class="w-full px-6 py-5 flex justify-between items-center text-left font-display font-bold text-sm sm:text-base text-[#3D1A08]">
                <span>💳 What is your order cancellation or modification policy?</span>
                <span class="text-lg text-rose-500 font-extrabold transition-transform duration-200" :class="active === 5 ? 'rotate-45' : ''">+</span>
            </button>
            <div x-show="active === 5" x-transition.opacity.duration.300ms
                 class="px-6 pb-5 text-xs sm:text-sm text-[#6B3A1F]/80 leading-relaxed font-semibold border-t border-[#FDF6EC] pt-4">
                Since our pastries are bespoke-crafted per order, cancellations or modifications must be submitted at least 24 hours prior to your scheduled dispatch time to receive a full refund. Modifications made within 24 hours can be requested, but might be subject to custom ingredient adjustment charges.
            </div>
        </div>

    </div>

</div>
@endsection
