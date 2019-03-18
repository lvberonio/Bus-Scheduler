@extends('front.template')

@section('main')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">{!! trans('front/station.list') !!}</h1>
		</div>
	</div>
	@foreach ($stations as $key => $station)
		<div class="col-lg-12">
			<div class="panel-group row" id="accordion{!! $key !!}">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion{!! $key !!}" href="#collapse{!! $key !!}">
								{!! $station->name !!}
							</a>
							<small>{!! $station->location !!}</small>
							<span class="pull-right"><span class="glyphicon glyphicon-road"></span>&nbsp;{!! number_format($station->distance, 2) !!}  kms</span>
						</h4>
					</div>
					<div id="collapse{!! $key !!}" class="panel-collapse collapse">
						<div class="panel-body">
							<div class="col-lg-12">
								<div>
									<table class="table-striped table table-bordered">
										<thead>
										<tr class="active">
											<th>Bus Route/No.</th>
											<th>Description</th>
											<th>Arrival Time</th>
											<th>Departure Time</th>
										</tr>
										</thead>
										<tbody>
										@php
											$schedules = $station->getNextAvailableSchedules();
										@endphp
										@foreach ($schedules as $schedule)
											<tr class="small">
												<td>{!! $schedule['route_no'] !!}</td>
												<td>{!! $schedule['description'] !!}</td>
												<td>{!! $schedule['arrival_time'] !!}</td>
												<td>{!! $schedule['departure_time'] !!}</td>
											</tr>
										@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endforeach
@stop
