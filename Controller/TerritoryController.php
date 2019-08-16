<?php

namespace Controller;
use Model\Region;
use Model\City;

class TerritoryController extends Controller
{
    public function getAllRegions()
    {
        $region = new Region();
        return $region->getAll();
    }

    public function getAllCitiesByRegion($region_id)
    {
        if(strlen($region_id) == 1) $region_id = "0$region_id";
        $city = new City();
//        dd($city->getAllCitiesByRegion($region_id));
        return $city->getAllCitiesByRegion($region_id);
    }

    public function getAllChildrenTerritoryByCity($ter_id)
    {
        $city = new City();
        dd($city->getAllChildrenTerritoryByCity($ter_id));
    }
}