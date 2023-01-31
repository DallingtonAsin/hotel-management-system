<?php

namespace App\Repositories;

use App\Models\Damage;
use App\Models\Stock;


class DamagedStockRepository
{
    protected $damage;

    public function __construct(Damage $damage)
    {
        $this->damage = $damage;
    }

    public function create($damageData)
    {
        return $this->damage->create($damageData);
    }

    public function get($id)
    {
        return $this->damage->find($id);
    }

    public function update($id, $damageData)
    {
        $damage = $this->damage->find($id);
        $damage->update($damageData);
        return $damage;
    }

    public function delete($id)
    {
        $damage = $this->damage->find($id);
        $damage->delete();
        return $damage;
    }


    public function getCostofDamages($startDate= null, $endDate = null)
    {
        try {

            $damages = Damage::all();
            if($startDate && $endDate){
              $damages = Damage::whereDate('recorded_on', ">=", $startDate)->whereDate('recorded_on', "<=", $endDate)->get();
            }

            $total_cost  = 0;
            foreach ($damages as $item) {
                $price = Stock::where('id', $item->item_id)->value('buying_price');
                $cost = $item->quantity * $price;
                $total_cost += $cost;
            }

            return $total_cost;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
