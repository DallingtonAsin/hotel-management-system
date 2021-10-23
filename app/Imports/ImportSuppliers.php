<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Supplier;

class ImportSuppliers implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Supplier([
            'name' => $row['name'],
            'address' => $row['address'],
            'contact' => $row['contact'],
            'email' => $row['email'],
            'debt' => floatval($row['debt']),
            'credit' => floatval($row['credit']),
        ]);
    }
}
