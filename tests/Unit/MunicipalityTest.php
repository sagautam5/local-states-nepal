<?php

use Sagautam5\LocalStateNepal\Entities\Municipality;

beforeEach(function () {
    $this->language = $_ENV['APP_LANG'];
    $this->municipality = new Municipality($this->language);
});

it('returns the largest municipality', function () {
    $largest = $this->municipality->largest();
    expect([$largest->id, $largest->district_id, $largest->category_id])->toEqual([617, 62, 4]);
});

it('finds municipality for range between 1 and 753', function () {
    $correctIdSet = range(1, 753);
    $incorrectIdSet = range(754, 1000);

    foreach ($correctIdSet as $id) {
        expect($this->municipality->find($id))->not()->toBeNull();
    }

    foreach ($incorrectIdSet as $id) {
        expect($this->municipality->find($id))->toBeNull();
    }
});

it('returns the smallest municipality', function () {
    $smallest = $this->municipality->smallest();
    expect([$smallest->id, $smallest->district_id, $smallest->category_id])->toEqual([274, 23, 3]);
});

it('counts the municipalities correctly', function () {
    expect(count($this->municipality->allMunicipalities()))->toBe(753);
});

it('fails if municipality data contains null values', function () {
    foreach ($this->municipality->allMunicipalities() as $set) {
        expect(in_array(null, (array) $set, true))->toBeFalse();
    }
});

it('checks municipality wards in range of 5 to 33', function () {
    $lang = $this->municipality->getLanguage();
    $wards = $lang === 'np'
        ? array_map(fn($item) => \Sagautam5\LocalStateNepal\Helpers\Helper::numericNepali((string) $item), range(1, 33))
        : range(1, 33);

    $idSet = range(1, 753);
    foreach ($idSet as $id) {
        expect(array_diff($this->municipality->wards($id), $wards))->toBeEmpty();
    }
});

it('checks if municipality has correct category id', function () {
    $idSet = range(1, 753);

    foreach ($idSet as $id) {
        $municipality = $this->municipality->find($id);
        if ($municipality) {
            expect(in_array($municipality->category_id, range(1, 4)))->toBeTrue();
        }
    }
});

it('checks if municipality has correct district id', function () {
    $idSet = range(1, 753);

    foreach ($idSet as $id) {
        $municipality = $this->municipality->find($id);
        if ($municipality) {
            expect(in_array($municipality->district_id, range(1, 77)))->toBeTrue();
        }
    }
});

it('searches across all municipalities', function () {
    $municipalities = $this->municipality->allMunicipalities();
    $keywords = ['id', 'district_id', 'category_id', 'name', 'area_sq_km', 'website', 'wards'];

    foreach ($keywords as $key) {
        $dataSet = array_column($municipalities, $key);
        foreach ($dataSet as $item) {
            $searchResults = $this->municipality->search($key, $item, true);
            expect($searchResults)->not()->toBeEmpty();
        }
    }
});

it('performs a recursive search', function () {
    $params = $_ENV['APP_LANG'] == 'en'? 
        [
            [
                'key' => 'name', 
                'value' => 
                'Jorpati', 
                'exact' => false
            ]
        ]: 
        [
            [
                'key' => 'name',
                'value' => 'जोरपाटी', 
                'exact' => false
            ]
        ];

    $result = $this->municipality->recursiveSearch($params);
    expect($result)->not()->toBeNull();
});

it('sorts municipalities by keys', function () {
    $keys = $this->municipality->getKeys();
    $orders = [SORT_ASC, SORT_DESC];

    foreach ($orders as $order) {
        foreach ($keys as $key) {
            $expected = array_column($this->municipality->allMunicipalities(), $key);
            $order === SORT_ASC ? sort($expected) : rsort($expected);
            $actual = array_column($this->municipality->sortBy($key, $order), $key);
            expect($expected)->toEqual($actual);
        }
    }
});

it('checks correct municipality count by province', function () {
    $expectedSet = [
        '1' => 137, '2' => 136, '3' => 119, '4' => 85, '5' => 109, '6' => 79, '7' => 88
    ];
    $actualSet = [];
    for ($index = 1; $index <= 7; $index++) {
        $actualSet[(string) $index] = count($this->municipality->getMunicipalityByProvince($index));
    }
    expect($expectedSet)->toEqual($actualSet);
});

it('checks total municipality count by province', function () {
    $expectedTotal = 753;
    $actualTotal = 0;

    for ($index = 1; $index <= 7; $index++) {
        $actualTotal += count($this->municipality->getMunicipalityByProvince($index));
    }

    expect($actualTotal)->toBe($expectedTotal);
});

it('returns a valid language (en or np)', function () {
    expect($this->municipality->getLanguage())->toBeIn(['en', 'np']);
});
