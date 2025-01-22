<?php

namespace App\Livewire;

use App\Pathao\Facade\Pathao;
use Livewire\Component;

class PathaoAddress extends Component
{
    public $city_id;
    public $area_id;

    public function mount($cityId, $areaId)
    {
        $this->city_id = old('city_id', $cityId);
        $this->area_id = old('area_id', $areaId);
    }

    public function render()
    {
        return view('livewire.pathao-address');
    }

    public function getCityList()
    {
        $exception = false;
        $cityList = cache()->remember('pathao_cities', now()->addDay(), function () use (&$exception) {
            try {
                return Pathao::area()->city()->data;
            } catch (\Exception) {
                $exception = true;

                return [];
            }
        });

        if ($exception) {
            cache()->forget('pathao_cities');
        }

        return $cityList;
    }

    public function getAreaList()
    {
        $areaList = [];
        $exception = false;
        if ($this->city_id ?? false) {
            $areaList = cache()->remember('pathao_areas:'.$this->city_id, now()->addDay(), function () use (&$exception) {
                try {
                    return Pathao::area()->zone($this->city_id)->data;
                } catch (\Exception) {
                    $exception = true;

                    return [];
                }
            });
        }

        if ($exception) {
            cache()->forget('pathao_areas:'.$this->city_id);
        }

        return $areaList;
    }
}
