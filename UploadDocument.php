######### PASTE TO UploadDocument.php FOR GORGAGAN RETURNS##########

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
echo '<div class="target-column" style="display: none;" >'.$_GET["id_of_column_to_update_after_upload"].'</div>';
echo "<div class='parent'>";
echo '<div id="upload-document-docket" class="child">Docket: </div> ' ;
echo '<div class="target-docket child" >'.$_GET["docket"].'</div>';
echo "</div><br />";

echo '
  <div>
  Select file to upload:
  </div>
  <div style="display:flex;align-items:center;width:446px;height:57px;">
  <input class="file-browser" type="file" name="fileToUpload" id="fileToUpload">
  <input  class="btn btn-primary submit-upload btn-submit-file" type="button" class="button" value="submit"
                        id="but_upload">
  </div>
 ';
}
?>

<script type="text/javascript">
              $(document).ready(function(){
                $('.btn-submit-file').click(function(){
                  // alert(" you clicked me");
                  var $target = $("div.target-docket").text();    // Find the row
                  var data_for_upload_php = "?docket=" + $target
                  var id_of_column_to_update_after_upload = $("div.target-column").text();    // Find the row
                  // alert (id_of_column_to_update_after_upload)

                  var fd = new FormData();
                  var files = $('#fileToUpload')[0].files[0];
                  fd.append('fileToUpload', files);
                  $.ajax({
                      url: 'UploadFile.php' + data_for_upload_php,
                      type: 'post',
                      data: fd,
                      contentType: false,
                      processData: false,
                      success: function(response){
                          if(response != 0){
                            var index = id_of_column_to_update_after_upload;


                            // $('#ndas').DataTable().cell({row:index , column:3}).data("");
                            // console.log(idk)
                            var filename = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '');
                            link_to_file = '<a href=' + '"' + 'https://orspweb2.utep.edu/NDAs_dev/' + $target + '/'+ filename + '"' + '>' + filename  + '<br />' + '</a>'
                            delete_button = '<form action =' + '"' + 'DeleteFile.php?file=' + encodeURIComponent($target + '/'+ filename) + '" method="POST"> <input class="btn btn-danger" type="submit" value="Delete File" ></form>'
                                            // '<form action="DeleteFile.php?file=', rawurlencode($row['Docket'].'/'.$files[$i]), '", method="POST"> <input class="btn btn-danger" type="submit" value="Delete File"></form>'; //adds delete button for the file
                                            console.log(delete_button)
                            $("td#" + id_of_column_to_update_after_upload).append(link_to_file);
                            $("td#" + id_of_column_to_update_after_upload).append(delete_button);
                            // $("td#" + id_of_column_to_update_after_upload).html( '<a href="https://orspweb2.utep.edu/NDAs_dev/'+ $target + '/'+ filename '" );
                            alert('file uploaded');
                            // var target_row = $("tr:contains('$target')")
                            // alert(target_row.html());
                            // console.log(target_row.html())
                            // $('#ndas').DataTable().ajax.reload()
                          }
                          else{
                              alert('file not uploaded');
                          }
                      },
                  });

                  //Open the upload document pop-up, then add the text of uploadDocument.php.
                  // (This makes sure the program remembers which docket the user clicked)
                  // $("#UploadDocumentTextGoesHere").load("UploadDocument.php?docket="+ text);

                });


              });
           </script>


<!-- <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#uploadDoc" value="https://orspweb2.utep.edu/displayndas_dev/UploadDocument.php?docket=' . $_GET['Docket'] . '">Upload File</button> -->
<!-- <input name="Submit2" id="Submit2" type="submit" value="Upload"> -->
