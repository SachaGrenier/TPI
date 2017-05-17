<?php 
use App\Http\Controllers\MSPController;

$MSPs = MSPController::getAllMSPs();

?>
@extends('layouts.app')

@section('content')

<div class="flex-center position-ref full-height">
   	<div class="content">
       	<?php
			//bar to show information if needed
			if (Session::get('status'))
			{
				echo '<div class="alert '.Session::get('class').'">';
				echo Session::get('status');
				echo '</div>';
			}
		?>  
		<h2>Travailleurs</h2>
   		<div class="worker-table">
           	<table id="my-table" class="stripe" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>ID</th>
						<th>Prénom</th>
						<th>Nom</th>
						<th>Nom d'utilisateur</th>
						<th>%</th>
						<th>MSP</th>
						<th>Crée le</th>
						<th>Supprimer</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<br>
		<h2>Maître Sociaux Professionnels</h2>
		<div class="msp-table">
			{{ Form::open(array('url' => 'addmsp','method'=>'POST','class' => 'form-inline')) }}
				{{ Form::Text('msp_firstname','',['class' => 'form-control','id' => 'msp_firstname','placeholder' => ' Prénom']) }}
				{{ Form::Text('msp_lastname','',['class' => 'form-control','id' => 'msp_lastname','placeholder' => ' Nom']) }}
				{{ Form::Text('msp_initials','',['class' => 'form-control','id' => 'msp_initials','placeholder' => ' Initiales']) }}
				{{ Form::submit('Créer',['class' => 'btn btn-secondary']) }}
			{{ Form::close() }}
			<br>
			<table class="table table-bordered">
			  	<thead >
					<tr>
						<th>ID</th>
						<th>Prénom</th>
						<th>Nom</th>
						<th>Initiales</th>
						<th>Supprimer</th>
					</tr>
				</thead>
				<tbody>
				  @foreach ($MSPs as $MSP)
				  <tr>
				  	<td>{{ $MSP->id }}</td>
				  	<td>{{ $MSP->firstname }}</td>
				  	<td>{{ $MSP->lastname }}</td>
				  	<td>{{ $MSP->initials }}</td>
				  	<td>
				  		{{ Form::open(array('url' => 'deletemsp','method'=>'POST','class' => 'form-inline', 'onsubmit' => 'deleteMsp(this)')) }}
				  			{{ Form::hidden('msp_id',$MSP->id) }}
				  			{{ Form::submit('X',['class' => 'btn btn-danger middle-button']) }}
				  		{{ Form::close() }}
				  	</td>
				  </tr>
				  @endforeach
				</tbody>
			</table>
		</div>
    </div>
