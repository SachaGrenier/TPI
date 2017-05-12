@extends('layouts.app')

@section('content')

<form></form>

        <div class="flex-center position-ref full-height">
           	<div class="content">
           		<div class="worker-table">
		           	<table id="my-table" class="stripe" cellspacing="0" width="100%">
						<thead >
							<tr>
								<th>ID</th>
								<th>Prénom</th>
								<th>Nom</th>
								<th>Nom d'utilisateur</th>
								<th>%</th>
								<th>MSP</th>
								<th>Crée le</th>
								<th>Modifié le</th>
								<th>Supprimer</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>

                
            </div>
        </div>

<script>
$(document ).ready(function() {
	initializeTable();
});
      function initializeTable()
      {

        $.ajax({
            url: '/getworkersarray/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
            	console.log(data);
                setTable(data);
            }
        });
        function setTable(data) 
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
                   "mData": "updated_at"
               },
               {
                   "aTargets": [8], 
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
</script>	
@endsection