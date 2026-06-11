@extends('layouts.app')

@section('content')
<div class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-100 min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900">Daftar Rencana Trip</h2>
            <p class="text-gray-500 mt-1">Kelola semua rencana perjalanan Anda di sini.</p>
        </div>
        <button onclick="openTripModal()" class="bg-indigo-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-indigo-700 shadow-md shadow-indigo-200 transition-all flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            <span>Trip Baru</span>
        </button>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-600 px-6 py-4 rounded-2xl mb-8 font-bold border border-emerald-100 flex items-center space-x-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($trips as $trip)
            <div class="bg-gray-50 rounded-[24px] p-6 border border-gray-100 hover:shadow-md transition-all group">
                <div class="h-40 bg-gray-200 rounded-[16px] mb-5 overflow-hidden relative">
                    <img src="https://source.unsplash.com/600x400/?{{ urlencode($trip->country_or_city) }},travel" alt="{{ $trip->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.src='https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?w=600&q=80'">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-colors"></div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-1 truncate" title="{{ $trip->title }}">{{ $trip->title }}</h3>
                <p class="text-gray-500 font-medium mb-4 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>{{ $trip->country_or_city }}</span>
                </p>
                <div class="flex items-center space-x-6 text-sm text-gray-600 mb-6">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-bold">{{ \Carbon\Carbon::parse($trip->start_date)->translatedFormat('d M Y') }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="font-bold">{{ $trip->pax_count }} Pax</span>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-3 pt-4 border-t border-gray-200">
                    <button onclick="openEditTripModal({{ $trip->id }}, '{{ addslashes($trip->title) }}', '{{ addslashes($trip->country_or_city) }}', '{{ $trip->start_date }}', {{ $trip->pax_count }})" class="py-2.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl text-sm hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-colors text-center">Edit</button>
                    <form action="{{ route('trips.destroy', $trip) }}" method="POST" class="w-full">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus trip ini? Semua data terkait akan ikut terhapus.')" class="w-full py-2.5 bg-red-50 text-red-600 font-bold rounded-xl text-sm hover:bg-red-100 transition-colors">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center bg-gray-50 rounded-[24px] border border-dashed border-gray-200">
                <div class="text-5xl mb-4">🌍</div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Belum ada trip.</h3>
                <p class="text-sm text-gray-500">Mulai rencanakan petualangan pertama Anda!</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Include existing create modals (tripModal) -->
@include('dashboard.modals')

<!-- Edit Trip Modal -->
<div id="editTripModal" class="fixed inset-0 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeEditTripModal()"></div>
    <div class="bg-white rounded-[32px] p-8 w-full max-w-lg relative z-10 shadow-2xl transform scale-95 transition-transform duration-300" id="editTripModalContent">
        <div class="mb-6">
            <h3 class="text-2xl font-extrabold text-gray-900">Edit Rencana Trip</h3>
        </div>
        <form id="editTripForm" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-[13px] font-bold text-gray-700 mb-1">Nama Rencana Trip</label>
                <input type="text" id="edit_trip_title" name="title" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
            </div>
            <div>
                <label class="block text-[13px] font-bold text-gray-700 mb-1">Kota / Negara Tujuan</label>
                <input type="text" id="edit_trip_country" name="country_or_city" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[13px] font-bold text-gray-700 mb-1">Tanggal Berangkat</label>
                    <input type="date" id="edit_trip_date" name="start_date" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                </div>
                <div>
                    <label class="block text-[13px] font-bold text-gray-700 mb-1">Jumlah Peserta</label>
                    <input type="number" id="edit_trip_pax" name="pax_count" required min="1" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                </div>
            </div>
            <div class="pt-4 flex space-x-3">
                <button type="button" onclick="closeEditTripModal()" class="flex-1 px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditTripModal(id, title, country, date, pax) {
        document.getElementById('editTripForm').action = '/trips/' + id;
        document.getElementById('edit_trip_title').value = title;
        document.getElementById('edit_trip_country').value = country;
        document.getElementById('edit_trip_date').value = date.substring(0,10);
        document.getElementById('edit_trip_pax').value = pax;
        
        const modal = document.getElementById('editTripModal');
        const content = document.getElementById('editTripModalContent');
        modal.classList.remove('hidden');
        void modal.offsetWidth;
        modal.classList.remove('opacity-0');
        content.classList.remove('scale-95');
    }
    function closeEditTripModal() {
        const modal = document.getElementById('editTripModal');
        const content = document.getElementById('editTripModalContent');
        modal.classList.add('opacity-0');
        content.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }
</script>
@endsection
