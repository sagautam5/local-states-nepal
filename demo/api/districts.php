<?php

ini_set('display_errors', 1);

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

require __DIR__.'/'.'../../src/Loaders/DistrictsLoader.php';
require __DIR__.'/'.'../../src/Entities/BaseEntity.php';
require __DIR__.'/'.'../../src/Entities/District.php';
require __DIR__.'/'.'../../src/Exceptions/LoadingException.php';

use Sagautam5\LocalStateNepal\Entities\District;
use Sagautam5\LocalStateNepal\Exceptions\LoadingException;

$lang = isset($_REQUEST['lang']) ? (in_array($_REQUEST['lang'], ['en', 'np']) ? $_REQUEST['lang']: 'en') : 'en';
$provinceId = isset($_REQUEST['province_id']) ? $_REQUEST['province_id']:null;
try{
    $district = new District($lang);
    $districts = $district->getDistrictsByProvince($provinceId);

    $data = array();
    foreach ($districts as $item){
        $data[$item->id] = $item->name;
    }

    if($data){
        http_response_code(200);
        echo json_encode($data);
    }else{
        http_response_code(500);
        echo json_encode(array("message" => "Unable to get districts"));
    }

}catch (LoadingException $e){
    http_response_code(500);
    echo json_encode(array("message" => $e->getMessage()));
}
