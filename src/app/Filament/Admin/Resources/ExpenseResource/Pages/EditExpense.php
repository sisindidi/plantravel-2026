<?php

namespace App\Filament\Admin\Resources\ExpenseResource\Pages;

use App\Filament\Admin\Resources\ExpenseResource;
use App\Models\Expense;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditExpense extends EditRecord
{
    protected static string $resource = ExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // 1. Tarik data dari DB flat, ubah jadi format array Repeater sebelum form ditampilkan
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Cari semua expense yang memiliki trip_id yang sama dengan record saat ini
        $expenses = Expense::where('trip_id', $this->record->trip_id)->get();

        $data['expense_details'] = $expenses->map(function ($expense) {
            return [
                'expense_name' => $expense->expense_name,
                'amount' => $expense->amount,
            ];
        })->toArray();

        return $data;
    }

    // 2. Override proses update data biar sinkron ke database flat
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $tripId = $data['trip_id'] ?? $record->trip_id;
        $expenseDetails = $data['expense_details'] ?? [];

        // Hapus dulu data lama untuk trip_id ini biar gak numpuk/double
        Expense::where('trip_id', $record->trip_id)->delete();

        $firstRecord = null;

        // Masukkan ulang data baru dari repeater
        foreach ($expenseDetails as $detail) {
            if (!isset($detail['expense_name']) || !isset($detail['amount'])) {
                continue;
            }

            $expense = Expense::create([
                'trip_id' => $tripId,
                'expense_name' => $detail['expense_name'],
                'amount' => $detail['amount'],
            ]);

            if (!$firstRecord) {
                $firstRecord = $expense;
            }
        }

        // Fallback jika dikosongkan semuanya
        if (!$firstRecord) {
            $firstRecord = Expense::create([
                'trip_id' => $tripId,
                'expense_name' => 'Biaya Umum',
                'amount' => 0,
            ]);
        }

        return $firstRecord;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}