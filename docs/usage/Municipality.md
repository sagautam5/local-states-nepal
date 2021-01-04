### Municipalities

#### Introduction
By default, english language will be used. In order to use Nepali language, you have to specify while initiating the municipality object.

```php
<?php

use Sagautam5\LocalStateNepal\Entities\Municipality;

// English language will be selected by default
$municipality = new Municipality();

```

You can specify language like this:

```php
<?php

use Sagautam5\LocalStateNepal\Entities\Municipality;

$municipality = new Municipality('np');
```

#### Retrieving Municipalities

Once you initiate municipality entity, you can retrieve variety of data.

1. Get list of all municipalities
    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\Municipality;
    
    $municipality = new Municipality();
    
    $municipalityList = $municipality->allMunicipalities();
    ```

2. Find municipality details by unique identifier

    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\Municipality;
    
    $municipality = new Municipality();
    
    $municipalityDetails = $municipality->find(1);
    ```

3. Get municipality with largest area

    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\Municipality;
    
    $municipality = new Municipality();
    
    $municipalityDetails = $municipality->largest();
    ```
   
4. Get municipality with smallest area

    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\Municipality;
    
    $municipality = new Municipality();
    
    $municipalityDetails = $municipality->smallest();
    ```
   
5. Get all municipalities by district id

    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\Municipality;
    
    $municipality = new Municipality();
    
    $municipalityDetails = $municipality->getMunicipalitiesByDistrict(12);
    ```
6. Get all municipalities by category id

    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\Municipality;
    
    $municipality = new Municipality();
    
    $municipalityDetails = $municipality->getMunicipalityByCategory(4);
    ```
   
7. Get all wards of a municipality

   ```php
   <?php
   
   use Sagautam5\LocalStateNepal\Entities\Municipality;
   
   $municipality = new Municipality();
   
   $municipalityDetails = $municipality->wards(4);
   ```