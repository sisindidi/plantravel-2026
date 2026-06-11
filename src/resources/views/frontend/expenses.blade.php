@extends('layouts.app')

@section('content')
<div class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-100 min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900">Budget Planner</h2>
            <p class="text-gray-500 mt-1">Kelola dan lacak pengeluaran perjalanan Anda.</p>
        </div>
        <button onclick="openExpenseModal()" class="bg-amber-500 text-white px-6 py-3 rounded-2xl font-bold hover:bg-amber-600 shadow-md shadow-amber-200 transition-all flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            <span>Pengeluaran Baru</span>
        </button>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-600 px-6 py-4 rounded-2xl mb-8 font-bold border border-emerald-100 flex items-center space-x-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="mb-8">
        <form method="GET" action="{{ route('frontend.expenses') }}" class="flex items-center space-x-4 max-w-sm">
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
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pengeluaran</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nominal</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Catatan</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($expenses as $expense)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $expense->expense_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $expense->notes ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button onclick="openEditExpenseModal({{ $expense->id }}, '{{ addslashes($expense->expense_name) }}', {{ $expense->amount }}, '{{ addslashes($expense->notes ?? '') }}', {{ $expense->trip_id }})" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</button>
                            <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus pengeluaran ini?')" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500 font-medium">Tidak ada data pengeluaran untuk trip ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('dashboard.modals')

<!-- Edit Expense Modal -->
<div id="editExpenseModal" class="fixed inset-0 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeEditExpenseModal()"></div>
    <div class="bg-white rounded-[32px] p-8 w-full max-w-lg relative z-10 shadow-2xl transform scale-95 transition-transform duration-300" id="editExpenseModalContent">
        <h3 class="text-2xl font-extrabold text-gray-900 mb-6">Edit Pengeluaran</h3>
        <form id="editExpenseForm" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <input type="hidden" id="edit_expense_trip_id" name="trip_id">
            <div>
                <label class="block text-[13px] font-bold text-gray-700 mb-1">Nama Pengeluaran</label>
                <input type="text" id="edit_expense_name" name="expense_name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50">
            </div>
            <div>
                <label class="block text-[13px] font-bold text-gray-700 mb-1">Nominal (Rp)</label>
                <input type="number" id="edit_expense_amount" name="amount" required min="0" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50">
            </div>
            <div>
                <label class="block text-[13px] font-bold text-gray-700 mb-1">Catatan</label>
                <textarea id="edit_expense_notes" name="notes" rows="2" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50"></textarea>
            </div>
            <div class="pt-4 flex space-x-3">
                <button type="button" onclick="closeEditExpenseModal()" class="flex-1 px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="flex-1 px-6 py-3 bg-amber-500 text-white rounded-xl text-sm font-bold hover:bg-amber-600">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditExpenseModal(id, name, amount, notes, tripId) {
        document.getElementById('editExpenseForm').action = '/expenses/' + id;
        document.getElementById('edit_expense_name').value = name;
        document.getElementById('edit_expense_amount').value = amount;
        document.getElementById('edit_expense_notes').value = notes;
        document.getElementById('edit_expense_trip_id').value = tripId;
        
        const modal = document.getElementById('editExpenseModal');
        const content = document.getElementById('editExpenseModalContent');
        modal.classList.remove('hidden');
        void modal.offsetWidth;
        modal.classList.remove('opacity-0');
        content.classList.remove('scale-95');
    }
    function closeEditExpenseModal() {
        const modal = document.getElementById('editExpenseModal');
        const content = document.getElementById('editExpenseModalContent');
        modal.classList.add('opacity-0');
        content.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }
</script>
@endsection
