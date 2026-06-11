@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-[1fr_380px] gap-8">
    
    <!-- Left Column (Stats + Main Cards) -->
    <div class="space-y-8">
        
        <!-- Top Stats Row -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Total Trip -->
            <div class="bg-white rounded-[24px] p-5 shadow-sm border border-gray-100 flex items-center space-x-4 hover:shadow-md transition-shadow">
                <div class="w-[52px] h-[52px] rounded-[18px] bg-purple-50 flex items-center justify-center text-purple-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <p class="text-[11px] text-gray-500 font-semibold uppercase tracking-wider mb-0.5">Total Trip</p>
                    <p class="text-2xl font-extrabold text-gray-900 leading-none">{{ $totalTrips }}</p>
                    <p class="text-[10px] text-gray-400 mt-1 font-medium">Semua waktu</p>
                </div>
            </div>

            <!-- Trip Aktif -->
            <div class="bg-white rounded-[24px] p-5 shadow-sm border border-gray-100 flex items-center space-x-4 hover:shadow-md transition-shadow">
                <div class="w-[52px] h-[52px] rounded-[18px] bg-sky-50 flex items-center justify-center text-sky-500 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[11px] text-gray-500 font-semibold uppercase tracking-wider mb-0.5">Trip Aktif</p>
                    <p class="text-2xl font-extrabold text-gray-900 leading-none">{{ $activeTrips }}</p>
                    <p class="text-[10px] text-gray-400 mt-1 font-medium">Sedang berjalan</p>
                </div>
            </div>

            <!-- Destinasi Wishlist -->
            <div class="bg-white rounded-[24px] p-5 shadow-sm border border-gray-100 flex items-center space-x-4 hover:shadow-md transition-shadow">
                <div class="w-[52px] h-[52px] rounded-[18px] bg-amber-50 flex items-center justify-center text-amber-500 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[11px] text-gray-500 font-semibold uppercase tracking-wider mb-0.5">Destinasi Wishlist</p>
                    <p class="text-2xl font-extrabold text-gray-900 leading-none">{{ $destinationsWishlist }}</p>
                    <p class="text-[10px] text-gray-400 mt-1 font-medium">Tempat tujuan</p>
                </div>
            </div>

            <!-- Progress Persiapan -->
            <div class="bg-white rounded-[24px] p-5 shadow-sm border border-gray-100 flex items-center space-x-4 hover:shadow-md transition-shadow">
                <div class="w-[52px] h-[52px] rounded-[18px] bg-emerald-50 flex items-center justify-center text-emerald-500 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <div>
                    <p class="text-[11px] text-gray-500 font-semibold uppercase tracking-wider mb-0.5">Progress Persiapan</p>
                    <p class="text-2xl font-extrabold text-gray-900 leading-none">{{ $progressPersiapan }}%</p>
                    <p class="text-[10px] text-gray-400 mt-1 font-medium">Berdasarkan packing</p>
                </div>
            </div>
        </div>

        <!-- Trip Terdekat (Hero Card) -->
        <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden relative group">
            @if($nearestTrip)
                <div class="h-[240px] bg-gray-200 relative overflow-hidden">
                    <!-- Dynamic cover based on trip name or fallback to a nice landscape -->
                    <img src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="{{ $nearestTrip->title }}" class="w-full h-full object-cover">
                    
                    <div class="absolute top-5 left-5 bg-indigo-600/90 backdrop-blur-md text-white text-[11px] font-bold uppercase tracking-wider px-4 py-2 rounded-xl">
                        Trip Terdekat
                    </div>
                    
                    <button class="absolute top-5 right-5 w-11 h-11 bg-white/90 backdrop-blur-md rounded-2xl flex items-center justify-center text-red-500 shadow-sm hover:scale-105 transition-transform cursor-pointer">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
                
                <div class="px-8 pb-8 pt-6 relative">
                    <!-- Progress Circle Overlay -->
                    <div class="absolute -top-14 right-8 w-28 h-28 bg-white rounded-full p-1.5 shadow-xl border border-gray-50 flex items-center justify-center z-10">
                        <div class="relative flex items-center justify-center w-full h-full bg-white rounded-full">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                <path class="text-indigo-50" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                <path class="text-indigo-600 transition-all duration-1000" stroke-width="3" stroke-dasharray="{{ $progressPersiapan }}, 100" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            </svg>
                            <div class="absolute text-center flex flex-col items-center justify-center">
                                <span class="text-xl font-extrabold text-gray-900 block leading-none">{{ $progressPersiapan }}%</span>
                                <span class="text-[9px] text-gray-500 font-medium uppercase tracking-wide mt-0.5">Persiapan</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 mb-2">
                        <h3 class="text-[28px] font-extrabold text-gray-900 leading-none">{{ $nearestTrip->title }}</h3>
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 shrink-0"></span>
                    </div>
                    <p class="text-[15px] font-medium text-gray-500 mb-8">{{ $nearestTrip->country_or_city }}</p>

                    <div class="flex items-center space-x-12 mb-8">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-[16px] bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[13px] font-bold text-gray-900">{{ \Carbon\Carbon::parse($nearestTrip->start_date)->translatedFormat('d M Y') }}</p>
                                <p class="text-[11px] text-gray-500 font-medium mt-0.5">Tanggal Berangkat</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-[16px] bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[13px] font-bold text-gray-900">{{ $nearestTrip->pax_count ?? 1 }} Orang</p>
                                <p class="text-[11px] text-gray-500 font-medium mt-0.5">Jumlah Peserta</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-[16px] bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                @php
                                    $diff = max(0, \Carbon\Carbon::parse($nearestTrip->start_date)->diffInDays(now()));
                                @endphp
                                <p class="text-[13px] font-bold text-gray-900">{{ $diff }} Hari Lagi</p>
                                <p class="text-[11px] text-gray-500 font-medium mt-0.5">Menuju keberangkatan</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('frontend.trips') }}" class="inline-flex bg-indigo-50 text-indigo-600 px-6 py-3 rounded-2xl text-[13px] font-bold hover:bg-indigo-100 transition-colors items-center space-x-2">
                        <span>Lihat Detail Trip</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            @else
                <!-- No Trip Active State -->
                <div class="px-8 py-20 text-center flex flex-col items-center justify-center bg-white">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center text-4xl mb-4">🏝️</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada trip aktif</h3>
                    <p class="text-sm text-gray-500 mb-6 max-w-sm">Anda belum memiliki rencana perjalanan yang akan datang. Ayo buat sekarang!</p>
                    <button type="button" onclick="openTripModal()" class="bg-indigo-600 text-white px-6 py-3 rounded-2xl text-sm font-semibold hover:bg-indigo-700 shadow-md shadow-indigo-200 transition-all">Buat Trip Sekarang</button>
                </div>
            @endif
        </div>

        <!-- Bottom Row (Itinerary & Wishlist) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Itinerary Ringkas -->
            <div class="bg-white rounded-[24px] p-6 shadow-sm border border-gray-100 flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900">Itinerary Ringkas</h4>
                    </div>
                    <a href="{{ route('frontend.itineraries') }}" class="text-[11px] font-bold text-indigo-600 bg-indigo-50 px-4 py-1.5 rounded-full hover:bg-indigo-100 transition-colors">Lihat Semua</a>
                </div>
                
                <div class="space-y-4 flex-1">
                    @if($nearestTrip && count($itineraries) > 0)
                        @foreach($itineraries as $day => $items)
                            <div class="flex items-start">
                                <div class="w-16 pt-0.5 text-[13px] text-indigo-600 font-bold shrink-0">Hari {{ $day }}</div>
                                <div class="flex-1 text-[13px] font-medium text-gray-600 pl-4 border-l-2 border-indigo-50 leading-relaxed">
                                    {{ implode(' - ', $items->map(fn($i) => $i->destination ? $i->destination->name : $i->activity)->toArray()) }}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="h-full flex flex-col items-center justify-center text-center py-6">
                            <p class="text-[13px] font-medium text-gray-400">Tidak ada rincian itinerary.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Wishlist Destinasi -->
            <div class="bg-white rounded-[24px] p-6 shadow-sm border border-gray-100 flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-xl bg-red-50 flex items-center justify-center text-red-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900">Wishlist Destinasi</h4>
                    </div>
                    <a href="{{ route('frontend.destinations') }}" class="text-[11px] font-bold text-indigo-600 bg-indigo-50 px-4 py-1.5 rounded-full hover:bg-indigo-100 transition-colors">Lihat Semua</a>
                </div>
                
                <div class="space-y-3 flex-1 overflow-y-auto no-scrollbar pr-2">
                    @forelse($destinations as $dest)
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:border-indigo-100 hover:bg-indigo-50/50 transition-colors cursor-pointer group" onclick="window.location='{{ route('frontend.destinations') }}'">
                            <div class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-400 group-hover:text-indigo-500 group-hover:border-indigo-200 transition-colors shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[13px] font-bold text-gray-900 truncate group-hover:text-indigo-700 transition-colors">{{ $dest->name }}</p>
                                @if($dest->visit_date)
                                    <p class="text-[11px] font-medium text-gray-500 truncate">{{ \Carbon\Carbon::parse($dest->visit_date)->translatedFormat('d M Y') }}</p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="h-full flex flex-col items-center justify-center text-center py-6">
                            <p class="text-[13px] font-medium text-gray-400">Belum ada destinasi di wishlist.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Tips Banner -->
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-[24px] p-5 flex items-center space-x-4 border border-amber-100/50 shadow-sm">
            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-2xl shadow-sm shrink-0">💡</div>
            <div>
                <h5 class="text-[14px] font-bold text-amber-900 mb-0.5">Tips Perjalanan Pintar</h5>
                <p class="text-[12px] font-medium text-amber-700/80">Jangan lupa untuk memeriksa cuaca sebelum berangkat dan lengkapi packing list Anda jauh-jauh hari!</p>
            </div>
            <div class="ml-auto text-3xl opacity-80 pl-4 hidden sm:block">⛅</div>
        </div>
    </div>

    <!-- Right Column (Budget + Checklist) -->
    <div class="space-y-8">
        
        <!-- Estimasi Budget -->
        <div class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-100">
            <h4 class="font-extrabold text-gray-900 mb-8 text-lg">Estimasi Budget<br><span class="text-[13px] font-medium text-gray-500">{{ $nearestTrip->title ?? 'Belum ada trip' }}</span></h4>
            
            @if($totalBudget > 0)
                <div class="relative w-[200px] h-[200px] mx-auto mb-8">
                    <canvas id="budgetChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total</span>
                        <span class="text-lg font-extrabold text-gray-900">Rp {{ number_format($totalBudget / 1000000, 1, ',', '') }}Jt</span>
                    </div>
                </div>

                <div class="space-y-4 mb-8">
                    @foreach($expenses->take(4) as $idx => $expense)
                        @php
                            $colors = ['bg-[#38bdf8]', 'bg-[#6366f1]', 'bg-[#fb923c]', 'bg-[#34d399]'];
                            $colorClass = $colors[$idx % count($colors)];
                        @endphp
                        <div class="flex items-center justify-between text-[13px]">
                            <div class="flex items-center space-x-3">
                                <div class="w-2.5 h-2.5 rounded-full {{ $colorClass }}"></div>
                                <span class="font-medium text-gray-600">{{ $expense->expense_name }}</span>
                            </div>
                            <span class="font-bold text-gray-900">Rp {{ number_format($expense->total_amount, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="h-[200px] flex flex-col items-center justify-center mb-8 bg-gray-50 rounded-[20px] border border-dashed border-gray-200">
                    <div class="text-3xl mb-2 opacity-50">💰</div>
                    <p class="text-[13px] font-medium text-gray-400">Belum ada pengeluaran</p>
                </div>
            @endif
            
            <a href="{{ route('frontend.expenses') }}" class="block text-center w-full bg-gray-50 text-gray-700 font-bold py-3 rounded-2xl hover:bg-gray-100 transition-colors mt-6 text-sm">Kelola Budget</a>
        </div>

        <!-- Checklist Persiapan -->
        <div class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-8">
                <h4 class="font-extrabold text-gray-900 text-lg">Checklist Persiapan</h4>
                <a href="{{ route('frontend.packinglists') }}" class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                </a>
            </div>

            <div class="space-y-5 relative before:absolute before:inset-0 before:ml-[19px] before:-translate-x-px before:h-full before:w-[2px] before:bg-gradient-to-b before:from-gray-100 before:via-gray-100 before:to-transparent">
                
                @forelse($packingLists as $idx => $item)
                    <div class="relative flex items-center space-x-5 group">
                        @if($item->is_checked)
                            <div class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center shadow-md shadow-emerald-200 z-10 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="flex-1 bg-white p-3.5 rounded-[18px] border border-gray-100 flex items-center space-x-3 shadow-sm group-hover:border-emerald-100 transition-colors">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[13px] font-bold text-gray-900 leading-tight mb-0.5 line-through opacity-70">{{ $item->item_name }}</p>
                                    <p class="text-[10px] font-medium text-emerald-600 uppercase tracking-wide">Selesai</p>
                                </div>
                            </div>
                        @else
                            <div class="w-10 h-10 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center z-10 shrink-0 group-hover:border-indigo-400 transition-colors">
                            </div>
                            <div class="flex-1 bg-white p-3.5 rounded-[18px] border border-gray-100 flex items-center space-x-3 shadow-sm group-hover:shadow-md transition-all cursor-pointer">
                                <div class="w-10 h-10 rounded-xl bg-gray-50 text-gray-400 flex items-center justify-center shrink-0 group-hover:bg-indigo-50 group-hover:text-indigo-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[13px] font-bold text-gray-900 leading-tight mb-0.5 group-hover:text-indigo-600 transition-colors">{{ $item->item_name }}</p>
                                    <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wide">Belum selesai</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="py-8 text-center bg-gray-50 rounded-[20px] border border-dashed border-gray-200">
                        <p class="text-[13px] font-medium text-gray-400">Tidak ada checklist.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
@if($totalBudget > 0)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('budgetChart');
        if(ctx) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($expenses->pluck('expense_name')) !!},
                    datasets: [{
                        data: {!! json_encode($expenses->pluck('total_amount')) !!},
                        backgroundColor: [
                            '#38bdf8', // sky-400
                            '#6366f1', // indigo-500
                            '#fb923c', // orange-400
                            '#34d399', // emerald-400
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '78%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(17, 24, 39, 0.9)',
                            padding: 12,
                            titleFont: { family: 'Inter', size: 13 },
                            bodyFont: { family: 'Inter', size: 13, weight: 'bold' },
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(context.parsed);
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endif
@endpush

<!-- Create Trip Modal -->
<div id="tripModal" class="fixed inset-0 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeTripModal()"></div>
    
    <div class="bg-white rounded-[32px] p-8 w-full max-w-lg relative z-10 shadow-2xl transform scale-95 transition-transform duration-300" id="tripModalContent">
        <button onclick="closeTripModal()" class="absolute top-6 right-6 w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="mb-6">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-2xl font-extrabold text-gray-900">Buat Trip Baru</h3>
            <p class="text-sm text-gray-500 mt-1">Isi informasi untuk petualangan Anda berikutnya!</p>
        </div>

        <form action="{{ route('trips.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="title" class="block text-[13px] font-bold text-gray-700 mb-1">Nama Rencana Trip <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" required placeholder="Contoh: Eksplorasi Jepang Bersama Keluarga" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors">
            </div>
            
            <div>
                <label for="country_or_city" class="block text-[13px] font-bold text-gray-700 mb-1">Kota / Negara Tujuan <span class="text-red-500">*</span></label>
                <input type="text" id="country_or_city" name="country_or_city" required placeholder="Contoh: Tokyo, Jepang" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="block text-[13px] font-bold text-gray-700 mb-1">Tanggal Berangkat <span class="text-red-500">*</span></label>
                    <input type="date" id="start_date" name="start_date" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors text-gray-600">
                </div>
                <div>
                    <label for="pax_count" class="block text-[13px] font-bold text-gray-700 mb-1">Jumlah Peserta <span class="text-red-500">*</span></label>
                    <input type="number" id="pax_count" name="pax_count" required min="1" value="1" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors text-gray-600">
                </div>
            </div>

            <div class="pt-4 flex space-x-3">
                <button type="button" onclick="closeTripModal()" class="flex-1 px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 shadow-md shadow-indigo-200 transition-all">Simpan Trip</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openTripModal() {
        const modal = document.getElementById('tripModal');
        const content = document.getElementById('tripModalContent');
        modal.classList.remove('hidden');
        // Trigger reflow
        void modal.offsetWidth;
        modal.classList.remove('opacity-0');
        content.classList.remove('scale-95');
    }

    function closeTripModal() {
        const modal = document.getElementById('tripModal');
        const content = document.getElementById('tripModalContent');
        modal.classList.add('opacity-0');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>

@include('dashboard.modals')
