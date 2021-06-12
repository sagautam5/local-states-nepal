<?php

ini_set('display_errors', 1);

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

require __DIR__.'/'.'../../src/Loaders/MunicipalitiesLoader.php';
require __DIR__.'/'.'../../src/Loaders/CategoriesLoader.php';
require __DIR__.'/'.'../../src/Entities/BaseEntity.php';
require __DIR__.'/'.'../../src/Entities/Category.php';
require __DIR__.'/'.'../../src/Entities/Municipality.php';
require __DIR__.'/'.'../../src/Exceptions/LoadingException.php';

use Sagautam5\LocalStateNepal\Entities\Municipality;
use Sagautam5\LocalStateNepal\Exceptions\LoadingException;

try{
    $lang = isset($_REQUEST['lang']) ? (in_array($_REQUEST['lang'], ['en', 'np']) ? $_REQUEST['lang']: 'en') : 'en';
    $districtId = isset($_REQUEST['district_id']) ? $_REQUEST['district_id']:null;

    $municipality = new Municipality($lang);
    $municipalities = $municipality->getMunicipalitiesByDistrict($districtId);

    $data = array();
    foreach ($municipalities as $item){
        $data[$item->id] = $item->name;
    }


    if($data){
        http_response_code(200);
        echo json_encode($data);
    }else{
        http_response_code(500);
        echo json_encode(array("message" => "Unable to get municipalities"));
    }

}catch (LoadingException $e){
    http_response_code(500);
    echo json_encode(array("message" => $e->getMessage()));
}
