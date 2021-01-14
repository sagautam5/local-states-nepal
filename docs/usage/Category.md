### Categories

#### Introduction
By default, english language will be used. In order to use Nepali language, you have to specify while initiating the category object.

```php
<?php

use Sagautam5\LocalStateNepal\Entities\Category;

// English language will be selected by default
$category = new Category();

```

You can specify language like this:

```php
<?php

use Sagautam5\LocalStateNepal\Entities\Category;

$category = new Category('np');
```

#### Retrieving Categories

Once you initiate category entity, you can retrieve variety of data.

1. Get list of all categories  
    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\Category;
    
    $category = new Category();
    
    $categoryList = $category->allCategories();
    ```

2. Find category details by unique identifier

    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\Category;
    
    $category = new Category();
    
    $categoryDetails = $category->find(1);
    ```
   
3. Find category details by short code

    ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\Category;
    
    $category = new Category();
   
    // Options: MC, SMC, M, RM
    $categoryDetails = $category->findByShortCode('MC');
    ```
   
4. Search categories by key and value with exact match option

   ```php
    <?php
    
    use Sagautam5\LocalStateNepal\Entities\Category;
    
    $category = new Category();
   
    $categoryDetails = $category->search('name', 'Municipality');
   
    // For exact match, pass optional parameter $exact as true 
    $categoryDetails = $category->search('name', 'Municipality', true);
    ```   
   
   List of options for parameter key:
         
      ```php
          ['id', 'name', 'short_code']
      ```       