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
  <form id="uploadForm" enctype="multipart/form-data">
  <div style="display:flex;align-items:center;width:446px;height:57px;">
  <input class="file-browser" type="file" name="fileToUpload" id="fileToUpload">
  <input  class="btn btn-primary submit-upload btn-submit-file" type="button" class="button" value="submit"
                        id="but_upload">
   </form>
  </div>
 ';

echo '<div class="progress">0%
<div class="progress-bar"></div>
</div>';
echo '<div id="uploadStatus"></div>';
}
?>

<!-- Uploads files asynchronously and displays them on the datatable after upload  -->
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
                    xhr: function() {
                                    var xhr = new window.XMLHttpRequest();
                                    xhr.upload.addEventListener("progress", function(evt) {
                                        if (evt.lengthComputable) {
                                            var percentComplete = ((evt.loaded / evt.total) * 100);
                                            $(".progress-bar").width(percentComplete + '%');
                                            $(".progress-bar").html(percentComplete+'%');
                                        }
                                    }, false);
                                    return xhr;
                                },

                    //start of normal
                      url: 'UploadFile.php' + data_for_upload_php,
                      type: 'post',
                      data: fd,
                      contentType: false,
                      cache: false,
                      processData: false,
                      beforeSend: function(){
                                      $(".progress-bar").width('0%');
                                  },
                                  error:function(){
                                      $('#uploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
                                  },
                      success: function(response){
                          if(response != 0){
                            $('#uploadStatus').html('<p style="color:#28A74B;">File has uploaded successfully!</p>');
                            var index = id_of_column_to_update_after_upload;
                            var filename = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '');
                            var abomination = '<div class=" file_section"> <a href=' + '"' + 'https://orspweb2.utep.edu/NDAs_dev/' + $target + '/'+ filename + '"' + '>' + filename  + '<br />' + '</a>' + '<form action="#", method="POST"> <input id=' +'"' + 'DeleteFile.php?file=' + encodeURIComponent($target + '/'+ filename) + '"  class="btn btn-danger btn_delete_file" type="button" value="Delete File" ></div></form>';
                            // var abomination = container + link_to_file + delete_button
                            console.log(abomination)
                            $("td#" + id_of_column_to_update_after_upload).append(abomination);
                            // $("td#" + id_of_column_to_update_after_upload).append(delete_button);
                            $('#uploadForm')[0].reset();


                          }
                          else{
                              $('#uploadStatus').html('<p style="color:#EA4335;">File not uploaded.</p>');
                              alert('file not uploaded');
                          }
                      },
                  });

                });


              });
           </script>



<!-- <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#uploadDoc" value="https://orspweb2.utep.edu/displayndas_dev/UploadDocument.php?docket=' . $_GET['Docket'] . '">Upload File</button> -->
<!-- <input name="Submit2" id="Submit2" type="submit" value="Upload"> -->
