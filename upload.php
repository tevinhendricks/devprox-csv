<?php include_once('header.php'); ?>

<div class="container">
    <?php 
    if(isset($_GET['Success'])){
        echo "<div class='alert alert-success'>You have successfully uploaded the CSV</div>";
    } 
    if(isset($_GET['Warning'])){
        echo "<div class='alert alert-danger'>Please select a valid CSV</div>";
    }
    ?>
    <a href="index.php" class="btn btn-primary">Home</a>
    <br>
    <br>
    <form action="import.php" method="post" enctype="multipart/form-data">
      <div class="input-group">
        <div class="custom-file">
          <input type="file"  id="customFileInput" aria-describedby="customFileInput" name="file">
          <label class="custom-file-label" for="customFileInput">Select file</label>
        </div>
        <div class="input-group-append">
           <input type="submit" name="submit" value="Upload" class="btn btn-primary">
        </div>
      </div>
  </form>
  </div>

  <?php include_once('footer.php'); ?> 