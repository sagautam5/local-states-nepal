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
   
7. Search districts by key and value with exact match option

   ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\District;
    
    $district = new District();
   
    $districtDetails = $district->search('name','Gulmi');
    
    // For exact match, pass optional parameter $exact as true 
    $districtDetails = $district->search('name','Gulmi', true);
    ```      
   
   List of options for parameter key:
      
      ```php
       ['id', 'province_id', 'name', 'area_sq_km', 'website', 'headquarter'];
      ```         
8. Recursive search with multiple set of key value data
   
      ```php
       <?php
       
       use Sagautam5\LocalStateNepal\Entities\District;
       
       $district = new District();
       $params = [
                      ['key' => 'headquarter', 'value' => 'some name', 'exact' => true],   
                      ['key' => 'id', 'value' => 'some id', 'exact' => true]
          ];
       $districtDetails = $district->recursiveSearch($params);   
      
       // if you have already filtered district data in structured format, then you can pass the data in recursive search
       $data =  $district->search('name', 'some name', false); 
      
       $districtDetails = $district->search($params, $data);
   ```   
      
      
   List of options for parameter key:
      
   ```php
    ['id', 'province_id', 'name', 'area_sq_km', 'website', 'headquarter'];
   ```           