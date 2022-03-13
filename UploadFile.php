<?php
//delete
function println($data) {
$console = $data;
if (is_array($console))
$console = implode(',', $console);

echo "<script>console.log('Console: " . $console . "' );</script>";
}
print_r($_POST);
echo '<br />';
print_r($_GET);
echo '<br />';

print_r($_FILES);
echo '<br />';

if (isset($_POST["submit"])) {


  $target_dir  = "\\\ORSPSRVAPP02\\webroot2\\NDAs_dev\\".$_GET['docket'].'\\';

  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  print($target_file);
  $uploadOk    = 1;


  // Check if file already exists
  if (file_exists($target_file)) {
    echo "The file already exists.";
    $uploadOk = 0;
  }


  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 65062000) {
    echo " Your file is too large.";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      echo " Your file was not uploaded.";
      //header("Location: https://orspweb2.utep.edu/displayndas_dev/index.php"); //remove ths after adding ajax

      exit();

  // if everything is ok, try to upload file
  } else {

      if (!is_dir($target_dir)) {

        mkdir($target_dir);
      }

      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo " The file ". basename($target_file). " has been uploaded.";
        header("Location: https://orspweb2.utep.edu/displayndas_dev/index.php"); //remove ths after adding ajax


      } else {
          echo " There was an error uploading your file.";
          //header("Location: https://orspweb2.utep.edu/displayndas_dev/index.php"); //remove ths after adding ajax

      }

    }
  }

?>
