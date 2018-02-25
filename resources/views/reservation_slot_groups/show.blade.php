@extends('layouts.app')

@section('content')
  <h2>{{$group->title}} Reservations on {{date('F jS, Y', $today)}}</h2>
    <hr/>

    <h3>Change date:</h3>
  <form action="{{route('show-reservation-slot-with-date', [$group])}}" method="post">
    {{ csrf_field() }}
    <input type="text" id="reservation_datepicker" name="date" class="datepicker"> 
    <input type="submit" class="btn" value="Check Date" />
  </form>
	<a href="{{route('check-time-for-reservation', ['reservation_slots' => implode(',', $reservation_slots->pluck('id')->toArray()), 'desired_date' => date('m-d-Y', $today)])}}" class="btn btn-success" style="margin-right: 9px;">Reserve slots for this date</a>


    @foreach($reservation_slots as $reservation_slot)
      <h3>{{$reservation_slot->title}}</h3>
      @foreach($reservation_slot->reservations->where("start_time", "<", date('Y-m-d H:i:s', $tomorrow))->where("end_time", ">", date('Y-m-d H:i:s', $today)) as $reservation)

        <p><b>{{date('g:i A', strtotime($reservation->start_time))}} until {{date('g:i A', strtotime($reservation->end_time))}}</b>
          - <a href="mailto:{{$reservation->user->email}}">{{$reservation->user->name}}</a>
          - {{$reservation->notes}}</p>

      @endforeach
    @endforeach
  @endsection
        
  @section('javascript')
  <script type="text/javascript"> 
    $(document).ready(function() {  
      $('#reservation_datepicker').datepicker({ "format": "yyyy-mm-dd", "weekStart": 0, "startDate": "#{Date.today}" });
    });
  </script>
  @endsection