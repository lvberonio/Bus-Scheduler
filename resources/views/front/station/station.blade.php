@extends('front.template')

@section('main')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">{!! trans('front/station.add') !!}</h1>
		</div>
	</div>
	<div class="row">
		{!! Form::open(['url' => 'station', 'method' => 'post']) !!}
			<div class="col-md-12">
				<div class="col-md-6">
					{!! Form::control('text', 0, 'name', $errors, trans('front/station.name'), null, null, trans('front/station.enterName')) !!}
					{!! Form::control('text', 0, 'location', $errors, trans('front/station.address'), null, null, trans('front/station.enterAddress')) !!}
				</div>
				<div class="col-md-3">
					{!! Form::control('number', 0, 'latitude', $errors, trans('front/station.latitude'), null, null, trans('front/station.enterLatitude'), '0.000001') !!}
					{!! Form::control('number', 0, 'longitude', $errors, trans('front/station.longitude'), null, null, trans('front/station.enterLongitude'), '0.000001') !!}
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="status">Status<span class="required-field">*</span></label>
						<select id="status" name="status" class="form-control required">
							<option value="1">Active</option>
							<option value="2">Inactive</option>
						</select>
					</div>
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
			<h1 class="page-header">List of stations</h1>
		</div>
	</div>
	<table id="stations" class="table-striped table">
		<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Address</th>
			<th>Latitude</th>
			<th>Longitude</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
		</thead>
	</table>
@stop

@section('scripts')
	<script>
		$(document).ready(function() {
			$('#stations').dataTable({
				"ajax": "/station/data",
				"bSort" : false,
				"processing": true,
				"serverSide": true,
				"pageLength": 25
			});
		});
	</script>
@stop
