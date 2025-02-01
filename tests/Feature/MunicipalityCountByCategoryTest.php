<?php

use Sagautam5\LocalStateNepal\Entities\Municipality;

beforeEach(function () {
    $this->language = $_ENV['APP_LANG'];
    $this->municipality = new Municipality($this->language);
});

it('retrieves correct municipality count for each category', function () {
    $categoryIdSet = range(1, 4);
    $categoryCountSet = [6, 11, 276, 460];

    foreach ($categoryIdSet as $key => $id) {
        $municipalities = $this->municipality->getMunicipalityByCategory($id);

        expect(is_array($municipalities) && count($municipalities) == $categoryCountSet[$key])
            ->toBeTrue();
    }
});