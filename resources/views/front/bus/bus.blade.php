@extends('front.template')

@section('main')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">{!! trans('front/bus.add') !!}</h1>
		</div>
	</div>
	<div class="row">
		{!! Form::open(['url' => 'bus', 'method' => 'post']) !!}
			<div class="col-md-12">
				<div class="col-md-6">
					{!! Form::control('text', 0, 'route_no', $errors, trans('front/bus.routeNo'), null, null, trans('front/bus.enterRouteNo')) !!}
					{!! Form::control('text', 0, 'description', $errors, trans('front/bus.description'), null, null, trans('front/bus.enterDescription')) !!}
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
			<h1 class="page-header">List of buses</h1>
		</div>
	</div>
	<table id="buses" class="table-striped table">
		<thead>
		<tr>
			<th>#</th>
			<th>Route No.</th>
			<th>Description</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
		</thead>
	</table>
@stop

@section('scripts')
	<script>
		$(document).ready(function() {
			$('#buses').dataTable({
				"ajax": "/bus/data",
				"bSort" : false,
				"processing": true,
				"serverSide": true,
				"pageLength": 25
			});
		});
	</script>
@stop
