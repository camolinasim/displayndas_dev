<!-- <br>File to upload <input name="fileToUpload" type="file" id='fileToUpload' STYLE="width: 600px;" onchange="document.getElementById('Submit2').disabled=false;"> -->
 <br>

 <style>
 .parent {
   /* text-align: center; */
 }
 .child {
   display: inline-block;

 }
 </style>

<?php

if(!isset($_GET["docket"])){
    echo("POST['docket'] not set");
    print_r($_GET);
  }

else {
echo "<div class='parent'>";
echo '<div id="upload-document-docket" class="child">Docket: </div> ' ;
echo '<div class="target-docket child" >'.$_GET["docket"].'</div>';
echo "</div><br />";

echo ' <form action="UploadFile.php?docket='.$_GET["docket"].'" method="post" enctype="multipart/form-data">
  <div>
  Select file to upload:
  </div>
  <div style="display:flex;align-items:center;width:446px;height:57px;">
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input class="btn btn-primary submit-upload" type="submit" value="Submit" name="submit"> </form>
  </div>
 ';
}



// echo '<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#uploadDoc" value="https://orspweb2.utep.edu/displayndas_dev/UploadDocument.php?docket=' . $_GET['Docket'] . '">Upload File</button>'
// echo '<form id="Submit2" action="UploadFile.php?docket='.$_GET["docket"].'" method="post"> <input type="submit" value="Submit2"> </form>';



?>

<!-- <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#uploadDoc" value="https://orspweb2.utep.edu/displayndas_dev/UploadDocument.php?docket=' . $_GET['Docket'] . '">Upload File</button> -->
<!-- <input name="Submit2" id="Submit2" type="submit" value="Upload"> -->
