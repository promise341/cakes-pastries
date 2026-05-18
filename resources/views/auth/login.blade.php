@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-16">
    <div id="loginCard" class="w-full max-w-md bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xl p-8 space-y-6 opacity-0 translate-y-4">
        
        <div class="text-center space-y-2">
            <span class="text-4xl">🧁</span>
            <h1 class="font-display text-3xl font-extrabold text-[#3D1A08]">Welcome Back</h1>
            <p class="text-xs text-[#6B3A1F]/70">Enter your credentials to access your sweet dashboard.</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            
            {{-- Email Input --}}
            <div class="relative">
                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder=" "
                       class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-sm font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                <label for="email" 
                       class="absolute left-4 top-2 text-[10px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 transition-all peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[10px] peer-focus:text-rose-500 pointer-events-none">
                    Email Address
                </label>
                @error('email')
                    <p class="text-xs text-rose-500 mt-1 pl-2 font-semibold">⚠️ {{ $message }}</p>
                @enderror
            </div>

            {{-- Password Input --}}
            <div class="relative">
                <input type="password" name="password" id="password" required placeholder=" "
                       class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-sm font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                <label for="password" 
                       class="absolute left-4 top-2 text-[10px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 transition-all peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[10px] peer-focus:text-rose-500 pointer-events-none">
                    Password
                </label>
                @error('password')
                    <p class="text-xs text-rose-500 mt-1 pl-2 font-semibold">⚠️ {{ $message }}</p>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center justify-between text-xs font-semibold text-[#6B3A1F] px-1">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded text-rose-500 focus:ring-rose-500 border-[#F5E6D0] bg-[#FDF6EC]">
                    Remember me
                </label>
                <a href="#" class="text-rose-600 hover:underline">Forgot password?</a>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn-primary w-full py-4 justify-center rounded-2xl text-xs uppercase tracking-wider font-extrabold shadow-md hover:shadow-lg transition-all mt-2">
                Sign In
            </button>
        </form>

        <div class="text-center border-t border-[#F5E6D0]/40 pt-6 text-xs text-[#6B3A1F]/80">
            Don't have an account yet? 
            <a href="{{ route('register') }}" class="font-bold text-[#3D1A08] hover:text-rose-600 transition-colors underline ml-1">Create Account</a>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Butter-smooth entrance animation for the login card using GSAP
        gsap.to('#loginCard', {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: 'back.out(1.2)'
        });
    });
</script>
@endsection
