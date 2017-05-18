<?php 
use App\Http\Controllers\LevelController;
use App\Http\Controllers\PlanningController;
use Carbon\Carbon;
 setLocale(LC_TIME,config('app.locale'));
$week = PlanningController::getWeek(Carbon::now());
?>
@extends('layouts.app')

@section('content')
        <div class="flex-center position-ref full-height">
           <div class="content large">

                <div class="weeks">
                    <button class="week-button"><</button>
                    <div class="week-previous">Semaine précédente</div>
                    <div class="week-current">Semaine du {{ Carbon::parse($week["start_end"]["start"])->formatLocalized('%d') }} au {{ Carbon::parse($week["start_end"]["end"])->formatLocalized('%d %B %Y') }}</div>
                    <div class="week-next">Semaine suivante</div>
                    <button class="week-button">></button>
                </div>
                <div class="menu-contener">
                    <button  class="btn btn-secondary" id="open-menu">Gestion niveaux</button>
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
                            <th colspan="2" class="middle" id="monday">Lundi {{ Carbon::parse($week["days"]["monday"])->formatLocalized('%d') }}</th>
                            <th colspan="2" class="middle" id="tuesday">Mardi {{ Carbon::parse($week["days"]["tuesday"])->formatLocalized('%d') }}</th>
                            <th colspan="2" class="middle" id="wednesday">Mercredi {{ Carbon::parse($week["days"]["wednesday"])->formatLocalized('%d') }}</th>
                            <th colspan="2" class="middle" id="thursday">Jeudi {{ Carbon::parse($week["days"]["thursday"])->formatLocalized('%d') }}</th>
                            <th colspan="2" class="middle" id="friday">Vendredi {{ Carbon::parse($week["days"]["friday"])->formatLocalized('%d') }}</th>
                            <th rowspan="2" class="middle" >Action</th>
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $level_1_list = LevelController::getLevel1();

                         foreach ($level_1_list as $level_1) 
                         {
                            
                            $level_2_list = LevelController::getLevel2WithLevel1($level_1->id);

                            $nbrows = 0;
                            foreach ($level_2_list as $level_2) 
                            {
                                $level_3_list = LevelController::getLevel3WithLevel2($level_2->id);
                                $nbrows += count($level_3_list);
                            }

                            echo '<tr>';
                                $color = 'style="background-color:'.$level_1->color->hex.'"';
                                echo '<td '.$color.'rowspan="'.$nbrows.'">'.$level_1->name.'</td>';
                                foreach ($level_2_list as $level_2) 
                                {
                                    $level_3_list = LevelController::getLevel3WithLevel2($level_2->id);
                                    $color = 'style="background-color:'.$level_2->workshop_level_1->color->hex.'"';
                                    echo '<td '. $color.' rowspan="'.count($level_3_list).'">'.$level_2->name.'</td>';

                                    foreach ($level_3_list as $level_3) 
                                    {
                                        $color = 'style="background-color:'.$level_3->workshop_level_2->workshop_level_1->color->hex.'"';
                                        echo '<td '.$color.'>'.$level_3->name.'</td>';

                                        echo '<td '.$color.' ondblclick="showForm(this)" value="1"></td>';
                                        echo '<td '.$color.' ondblclick="showForm(this)" value="0"></td>';
                                        echo '<td '.$color.' ondblclick="showForm(this)" value="1"></td>';
                                        echo '<td '.$color.' ondblclick="showForm(this)" value="0"></td>';
                                        echo '<td '.$color.' ondblclick="showForm(this)" value="1"></td>';
                                        echo '<td '.$color.' ondblclick="showForm(this)" value="0"></td>';
                                        echo '<td '.$color.' ondblclick="showForm(this)" value="1"></td>';
                                        echo '<td '.$color.' ondblclick="showForm(this)" value="0"></td>';
                                        echo '<td '.$color.' ondblclick="showForm(this)" value="1"></td>';
                                        echo '<td '.$color.' ondblclick="showForm(this)" value="0"></td>';
                                        echo '<td '.$color.'></td>';
                                        echo '</tr>';
                                    }
                                }
                            
                         }


                        ?>
                    </tbody>
                </table>
            </div>
        </div>
<script>
 $(document).ready(function() {
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
function showForm(clicked_cell)
{
    var cell = $(clicked_cell);
    
    cell.html("<input id='autocomplete'>");    

            $('#autocomplete').autocomplete({
                source: "/getworkers" 
            });


  
    

    
}

</script>    
@endsection