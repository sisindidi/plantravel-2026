@extends('layouts.app')

@section('content')
<div class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-100 min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900">Wishlist Destinasi</h2>
            <p class="text-gray-500 mt-1">Daftar tempat wisata yang ingin Anda kunjungi.</p>
        </div>
        <button onclick="openDestinationModal()" class="bg-rose-500 text-white px-6 py-3 rounded-2xl font-bold hover:bg-rose-600 shadow-md shadow-rose-200 transition-all flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            <span>Tambah Destinasi</span>
        </button>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-600 px-6 py-4 rounded-2xl mb-8 font-bold border border-emerald-100 flex items-center space-x-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="mb-8">
        <form method="GET" action="{{ route('frontend.destinations') }}" class="flex items-center space-x-4 max-w-sm">
            <label for="trip_id" class="text-sm font-bold text-gray-700">Pilih Trip:</label>
            <select name="trip_id" id="trip_id" onchange="this.form.submit()" class="flex-1 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                @foreach($allTrips as $trip)
                    <option value="{{ $trip->id }}" {{ $selectedTripId == $trip->id ? 'selected' : '' }}>{{ $trip->title }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="space-y-4">
        @forelse($destinations as $dest)
            <div class="flex items-center justify-between p-5 bg-white border border-gray-100 rounded-2xl hover:shadow-md hover:border-indigo-100 transition-all group">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $dest->name }}</h3>
                        @if($dest->visit_date)
                            <p class="text-sm font-medium text-gray-500 mt-0.5 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>{{ \Carbon\Carbon::parse($dest->visit_date)->translatedFormat('d F Y') }}</span>
                            </p>
                        @endif
                    </div>
                </div>
                
                <div class="flex items-center space-x-2">
                    <button onclick="openEditDestinationModal({{ $dest->id }}, '{{ addslashes($dest->name) }}', '{{ $dest->visit_date ? substr($dest->visit_date, 0, 10) : '' }}', {{ $dest->trip_id }})" class="p-2 text-indigo-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>
                    <form action="{{ route('destinations.destroy', $dest) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Hapus destinasi ini?')" class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="py-16 text-center text-gray-500 font-medium bg-gray-50 rounded-3xl border border-dashed border-gray-200">
                <div class="text-5xl mb-4">📍</div>
                Belum ada destinasi di wishlist untuk trip ini.
            </div>
        @endforelse
    </div>
</div>

@include('dashboard.modals')

<!-- Edit Destination Modal -->
<div id="editDestinationModal" class="fixed inset-0 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeEditDestinationModal()"></div>
    <div class="bg-white rounded-[32px] p-8 w-full max-w-lg relative z-10 shadow-2xl transform scale-95 transition-transform duration-300" id="editDestinationModalContent">
        <h3 class="text-2xl font-extrabold text-gray-900 mb-6">Edit Destinasi</h3>
        <form id="editDestinationForm" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <input type="hidden" id="edit_destination_trip_id" name="trip_id">
            <div>
                <label class="block text-[13px] font-bold text-gray-700 mb-1">Nama Destinasi</label>
                <input type="text" id="edit_destination_name" name="name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/50">
            </div>
            <div>
                <label class="block text-[13px] font-bold text-gray-700 mb-1">Tanggal Kunjungan (Opsional)</label>
                <input type="date" id="edit_destination_date" name="visit_date" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/50">
            </div>
            <div class="pt-4 flex space-x-3">
                <button type="button" onclick="closeEditDestinationModal()" class="flex-1 px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="flex-1 px-6 py-3 bg-rose-500 text-white rounded-xl text-sm font-bold hover:bg-rose-600">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditDestinationModal(id, name, date, tripId) {
        document.getElementById('editDestinationForm').action = '/destinations/' + id;
        document.getElementById('edit_destination_name').value = name;
        document.getElementById('edit_destination_date').value = date;
        document.getElementById('edit_destination_trip_id').value = tripId;
        
        const modal = document.getElementById('editDestinationModal');
        const content = document.getElementById('editDestinationModalContent');
        modal.classList.remove('hidden');
        void modal.offsetWidth;
        modal.classList.remove('opacity-0');
        content.classList.remove('scale-95');
    }
    function closeEditDestinationModal() {
        const modal = document.getElementById('editDestinationModal');
        const content = document.getElementById('editDestinationModalContent');
        modal.classList.add('opacity-0');
        content.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }
</script>
@endsection
