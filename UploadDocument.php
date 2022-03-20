
 <!-- <br>File to upload <input name="fileToUpload" type="file" id='fileToUpload' STYLE="width: 600px;" onchange="document.getElementById('Submit2').disabled=false;"> -->
 <br>

<?php
if(!isset($_GET["docket"])){
    echo("POST['docket'] not set");
    print_r($_GET);
  }

else {
echo '<div id="upload-document-docket"> Docket: '.$_GET["docket"].'<br><br></div>' ;

echo ' <form action="UploadFile.php?docket='.$_GET["docket"].'" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input method="post" type="submit" value="Submit2" name="submit"> </form>
 ';
}



// echo '<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#uploadDoc" value="https://orspweb2.utep.edu/displayndas_dev/UploadDocument.php?docket=' . $_GET['Docket'] . '">Upload File</button>'
// echo '<form id="Submit2" action="UploadFile.php?docket='.$_GET["docket"].'" method="post"> <input type="submit" value="Submit2"> </form>';



?>

<!-- <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#uploadDoc" value="https://orspweb2.utep.edu/displayndas_dev/UploadDocument.php?docket=' . $_GET['Docket'] . '">Upload File</button> -->
<!-- <input name="Submit2" id="Submit2" type="submit" value="Upload"> -->
<input name="Clear" type="reset" value="Clear">


 </form>
