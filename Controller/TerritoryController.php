<?php

namespace Controller;
use Model\Region;
use Model\KOATUU;

class TerritoryController extends Controller
{
    public function getAllRegions()
    {
        $region = new Region();
        return $region->getAll();
    }

    public function getAllChildrenTerritory($ter_id)
    {
        $koattu = new KOATUU();
        $koattu->getAllChildrenTerritory($ter_id);
        return responseJson($koattu->getData());
    }

}