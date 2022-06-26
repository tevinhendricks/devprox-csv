<?php
// include mysql database configuration file
include_once 'db.php';


if (isset($_POST['submit'])){

    function file_get_contents_chunked($link, $file, $chunk_size, $queryValuePrefix, $callback)
    {
        try {
            $handle = fopen($file, "r");
            fgetcsv($handle);
            $i = 0;
            while (! feof($handle)) {
                call_user_func_array($callback, array(
                    fread($handle, $chunk_size),
                    &$handle,
                    $i,
                    &$queryValuePrefix,
                    $link
                ));
                $i ++;
            }
            fclose($handle);
        } catch (Exception $e) {
            trigger_error("file_get_contents_chunked::" . $e->getMessage(), E_USER_NOTICE);
            return false;
        }

        return true;
        
    }
    // $link = mysqli_connect("localhost", "root", "", "devprox_db");
     $csvFile = $_FILES['file']['name'];

    //  echo '<pre>'.print_r($_FILES,true).'</pre>';
    $success = file_get_contents_chunked($conn,$csvFile, 2048, '', function ($chunk, &$handle, $iteration, &$queryValuePrefix, $conn) {
        $TABLENAME = 'csv_users';
        $chunk = $queryValuePrefix . $chunk;

        // split the chunk of string by newline. Not using PHP's EOF
        // as it may not work for content stored on external sources
        $lineArray = preg_split("/\r\n|\n|\r/", $chunk);
        $query = 'INSERT INTO ' . $TABLENAME . '(name, surname, initials,age,date_of_birth) VALUES ';
        $numberOfRecords = count($lineArray);
        for ($i = 0; $i < $numberOfRecords - 2; $i ++) {
            // split single CSV row to columns
            $colArray = explode(',', $lineArray[$i]);
            $query = $query . '("' . $colArray[1] . '","' . $colArray[2] . '","' . $colArray[3] . '","' . $colArray[4] . '","' . $colArray[5] . '"),';

        }
        // last row without a comma
        $colArray = explode(',', $lineArray[$i]);
        $query = $query . '("' . $colArray[1] . '","' . $colArray[2] . '","' . $colArray[3] . '","' . $colArray[4] . '","' . $colArray[5] . '")';

        $i = $i + 1;

        // storing the last truncated record and this will become the
        // prefix in the next run
        $queryValuePrefix = $lineArray[$i];
        mysqli_query($conn, $query) or die(mysqli_error($conn));

        /*
        * {$handle} is passed in case you want to seek to different parts of the file
        * {$iteration} is the section of the file that has been read so
        * ($i * 4096) is your current offset within the file.
        */
    });

    if (! $success) {
        header("Location: upload.php?Warning");
    }else{
        header("Location: upload.php?Success");
    }
}


