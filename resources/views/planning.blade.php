<?php 
use App\Http\Controllers\LevelController;
use App\Http\Controllers\PlanningController;
use Carbon\Carbon;

setLocale(LC_TIME,config('app.locale'));
?>
@extends('layouts.app')

@section('content')
        <div class="flex-center position-ref full-height">
           <div class="content large">

                <div class="weeks">
                    <a href="/planning/{{ $week['start_end']['week'] - 1}}/{{$year}}"><button class="btn btn-secondary" ><</button></a>
                    <div class="week-previous">Semaine précédente</div>
                    <div class="week-current">Semaine du {{ Carbon::parse($week["start_end"]["start"])->formatLocalized('%d') }} au {{ Carbon::parse($week["start_end"]["end"])->formatLocalized('%d %B %Y') }}</div>
                    <div class="week-next">Semaine suivante</div>
                    <a href="/planning/{{ $week['start_end']['week'] + 1}}/{{$year}}"><button class="btn btn-secondary">></button></a>
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
                            <th class="middle shaped">Matin</th>
                            <th class="middle shaped">Après-midi</th>
                            <th class="middle shaped">Matin</th>
                            <th class="middle shaped">Après-midi</th>
                            <th class="middle shaped">Matin</th>
                            <th class="middle shaped">Après-midi</th>
                            <th class="middle shaped">Matin</th>
                            <th class="middle shaped">Après-midi</th>
                            <th class="middle shaped">Matin</th>
                            <th class="middle shaped">Après-midi</th>
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

                            echo '<tr data-level_1="'.$level_1->id.'">';
                            $color = 'style="background-color:'.$level_1->color->hex.'"';
                            echo '<td '.$color.'rowspan="'.$nbrows.'" >'.$level_1->name.'</td>';
                                
                                foreach ($level_2_list as $level_2) 
                                {
                                    $level_3_list = LevelController::getLevel3WithLevel2($level_2->id);
                                    $color = 'style="background-color:'.$level_2->workshop_level_1->color->hex.'"';
                                    echo '<td '. $color.' rowspan="'.count($level_3_list).'" >'.$level_2->name.'</td>';

                                    foreach ($level_3_list as $level_3) 
                                    {
                                        $color = 'style="background-color:'.$level_3->workshop_level_2->workshop_level_1->color->hex.'"';
                                        echo '<td '.$color.'>'.$level_3->name.'</td>';

                                        $date = Carbon::parse($week["days"]["monday"])->formatLocalized('%Y-%m-%d');
                                       
                                        echo '<td '.$color.' ondblclick="showForm(this)" data-ismorning="1" data-date="'.$date.'" data-workshop_id="'.$level_3->id.'" class="cell"></td>';
                                        echo '<td '.$color.' ondblclick="showForm(this)" data-ismorning="0" data-date="'.$date.'" data-workshop_id="'.$level_3->id.'" class="cell"></td>';

                                        $date = Carbon::parse($week["days"]["tuesday"])->formatLocalized('%Y-%m-%d');
                                        echo '<td '.$color.' ondblclick="showForm(this)" data-ismorning="1" data-date="'.$date.'" data-workshop_id="'.$level_3->id.'" class="cell"></td>';
                                        echo '<td '.$color.' ondblclick="showForm(this)" data-ismorning="0" data-date="'.$date.'" data-workshop_id="'.$level_3->id.'" class="cell"></td>';
                                        $date = Carbon::parse($week["days"]["wednesday"])->formatLocalized('%Y-%m-%d');

                                        echo '<td '.$color.' ondblclick="showForm(this)" data-ismorning="1" data-date="'.$date.'" data-workshop_id="'.$level_3->id.'" class="cell"></td>';
                                        echo '<td '.$color.' ondblclick="showForm(this)" data-ismorning="0" data-date="'.$date.'" data-workshop_id="'.$level_3->id.'" class="cell"></td>';
                                        $date = Carbon::parse($week["days"]["thursday"])->formatLocalized('%Y-%m-%d');

                                        echo '<td '.$color.' ondblclick="showForm(this)" data-ismorning="1" data-date="'.$date.'" data-workshop_id="'.$level_3->id.'" class="cell"></td>';
                                        echo '<td '.$color.' ondblclick="showForm(this)" data-ismorning="0" data-date="'.$date.'" data-workshop_id="'.$level_3->id.'" class="cell"></td>';
                                        $date = Carbon::parse($week["days"]["friday"])->formatLocalized('%Y-%m-%d');

                                        echo '<td '.$color.' ondblclick="showForm(this)" data-ismorning="1" data-date="'.$date.'" data-workshop_id="'.$level_3->id.'" class="cell"></td>';
                                        echo '<td '.$color.' ondblclick="showForm(this)" data-ismorning="0" data-date="'.$date.'" data-workshop_id="'.$level_3->id.'" class="cell"></td>';
                                        echo '<td '.$color.'><button class="action-button" data-level_1="'.$level_1->id.'" onclick="addRow(this)" >+</button><button class="action-button" onclick="remRow('.$level_3->id.')">X</button></td>';
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

var workers_array = [];

 $(document).ready(function() {
    getMenu();

    $.ajax({
            url: '/getworkers',
            type: 'GET',
            success: function (data) {
                workers_array = JSON.parse(data);
            }
        });
    initializeTable();
    
    var $span = $('<span class="delete-workshop-button" onclick="removeWorkerInWorkhsop(this)" />').html('X'); 

    $('.cell').hover(function(){
        $cell = $(this);
        if($cell.html())
        {
            if(!$('.autocomplete-box').length)
            {
                $cell.append($span);
            }
        }
        else
        {
            $span.remove();
        }
    });

    $(document).click(function(event) {
        if(!$(event.target).hasClass('autocomplete'))
        {
            if($('.autocomplete'))
            {
                $('.autocomplete-box').remove();
            }
        }
    });
});
function initializeTable()
{
    $.ajax({
            url: '/getplanningcells',
            type: 'GET',
            success: function (data) 
            {
                data = JSON.parse(data);
                for (var i = data.length - 1; i >= 0; i--) 
                {
                    $('*[data-date="'+ data[i].date +'"][data-ismorning="'+ data[i].isMorning +'"][data-workshop_id="'+ data[i].workshop_level_3 +'"]').text(data[i].text);
                }
            }
      });  

}

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

    if(!cell.html())
    {
        
        cell.html("<div class='autocomplete-box'><input class='autocomplete'><input id='_token' hidden value='<?php echo csrf_token() ?>'></div>");    

        $('.autocomplete').autocomplete({
            source: workers_array,
            select: function (event, ui) {
                var resetCell = function() {
                                console.log("aook");
                            //refresh table
                            cell.text(ui.item.value);
                        }

                insertWorkerInWorkshop(ui.item.id,cell.data("ismorning"),cell.data("date"),cell.data("workshop_id"),$('#_token').val(),resetCell);
            }
        });
    }
}
function insertWorkerInWorkshop(worker_id,ismorning,date,workshop_id,_token,resetCell)
{
    // Variable to hold request
    var request;

    // Fire off the request to /form.php
      request = $.ajax({
        url: '/addworkeratworkshop',
        type: 'POST',
        data: {
                worker_id: worker_id,
                ismorning: ismorning,
                date: date,
                workshop_id: workshop_id,
                _token: _token
              }
    });

    // Callback handler that will be called on success
    request.done(function(){

            initializeTable();
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Show error in a message box
        bootbox.alert({
            message: jqXHR.responseText
        });
    });
}
function removeWorkerInWorkhsop(span)
{
    console.log($(span).parent());
    
    $cell = $(span).parent();
    var username = $(span).parent().text();
    var workshop_level_3 = $cell.attr("data-workshop_id");
    username = $cell.text().substring(0, $cell.text().length - 1);
    $cell.html("<input id='_token_rem' hidden value='<?php echo csrf_token() ?>'></div>"); 
    var token = $('#_token_rem').val();

     // Variable to hold request
    var request;

    // Fire off the request to /form.php
      request = $.ajax({
        url: '/remworkeratworkshop',
        type: 'POST',
        data: {
                worker_username: username,
                workshop_level_3: workshop_level_3,
                _token: token
              }
    });

    // Callback handler that will be called on success
    request.done(function(){
            //remove token
            $('#_token_rem').remove();
            initializeTable();
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Show error in a message box
        bootbox.alert({
            message: jqXHR.responseText
        });
    });

}
function addRow(cell) 
{
    //get row from cell
    $tr = $(cell).parent().parent();
    
    var level_1_id = $(cell).data('level_1');
    console.log(level_1_id);
    //remove the 2 first cells
    //creates new row 
    var newRow = $tr.clone(true);
    //get lenght of rowspans
    var lenght  = $tr.find(">:first-child").attr('rowspan');
    var lenght2 = $tr.find(">:nth-child(2)").attr('rowspan');
    //if the row doesn't have information about row
    if(lenght && lenght2)
    {
        console.log("oui");
        ++lenght;
        ++lenght2;
        $(newRow).find(">:lt(2)").remove();
        $tr.find(">:first-child").attr('rowspan',lenght);
        console.log($tr.find(">:first-child"));
        $tr.find(">:nth-child(2)").attr('rowspan',lenght2);
    }
    else if (lenght) 
    {

        lenght2 = $('*[data-level_1="'+level_1_id+'"').find(">:first-child").attr('rowspan');
        console.log("ah");
        ++lenght;
        ++lenght2;
        $('*[data-level_1="'+level_1_id+'"').find(">:first-child").attr('rowspan', lenght2);
        $tr.find(">:first-child").attr('rowspan',lenght);
        $(newRow).find(">:lt(1)").remove();

    }
    else
    {
        console.log("non");
        //takes the above one
        $_tr = $(cell).parent().parent().prev();
        var lenght  = $_tr.find(">:first-child").attr('rowspan');
        var lenght2 = $_tr.find(">:nth-child(2)").attr('rowspan');
        ++lenght;
        ++lenght2;
        $_tr.find(">:first-child").attr('rowspan',lenght);
        $_tr.find(">:nth-child(2)").attr('rowspan',lenght2);
        console.log($_tr);

    }
    console.log(lenght);
    console.log(lenght2);
    console.log($(newRow));

    

    $(newRow).insertAfter($tr.closest('tr'));

}
function remRow(row_id)
{
    // body...
}
</script>    
@endsection