<!-- Modals for all entities -->

<!-- 1. Expense Modal -->
<div id="expenseModal" class="fixed inset-0 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeExpenseModal()"></div>
    <div class="bg-white rounded-[32px] p-8 w-full max-w-lg relative z-10 shadow-2xl transform scale-95 transition-transform duration-300" id="expenseModalContent">
        <button onclick="closeExpenseModal()" class="absolute top-6 right-6 w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <div class="mb-6">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-2xl font-extrabold text-gray-900">Tambah Pengeluaran</h3>
            <p class="text-sm text-gray-500 mt-1">Catat budget perjalanan Anda agar tetap terkontrol.</p>
        </div>
        <form action="{{ route('expenses.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="expense_trip_id" class="block text-[13px] font-bold text-gray-700 mb-1">Rencana Trip <span class="text-red-500">*</span></label>
                <select id="expense_trip_id" name="trip_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors">
                    @foreach($allTrips as $trip)
                        <option value="{{ $trip->id }}">{{ $trip->title }} ({{ $trip->country_or_city }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="expense_name" class="block text-[13px] font-bold text-gray-700 mb-1">Nama Pengeluaran <span class="text-red-500">*</span></label>
                <input type="text" id="expense_name" name="expense_name" required placeholder="Contoh: Tiket Pesawat PP" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors">
            </div>
            <div>
                <label for="amount" class="block text-[13px] font-bold text-gray-700 mb-1">Nominal (Rp) <span class="text-red-500">*</span></label>
                <input type="number" id="amount" name="amount" required min="0" placeholder="Contoh: 5000000" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors text-gray-600">
            </div>
            <div>
                <label for="expense_notes" class="block text-[13px] font-bold text-gray-700 mb-1">Catatan</label>
                <textarea id="expense_notes" name="notes" rows="2" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors" placeholder="Catatan tambahan..."></textarea>
            </div>
            <div class="pt-4 flex space-x-3">
                <button type="button" onclick="closeExpenseModal()" class="flex-1 px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="flex-1 px-6 py-3 bg-amber-500 text-white rounded-xl text-sm font-bold hover:bg-amber-600 shadow-md shadow-amber-200 transition-all">Simpan Budget</button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Itinerary Modal -->
<div id="itineraryModal" class="fixed inset-0 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeItineraryModal()"></div>
    <div class="bg-white rounded-[32px] p-8 w-full max-w-lg relative z-10 shadow-2xl transform scale-95 transition-transform duration-300" id="itineraryModalContent">
        <button onclick="closeItineraryModal()" class="absolute top-6 right-6 w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <div class="mb-6">
            <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-500 flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
            <h3 class="text-2xl font-extrabold text-gray-900">Tambah Itinerary</h3>
            <p class="text-sm text-gray-500 mt-1">Jadwalkan aktivitas kegiatan Anda.</p>
        </div>
        <form action="{{ route('itineraries.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="itinerary_trip_id" class="block text-[13px] font-bold text-gray-700 mb-1">Rencana Trip <span class="text-red-500">*</span></label>
                <select id="itinerary_trip_id" name="trip_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors">
                    @foreach($allTrips as $trip)
                        <option value="{{ $trip->id }}">{{ $trip->title }} ({{ $trip->country_or_city }})</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="day_number" class="block text-[13px] font-bold text-gray-700 mb-1">Hari Ke- <span class="text-red-500">*</span></label>
                    <input type="number" id="day_number" name="day_number" required min="1" value="1" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors text-gray-600">
                </div>
                <div>
                    <label for="start_time" class="block text-[13px] font-bold text-gray-700 mb-1">Jam Mulai <span class="text-red-500">*</span></label>
                    <input type="time" id="start_time" name="start_time" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors text-gray-600">
                </div>
            </div>
            <div>
                <label for="activity" class="block text-[13px] font-bold text-gray-700 mb-1">Aktivitas <span class="text-red-500">*</span></label>
                <input type="text" id="activity" name="activity" required placeholder="Contoh: Mengunjungi Tokyo Tower" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors">
            </div>
            <div>
                <label for="itinerary_notes" class="block text-[13px] font-bold text-gray-700 mb-1">Catatan</label>
                <textarea id="itinerary_notes" name="notes" rows="2" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors" placeholder="Catatan tambahan..."></textarea>
            </div>
            <div class="pt-4 flex space-x-3">
                <button type="button" onclick="closeItineraryModal()" class="flex-1 px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="flex-1 px-6 py-3 bg-sky-500 text-white rounded-xl text-sm font-bold hover:bg-sky-600 shadow-md shadow-sky-200 transition-all">Simpan Jadwal</button>
            </div>
        </form>
    </div>
</div>

<!-- 3. Packinglist Modal -->
<div id="packinglistModal" class="fixed inset-0 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closePackinglistModal()"></div>
    <div class="bg-white rounded-[32px] p-8 w-full max-w-lg relative z-10 shadow-2xl transform scale-95 transition-transform duration-300" id="packinglistModalContent">
        <button onclick="closePackinglistModal()" class="absolute top-6 right-6 w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <div class="mb-6">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-2xl font-extrabold text-gray-900">Tambah Checklist Barang</h3>
            <p class="text-sm text-gray-500 mt-1">Pastikan barang bawaan Anda lengkap.</p>
        </div>
        <form action="{{ route('packinglists.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="packinglist_trip_id" class="block text-[13px] font-bold text-gray-700 mb-1">Rencana Trip <span class="text-red-500">*</span></label>
                <select id="packinglist_trip_id" name="trip_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors">
                    @foreach($allTrips as $trip)
                        <option value="{{ $trip->id }}">{{ $trip->title }} ({{ $trip->country_or_city }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="item_name" class="block text-[13px] font-bold text-gray-700 mb-1">Nama Barang <span class="text-red-500">*</span></label>
                <input type="text" id="item_name" name="item_name" required placeholder="Contoh: Paspor & Dokumen" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors">
            </div>
            <div class="pt-4 flex space-x-3">
                <button type="button" onclick="closePackinglistModal()" class="flex-1 px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="flex-1 px-6 py-3 bg-emerald-500 text-white rounded-xl text-sm font-bold hover:bg-emerald-600 shadow-md shadow-emerald-200 transition-all">Simpan Barang</button>
            </div>
        </form>
    </div>
</div>

<!-- 4. Destination Modal -->
<div id="destinationModal" class="fixed inset-0 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeDestinationModal()"></div>
    <div class="bg-white rounded-[32px] p-8 w-full max-w-lg relative z-10 shadow-2xl transform scale-95 transition-transform duration-300" id="destinationModalContent">
        <button onclick="closeDestinationModal()" class="absolute top-6 right-6 w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <div class="mb-6">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            </div>
            <h3 class="text-2xl font-extrabold text-gray-900">Tambah Destinasi</h3>
            <p class="text-sm text-gray-500 mt-1">Tambahkan wishlist destinasi yang ingin Anda kunjungi.</p>
        </div>
        <form action="{{ route('destinations.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="destination_trip_id" class="block text-[13px] font-bold text-gray-700 mb-1">Rencana Trip <span class="text-red-500">*</span></label>
                <select id="destination_trip_id" name="trip_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors">
                    @foreach($allTrips as $trip)
                        <option value="{{ $trip->id }}">{{ $trip->title }} ({{ $trip->country_or_city }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="destination_name" class="block text-[13px] font-bold text-gray-700 mb-1">Nama Destinasi <span class="text-red-500">*</span></label>
                <input type="text" id="destination_name" name="name" required placeholder="Contoh: Universal Studios" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors">
            </div>
            <div>
                <label for="visit_date" class="block text-[13px] font-bold text-gray-700 mb-1">Tanggal Kunjungan (Opsional)</label>
                <input type="date" id="visit_date" name="visit_date" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors text-gray-600">
            </div>
            <div class="pt-4 flex space-x-3">
                <button type="button" onclick="closeDestinationModal()" class="flex-1 px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="flex-1 px-6 py-3 bg-rose-500 text-white rounded-xl text-sm font-bold hover:bg-rose-600 shadow-md shadow-rose-200 transition-all">Simpan Destinasi</button>
            </div>
        </form>
    </div>
</div>

<script>
    // General Modal Functions
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        const content = document.getElementById(modalId + 'Content');
        modal.classList.remove('hidden');
        void modal.offsetWidth;
        modal.classList.remove('opacity-0');
        content.classList.remove('scale-95');
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        const content = document.getElementById(modalId + 'Content');
        modal.classList.add('opacity-0');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function openExpenseModal() { openModal('expenseModal'); }
    function closeExpenseModal() { closeModal('expenseModal'); }

    function openItineraryModal() { openModal('itineraryModal'); }
    function closeItineraryModal() { closeModal('itineraryModal'); }

    function openPackinglistModal() { openModal('packinglistModal'); }
    function closePackinglistModal() { closeModal('packinglistModal'); }

    function openDestinationModal() { openModal('destinationModal'); }
    function closeDestinationModal() { closeModal('destinationModal'); }
</script>
