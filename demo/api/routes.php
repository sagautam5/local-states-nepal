<?php

use Sagautam5\LocalStateNepal\Controllers\ApiController;

// Get the requested path
$requestUri = trim($_SERVER['REQUEST_URI'], '/');

(new ApiController())->fetchProvinces();

// Routing logic
switch ($requestUri) {
    case 'api/provinces':
        (new ApiController())->fetchProvinces();
        break;

    case 'api/districts':
        (new ApiController())->fetchDistricts();
        break;

    case 'api/municipalities':
        (new ApiController())->fetchMunicipalities();
        break;

    case 'api/wards':
        (new ApiController())->fetchWards();
        break;

    default:
        http_response_code(404);
        echo json_encode(['message' => 'Endpoint not found.']);
        break;
}
