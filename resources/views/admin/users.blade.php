@extends('layouts.app')
@section('title', 'Users Management')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12 space-y-10">

    {{-- Welcome Admin --}}
    <div class="flex items-center gap-3 border-b border-[#F5E6D0]/50 pb-6">
        <span class="text-4xl">👥</span>
        <div>
            <h1 class="font-display text-3xl font-extrabold text-[#3D1A08]">Customer Accounts Management</h1>
            <p class="text-xs text-[#6B3A1F]/70 mt-1">Audit customer credentials and configure secure administrative panel access.</p>
        </div>
    </div>

    {{-- Admin Navigation Strip --}}
    <div class="flex gap-3 overflow-x-auto pb-2 border-b border-[#FDF6EC] text-[10px] uppercase tracking-wider font-extrabold text-[#6B3A1F]">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-white border border-[#F5E6D0] hover:bg-[#FDF6EC] hover:scale-105 transition-transform shrink-0">📈 Dashboard</a>
        <a href="{{ route('admin.products.index') }}" class="px-4 py-2.5 rounded-xl bg-white border border-[#F5E6D0] hover:bg-[#FDF6EC] hover:scale-105 transition-transform shrink-0">🧁 Products</a>
        <a href="{{ route('admin.categories.index') }}" class="px-4 py-2.5 rounded-xl bg-white border border-[#F5E6D0] hover:bg-[#FDF6EC] hover:scale-105 transition-transform shrink-0">📂 Categories</a>
        <a href="{{ route('admin.coupons.index') }}" class="px-4 py-2.5 rounded-xl bg-white border border-[#F5E6D0] hover:bg-[#FDF6EC] hover:scale-105 transition-transform shrink-0">🎫 Coupons</a>
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 rounded-xl bg-[#3D1A08] text-[#F5E6D0] hover:scale-105 transition-transform shrink-0">👥 Users Access</a>
    </div>

    <div class="flex justify-between items-center">
        <h2 class="font-display text-2xl font-bold text-[#3D1A08]">Registered Users Console</h2>
        <span class="text-xs font-semibold text-[#6B3A1F]/60">Total customer pool size: {{ $users->count() }} accounts</span>
    </div>

    {{-- Users Table --}}
    <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6">
        <div class="overflow-x-auto rounded-2xl border border-[#FDF6EC]">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#FDF6EC] text-[#6B3A1F]/80 uppercase font-extrabold tracking-wider border-b border-[#F5E6D0]/50">
                        <th class="p-4">Profile Name</th>
                        <th class="p-4">Email Coordinates</th>
                        <th class="p-4">Account Type</th>
                        <th class="p-4">Joined Date</th>
                        <th class="p-4 text-center">Safety Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#FDF6EC]">
                    @foreach($users as $user)
                    <tr class="hover:bg-[#FDF6EC]/10 transition-all">
                        <td class="p-4 font-bold text-[#3D1A08]">
                            {{ $user->name }}
                        </td>
                        <td class="p-4 font-semibold text-[#6B3A1F]">
                            {{ $user->email }}
                        </td>
                        <td class="p-4">
                            @if($user->is_admin)
                            <span class="px-2.5 py-0.5 rounded-full text-[9px] font-extrabold uppercase bg-amber-50 text-amber-600 border border-amber-100">
                                🛡️ Admin Console
                            </span>
                            @else
                            <span class="px-2.5 py-0.5 rounded-full text-[9px] font-extrabold uppercase bg-indigo-50 text-indigo-600 border border-indigo-100">
                                🍰 Shop Customer
                            </span>
                            @endif
                        </td>
                        <td class="p-4 text-[#6B3A1F]/80 font-semibold">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center items-center gap-3">
                                {{-- Admin toggle --}}
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 rounded-full border border-[#F5E6D0] hover:bg-[#FDF6EC] text-[#6B3A1F] font-extrabold transition-all">
                                        {{ $user->is_admin ? 'Restrict Role' : 'Promote Admin' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Permanently remove this user account?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 font-extrabold">Terminate Account</button>
                                </form>
                                @else
                                <span class="text-[10px] text-emerald-600 font-extrabold">✓ Active Admin Session</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
