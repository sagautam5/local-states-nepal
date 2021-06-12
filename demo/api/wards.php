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
require __DIR__.'/'.'../../src/Helpers/Helper.php';
require __DIR__.'/'.'../../src/Exceptions/LoadingException.php';

use Sagautam5\LocalStateNepal\Entities\Municipality;
use Sagautam5\LocalStateNepal\Exceptions\LoadingException;

try{
    $lang = isset($_REQUEST['lang']) ? (in_array($_REQUEST['lang'], ['en', 'np']) ? $_REQUEST['lang']: 'en') : 'en';
    $municipalityId = isset($_REQUEST['municipality_id']) ? $_REQUEST['municipality_id']:null;

    $municipality = new Municipality($lang);
    $wards = $municipality->wards($municipalityId);

    if($wards){
        http_response_code(200);
        echo json_encode($wards);
    }else{
        http_response_code(500);
        echo json_encode(array("message" => "Unable to get municipalities"));
    }

}catch (LoadingException $e){
    http_response_code(500);
    echo json_encode(array("message" => $e->getMessage()));
}
