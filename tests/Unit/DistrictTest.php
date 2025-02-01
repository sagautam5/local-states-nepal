<?php

use Sagautam5\LocalStateNepal\Entities\District;

beforeEach(function () {
    $this->language = $_ENV['APP_LANG'];
    $this->district = new District($this->language);
});

it('returns the largest district', function () {
    $largest = $this->district->largest();
    expect([$largest->id, $largest->province_id])->toEqual([61, 6]);
});

it('finds district for range between 1 to 77', function () {
    $correctIdSet = range(1, 77);
    $incorrectIdSet = range(78, 154);

    foreach ($correctIdSet as $id) {
        expect($this->district->find($id))->not()->toBeNull();
    }

    foreach ($incorrectIdSet as $id) {
        expect($this->district->find($id))->toBeNull();
    }
});

it('returns the smallest district', function () {
    $smallest = $this->district->smallest();
    expect([$smallest->id, $smallest->province_id])->toEqual([23, 3]);
});

it('counts the districts correctly', function () {
    expect(count($this->district->allDistricts()))->toBe(77);
});

it('fails if district data contains null values', function () {
    foreach ($this->district->allDistricts() as $set) {
        expect(in_array(null, (array) $set, true))->toBeFalse();
    }
});

it('checks districts for correct province ids', function () {
    $idSet = range(1, 77);

    foreach ($idSet as $id) {
        $district = $this->district->find($id);
        if ($district) {
            expect(in_array($district->province_id, range(1, 7)))->toBeTrue();
        }
    }
});

it('searches across all districts', function () {
    $districts = $this->district->allDistricts();
    $keywords = ['id', 'province_id', 'name', 'area_sq_km', 'website', 'headquarter'];

    foreach ($keywords as $key) {
        $dataSet = array_column($districts, $key);
        foreach ($dataSet as $item) {
            $searchResults = $this->district->search($key, $item, true);
            expect($searchResults)->not()->toBeEmpty();
        }
    }
});

it('performs a recursive search', function () {
    $params = $_ENV['APP_LANG'] == 'en'
        ? [
            [
                'key' => 'name', 
                'value' => 'Gulmi', 
                'exact' => false
            ],
            [
                'key' => 'headquarter', 
                'value' => 'Tamghas', 
                'exact' => false
            ],
            [
                'key' => 'province_id', 
                'value' => '5', 
                'exact' => false
            ]
        ]
        : [
            [
                'key' => 'name',
                'value' => 'गुल्', 
                'exact' => false
            ],
            [
                'key' => 'headquarter',
                'value' => 'तम्घा',
                'exact' => false
            ],
            [
                'key' => 'province_id',
                'value' => '5', 
                'exact' => false
            ]
        ];

    $result = $this->district->recursiveSearch($params);
    expect($result)->not()->toBeNull();
});

it('sorts districts by keys', function () {
    $keys = $this->district->getKeys();
    $orders = [SORT_ASC, SORT_DESC];

    foreach ($orders as $order) {
        foreach ($keys as $key) {
            $expected = array_column($this->district->allDistricts(), $key);
            $order == SORT_ASC ? sort($expected) : rsort($expected);
            $actual = array_column($this->district->sortBy($key, $order), $key);
            expect($expected)->toEqual($actual);
        }
    }
});

it('returns a valid language (en or np)', function () {
    expect($this->district->getLanguage())->toBeIn(['en', 'np']);
});
