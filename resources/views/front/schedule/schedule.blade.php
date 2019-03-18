@extends('front.template')

@section('main')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">{!! trans('front/schedule.add') !!}</h1>
		</div>
	</div>
	<div class="row">
		{!! Form::open(['url' => 'schedule', 'method' => 'post']) !!}
			<div class="col-md-12">
				<div class="col-md-4">
					<div class="form-group">
						<label for="day">Day<span class="required-field">*</span></label>
						<select id="day" name="day" class="form-control required">
							<option value="0">Sunday</option>
							<option value="1">Monday</option>
							<option value="2">Tuesday</option>
							<option value="3">Wednesday</option>
							<option value="4">Thursday</option>
							<option value="5">Friday</option>
							<option value="6">Saturday</option>
						</select>
					</div>
					<div class="form-group">
						<label for="status">Status</label>
						<select id="status" name="status" class="form-control required">
							<option value="1">Active</option>
							<option value="2">Inactive</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					{!! Form::control('time', 0, 'arrival_time', $errors, trans('front/schedule.arrivalTime'), null, null, trans('front/schedule.enterArrivalTime')) !!}
					{!! Form::control('time', 0, 'departure_time', $errors, trans('front/schedule.departureTime'), null, null, trans('front/schedule.enterDepartureTime')) !!}
				</div>
				<div class="col-md-4">
					{!! Form::selection('station', $stations, null, trans('front/station.add')) !!}
					{!! Form::selection('bus', $bus, null, trans('front/bus.add')) !!}
				</div>
			</div>
			<div class="col-md-12">
				<div class="col-md-6">
					<div class="form-group">
						<input type="submit" class="btn btn-default" />
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">List of schedules</h1>
		</div>
	</div>
	<table id="schedules" class="table-striped table">
		<thead>
		<tr>
			<th>#</th>
			<th>Bus</th>
			<th>Station</th>
			<th>Day</th>
			<th>Arrival Time</th>
			<th>Departure Time</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
		</thead>
	</table>
@stop

@section('scripts')
	<script>
		$(document).ready(function() {
			$('#schedules').dataTable({
				"ajax": "/schedule/data",
				"bSort" : false,
				"processing": true,
				"serverSide": true,
				"pageLength": 25
			});
		});
	</script>
@stop
