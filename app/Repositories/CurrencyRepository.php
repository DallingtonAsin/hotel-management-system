<?php

namespace App\Repositories;

use App\Models\Currency;

class CurrencyRepository
{
    protected $currency;

    public function __construct(Currency $currency)
    {
        $this->currency = $currency;
    }

    public function create($currencyData)
    {
        try {
            return $this->currency->create($currencyData);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function get($id = null)
    {
        try {
            if($id){
                return $this->currency->find($id);
            }
            return $this->currency->all();
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function update($id, $currencyData)
    {
        try {
            $currency = $this->currency->find($id);
            $currency->update($currencyData);
            return $currency;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function delete($id)
    {
        try {
            $currency = $this->currency->find($id);
            $currency->delete();
            return $currency;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function count(){
        try {
            return $this->currency->count();
        } catch (\Exception $e) {
            return $e;
        }
    }

   public function getCurrencyByEfrisCode($efris_code){
        try {
            return $this->currency->where('efris_code', $efris_code)->first();
        } catch (\Exception $e) {
            return $e;
        }
    }

}
