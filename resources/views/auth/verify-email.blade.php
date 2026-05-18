@extends('layouts.app')
@section('title', 'Email Verification')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-16">
    <div id="verifyCard" class="w-full max-w-md bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xl p-8 space-y-6 opacity-0 translate-y-4">
        
        <div class="text-center space-y-2">
            <span class="text-4xl">✉️</span>
            <h1 class="font-display text-3xl font-extrabold text-[#3D1A08]">Verify Your Email</h1>
            <p class="text-xs text-[#6B3A1F]/70 leading-relaxed font-semibold">
                Thanks for joining Cakes & Pastries! Before you start shopping, please verify your email address by clicking the link we just sent you.
            </p>
        </div>

        @if(session('message') == 'verification-link-sent')
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 text-xs font-semibold animate-fadein text-center">
            ✅ A new verification link has been dispatched to the email address provided in your registration.
        </div>
        @endif

        <div class="space-y-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-primary w-full py-4 justify-center rounded-2xl text-xs uppercase tracking-wider font-extrabold shadow-md hover:shadow-lg transition-all">
                    Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" id="logoutFormVerify">
                @csrf
                <button type="submit" class="w-full py-3.5 border border-[#F5E6D0]/50 hover:bg-rose-50 text-[#6B3A1F] rounded-2xl text-xs uppercase tracking-wider font-bold transition-all">
                    Log Out
                </button>
            </form>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Entry reveal using GSAP
        gsap.to('#verifyCard', {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: 'back.out(1.2)'
        });
    });
</script>
@endsection
