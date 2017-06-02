<?php 
use App\Http\Controllers\PlanningController;
use Carbon\Carbon;

$workers = PlanningController::getWorkersPlanning();
setLocale(LC_TIME,config('app.locale'));

?>
@extends('layouts.app')

@section('content')

<div class="flex-center position-ref full-height">
   	<div class="content">
   		  <div class="weeks-large">
                    <a href="/workersplanning/{{ $week['start_end']['week'] - 1}}/{{$year}}"><button class="btn btn-secondary" ><</button></a>
                    <div class="week-previous">Semaine précédente</div>
                    <div class="week-current">Semaine du {{ Carbon::parse($week["start_end"]["start"])->formatLocalized('%d') }} au {{ Carbon::parse($week["start_end"]["end"])->formatLocalized('%d %B %Y') }}</div>
                    <div class="week-next">Semaine suivante</div>
                    <a href="/workersplanning/{{ $week['start_end']['week'] + 1}}/{{$year}}"><button class="btn btn-secondary">></button></a>
            </div>

            <div id="workersplanning">
                    <table class="table table-bordered planning" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th rowspan="2" class="middle" align="middle">ID</th>
                                <th rowspan="2" class="middle">Nom</th>
                                <th rowspan="2" class="middle">Prénom</th>
                                <th rowspan="2" class="middle">MSP</th>
                                <th rowspan="2" class="middle">%</th>
                                <th colspan="2" class="middle" id="monday">Lundi {{ Carbon::parse($week["days"]["monday"])->formatLocalized('%d') }}</th>
                                <th colspan="2" class="middle" id="tuesday">Mardi {{ Carbon::parse($week["days"]["tuesday"])->formatLocalized('%d') }}</th>
                                <th colspan="2" class="middle" id="wednesday">Mercredi {{ Carbon::parse($week["days"]["wednesday"])->formatLocalized('%d') }}</th>
                                <th colspan="2" class="middle" id="thursday">Jeudi {{ Carbon::parse($week["days"]["thursday"])->formatLocalized('%d') }}</th>
                                <th colspan="2" class="middle" id="friday">Vendredi {{ Carbon::parse($week["days"]["friday"])->formatLocalized('%d') }}</th>
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
                         @foreach ($workers as $worker)
                         <tr>
                         		<td>{{ $worker->id }}</td>
                         		<td>{{ $worker->lastname }}</td>
                         		<td>{{ $worker->firstname }}</td>
                         		<td>{{ $worker->msp->initials }}</td>
                         		<td>{{ $worker->percentage }}</td>

                         		<?php 
                         	
                         		$planning = PlanningController::getWorkerWorkshops($worker->id,$week["days"]);



                   				foreach($planning as $task) 
                         		{
                         			echo $task;		
                         		}

                         		?>

                         </tr>	
                         @endforeach
                        </tbody>
                    </table>
                  <style>
                        td
                        {
                            border:1px solid grey;
                        }
                        th
                        {
                            border:1px solid grey;
                        }
                    </style>
            
                </div>
                {{ Form::open(array('url' => 'print','method'=>'POST', 'id' => 'PdfForm')) }}
                    {{ Form::hidden('html_content', '' ) }}
                    {{ Form::submit('PDF',['class' => 'btn btn-secondary']) }}
                {{ Form::close() }}
            
                </div>
   	</div>
</div>

<script>
$(document).ready(function(){
	$('#PdfForm').submit(function(){
        $('input[name=html_content]').val($('#workersplanning').html());
    });
})
</script>
@endsection