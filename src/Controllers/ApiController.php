<?php

namespace Sagautam5\LocalStateNepal\Controllers;

use Sagautam5\LocalStateNepal\Entities\District;
use Sagautam5\LocalStateNepal\Entities\Municipality;
use Sagautam5\LocalStateNepal\Entities\Province;
use Sagautam5\LocalStateNepal\Exceptions\LoadingException;

class ApiController
{
    private string $lang;

    public function __construct()
    {
        $this->setHeaders();
        $this->lang = $this->getRequestParam('lang', 'en', ['en', 'np']);
    }

    private function setHeaders(): void
    {
        ini_set('display_errors', 1);
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json');
    }

    /**
     * @param array<string> $allowedValues
     */
    private function getRequestParam(string $param, string $default = null, array $allowedValues = []): mixed
    {
        $value = $_REQUEST[$param] ?? $default;
        return $allowedValues ? (in_array($value, $allowedValues) ? $value : $default) : $value;
    }

    /**
     * @param array<mixed> $data
     */
    private function sendResponse(int $statusCode, array $data): void
    {
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }

    public function handleRequest(callable $handler): void
    {
        try {
            $result = $handler($this->lang);
            if ($result) {
                $this->sendResponse(200, $result);
            } else {
                $this->sendResponse(500, ["message" => "No data available."]);
            }
        } catch (LoadingException $e) {
            $this->sendResponse(500, ["message" => $e->getMessage()]);
        }
    }

    public function fetchProvinces(): void
    {
        $this->handleRequest(function ($lang) {
            $province = new Province($lang);
            $provinces = $province->allProvinces();
        
            return array_reduce($provinces, function ($carry, $item) {
                $carry[$item->id] = $item->name; // @phpstan-ignore-line
                return $carry;
            }, []);
        });
    }

    public function fetchDistricts(): void
    {
        $this->handleRequest(function ($lang) {
            $provinceId = $_REQUEST['province_id'] ?? null;
            $district = new District($lang);
            $districts = $district->getDistrictsByProvince($provinceId);
        
            return array_reduce($districts, function ($carry, $item) { // @phpstan-ignore-line
                $carry[$item->id] = $item->name; // @phpstan-ignore-line
                return $carry;
            }, []);
        });
    }

    public function fetchMunicipalities(): void
    {
        $this->handleRequest(function ($lang) {
            $districtId = $_REQUEST['district_id'] ?? null;
            $municipality = new Municipality($lang);
            $municipalities = $municipality->getMunicipalitiesByDistrict($districtId);
        
            return array_reduce($municipalities, function ($carry, $item) { // @phpstan-ignore-line
                $carry[$item->id] = $item->name; // @phpstan-ignore-line
                return $carry;
            }, []);
        });
    }
    public function fetchWards(): void
    {
        $this->handleRequest(function ($lang) {
            $municipalityId = $_REQUEST['municipality_id'] ?? null;
            $municipality = new Municipality($lang);
            return $municipality->wards($municipalityId);
        });
    }
}
