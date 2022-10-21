<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Customer;

class ImportCustomers implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Customer([
          'name' => $row['name'],
          'contact' => $row['contact'],
          'debt' => floatval($row['debt']),
          'credit' => floatval($row['credit']),
        ]);
    }


    
}
