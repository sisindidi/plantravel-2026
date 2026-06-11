@extends('layouts.app')

@section('content')
<div class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-100 min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900">Jadwal Perjalanan</h2>
            <p class="text-gray-500 mt-1">Kelola itinerary perjalanan Anda.</p>
        </div>
        <button onclick="openItineraryModal()" class="bg-sky-500 text-white px-6 py-3 rounded-2xl font-bold hover:bg-sky-600 shadow-md shadow-sky-200 transition-all flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            <span>Aktivitas Baru</span>
        </button>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-600 px-6 py-4 rounded-2xl mb-8 font-bold border border-emerald-100 flex items-center space-x-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="mb-8">
        <form method="GET" action="{{ route('frontend.itineraries') }}" class="flex items-center space-x-4 max-w-sm">
            <label for="trip_id" class="text-sm font-bold text-gray-700">Pilih Trip:</label>
            <select name="trip_id" id="trip_id" onchange="this.form.submit()" class="flex-1 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                @foreach($allTrips as $trip)
                    <option value="{{ $trip->id }}" {{ $selectedTripId == $trip->id ? 'selected' : '' }}>{{ $trip->title }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="overflow-hidden bg-white border border-gray-100 rounded-[24px]">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Hari Ke</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aktivitas</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Catatan</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($itineraries as $itinerary)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">Hari {{ $itinerary->day_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-sky-600">{{ \Carbon\Carbon::parse($itinerary->start_time)->format('H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $itinerary->activity }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $itinerary->notes ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button onclick="openEditItineraryModal({{ $itinerary->id }}, {{ $itinerary->day_number }}, '{{ \Carbon\Carbon::parse($itinerary->start_time)->format('H:i') }}', '{{ addslashes($itinerary->activity) }}', '{{ addslashes($itinerary->notes ?? '') }}', {{ $itinerary->trip_id }})" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</button>
                            <form action="{{ route('itineraries.destroy', $itinerary) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus jadwal ini?')" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500 font-medium">Tidak ada data jadwal untuk trip ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('dashboard.modals')

<!-- Edit Itinerary Modal -->
<div id="editItineraryModal" class="fixed inset-0 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeEditItineraryModal()"></div>
    <div class="bg-white rounded-[32px] p-8 w-full max-w-lg relative z-10 shadow-2xl transform scale-95 transition-transform duration-300" id="editItineraryModalContent">
        <h3 class="text-2xl font-extrabold text-gray-900 mb-6">Edit Itinerary</h3>
        <form id="editItineraryForm" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <input type="hidden" id="edit_itinerary_trip_id" name="trip_id">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[13px] font-bold text-gray-700 mb-1">Hari Ke-</label>
                    <input type="number" id="edit_itinerary_day" name="day_number" required min="1" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/50">
                </div>
                <div>
                    <label class="block text-[13px] font-bold text-gray-700 mb-1">Jam Mulai</label>
                    <input type="time" id="edit_itinerary_time" name="start_time" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/50">
                </div>
            </div>
            <div>
                <label class="block text-[13px] font-bold text-gray-700 mb-1">Aktivitas</label>
                <input type="text" id="edit_itinerary_activity" name="activity" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/50">
            </div>
            <div>
                <label class="block text-[13px] font-bold text-gray-700 mb-1">Catatan</label>
                <textarea id="edit_itinerary_notes" name="notes" rows="2" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/50"></textarea>
            </div>
            <div class="pt-4 flex space-x-3">
                <button type="button" onclick="closeEditItineraryModal()" class="flex-1 px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="flex-1 px-6 py-3 bg-sky-500 text-white rounded-xl text-sm font-bold hover:bg-sky-600">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditItineraryModal(id, day, time, activity, notes, tripId) {
        document.getElementById('editItineraryForm').action = '/itineraries/' + id;
        document.getElementById('edit_itinerary_day').value = day;
        document.getElementById('edit_itinerary_time').value = time;
        document.getElementById('edit_itinerary_activity').value = activity;
        document.getElementById('edit_itinerary_notes').value = notes;
        document.getElementById('edit_itinerary_trip_id').value = tripId;
        
        const modal = document.getElementById('editItineraryModal');
        const content = document.getElementById('editItineraryModalContent');
        modal.classList.remove('hidden');
        void modal.offsetWidth;
        modal.classList.remove('opacity-0');
        content.classList.remove('scale-95');
    }
    function closeEditItineraryModal() {
        const modal = document.getElementById('editItineraryModal');
        const content = document.getElementById('editItineraryModalContent');
        modal.classList.add('opacity-0');
        content.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }
</script>
@endsection
