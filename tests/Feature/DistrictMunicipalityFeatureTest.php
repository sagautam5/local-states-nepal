<?php

use Sagautam5\LocalStateNepal\Entities\District;

beforeEach(function () {
    $this->language = $_ENV['APP_LANG'];
    $this->district = new District($this->language);
});

it('retrieves districts with municipalities', function () {
    $districtsWithMunicipalities = $this->district->getDistrictsWithMunicipalities();

    foreach ($districtsWithMunicipalities as $item) {
        expect(isset($item->municipalities) && is_array($item->municipalities))->toBeTrue();
    }
});
