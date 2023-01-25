<?php 
namespace App\Repositories;

use App\Models\CommodityCategory;

class CommodityCategoryRepository
{
    protected $goodCategory;

    public function __construct(CommodityCategory $goodCategory)
    {
        $this->goodCategory = $goodCategory;
    }

    public function create($goodCategoryData)
    {
        return $this->goodCategory->create($goodCategoryData);
    }

    public function get($id = null)
    {
        if($id){
            return $this->goodCategory->find($id);
        }
        return $this->goodCategory->all();
    }

    public function update($id, $goodCategoryData)
    {
        $goodCategory = $this->goodCategory->find($id);
        $goodCategory->update($goodCategoryData);
        return $goodCategory;
    }

    public function delete($id)
    {
        $goodCategory = $this->goodCategory->find($id);
        $goodCategory->delete();
        return $goodCategory;
    }

    public function count(){
        try {
            return $this->goodCategory->count();
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function existsGoodCategory($goodCategorys_code){
        try {
            $exists = CommodityCategory::where('goods_code', $goodCategorys_code)->exists();
            return $exists;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
