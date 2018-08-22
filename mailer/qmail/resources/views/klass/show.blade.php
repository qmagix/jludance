@extends('layouts.app')

@section('content')
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2>Class {{$klass->title}}</h2>
	        </div>
	    </div>
	</div>
	@if ($message = Session::get('success'))
		<div class="alert alert-success">
			<p>{{ $message }}</p>
		</div>
	@endif
	<table class="table table-bordered">
		<tr>
			<th>No</th>
			<th>Name</th>
			<th>Email</th>
			<th>birthday</th>

			<th width="280px">Action</th>
		</tr>
	@foreach ($data as $key => $user)
	<tr>
		<td>{{ ++$i }}</td>
		<td>{{ $user->name }}</td>
		<td>{{ $user->email }}</td>
		<td>{{ $user->birthday }}</td>
		<td>
{{$user->id}}
		</td>
	</tr>
	@endforeach
	</table>


<form method="POST" action="{{route('emailklass')}}">
	{{ csrf_field() }}
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
							<strong>Subject:</strong>
							{!! Form::text('subject', null, array('placeholder' => 'Subject','class' => 'form-control')) !!}
					</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
							<strong>Message:</strong>
							{!! Form::textarea('message', null, array('placeholder' => 'message','class' => 'form-control')) !!}
					</div>
			</div>
			<input type="hidden" name="classid" value="{{$klass->id}}">
			<div class="col-xs-12 col-sm-12 col-md-12 text-center">
			<button type="submit" class="btn btn-primary">Send</button>
			</div>
</div>
</form>

@endsection
