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


    public function getCostofDamages()
    {
        try {

            $damages = Damage::all();
            $cost_of_damages  = 0;

            foreach ($damages as $item) {
                $price = Stock::where('id', $item->item_id)->value('buying_price');
                $cost = $item->quantity * $price;
                $cost_of_damages += $cost;
            }

            return $cost_of_damages;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
