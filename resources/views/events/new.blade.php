@extends("layouts.app")

@section("content")
<div class="container">
	<h3>Create A New Event</h3>
	<p>Enter the details for your event below.</p>
	
  <form method="post" action="{{ route('create-event') }}" class="well">
		{{ csrf_field() }}
		<div class="container">
			<div class="span6">
        <label>Name</label>
        <input type="text" name="name"/><br/><br/>
				<label>Description</label>
        <textarea name="description" cols="60" rows="12"></textarea><br/><br/>
        <label>Fee (ex: $25.00)</label>
        <input type="text" name="fee"/><br/><br/>
				
        <label>Email Address for Notifications</label>
        <input type="email" name="notification_email"/><br/><br/>
				
				<label>Choose a reservation slot</label>
        <select name="reservation[reservation_slot_id]">
          <option>Select a reservation slot</option>
          @foreach ($reservation_slots as $reservation_slot)
            <option value="{{$reservation_slot->id}}">{{$reservation_slot->title}}</option>
          @endforeach
        </select>
				
				<br/><br/>
        <input type="checkbox" name="public"/> Event is Public
			</div>
			<div class="span5">
				<div class="container">
				  
					<div class="input-append">
            Date:<br/>
              <input type="text" name="date" class="datepicker input-small"/>
              <span class="add-on"><i class="icon-calendar"></i></span>
          </div><br/>
					<input type="checkbox" name="is_recurring"/> Recurring 
					<input class="thin_input" type="text" name="recurring[times]"/> times 
					<select name="recurring[frequency]"/>
						<option value="day">daily</option>
						<option value="week">a week</option>
						<option value="biweek">every other week</option>
						<option value="month">a month</option>
					</select>
						<br/><br/>
					<div class="input-append">
            Start Time:<br/>
              <input type="text" name="start_time" class="timepicker input-small"/> 
              <span class="add-on"><i class="icon-time"></i></span>
            </div><br/>
					<div class="input-append">
            End Time:<br/>
              <input type="text" name="end_time" class="timepicker input-small"/> 
              <span class="add-on"><i class="icon-time"></i></span>
            </div>
				</div><br/>
        <label>Spots Available For This Event</label>
        <input type="text" name="available_spots"/>
				<label>Registration Window (number of days before event that users may register)</label>
        <input type="text" name="registration_window"/>
				<br/>
        <label>Event Notes & Facility Requirements</label>
			  <textarea name="reservation[notes]" cols="60" rows="12"></textarea><br/><br/>
			</div>
			<div class="span12">
				<br/><br/>
        <input type="submit" value="Create New Event" class="btn btn-success">
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
