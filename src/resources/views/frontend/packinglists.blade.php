@extends('layouts.app')

@section('content')
<div class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-100 min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900">Checklist Barang</h2>
            <p class="text-gray-500 mt-1">Pastikan barang bawaan Anda lengkap.</p>
        </div>
        <button onclick="openPackinglistModal()" class="bg-emerald-500 text-white px-6 py-3 rounded-2xl font-bold hover:bg-emerald-600 shadow-md shadow-emerald-200 transition-all flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            <span>Tambah Barang</span>
        </button>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-600 px-6 py-4 rounded-2xl mb-8 font-bold border border-emerald-100 flex items-center space-x-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="mb-8">
        <form method="GET" action="{{ route('frontend.packinglists') }}" class="flex items-center space-x-4 max-w-sm">
            <label for="trip_id" class="text-sm font-bold text-gray-700">Pilih Trip:</label>
            <select name="trip_id" id="trip_id" onchange="this.form.submit()" class="flex-1 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                @foreach($allTrips as $trip)
                    <option value="{{ $trip->id }}" {{ $selectedTripId == $trip->id ? 'selected' : '' }}>{{ $trip->title }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="space-y-4">
        @forelse($packinglists as $item)
            <div class="flex items-center justify-between p-4 bg-white border border-gray-100 rounded-2xl hover:shadow-md transition-shadow group">
                <form action="{{ route('packinglists.toggle', $item) }}" method="POST" class="flex-1 flex items-center space-x-4 cursor-pointer" onclick="this.submit()">
                    @csrf @method('PATCH')
                    @if($item->is_checked)
                        <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center shadow-md shadow-emerald-200 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-[15px] font-bold text-gray-400 line-through">{{ $item->item_name }}</span>
                    @else
                        <div class="w-8 h-8 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center shrink-0 group-hover:border-emerald-400 transition-colors"></div>
                        <span class="text-[15px] font-bold text-gray-900 group-hover:text-emerald-600 transition-colors">{{ $item->item_name }}</span>
                    @endif
                </form>
                <div class="flex items-center space-x-2">
                    <button onclick="openEditPackinglistModal({{ $item->id }}, '{{ addslashes($item->item_name) }}', {{ $item->trip_id }})" class="p-2 text-indigo-400 hover:text-indigo-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>
                    <form action="{{ route('packinglists.destroy', $item) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Hapus barang ini?')" class="p-2 text-red-400 hover:text-red-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="py-12 text-center text-gray-500 font-medium bg-gray-50 rounded-3xl border border-dashed border-gray-200">
                Tidak ada barang di checklist untuk trip ini.
            </div>
        @endforelse
    </div>
</div>

@include('dashboard.modals')

<!-- Edit Packinglist Modal -->
<div id="editPackinglistModal" class="fixed inset-0 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeEditPackinglistModal()"></div>
    <div class="bg-white rounded-[32px] p-8 w-full max-w-lg relative z-10 shadow-2xl transform scale-95 transition-transform duration-300" id="editPackinglistModalContent">
        <h3 class="text-2xl font-extrabold text-gray-900 mb-6">Edit Checklist Barang</h3>
        <form id="editPackinglistForm" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <input type="hidden" id="edit_packinglist_trip_id" name="trip_id">
            <div>
                <label class="block text-[13px] font-bold text-gray-700 mb-1">Nama Barang</label>
                <input type="text" id="edit_packinglist_name" name="item_name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
            </div>
            <div class="pt-4 flex space-x-3">
                <button type="button" onclick="closeEditPackinglistModal()" class="flex-1 px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="flex-1 px-6 py-3 bg-emerald-500 text-white rounded-xl text-sm font-bold hover:bg-emerald-600">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditPackinglistModal(id, name, tripId) {
        document.getElementById('editPackinglistForm').action = '/packinglists/' + id;
        document.getElementById('edit_packinglist_name').value = name;
        document.getElementById('edit_packinglist_trip_id').value = tripId;
        
        const modal = document.getElementById('editPackinglistModal');
        const content = document.getElementById('editPackinglistModalContent');
        modal.classList.remove('hidden');
        void modal.offsetWidth;
        modal.classList.remove('opacity-0');
        content.classList.remove('scale-95');
    }
    function closeEditPackinglistModal() {
        const modal = document.getElementById('editPackinglistModal');
        const content = document.getElementById('editPackinglistModalContent');
        modal.classList.add('opacity-0');
        content.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }
</script>
@endsection
