<?php

use Sagautam5\LocalStateNepal\Entities\Province;

beforeEach(function () {
    $this->language = $_ENV['APP_LANG'];
    $this->province = new Province($this->language);
});

it('returns the largest province', function () {
    $largest = $this->province->largest();
    expect($largest->id)->toBe(6);
});

it('finds province for range between 1 and 7', function () {
    $correctIdSet = range(1, 7);
    $incorrectIdSet = range(8, 15);

    foreach ($correctIdSet as $id) {
        expect($this->province->find($id))->not()->toBeNull();
    }

    foreach ($incorrectIdSet as $id) {
        expect($this->province->find($id))->toBeNull();
    }
});

it('returns the smallest province', function () {
    $smallest = $this->province->smallest();
    expect($smallest->id)->toBe(2);
});

it('counts the provinces correctly', function () {
    expect(count($this->province->allProvinces()))->toBe(7);
});

it('fails if province data contains null values', function () {
    foreach ($this->province->allProvinces() as $set) {
        expect(in_array(null, (array) $set, true))->toBeFalse();
    }
});

it('searches across all provinces', function () {
    $provinces = $this->province->allProvinces();
    $keywords = ['id', 'name', 'area_sq_km', 'website', 'headquarter'];

    foreach ($keywords as $key) {
        $dataSet = array_column($provinces, $key);
        foreach ($dataSet as $item) {
            $searchResults = $this->province->search($key, $item, true);
            expect($searchResults)->not()->toBeEmpty();
        }
    }
});

it('performs a recursive search', function () {
    $params = $_ENV['APP_LANG'] == 'en'? 
        [
            [
                'key' => 'name', 
                'value' => 'mati', 
                'exact' => false
            ], 
            [
                'key' => 'headquarter', 
                'value' => 'Hetauda', 
                'exact' => 
                false    
            ]
        ]: 
        [
            [
                'key' => 'name', 
                'value' => 'मती', 
                'exact' => false
            ], 
            [
                'key' => 'headquarter', 
                'value' => 
                'हेटौडा', 
                'exact' => false
            ]
        ];

    $result = $this->province->recursiveSearch($params);
    expect($result)->not()->toBeNull();
});

it('sorts provinces by keys', function () {
    $keys = $this->province->getKeys();
    $orders = [SORT_ASC, SORT_DESC];

    foreach ($orders as $order) {
        foreach ($keys as $key) {
            $expected = array_column($this->province->allProvinces(), $key);
            $order === SORT_ASC ? sort($expected) : rsort($expected);
            $actual = array_column($this->province->sortBy($key, $order), $key);
            expect($expected)->toEqual($actual);
        }
    }
});

it('returns a valid language (en or np)', function () {
    expect($this->province->getLanguage())->toBeIn(['en', 'np']);
});
