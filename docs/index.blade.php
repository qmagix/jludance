@extends('layouts.editable')

@section('content')


<div class="container">
	<h1>Add Item</h1>


	@if(Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
        @php
        Session::forget('success');
        @endphp
    </div>
    @endif


	<form action="{{ url('item') }}" method="POST">
		{{ csrf_field() }}
		<div class="form-group">
			<label>Title:</label>
			<input type="text" name="title" class="form-control" placeholder="Title">
			@if ($errors->has('title'))
                <span class="text-danger">{{ $errors->first('title') }}</span>
            @endif
		</div>

    <div class="form-group">
      <label>Url:</label>
      <input type="text" name="url" class="form-control" placeholder="Url">
      @if ($errors->has('url'))
                <span class="text-danger">{{ $errors->first('url') }}</span>
            @endif
    </div>


		<div class="form-group">
			<strong>Notes:</strong>
			<textarea class="form-control" name="notes" placeholder="Notes"></textarea>
			@if ($errors->has('notes'))
                <span class="text-danger">{{ $errors->first('notes') }}</span>
            @endif
		</div>


		<div class="form-group">
			<label>Tags:</label>
			<br/>
			<input data-role="tagsinput" type="text" name="tags" >
			@if ($errors->has('tags'))
                <span class="text-danger">{{ $errors->first('tags') }}</span>
            @endif
		</div>


		<div class="form-group">
			<button class="btn btn-success btn-submit">Submit</button>
		</div>
	</form>



	@if($items->count())
  <h1>Item To Be Scheduled ({{$items->count()}})</h1>
  <table class="table table-bordered">
    <thead>
        <tr>
					<th>Video</th>
          <th>URL/title/KEY</th>
          <th>tags</th>
					 <th>Schedule</th>
        </tr>
    </thead>
    <tbody>
		@foreach($items as $key => $article)
    <tr>
			<td>
				<iframe width=320 height=180 src='{{$article->embedurl}}' frameborder=0 allowfullscreen></iframe>
			</td>
      <td>{{ $article->url }}<br>
				{{ $article->title }}<br>
				{{ $article->key }}<br>
					<a class="btn btn-primary" href="{{ route('items.edit',$article->id) }}">Edit</a>
			</td>
			<td>
				@foreach($article->tags as $tag)
          <a href="{{route('items.bytag',$tag->name)}}">
          <label class="badge badge-info">{{ $tag->name }}</label>
          </a>
				@endforeach
			</td>
			<td>
				<a href="#" class='scheduleeditable' id="createschedule" data-type="date" data-pk="{{$article->id}}" data-url="/schedule/microupdate" data-title="Select date"></a>
				@if($article->schedules)
					@foreach($article->schedules as $s)
						<span class="badge badge-success">{{ $s->publishing_date }}</span> |
					@endforeach
				@else
				@endif
		</td>

    </tr>
		@endforeach
    </tbody>
	@endif
  </table>
</div>
@endsection
