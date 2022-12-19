<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Stock;

class ImportStock implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

      //  dd($row);
       $item_code = $row['barcode'];
       $item = $row['item'];
       $stock = $this->getStock();

       (isset($item_code))
       ? $item_code = $item_code
       : $item_code = null;

       if(in_array($item, $stock)){
        
        $qty = $this->getItemQty($item);
        $newQty = $qty + floatval($row['quantity']);
         Stock::where('item', $item)
           ->update(['quantity' => $newQty]);

       }

       else
       {
         return new Stock([
          'item_code' => $item_code,
          'item' => $item,
          'quantity' => floatval($row['quantity']),
          'buying_price' => floatval($row['cost_price']),
          'selling_price' => floatval($row['selling_price']),
          'wholesale_price' => floatval($row['wholesale_price']),
          'supplier' => $row['supplier']
        ]);

       }
       
    }


    protected function getStock()
    {

      $items = Stock::all();
      $itemsArr = array();
      foreach ($items as $item) {
        array_push($itemsArr, $item->item);
      }

      return $itemsArr;


    }


    protected function getItemQty($item)
    {
      
      $qty = Stock::where('item', $item)
             ->value('quantity');
      return $qty;
    }


}
