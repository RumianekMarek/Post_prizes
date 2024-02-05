<?php
//Required data
require_once('dane.php');

//form
echo'
  <form action="" id="addfile" method="post" enctype="multipart/form-data">
    <label>Add File</label><br>
    <input type="file" name="postcode"><br>
    <button name="submit">Submit</button>
  </form>
';

// Function to create the database table
function create_database($content){
    $tableName = "post_codes";

    $conn = check_database($tableName);

    if (!table_exists($tableName)) {
      $createTableQuery = "CREATE TABLE $tableName (
        zone_number INT,
        price VARCHAR(10)
      )";
      if ($conn->query($createTableQuery) === true) {
        echo "Table post_codes has been created.<br>";
      } else {
        echo "Error creating table: " . $conn->error . "<br>";
      }

    }
    add_to_table($tableName, $content);  
    $conn->close();
}

// Checking and distributing form entries
if(isset($_POST['submit'])){
  if (!empty($_FILES['postcode']['tmp_name'])) {
    $content = [];
    $uploadedFile = $_FILES['postcode']['tmp_name'];

    $fileHandle = fopen($uploadedFile, 'r');

      if ($fileHandle !== false) {
          $file_array = [];

          while (($row = fgetcsv($fileHandle)) !== false) {
              $file_array[] = $row;
          }
          
          foreach($file_array as $id => $file){
            $content[] = [$id+1 , implode(',', $file)];
          }
          fclose($fileHandle);
      }
      create_database($content);
    } else {
        echo "<p>Error uploading file.</p>";
    }
}