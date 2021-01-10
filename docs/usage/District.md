### Districts

#### Introduction
By default, english language will be used. In order to use Nepali language, you have to specify while initiating the district object.

```php
<?php

use Sagautam5\LocalStateNepal\Entities\District;

// English language will be selected by default
$district = new District();

```

You can specify language like this:

```php
<?php

use Sagautam5\LocalStateNepal\Entities\District;

$district = new District('np');
```

#### Retrieving Districts

Once you initiate district entity, you can retrieve variety of data.

1. Get list of all districts  
    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\District;
    
    $district = new District();
    
    $districtList = $district->allDistricts();
    ```

2. Find district details by unique identifier

    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\District;
    
    $district = new District();
    
    $districtDetails = $district->find(1);
    ```

3. Get district with largest area

    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\District;
    
    $district = new District();
    
    $districtDetails = $district->largest();
    ```
   
4. Get district with smallest area

    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\District;
    
    $district = new District();
    
    $districtDetails = $district->smallest();
    ```
   
5. Get all districts and their municipalities

    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\District;
    
    $district = new District();
    
    $districtDetails = $district->getDistrictsWithMunicipalities();
    ```
6. Get all districts by province

    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\District;
    
    $district = new District();
    
    $districtDetails = $district->getDistrictsByProvince(3);
    ```
   
7. Search District By Keyword

   ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\District;
    
    $district = new District();
   
    $districtDetails = $district->search('Gulmi');
    ```      