@extends('front.template')

@section('main')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">{!! trans('front/schedule.edit') !!}</h1>
		</div>
	</div>
	<div class="row">
		{!! Form::model($schedule, ['route' => ['schedule.update', $schedule->id], 'method' => 'put']) !!}
		<div class="col-md-12">
			<div class="col-md-4">
				<div class="form-group">
					<label for="day">Day</label>
					<select id="day" name="day" class="form-control required">
						<option value="0" @if($schedule->day == 0) selected @endif>Sunday</option>
						<option value="1" @if($schedule->day == 1) selected @endif>Monday</option>
						<option value="2" @if($schedule->day == 2) selected @endif>Tuesday</option>
						<option value="3" @if($schedule->day == 3) selected @endif>Wednesday</option>
						<option value="4" @if($schedule->day == 4) selected @endif>Thursday</option>
						<option value="5" @if($schedule->day == 5) selected @endif>Friday</option>
						<option value="6" @if($schedule->day == 6) selected @endif>Saturday</option>
					</select>
				</div>
				<div class="form-group">
					<label for="status">Status</label>
					<select id="status" name="status" class="form-control required">
						<option value="1" @if($schedule->status == 1) selected @endif>Active</option>
						<option value="2" @if($schedule->status == 2) selected @endif>Inactive</option>
					</select>
				</div>
			</div>
			<div class="col-md-4">
				{!! Form::control('time', 0, 'arrival_time', $errors, trans('front/schedule.arrivalTime'), null, null, trans('front/schedule.enterArrivalTime')) !!}
				{!! Form::control('time', 0, 'departure_time', $errors, trans('front/schedule.departureTime'), null, null, trans('front/schedule.enterDepartureTime')) !!}
			</div>
			<div class="col-md-4">
				{!! Form::selection('station', $stations, $schedule->station_id, trans('front/station.add')) !!}
				{!! Form::selection('bus', $bus, $schedule->bus_id, trans('front/bus.add')) !!}
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

@stop