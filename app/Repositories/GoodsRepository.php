<?php 
namespace App\Repositories;

use App\Models\Good;

class GoodsRepository
{
    protected $good;

    public function __construct(Good $good)
    {
        $this->good = $good;
    }

    public function create($goodData)
    {
        return $this->good->create($goodData);
    }

    public function get($id = null)
    {
        if($id){
            return $this->good->find($id);
        }
        return $this->good->all();
    }

    public function update($id, $goodData)
    {
        $good = $this->good->find($id);
        $good->update($goodData);
        return $good;
    }

    public function delete($id)
    {
        $good = $this->good->find($id);
        $good->delete();
        return $good;
    }

    public function count(){
        try {
            return $this->good->count();
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function existsGood($goods_code){
        try {
            $exists = $this->good->where('goods_code', $goods_code)->exists();
            return $exists;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function findGoodByName($goods_name){
        return $this->good->where("goods_name", $goods_name)->first();
    }

    public function getGoodsByName($goods_name){
        return $this->good->where("goods_name", "like", "%" . $goods_name . "%")->get();
    }
}
