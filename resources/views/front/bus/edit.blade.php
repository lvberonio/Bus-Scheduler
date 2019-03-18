@extends('front.template')

@section('main')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">{!! trans('front/bus.edit') !!}</h1>
		</div>
	</div>
	<div class="row">
		{!! Form::model($bus, ['route' => ['bus.update', $bus->id], 'method' => 'put']) !!}
		<div class="col-md-12">
			<div class="col-md-6">
				{!! Form::control('text', 0, 'route_no', $errors, trans('front/bus.routeNo'), null, null, trans('front/bus.enterRouteNo')) !!}
				{!! Form::control('text', 0, 'description', $errors, trans('front/bus.description'), null, null, trans('front/bus.enterDescription')) !!}
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="status">Status<span class="required-field">*</span></label>
					<select id="status" name="status" class="form-control required">
						<option value="1" @if($bus->status == 1) selected @endif>Active</option>
						<option value="2" @if($bus->status == 2) selected @endif>Inactive</option>
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

@stop