@extends("layouts.app")

@section("content")
<div class="container">
	<h3>Edit {{$event->name}}</h3>
	<p>Enter the details for your event below.</p>
	
  <form method="post" action="{{ route('update-event', [$event]) }}" class="well">
		{{ csrf_field() }}
		<div class="container">
			<div class="span6">
        <label>Name</label>
        <input type="text" name="name" value="{{$event->name}}"/><br/><br/>
				<label>Description</label>
        <textarea name="description" cols="60" rows="12" >{{$event->description}}</textarea><br/><br/>
        <label>Fee (ex: $25.00)</label>
        <input type="text" name="fee" value="{{$event->fee}}"/><br/><br/>
				
        <label>Email Address for Notifications</label>
        <input type="email" name="notification_email" value="{{$event->notification_email}}"/><br/><br/>
				
				<label>Choose a reservation slot</label>
        <select name="reservation[reservation_slot_id]">
          <option>Select a reservation slot</option>
          @foreach ($reservation_slots as $reservation_slot)
            <option value="{{$reservation_slot->id}}"
                    @if ($event->reservation->reservation_slot->id == $reservation_slot->id)
                      selected      
                    @endif
                    >{{$reservation_slot->title}}</option>
          @endforeach
        </select>
				
				<br/><br/>
        <input type="checkbox" name="public" 
               @if ($event->public)
                 checked
               @endif
               /> Event is Public
			</div>
			<div class="span5">
				<div class="container">
				  
					<div class="input-append">
            Date:<br/>
              <input 
                     value="{{ date("Y-m-d", strtotime($event->reservation->start_time)) }}"
                     type="text" name="date" class="datepicker input-small"/>
              <span class="add-on"><i class="icon-calendar"></i></span>
          </div><br/>
					<div class="input-append">
            Start Time:<br/>
              <input
                     value="{{ date("h:i A", strtotime($event->reservation->start_time)) }}"
                     type="text" name="start_time" class="timepicker input-small"/> 
              <span class="add-on"><i class="icon-time"></i></span>
            </div><br/>
					<div class="input-append">
            End Time:<br/>
              <input value="{{ date("h:i A", strtotime($event->reservation->end_time)) }}"
                     type="text" name="end_time" class="timepicker input-small"/> 
              <span class="add-on"><i class="icon-time"></i></span>
            </div>
				</div><br/>
        <label>Spots Available For This Event</label>
        <input type="text" name="available_spots" value="{{$event->available_spots}}"/>
				<label>Registration Window (number of days before event that users may register)</label>
        <input type="text" name="registration_window" value="{{$event->registration_window}}"/>
				<br/>
        <label>Event Notes & Facility Requirements</label>
			  <textarea name="reservation[notes]" cols="60" rows="12">{{$event->reservation->notes}}</textarea><br/><br/>
			</div>
			<div class="span12">
				<br/><br/>
        <input type="submit" value="Update Event" class="btn btn-success">
			</div>
		</div>	  
  </form>
</div>
@endsection
          
@section("javascript")
<script type="text/javascript">
        $(document).ready(function () { 
            $('.timepicker').timepicker({
            		'timeFormat': 'h:i A',
            		'scrollDefaultNow': true,
                'step': 15,
                'minTime': '1:00am',
                'maxTime': '11:30pm',
            });
            
            $('.datepicker').datepicker({"format": "yyyy-mm-dd", "weekStart": 0, "startDate": "#{Date.today}", "autoclose": true})
        });
</script>
@endsection
