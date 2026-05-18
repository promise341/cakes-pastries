@extends('layouts.app')
@section('title', 'My Premium Account')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12 space-y-10" x-data="{ currentTab: 'orders' }">
    
    {{-- Welcome Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-[#F5E6D0]/50 pb-6">
        <div class="flex items-center gap-3">
            <span class="text-4xl">🧑‍🍳</span>
            <div>
                <h1 class="font-display text-3xl font-extrabold text-[#3D1A08]">My Premium Account</h1>
                <p class="text-xs text-[#6B3A1F]/70 mt-1">Hello, {{ auth()->user()->name }}. Manage your orders, wishlist, delivery address book, and profile below.</p>
            </div>
        </div>
        
        @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.dashboard') }}" class="btn-primary py-2.5 px-6 rounded-full text-xs uppercase tracking-widest font-extrabold shadow-sm">
            Go to Admin Console 🛡️
        </a>
        @endif
    </div>

    {{-- Layout Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
        
        {{-- Navigation Side Tabs --}}
        <aside class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6 space-y-2 lg:sticky lg:top-24">
            <button @click="currentTab = 'orders'; document.getElementById('dashboard-content-area').scrollIntoView({ behavior: 'smooth' })" 
                    :class="currentTab === 'orders' ? 'bg-[#3D1A08] text-[#F5E6D0]' : 'bg-[#FDF6EC] text-[#6B3A1F] hover:bg-[#F5E6D0]/20'"
                    class="w-full text-left px-4 py-3 rounded-xl text-xs font-extrabold transition-all flex items-center gap-3">
                <span>📦</span> Order History
            </button>
            <button @click="currentTab = 'wishlist'; document.getElementById('dashboard-content-area').scrollIntoView({ behavior: 'smooth' })" 
                    :class="currentTab === 'wishlist' ? 'bg-[#3D1A08] text-[#F5E6D0]' : 'bg-[#FDF6EC] text-[#6B3A1F] hover:bg-[#F5E6D0]/20'"
                    class="w-full text-left px-4 py-3 rounded-xl text-xs font-extrabold transition-all flex items-center gap-3">
                <span>❤️</span> My Wishlist
            </button>
            <button @click="currentTab = 'addresses'; document.getElementById('dashboard-content-area').scrollIntoView({ behavior: 'smooth' })" 
                    :class="currentTab === 'addresses' ? 'bg-[#3D1A08] text-[#F5E6D0]' : 'bg-[#FDF6EC] text-[#6B3A1F] hover:bg-[#F5E6D0]/20'"
                    class="w-full text-left px-4 py-3 rounded-xl text-xs font-extrabold transition-all flex items-center gap-3">
                <span>📍</span> Saved Addresses
            </button>
            <button @click="currentTab = 'profile'; document.getElementById('dashboard-content-area').scrollIntoView({ behavior: 'smooth' })" 
                    :class="currentTab === 'profile' ? 'bg-[#3D1A08] text-[#F5E6D0]' : 'bg-[#FDF6EC] text-[#6B3A1F] hover:bg-[#F5E6D0]/20'"
                    class="w-full text-left px-4 py-3 rounded-xl text-xs font-extrabold transition-all flex items-center gap-3">
                <span>⚙️</span> Profile Settings
            </button>
        </aside>

        {{-- Main tab panels --}}
        <div id="dashboard-content-area" class="lg:col-span-3 space-y-6 scroll-mt-24">
            
            {{-- TAB 1: ORDER HISTORY --}}
            <div x-show="currentTab === 'orders'" class="space-y-6 animate-fadein">
                
                {{-- Metrics Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-2xl border border-[#F5E6D0]/40 shadow-xs p-5 flex items-center gap-4">
                        <span class="text-2xl p-2.5 rounded-xl bg-[#FDF6EC]">🍰</span>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-[#6B3A1F]/60 font-extrabold block">Total Orders</span>
                            <span class="text-xl font-extrabold text-[#3D1A08]">{{ $totalOrders }}</span>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl border border-[#F5E6D0]/40 shadow-xs p-5 flex items-center gap-4">
                        <span class="text-2xl p-2.5 rounded-xl bg-[#FDF6EC]">💳</span>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-[#6B3A1F]/60 font-extrabold block">Spent</span>
                            <span class="text-xl font-extrabold text-[#3D1A08]">₦{{ number_format($totalSpent, 0) }}</span>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl border border-[#F5E6D0]/40 shadow-xs p-5 flex items-center gap-4">
                        <span class="text-2xl p-2.5 rounded-xl bg-[#FDF6EC]">🚚</span>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-[#6B3A1F]/60 font-extrabold block">Active Deliveries</span>
                            <span class="text-xl font-extrabold text-[#3D1A08]">{{ $pendingDeliveries }}</span>
                        </div>
                    </div>
                </div>

                {{-- Orders List --}}
                <div class="space-y-4">
                    @forelse($orders as $order)
                    <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-[#FDF6EC] pb-4 mb-4">
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-display font-extrabold text-sm text-[#3D1A08]">{{ $order->order_number }}</span>
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase {{ $order->payment_status === 'paid' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-500' }}">
                                        {{ $order->payment_status === 'paid' ? 'Paid' : 'Pending Payment' }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase bg-[#FDF6EC] text-[#6B3A1F]">
                                        {{ $order->status }}
                                    </span>
                                </div>
                                <span class="text-[10px] text-[#6B3A1F]/50 block mt-1">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</span>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <span class="font-display font-extrabold text-lg text-rose-600">₦{{ number_format($order->total_amount, 0) }}</span>
                                <a href="{{ route('order.track') }}?order_number={{ $order->order_number }}&email={{ urlencode($order->email) }}" 
                                   class="px-4 py-2 rounded-full border border-[#F5E6D0] hover:bg-[#FDF6EC] transition-all text-[10px] uppercase font-extrabold text-[#6B3A1F] shadow-xs">
                                    Track Order
                                </a>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            @foreach($order->items as $item)
                            <div class="flex justify-between items-center bg-[#FDF6EC]/40 p-2.5 rounded-xl border border-[#FDF6EC]/10 text-xs">
                                <span class="font-semibold text-[#3D1A08] truncate max-w-[200px]">{{ $item->product_name }}</span>
                                <span class="text-[#6B3A1F] font-bold">×{{ $item->quantity }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs">
                        <span class="text-4xl">🧁</span>
                        <p class="text-xs font-bold text-[#6B3A1F] mt-3">You haven't placed any pastry orders yet.</p>
                        <a href="{{ route('products.index') }}" class="inline-block btn-primary text-[10px] py-2.5 px-6 rounded-full uppercase tracking-wider font-extrabold mt-4">Browse Catalog</a>
                    </div>
                    @endforelse
                </div>

            </div>

            {{-- TAB 2: MY WISHLIST --}}
            <div x-show="currentTab === 'wishlist'" class="space-y-4 animate-fadein">
                <h3 class="font-display font-bold text-lg text-[#3D1A08]">Saved Wishlist Delicacies</h3>
                
                @if($wishlists->isEmpty())
                <div class="text-center py-12 bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs">
                    <span class="text-4xl">❤️</span>
                    <p class="text-xs font-bold text-[#6B3A1F] mt-3">Your wishlist is currently empty.</p>
                </div>
                @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($wishlists as $item)
                    <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-4 flex gap-4 items-center">
                        <img src="{{ $item->image_url }}" class="w-16 h-16 rounded-2xl object-cover bg-[#FDF6EC]" onerror="this.src='https://placehold.co/100?text=🎂'">
                        
                        <div class="flex-grow min-w-0">
                            <h4 class="font-bold text-xs text-[#3D1A08] truncate">{{ $item->name }}</h4>
                            <p class="text-[10px] text-rose-600 font-extrabold mt-0.5">₦{{ number_format($item->price, 0) }}</p>
                            
                            <div class="flex items-center gap-3 mt-2">
                                <a href="{{ route('products.show', $item) }}" class="text-[10px] font-bold text-[#6B3A1F] underline">View Details</a>
                                
                                <form action="{{ route('wishlist.toggle', $item) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[10px] font-bold text-rose-500 hover:text-rose-700">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- TAB 3: SAVED ADDRESSES --}}
            <div x-show="currentTab === 'addresses'" class="space-y-6 animate-fadein" x-data="{ openAdd: false }">
                <div class="flex justify-between items-center">
                    <h3 class="font-display font-bold text-lg text-[#3D1A08]">Address Book</h3>
                    <button @click="openAdd = !openAdd" class="btn-primary py-2 px-4 rounded-xl text-[10px] uppercase tracking-wider font-extrabold">
                        + Add Address
                    </button>
                </div>

                {{-- Add address form --}}
                <div x-show="openAdd" class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6 space-y-4">
                    <h4 class="font-display font-bold text-sm text-[#3D1A08]">New Delivery Location</h4>
                    <form action="{{ route('addresses.store') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="relative">
                                <input type="text" name="customer_name" id="addr_name" required placeholder=" "
                                       class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                                <label for="addr_name" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">Recipient Name</label>
                            </div>
                            <div class="relative">
                                <input type="text" name="phone" id="addr_phone" required placeholder=" "
                                       class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                                <label for="addr_phone" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">Phone Contact</label>
                            </div>
                        </div>

                        <div class="relative">
                            <input type="text" name="address_line_1" id="addr_1" required placeholder=" "
                                   class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                            <label for="addr_1" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">Street Address</label>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="relative">
                                <input type="text" name="city" id="addr_city" required placeholder=" "
                                       class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                                <label for="addr_city" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">City</label>
                            </div>
                            <div class="relative">
                                <input type="text" name="state" id="addr_state" required placeholder=" "
                                       class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                                <label for="addr_state" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">State/Region</label>
                            </div>
                            <div class="relative">
                                <input type="text" name="postal_code" id="addr_zip" placeholder=" "
                                       class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                                <label for="addr_zip" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">Postal Code (Optional)</label>
                            </div>
                        </div>

                        <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-[#3D1A08]">
                            <input type="checkbox" name="is_default" value="1" class="rounded border-[#F5E6D0] text-rose-500 focus:ring-rose-500">
                            <span>Set as default delivery address</span>
                        </label>

                        <button type="submit" class="btn-primary py-3 px-6 rounded-xl text-[10px] uppercase tracking-wider font-extrabold">
                            Save Address
                        </button>
                    </form>
                </div>

                {{-- Addresses List --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($addresses as $addr)
                    <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6 space-y-3 relative">
                        @if($addr->is_default)
                        <span class="absolute top-4 right-4 bg-emerald-50 text-emerald-600 text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-full border border-emerald-100">
                            Default
                        </span>
                        @endif

                        <h4 class="font-display font-extrabold text-sm text-[#3D1A08]">{{ $addr->customer_name }}</h4>
                        <p class="text-xs text-[#6B3A1F]/70 mt-1 leading-relaxed font-semibold">{{ $addr->full_address }}</p>
                        <p class="text-xs text-[#6B3A1F]/60">📞 Contact: {{ $addr->phone }}</p>

                        <div class="flex items-center gap-3 pt-2 border-t border-[#FDF6EC] text-[10px] font-bold">
                            <form action="{{ route('addresses.destroy', $addr) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-500 hover:text-rose-700">Delete Address</button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-8 opacity-60">
                        <span class="text-4xl">📍</span>
                        <p class="text-xs font-bold text-[#6B3A1F] mt-2">No delivery locations saved. Save your address for speedy checkouts!</p>
                    </div>
                    @endforelse
                </div>

            </div>

            {{-- TAB 4: PROFILE SETTINGS --}}
            <div x-show="currentTab === 'profile'" class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-8 space-y-6 animate-fadein">
                <h3 class="font-display font-bold text-lg text-[#3D1A08]">User Account Settings</h3>
                
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="relative">
                            <input type="text" name="name" id="prof_name" value="{{ auth()->user()->name }}" required placeholder=" "
                                   class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                            <label for="prof_name" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">Profile Display Name</label>
                        </div>
                        <div class="relative">
                            <input type="email" name="email" id="prof_email" value="{{ auth()->user()->email }}" required placeholder=" "
                                   class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                            <label for="prof_email" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">Email Coordinates</label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="relative">
                            <input type="password" name="password" id="prof_pass" placeholder=" "
                                   class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                            <label for="prof_pass" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">New Secure Password (Optional)</label>
                        </div>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="prof_pass_conf" placeholder=" "
                                   class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                            <label for="prof_pass_conf" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">Verify New Password</label>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary py-3.5 px-8 rounded-xl text-[10px] uppercase tracking-wider font-extrabold shadow-sm mt-2">
                        Update Settings
                    </button>
                </form>
            </div>

        </div>

    </div>

</div>
@endsection
