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
   
7. Search provinces by key and value with exact match option
      
      ```php
      <?php
      
      use Sagautam5\LocalStateNepal\Entities\Province;
      
      $province = new Province();
     
      $provinceDetails = $province->search('name','Bagmati');
       
      // For exact match, pass optional parameter $exact as true 
      $provinceDetails = $province->search('name','Bagmati', true);
   
      ```
   
   List of options for parameter key:
   
   ```php
    ['id', 'name', 'area_sq_km', 'website', 'headquarter'];
    ```         
   
8. Recursive search with multiple set of key value data
      
    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\Province;
    
    $province = new Province();
    $params = [
                 ['key' => 'name', 'value' => 'some name', 'exact' => false],   
                 ['key' => 'headquarter', 'value' => 'some name', 'exact' => true]
     ];
    $provinceDetails = $province->recursiveSearch($params);   
    
    // if you have already filtered province data in structured format, then you can pass the data in recursive search
    $data =  $province->search('name', 'some name', false); 
    
    $provinceDetails = $province->search($params, $data);
    ```   
         
    List of options for parameter key:
    
    ```php
    ['id', 'name', 'area_sq_km', 'website', 'headquarter'];
    ```  