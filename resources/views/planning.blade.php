<?php 
use App\Http\Controllers\LevelController;

$level_1_list = LevelController::getLevel1();
$level_2_list = LevelController::getLevel2();
$level_3_list = LevelController::getLevel3();

?>
@extends('layouts.app')

@section('content')
        <div class="flex-center position-ref full-height">
           <div class="content large">

                <div class="weeks">
                    <button class="week-button"><</button>
                    <div class="week-previous">Semaine précédente</div>
                    <div class="week-current">Semaine du x au y</div>
                    <div class="week-next">Semaine suivante</div>
                    <button class="week-button">></button>
                </div>
                <div class="menu-contener">
                    <button  class="btn btn-secondary" id="open-menu">Gestion menus</button>
                </div>
                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="menu">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Menu</h4>
                          </div>
                          <div class="modal-body">
                              
                           </div>
                           <div class="clearfix"></div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                          </div>
                        </div><!-- /.modal-content -->
                      </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    
                <table class="table table-bordered planning" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th rowspan="2" class="middle" align="middle">Niv 1</th>
                            <th rowspan="2" class="middle">Niv 2</th>
                            <th rowspan="2" class="middle">Niv 3</th>
                            <th colspan="2" class="middle">Lundi</th>
                            <th colspan="2" class="middle">Mardi</th>
                            <th colspan="2" class="middle">Mercredi</th>
                            <th colspan="2" class="middle">Jeudi</th>
                            <th colspan="2" class="middle">Vendredi</th>
                            <th>Action</th>
                        </tr>
                        <tr>                         
                            <th class="middle">Matin</th>
                            <th class="middle">Après-midi</th>
                            <th class="middle">Matin</th>
                            <th class="middle">Après-midi</th>
                            <th class="middle">Matin</th>
                            <th class="middle">Après-midi</th>
                            <th class="middle">Matin</th>
                            <th class="middle">Après-midi</th>
                            <th class="middle">Matin</th>
                            <th class="middle">Après-midi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Niv 1</td>
                            <td>Niv 2</td>
                            <td>Niv 3</td>
                            <td>Lundi</td>
                            <td>null</td>
                            <td>Mardi</td>
                            <td>null</td>
                            <td>Mercredi</td>
                            <td>null</td>
                            <td>Jeudi</td>
                            <td>null</td>
                            <td>Vendredi</td>
                            <td>null</td>
                            <td>Action</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
<script>
 $(document ).ready(function() {
    getMenu();
});
$('#open-menu').click(function(){
    $('#menu').modal();  

});

function getMenu()
{
    $.ajax({
            url: '/getmenu',
            type: 'GET',
            success: function (data) {
                $( ".modal-body" ).append(data);
            }
        });
}
function addLevel1()
{
    // Variable to hold request
    var request;

      // Let's select and cache all the fields
    var $confirm_button = $('#confirm_level_1');

    // Let's disable the inputs for the duration of the Ajax request.
    $confirm_button.prop("disabled", true);

    // Fire off the request to /form.php
      request = $.ajax({
        url: '/addlevel1',
        type: 'POST',
        data: {
                name: $('#level_1_name').val(),
                color: $('#color').val(),
                _token: $('#_token_level_1').text()
              }
    });

    // Callback handler that will be called on success
    request.done(function (){
        $('.modal-body').empty(getMenu());
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

function addLevel2(button)
{
    var id = button.id.substr(button.id.length - 1);
    // Variable to hold request
    var request;

    // Let's select and cache all the fields
    var $confirm_button = $('#confirm_level_2');

    // Let's disable the inputs for the duration of the Ajax request.
    $confirm_button.prop("disabled", true);

    // Fire off the request to /form.php
      request = $.ajax({
        url: '/addlevel2',
        type: 'POST',
        data: {
                name: $('#level_2_name_'+id).val(),
                workshop_level_1: $('#level_1_id_'+id).val(),
                _token: $('#_token_level_2_'+id).text()
              }
    });

    // Callback handler that will be called on success
    request.done(function (){
        $('.modal-body').empty(getMenu());
        
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
function addLevel3(button)
{
    var id = button.id.substr(button.id.length - 1);
    // Variable to hold request
    var request;

    // Let's select and cache all the fields
    var $confirm_button = $('#confirm_level_3');

    // Let's disable the inputs for the duration of the Ajax request.
    $confirm_button.prop("disabled", true);

    // Fire off the request to /form.php
      request = $.ajax({
        url: '/addlevel3',
        type: 'POST',
        data: {
                name: $('#level_3_name_'+id).val(),
                workshop_level_2: $('#level_2_id_'+id).val(),
                _token: $('#_token_level_3_'+id).text()
              }
    });

    // Callback handler that will be called on success
    request.done(function (){
        $('.modal-body').empty(getMenu());
        
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

function remLevel(level,workshop_id,button)
{
    bootbox.confirm("Êtes-vous sûr de vouloir supprimer cet atelier?", function(result){
    if(result)
    {
        // Variable to hold request
        var request;

        // Let's select and cache all the fields
        var $confirm_button = $(button);

        // Let's disable the inputs for the duration of the Ajax request.
        $confirm_button.prop("disabled", true);

        // Fire off the request to /form.php
          request = $.ajax({
            url: '/remlevel'+level,
            type: 'POST',
            data: {
                    workshop_id: workshop_id,
                    _token: $(button).val()
                  }
        });

        // Callback handler that will be called on success
        request.done(function (){
            $('.modal-body').empty(getMenu());
            
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
    });
}
</script>    
@endsection