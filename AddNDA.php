<?php
	echo '<form method="post" id= "SelectionForm" name= "SelectionForm" target="_blank" enctype="multipart/form-data">';
?>
	<br>
	<table class="addNDA">
		<tbody>
			<tr>
				<td class="formlabel">Docket</td>
				<td><input type="text" name="Docket" value="" onchange="document.getElementById('Submit2').disabled=false;" required></td>
			</tr>
			<tr>
				<td class="formlabel">Effective Date</td>
				<td><input type="date" name="EffectiveDate" value="" onchange="document.getElementById('Submit2').disabled=false;" required></td>
			</tr>
			<tr>
				<td class="formlabel">Expiration Date</td>
				<td><input type="date" name="ExpirationDate" value="" onchange="document.getElementById('Submit2').disabled=false;" required></td>
			</tr>
		</tbody>

	</table>
	<br><br>

	<input name="Submit2" class="btn btn-primary" id="Submit2" type="submit" value="Submit" disabled style="width: 111px">
	<input name="Submit3" class="btn btn-primary" id="Submit3" type="submit" value="Update" style="width: 129px">
	<input name="Clear" class="btn btn-warning" type="reset" value="Clear">
	<div id="results"></div>
  <div id="which_button_was_clicked" style="display: none" ></div>

	<!--<span class="style2"><br>
</span>&nbsp;-->
</form>


<script>
$( "#SelectionForm" ).on( "submit", function( event ) {
  event.preventDefault();
	let number_to_give_unique_ids = Math.floor(-Math.random()*10000);
    var form_array = $( this ).serializeArray();
	var form_to_pass_to_addNDA_script = $( this ).serialize();
	docket_name = form_array[0]['value'];
	effective_date = form_array[1]['value'];
	expiration_date = form_array[2]['value'];
	document.getElementById('SelectionForm').classList.add('newClassName');
	are_we_updating_or_creating_a_docket = $(which_button_was_clicked).text();
	let data="";
	let submit_clicked = are_we_updating_or_creating_a_docket === "submit_clicked"


	if(submit_clicked){
		data = form_to_pass_to_addNDA_script + '&Submit2=Submit2';
	}
	else {
		data = form_to_pass_to_addNDA_script + '&Submit3=Submit3';
	}

// console.log(data)
	var t = $('#ndas').DataTable();
	$.ajax({
        type: "POST",
        data : data,
        cache: false,
        url: "AddNDA2.php",
        success: function(data){
						var placeholder_to_know_where_to_put_the_uploadFile_and_deleteDocket_buttons = "placeholder" + Math.random();

            $("#results").html(data);
			let docket_already_exists=data.includes("Warning");
						if(submit_clicked){
							if(!docket_already_exists){
										var new_row=t.row.add( [
														docket_name,
														effective_date,
														expiration_date,
														'update_me_after_file_upload',
														placeholder_to_know_where_to_put_the_uploadFile_and_deleteDocket_buttons //don't judge me, I couldn't find a way to give Ids to columns from rows that are created dynamically, so placeholder strategy it is.
												] )
													.draw()
													.node()

												//adds blue highlight to the newly created row
												t.row(":contains('"+placeholder_to_know_where_to_put_the_uploadFile_and_deleteDocket_buttons+"')").select()

												//<adding upload file and delete docket buttons to correct location
												placeholder_location =	t.cell(":contains('"+placeholder_to_know_where_to_put_the_uploadFile_and_deleteDocket_buttons+"')")
												
												html_to_add_uploadFile_and_deleteDocket_in_placeholder_location = '<div id="button-layer" class="flex-parent jc-center"><button class="btn btn-primary pretty-upload" value="upload" type="button" data-toggle="modal" data-target="#uploadDoc"> Upload File </button><button class="btn btn-danger delete-docket"> Delete Docket </button></div>';
												placeholder_location.data(html_to_add_uploadFile_and_deleteDocket_in_placeholder_location)
												// end of adding upload file and delete docket buttons to correct location/>



												//adding 'dock' class to the docket cell of newly created row. 
												$( new_row ).find('td').eq(0).addClass('dock');

												//Adding id attribute to the docket cell. This makes sure the program knows which docket to upload to, or which docket to delete.
												$( new_row ).find('td').eq(0).attr("id", docket_name);
												$( new_row ).find('td').eq(0).attr("data-counter", number_to_give_unique_ids);


												//giving ID to effective date cell
												$( new_row ).find('td').eq(1).attr("id", 'effective_date'+ number_to_give_unique_ids);

												//giving ID to expiration date cell
												$( new_row ).find('td').eq(2).attr("id", 'expiration_date'+ number_to_give_unique_ids);

												//adding update_me_after_file_upload class to the NDAs cell of the newly added row. The program uses this class after a file is uploaded to know where to put a link to the uploaded file and the delete button for that file
												$( new_row ).find('td').eq(3).addClass('update_me_after_file_upload');
												$( new_row ).find('td').eq(3).attr("id", number_to_give_unique_ids);
												t.cell(":contains('update_me_after_file_upload')").data("") //clear the cell

											}
										}
					else {
						//if you reach this code, then update button was clicked.
						var magic_number = $('#'+ docket_name).attr("data-counter"); //used for knowing which cells to edit - every row in the datatable has a counter somewhere embedded in its name. It goes from 0 to however many rows there are. We can use this number as follows: "from the row with docket name x, delete the html element with id=effectivedate1 (where 1 is the magic number)"
						//the magic number is the same across an entire row (e.g. each cell of that row contains the magic number in their ID). This allows us to uniquely identify each element of a row and change its data, as long as we know the magic number.
						$('#'+ "effective_date" + magic_number).empty();
						$('#'+ "effective_date" + magic_number).append(effective_date);
						$('#'+ "expiration_date" + magic_number).empty();
						$('#'+ "expiration_date" + magic_number).append(expiration_date);
					}
        }
    });

	        });
</script>

<!-- lets you know if Submit button was clicked -->
<script>
$( "#Submit2" ).on( "click", function( event ) {

	// clear div
	$(which_button_was_clicked).empty();
	//write to div
	$(which_button_was_clicked).append("submit_clicked")
	});
</script>

<!-- lets you know if Update button was clicked (submit3 is the id of update button. Idk don't judge me, it had that name when I started working here) -->
<script>
$( "#Submit3" ).on( "click", function( event ) {
	// clear div
	$(which_button_was_clicked).empty();
	//write to div
	$(which_button_was_clicked).append("update_clicked")
	});
</script>
