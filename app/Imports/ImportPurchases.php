<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;

use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\Cell;

use Illuminate\Support\Facades\Auth;
use App\Models\Stock;
use App\Models\Purchase;
use Carbon\Carbon;
use Helper;
use DateTime;

class ImportPurchases extends DefaultValueBinder implements ToCollection, WithHeadingRow,WithCustomValueBinder
{
    

  public function collection(Collection $rows){
        
    foreach ($rows as $row){

      // dd($row);
 
        if(!empty($row['date_of_purchase'])){
        $date =  intval($row['date_of_purchase']); 
        $row['date_of_purchase']  = Date::excelToDateTimeObject($date)->format('Y-m-d');
        }else{
           $row['date_of_purchase']  = '1970-01-01'; 
        }

       $row['id'] = null;
       $item = $row['item'];
       if(Helper::isItemInStock($item)){
        $insertPurchase = Helper::createOrUpdatePurchase($row);
        $qty = Helper::getItemQty($item);
        $newQty = $qty + floatval($row['qty']);
         Stock::where('item', $item)
          ->update(['quantity' => $newQty]);
       }
       else {
         $insertPurchase = Helper::createOrUpdatePurchase($row);
         $insertStock =  Helper::createStock($row);
       }

       }
  }
  

}
