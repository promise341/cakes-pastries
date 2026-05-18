@extends('layouts.app')
@section('title', 'Contact Us')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-16 space-y-16">
    
    {{-- Heading --}}
    <div class="text-center space-y-3">
        <span class="text-xs uppercase tracking-widest font-extrabold text-rose-500">Get In Touch</span>
        <h1 class="font-display text-4xl sm:text-5xl font-extrabold text-[#3D1A08]">We'd Love to Hear From You</h1>
        <p class="text-xs sm:text-sm text-[#6B3A1F]/70 max-w-lg mx-auto">Have questions about catering, variant customization, or ordering bulk pastries? Message us below!</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        
        {{-- Contact Details Cards --}}
        <div class="space-y-6">
            
            {{-- Card 1: Call --}}
            <div class="bg-white p-6 rounded-3xl border border-[#F5E6D0]/40 shadow-xs flex items-start gap-4">
                <span class="text-2xl p-3 rounded-2xl bg-[#FDF6EC]">📞</span>
                <div>
                    <h3 class="font-display font-bold text-[#3D1A08] text-sm">Call/WhatsApp</h3>
                    <p class="text-xs text-[#6B3A1F]/80 mt-1 font-semibold">+234 812 345 6789</p>
                    <p class="text-[10px] text-[#6B3A1F]/60">Mon-Sat from 9am to 6pm</p>
                </div>
            </div>

            {{-- Card 2: Email --}}
            <div class="bg-white p-6 rounded-3xl border border-[#F5E6D0]/40 shadow-xs flex items-start gap-4">
                <span class="text-2xl p-3 rounded-2xl bg-[#FDF6EC]">✉️</span>
                <div>
                    <h3 class="font-display font-bold text-[#3D1A08] text-sm">Send Email</h3>
                    <p class="text-xs text-[#6B3A1F]/80 mt-1 font-semibold">orders@cakesandpastries.com</p>
                    <p class="text-[10px] text-[#6B3A1F]/60">We reply within 3 hours</p>
                </div>
            </div>

            {{-- Card 3: Location --}}
            <div class="bg-white p-6 rounded-3xl border border-[#F5E6D0]/40 shadow-xs flex items-start gap-4">
                <span class="text-2xl p-3 rounded-2xl bg-[#FDF6EC]">📍</span>
                <div>
                    <h3 class="font-display font-bold text-[#3D1A08] text-sm">Our Bakehouse</h3>
                    <p class="text-xs text-[#6B3A1F]/80 mt-1 font-semibold">12 Luxury Bakery Avenue</p>
                    <p class="text-[10px] text-[#6B3A1F]/60">Victoria Island, Lagos, Nigeria</p>
                </div>
            </div>

        </div>

        {{-- Contact Form Card --}}
        <div class="lg:col-span-2 bg-white p-8 rounded-3xl border border-[#F5E6D0]/40 shadow-xs">
            <h2 class="font-display text-2xl font-bold text-[#3D1A08] mb-6">Send an Inquiry</h2>

            <form id="contactForm" onsubmit="handleContactSubmit(event)" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="relative">
                        <input type="text" name="name" id="contact_name" required placeholder=" "
                               class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                        <label for="contact_name" 
                               class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 transition-all peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">
                            Full Name
                        </label>
                    </div>

                    <div class="relative">
                        <input type="email" name="email" id="contact_email" required placeholder=" "
                               class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                        <label for="contact_email" 
                               class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 transition-all peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">
                            Email Address
                        </label>
                    </div>
                </div>

                <div class="relative">
                    <input type="text" name="subject" id="contact_subject" required placeholder=" "
                           class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                    <label for="contact_subject" 
                           class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 transition-all peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">
                        Subject
                    </label>
                </div>

                <div class="relative">
                    <textarea name="message" id="contact_message" rows="4" required placeholder=" "
                              class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all"></textarea>
                    <label for="contact_message" 
                           class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 transition-all peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">
                        Your Message
                    </label>
                </div>

                <button type="submit" class="btn-primary w-full py-4 justify-center rounded-2xl text-xs uppercase tracking-wider font-extrabold shadow-md hover:shadow-lg transition-all mt-2">
                    Send Message
                </button>
            </form>
            
            {{-- Success Toast Trigger --}}
            <div id="contactSuccess" class="hidden mt-4 p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 text-xs font-semibold animate-fadein">
                ✅ Thank you! Your inquiry was sent successfully. Our support desk will contact you shortly.
            </div>

        </div>

    </div>

</div>
@endsection

@section('scripts')
<script>
    function handleContactSubmit(event) {
        event.preventDefault();
        
        // Dynamic loading & success show trigger
        document.getElementById('contactForm').reset();
        const success = document.getElementById('contactSuccess');
        success.classList.remove('hidden');
        
        // Hide after 5 seconds automatically
        setTimeout(() => {
            success.classList.add('hidden');
        }, 5000);
    }
</script>
@endsection