</div>
<script>
$(document ).ready(function() {
	initializeTable();

	$('#msp_firstname').change(function(){
		$('#msp_initials').val($('#msp_firstname').val().substr(0, 1)+""+ $('#msp_lastname').val().substr(0, 1));
	});
	$('#msp_lastname').change(function(){
		$('#msp_initials').val($('#msp_firstname').val().substr(0, 1)+""+ $('#msp_lastname').val().substr(0, 1));
	});
	
});
      function initializeTable()
      {

        $.ajax({
            url: '/getworkersarray',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                generateTable(data);
            }
        });
        function generateTable(data) 
        {
            var table = $('#my-table').DataTable({
            "dom": 'C<"clear">lfrtip',
            "bAutoWidth": true,
            "aaData": data,
            "oLanguage": 
            {
              "sInfo": "_TOTAL_ résultats (Affiche de _START_ à _END_)",
              "sInfoEmpty": "Aucun résultat",
              "sInfoFiltered": " - filtré de _MAX_ entrées",
              "sLengthMenu": "Afficher _MENU_ résultats",
              "sEmptyTable": "La table est vide",
              "sSearchPlaceholder" : "Rechercher",
              "sSearch": "_INPUT_ ",
               "oPaginate": 
                {
                  "sNext": "Page suivante",
                  "sPrevious": "Page précédente"
                }
            },
            "initComplete": function() {
				$('#confirm').click(function(){
					addworker();
				});
				$('#firstname').change(function() {
					$('#username').val($('#firstname').val() + '_'+ $('#lastname').val());
				});	

				$('#lastname').change(function() {
					$('#username').val($('#firstname').val() + '_'+ $('#lastname').val());
				});	

            },
            "aaSorting": [],
            "aoColumnDefs": [
               {
                   "aTargets": [0],
                   "mData": "id",
               },
               {
                   "aTargets": [1], 
                   "mData": "firstname"
               },
                {
                   "aTargets": [2], 
                   "mData": "lastname"
               },
               {
                   "aTargets": [3], 
                   "mData": "username"
               },
                 {
                   "aTargets": [4], 
                   "mData": "percentage"
               },
                 {
                   "aTargets": [5], 
                   "mData": "MSP_initials"
               },
                 {
                   "aTargets": [6], 
                   "mData": "created_at"
               },
               {
                   "aTargets": [7], 
                   "mData": "delete_link"
               }
                ]});
          }
       }

       function addworker()
       {  

   		    // Variable to hold request
			var request;

			  // Let's select and cache all the fields
		    var $confirm_button = $('#confirm');

		    // Let's disable the inputs for the duration of the Ajax request.
		    // Note: we disable elements AFTER the form data has been serialized.
		    // Disabled form elements will not be serialized.
		    $confirm_button.prop("disabled", true);

		    // Fire off the request to /form.php
			  request = $.ajax({
	            url: '/addworker',
	            type: 'POST',
	            data: {
	            		firstname: $('#firstname').val(),
	            	   	lastname: $('#lastname').val(),
	            	   	username: $('#username').val(),
	            	   	percentage: $('#percentage').val(),
	            	   	msp:$('#msp').val(),
	            	   	_token: $('#_token').text()
	            	  }
	        });

		    // Callback handler that will be called on success
		    request.done(function (){
		        $('#my-table').dataTable().fnDestroy();
		        initializeTable();
		    });

		    // Callback handler that will be called on failure
		    request.fail(function (jqXHR, textStatus, errorThrown){
		        // Show error in a message box
		        bootbox.alert({
				    message: jqXHR.responseText
				});
		    });

		    // Callback handler that will be called regardless
		    // if the request failed or succeeded
		    request.always(function () {
		        // Reenable the inputs
		        $confirm_button.prop("disabled", false);
		    });	
       }

      function deleteRow(worker_id,button)
      {
      	bootbox.confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur?", function(result){
   			 if(result)
   			 {
	       		// Variable to hold request
				var request;

			    // Disable the button while the ajax operation
			    $(button).prop("disabled", true);

			    // Fire off the request to /deleteworker
				  request = $.ajax({
		            url: '/deleteworker',
		            type: 'POST',
		            data: {worker_id: worker_id, _token: button.value}
		        });

			    // Callback handler that will be called on success
			    request.done(function (){
			        $('#my-table').dataTable().fnDestroy();
			        initializeTable();
			    });

			    // Callback handler that will be called on failure
			    request.fail(function (jqXHR, textStatus, errorThrown){
			        // Log the error to the console
			        console.error(
			            "The following error occurred: "+
			            textStatus, errorThrown
			        );
			    });

			    // Callback handler that will be called regardless
			    // if the request failed or succeeded
			    request.always(function () {
			        // Reenable the inputs
			         $(button).prop("disabled", false);
			    });	
       			 } 
       		});
      }
      function deleteMsp(form)
      {
			event.preventDefault();
	        bootbox.confirm("Êtes-vous sûr de vouloir supprimer ce Maître Sociaux Professionnels ?", function(result) {
	            if (result) {
	                form.submit();
	            }
	        });
      }



</script>	
@endsection