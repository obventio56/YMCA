@extends("layouts.app")

@section("content")
<h2>Book {{$reservation_slot->title}} on {{date('l, n/j/Y', $date)}} for {{date('g:ia', $date)}}</h2>
<p>Fill out the details below to complete your reservation.</p>
<hr/>
<form method="post" class="well" action="{{route('create-reservation')}}">
		{{ csrf_field() }}
    <input type="hidden" value="{{$reservation_slot->id}}" name="reservation_slot_id" />
    <input type="hidden" value="{{ date('Y-m-d H:i:s', $date) }}" name="start_time" />
	
		<div class="container">
			<div class="span6">
				
        <label>Length Of Reservation</label>
        <label>(maximum lengths of available reservation is shown)</label>
        <select name="length">
          <option>Select a length</option>
          @foreach ($available_durations as $duration)
              <option value="{{ $duration[0] }}">
                {{ $duration[1] }}
							</option>                                                    
          @endforeach
        </select><br><br>

        <label>Your name and any other comments/requirements</label>
        <textarea cols="60" rows="12" name="notes"></textarea><br><br>
				
        <input type="submit" value="Create Reservation" class="btn btn-success">
			</div>
		</div>	  
@endsection