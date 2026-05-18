@extends('layouts.app')
@section('title', 'Reset Password')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-16">
    <div id="resetCard" class="w-full max-w-md bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xl p-8 space-y-6 opacity-0 translate-y-4">
        
        <div class="text-center space-y-2">
            <span class="text-4xl">🔐</span>
            <h1 class="font-display text-3xl font-extrabold text-[#3D1A08]">New Password</h1>
            <p class="text-xs text-[#6B3A1F]/70">Enter your new secure password below to regain full account access.</p>
        </div>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-4" id="resetForm">
            @csrf
            
            {{-- Token stub --}}
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            {{-- Email Input --}}
            <div class="relative">
                <input type="email" name="email" id="email" value="{{ request('email') }}" required placeholder=" "
                       class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-sm font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                <label for="email" 
                       class="absolute left-4 top-2 text-[10px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 transition-all peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[10px] peer-focus:text-rose-500 pointer-events-none">
                    Email Address
                </label>
            </div>

            {{-- Password Input --}}
            <div class="relative">
                <input type="password" name="password" id="password" required placeholder=" "
                       class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-sm font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                <label for="password" 
                       class="absolute left-4 top-2 text-[10px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 transition-all peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[10px] peer-focus:text-rose-500 pointer-events-none">
                    New Password
                </label>
                @error('password')
                    <p class="text-xs text-rose-500 mt-1 pl-2 font-semibold">⚠️ {{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="relative">
                <input type="password" name="password_confirmation" id="password_confirmation" required placeholder=" "
                       class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-sm font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                <label for="password_confirmation" 
                       class="absolute left-4 top-2 text-[10px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 transition-all peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[10px] peer-focus:text-rose-500 pointer-events-none">
                    Confirm Password
                </label>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn-primary w-full py-4 justify-center rounded-2xl text-xs uppercase tracking-wider font-extrabold shadow-md hover:shadow-lg transition-all mt-2">
                Save & Sign In
            </button>
        </form>

        {{-- Success Notice --}}
        <div id="resetSuccess" class="hidden p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 text-xs font-semibold animate-fadein text-center space-y-3">
            <p>✅ Password updated successfully!</p>
            <a href="{{ route('login') }}" class="inline-block btn-primary text-[10px] py-2 px-6 rounded-full uppercase tracking-wider font-extrabold">Log In Now</a>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // butter-smooth entry reveal using GSAP
        gsap.to('#resetCard', {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: 'back.out(1.2)'
        });

        // Handle custom secure form submission stub
        const form = document.getElementById('resetForm');
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            form.classList.add('hidden');
            document.getElementById('resetSuccess').classList.remove('hidden');
        });
    });
</script>
@endsection
