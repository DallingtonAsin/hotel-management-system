<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Damage;

class ImportDamages implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        //Excel fields[headings] work perfect when in lower case
        
        (isset($row['itemid']))
        ? $itemid = $row['itemid']
        : $itemid = null;


        (isset($row['category']))
        ? $category = $row['category']
        : $category = null;

        return new Damage([
            'item_id' => $itemid ,
            'item' => $row['item'],
            'buying_price' => floatval(trim($row['buying_price'])),
            'category' => trim($category),
            'quantity' => floatval(trim($row['quantity'])),
           
        ]);
    }
}
