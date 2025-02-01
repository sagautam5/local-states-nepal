<?php

use Sagautam5\LocalStateNepal\Entities\Province;

beforeEach(function () {
    $this->language = $_ENV['APP_LANG'];
    $this->province = new Province($this->language);
});

it('retrieves provinces with districts correctly', function () {
    $provinceWithDistricts = $this->province->getProvincesWithDistricts();

    foreach ($provinceWithDistricts as $item) {
        expect(isset($item->districts) && is_array($item->districts))
            ->toBeTrue();
    }
});

it('retrieves provinces with districts and their municipalities correctly', function () {
    $provinceWithDistrictWithMunicipalities = $this->province->getProvincesWithDistrictsWithMunicipalities();

    foreach ($provinceWithDistrictWithMunicipalities as $province) {
        expect(isset($province->districts) && is_array($province->districts))->toBeTrue();

        foreach ($province->districts as $district) {
            expect(isset($district->municipalities) && is_array($district->municipalities))
                ->toBeTrue();
        }
    }
});
