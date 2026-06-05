<?php

namespace App\Filament\Admin\Resources\ExpenseResource\Pages;

use App\Filament\Admin\Resources\ExpenseResource;
use App\Models\Expense;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateExpense extends CreateRecord
{
    protected static string $resource = ExpenseResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $tripId = $data['trip_id'] ?? null;
        $expenseDetails = $data['expense_details'] ?? [];

        $firstRecord = null;

        // Ekstrak data array dinamis dari form Repeater ke database flat
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

        // Fallback jika user iseng mengosongkan row
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