### Provinces

#### Introduction
By default, english language will be used. In order to use Nepali language, you have to specify while initiating the province object.

```php
<?php

use Sagautam5\LocalStateNepal\Entities\Province;

// English language will be selected by default
$province = new Province();

```

You can specify language like this:

```php
<?php

use Sagautam5\LocalStateNepal\Entities\Province;

$province = new Province('np');
```

#### Retrieving Provinces

Once you initiate province entity, you can retrieve variety of data.

1. Get list of all provinces  
    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\Province;
    
    $province = new Province();
    
    $provinceList = $province->allProvinces();
    ```

2. Find province details by unique identifier

    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\Province;
    
    $province = new Province();
    
    $provinceDetails = $province->find(1);
    ```

3. Get province with largest area

    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\Province;
    
    $province = new Province();
    
    $provinceDetails = $province->largest();
    ```
   
4. Get province with smallest area

    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\Province;
    
    $province = new Province();
    
    $provinceDetails = $province->smallest();
    ```
   
5. Get all provinces and their districts

    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\Province;
    
    $province = new Province();
    
    $provinceDetails = $province->getProvincesWithDistricts();
    ```
   
6. Get all provinces and their districts and their municipalities

    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\Province;
    
    $province = new Province();
    
    $provinceDetails = $province->getProvincesWithDistrictsWithMunicipalities();
    ```
   
7. Search Province By Keyword
      
      ```php
      <?php
      
      use Sagautam5\LocalStateNepal\Entities\Province;
      
      $province = new Province();
     
      $provinceDetails = $province->search('Kathmandu');
      ```         