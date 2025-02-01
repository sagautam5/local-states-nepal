<?php

use Sagautam5\LocalStateNepal\Entities\Category;

beforeEach(function () {
    $this->lang = $_ENV['APP_LANG'];
    $this->category = new Category($this->lang);
});

it('finds category for range between 1 to 4', function () {
    $correctIdSet = range(1, 4);
    $incorrectIdSet = range(5, 8);

    foreach ($correctIdSet as $id) {
        expect($this->category->find($id))->not()->toBeNull();
    }

    foreach ($incorrectIdSet as $id) {
        expect($this->category->find($id))->toBeNull();
    }
});

it('finds category by each short code', function () {
    $correctCodeSet = ['MC', 'SMC', 'M', 'RM'];
    $incorrectCodeSet = ['AA', 'BB', 'CC', 'DD'];

    foreach ($correctCodeSet as $code) {
        expect($this->category->findByShortCode($code))->not()->toBeNull();
    }

    foreach ($incorrectCodeSet as $code) {
        expect($this->category->findByShortCode($code))->toBeNull();
    }
});

it('fails if categories contain null values', function () {
    foreach ($this->category->allCategories() as $set) {
        expect(in_array(null, (array) $set, true))->toBeFalse();
    }
});

it('counts the categories correctly', function () {
    expect(count($this->category->allCategories()))->toBe(4);
});

it('performs a search across all categories', function () {
    $categories = $this->category->allCategories();
    $keywords = ['id', 'name', 'short_code'];

    foreach ($keywords as $key) {
        $dataSet = array_column($categories, $key);
        foreach ($dataSet as $item) {
            $searchResults = $this->category->search($key, $item, true);
            expect($searchResults)->not()->toBeEmpty();
        }
    }
});

it('performs a recursive search', function () {
    $params = $_ENV['APP_LANG'] == 'en' ? 
        [
            [
                'key' => 'name',
                'value' => 'Municipality', 
                'exact' => false
            ], 
            [
                'key' => 'short_code',
                'value' => 'M',
                'exact' => false
            ]
        ]: 
        [
            [
                'key' => 'name',
                'value' => 'नगरपालिका',
                'exact' => false
            ],
            [
                'key' => 'short_code',
                'value' => 'M',
                'exact' => false
            ]
        ];

    $result = $this->category->recursiveSearch($params);
    expect($result)->not()->toBeNull();
});

it('sorts categories by keys', function () {
    $keys = $this->category->getKeys();
    $orders = [SORT_ASC, SORT_DESC];

    foreach ($orders as $order) {
        foreach ($keys as $key) {
            $expected = array_column($this->category->allCategories(), $key);
            $order == SORT_ASC ? sort($expected) : rsort($expected);
            $actual = array_column($this->category->sortBy($key, $order), $key);

            expect($expected)->toEqual($actual);
        }
    }
});

it('returns a valid language (en or np)', function () {
    expect($this->category->getLanguage())->toBeIn(['en', 'np']);
});
