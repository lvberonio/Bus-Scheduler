@extends('front.template')

@section('main')
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				@if(session()->has('error'))
					@include('partials/error', ['type' => 'danger', 'message' => session('error')])
				@endif
				<div class="login-panel panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Please Sign In</h3>
					</div>
					<div class="panel-body">
						{!! Form::open(['url' => 'auth/login', 'method' => 'post', 'role' => 'form']) !!}
							<fieldset>
								{!! Form::control('email', '', 'email', $errors, 'Email', null, null, trans('front/login.email')) !!}
								{!! Form::control('password', '', 'password', $errors, 'Password', null, null, trans('front/login.password')) !!}
								{!! Form::button(trans('front/login.title'), ['class'=>'btn btn-primary btn-lg btn-block', 'type'=>'submit']) !!}
							</fieldset>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@stop