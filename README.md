# devprox-csv
 Devprox Test 2



## Creating a CSV

1. Click on **Create CSV** button
2. Enter "Amount of Records" you would like
3. Add a name for the file
4. Click on **Create CSV**

## Importing CSV into MySQL

1. Go to db.php and enter in **YOUR** database credentials

```php
<?php
    $servername='localhost';
    $username='root';
    $password='';
    $dbname = "devprox_db";
    $conn=mysqli_connect($servername,$username,$password,"$dbname");
      if(!$conn){
          die('Could not Connect MySql Server:' .mysqli_error($conn));
        }
?>
```

2. Add a database called devprox_db to your MySQL database
3. Run the **db.sql** file in your database which will create the table used for Importing CSVs into MySQL database table
