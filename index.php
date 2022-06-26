<?php
set_time_limit(0);


function randomName() {
    $firstname = array(
        'Johnathon',
        'Anthony',
        'Erasmo',
        'Raleigh',
        'Nancie',
        'Tama',
        'Camellia',
        'Augustine',
        'Christeen',
        'Luz',
        'Diego',
        'Lyndia',
        'Thomas',
        'Georgianna',
        'Leigha',
        'Alejandro',
        'Marquis',
        'Joan',
        'Stephania',
        'Elroy',
        
    );

    $lastname = array(
        'Mischke',
        'Serna',
        'Pingree',
        'Mcnaught',
        'Pepper',
        'Schildgen',
        'Mongold',
        'Wrona',
        'Geddes',
        'Lanz',
        'Fetzer',
        'Schroeder',
        'Block',
        'Mayoral',
        'Fleishman',
        'Roberie',
        'Latson',
        'Lupo',
        'Motsinger',
        'Drews',
            );

    $name = $firstname[rand ( 0 , count($firstname) -1)];
    $name .= ' ';
    $name .= $lastname[rand ( 0 , count($lastname) -1)];

    return $name;
}

// $data = [
//     ['ID', 'Name', 'Surname', 'Initials','Age','DateOfBirth']
// ];


function create_name_arrays($count){
    
    $cnt = $count;

    $data = [
        ['ID', 'Name', 'Surname', 'Initials','Age','DateOfBirth']
    ];

    for($i=0; $i < $count; $i++){
        $rand_name = randomName();

        $fullname = explode(" ", $rand_name);
    
        $name = $fullname[0];
        $surname = $fullname[1];
    
        $age = rand(1,100);
    
        $today =  date('y-m-d');
    
        $birth_date = strtotime("$today -$age year");
    
        $dob = date('Y-m-d', $birth_date);
    
        $intials = strtoupper(substr($name, 0, 1)) . strtoupper(substr($surname, 0, 1));
    
        // echo '<pre>'.print_r($fullname,true).'</pre>';
        // echo '<pre>'.print_r($name,true).'</pre>';
        // echo '<pre>'.print_r($surname,true).'</pre>';
        // echo '<pre>'.print_r($intials,true).'</pre>';
        // echo '<pre>'.print_r($dob,true).'</pre>';
        // echo '<pre>'.print_r($today,true).'</pre>';
        // echo '<pre>'.print_r($age,true).'</pre>';
        $id = $i + 1;
        $dataArr =  Array($id,$name,$surname,$intials,$age,$dob);
        
        if (!in_array($dataArr, $data))
        {
            array_push($data,$dataArr);
        }
    }

    return $data;
}




// echo '<pre>'.print_r($arr,true).'</pre>';

if(isset($_POST['create_csv'])){
    $arr =  create_name_arrays($_POST['records']);
    ini_set('max_execution_time', '180'); 

    $rand = rand(1,5000);
    $filename = $_POST['filename']. $rand.'.csv';

    // open csv file for writing
    $f = fopen($filename, 'w');

    if ($f === false) {
        die('Error opening the file ' . $filename);
    }

    // write each row at a time to a file
    foreach ($arr as $row) {
        fputcsv($f, $row);
    }

    $message = "File created";
    // header("Location: index.php");

    // close the file
    fclose($f);

}



?>
<?php include_once("header.php"); ?>
<?php 
    if(isset($message)){
        echo "<div class='alert alert-success'>" . $message . "</div>";
    }
?>

<?php

$fileList = glob('*.csv');



?>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Create CSV
</button>
<a href="upload.php" class="btn btn-success">Import CSV to MySQL</a>
<br>
<br>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Create CSV</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="" method="post">
        <div class="form-group">
            <label for="records">Amount of Records</label>
            <input type="number" class="form-control" name="records">
        </div>
        <div class="form-group">
            <label for="filename">File Name</label>
            <input type="text" class="form-control" minlength="3" maxlength="2558" name="filename">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-success" type="submit" name="create_csv" value="Create CSV">
      </div>
    </form>
    </div>
  </div>
</div>
<?php 

if(!empty($fileList)){
    $tbl = "";
    $tbl .= '<table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">Files Uploaded</th>
      </tr>
    </thead>
    <tbody>';
    foreach($fileList as $phpfile)
    {
        
        $tbl .="<tr>
                    <td><a href=$phpfile>".basename($phpfile).".</a><br></td>
                </tr>"; 
        
    // echo "<a href=$phpfile>".basename($phpfile).".</a><br>";
    }
        $tbl .= '</tbody>
                    </table>';
        echo $tbl;
}
?>
<?php include_once('footer.php'); ?>