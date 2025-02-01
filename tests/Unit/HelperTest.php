<?php
namespace Sagautam5\LocalStateNepal\Test\Unit;

use Sagautam5\LocalStateNepal\Helpers\Helper;

it('converts nepali numbers to english correctly', function () {
    $helper = new Helper();
    $nepaliSet = ['०९', '१८', '२७', '३६', '४५', '५४', '६३', '७२', '८१', '९०'];
    $englishSet = ['09','18', '27', '36', '45', '54', '63', '72', '81', '90'];

    foreach ($nepaliSet as $key => $number) {
        expect($helper->numericEnglish($number))->toBe($englishSet[$key]);
    }
});

it('converts english numbers to nepali correctly', function () {
    $helper = new Helper();
    $englishSet = ['09','18', '27', '36', '45', '54', '63', '72', '81', '90'];
    $nepaliSet = ['०९', '१८', '२७', '३६', '४५', '५४', '६३', '७२', '८१', '९०'];

    foreach ($englishSet as $key => $number) {
        expect($helper->numericNepali($number))->toBe($nepaliSet[$key]);
    }
});