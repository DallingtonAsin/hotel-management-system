<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Expense;

class ImportExpenses implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        return new Expense([
          'expense_type' => $row['expense'],
          'amount' => floatval($row['amount']),
          'date_of_expenditure' => date('Y-m-d', strtotime($row['date'])),
        ]);
    }
}
