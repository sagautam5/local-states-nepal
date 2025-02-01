<?php

use Sagautam5\LocalStateNepal\Entities\Municipality;

beforeEach(function () {
    $this->language = $_ENV['APP_LANG'];
    $this->municipality = new Municipality($this->language);
});

it('calculates the total number of wards correctly', function () {
    $allMunicipalities = $this->municipality->allMunicipalities();

    $totalWards = array_reduce($allMunicipalities, function($mWards, $municipality) {
        return $mWards + $municipality->wards;
    }, 0);

    expect($totalWards)->toBe(6743);
});

it('calculates the total number of wards by category correctly', function () {
    $data = [
        'metropolitan' => 0,
        'subMetropolitan' => 0,
        'municipality' => 0,
        'ruralMunicipality' => 0
    ];

    $allMunicipalities = $this->municipality->allMunicipalities();

    foreach ($allMunicipalities as $municipality) {
        switch ($municipality->category_id) {
            case '1':
                $data['metropolitan'] += $municipality->wards;
                break;
            case '2':
                $data['subMetropolitan'] += $municipality->wards;
                break;
            case '3':
                $data['municipality'] += $municipality->wards;
                break;
            case '4':
                $data['ruralMunicipality'] += $municipality->wards;
                break;
            default:
                break;
        }
    }

    expect($data['metropolitan'])->toBe(174);
    expect($data['subMetropolitan'])->toBe(234);
    expect($data['municipality'])->toBe(3120);
    expect($data['ruralMunicipality'])->toBe(3215);

    expect(array_sum($data))->toBe(6743);
});
