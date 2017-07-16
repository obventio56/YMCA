@extends("layout.app")

@section("content")
<div class="container">
	<h3>Reservations/Bookings</h3>
	<p>You'll find all resources that are available for booking listed below.</p>
	
<% if current_user.superuser? %>

	<%= link_to "Create New Resource", new_reservation_path, :class => "btn btn-success", :style => "margin-right: 9px;" %><%= link_to "Calendar Overview", "/reservations/monthly", :class => "btn", :style => "margin-right: 9px;" %><%= link_to "Daily Racquetball/Squash", "/reservations/courts", :class => "btn", :style => "margin-right: 9px;" %>
	<br/><br/>
	<table class="table table-bordered table-striped">
	  <thead>
	    <tr>
	    	<th>Resource</th>
	      <th>Description/Location</th>
	      <th>Primary Email</th>
	      <th>Actions</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<% @reservations.each do |event| %>
	    <tr>
	    	<td style="width: 120px;"><b><a href="/reserve/<%= event.id %>"><%= event.title %></a></b></td>
	      <td>
	      	<p><%= event.description%></p>
	      	<p>Copy and paste the following URL anywhere that you need to link to registration for this resource:<br/><br/>
		      	<span style="color: #ff0000;">http://ymca-scheduler.herokuapp.com/reserve/<%= event.id %></span>
	      	</p>
	      </td>
	      <td><%= event.email_2 %><br/><br/><%= event.email_1.gsub(",", "\n") %></td>
	      <td style="width: 270px;"><%= link_to "Delete Resource", reservation_path(event), :confirm => "Are you sure?", :method => :delete, :class => "btn btn-danger pull-right" %> <%= link_to "Edit Resource", edit_reservation_path(event), :class => "btn btn-info pull-right", :style => "margin-right: 9px;" %></td>
	    </tr>
	    <% end %>
	  </tbody>
	</table>
	<br/>
	<h3>Current Bookings</h3>
	<table class="table table-bordered table-striped">
	  <thead>
	    <tr>
	    	<th>Resource/Room</th>
	      <th>Reservation Details</th>
	      <th>Cancel Registration</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<% @reservations2.each do |reg|
	  		if Reservation.where(:id => reg.reservation_id).count > 0
		  		event = Reservation.find(reg.reservation_id)
	  	%>
	    <tr>
	    	<td style="width: 120px;"><b><a href="/reserve/<%= event.id %>"><%= event.title %></a></b></td>
	      <td>
	      	<p><%= event.description%></p>
	      	<p><%= reg.time.strftime('%A %B %d, %Y') %> at <%= reg.time.strftime('%I:%M %p') %><br/>
	      	Length: <%= reg.length %> minutes</p>
	      </td>
	      <td style="width: 270px;"><%= link_to "Cancel Booking", booking_path(reg.id), :confirm => "Are you sure you want to DELETE this reservation?", :method => :delete, :class => "btn btn-danger pull-right" %></td>
	    </tr>
	    <% end end %>
	  </tbody>
	</table>
	
<% elsif current_user.admin? %>

	<%= link_to "Create New Resource", new_reservation_path, :class => "btn btn-success", :style => "margin-right: 9px;" %>
	<br/><br/>
	<table class="table table-bordered table-striped">
	  <thead>
	    <tr>
	    	<th>Resource</th>
	      <th>Description/Location</th>
	      <th>Notification Emails</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<% @reservations.each do |event| %>
	    <tr>
	    	<td style="width: 120px;"><b><a href="/reserve/<%= event.id %>"><%= event.title %></a></b></td>
	      <td>
	      	<p><%= event.description%></p>
	      </td>
	      <td style="width: 270px;"><%= event.email_2 %><br/><br/><%= event.email_1 %></td>
	    </tr>
	    <% end %>
	  </tbody>
	</table>
	<br/>
	<h3>Resources You've Booked</h3>
	<table class="table table-bordered table-striped">
	  <thead>
	    <tr>
	    	<th>Resource/Room</th>
	      <th>Reservation Details</th>
	      <th>Cancel Registration</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<% @reservations2.each do |reg| 
		  	event = Reservation.find(reg.reservation_id)
	  	%>
	    <tr>
	    	<td style="width: 120px;"><b><a href="/reserve/<%= event.id %>"><%= event.title %></a></b></td>
	      <td>
	      	<p><%= event.description%></p>
	      	<p><%= reg.time.strftime('%A %B %d, %Y') %> at <%= reg.time.strftime('%I:%M %p') %><br/>
	      	Length: <%= reg.length %> minutes</p>
	      </td>
	      <td style="width: 270px;"><%= link_to "Cancel Reservation", booking_path(reg.id), :confirm => "Are you sure you want to DELETE this reservation?", :method => :delete, :class => "btn btn-danger pull-right" %></td>
	    </tr>
	    <% end %>
	  </tbody>
	</table>
	
<% else %>

	<br/>
	<table class="table table-bordered table-striped">
	  <thead>
	    <tr>
	    	<th>Resource/Room</th>
	      <th>Reservation Details</th>
	      <th>Cancel Reservation</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<% @reservations.each do |reg| 
		  	reservation = Reservation.find(reg.reservation_id)
	  	%>
	    <tr>
	    	<td style="width: 120px;"><b><a href="/reserve/<%= reservation.id %>"><%= reservation.title %></a></b></td>
	      <td>
	      	<p><%= reservation.description%></p>
	      	<p><%= reg.time.strftime('%A %B %d, %Y') %> at <%= reg.time.strftime('%I:%M %p') %><br/>
	      	Length: <%= reg.length %> minutes</p>
	      	<p></p>
	      </td>
	      <td style="width: 270px;"><%= link_to "Cancel Reservation", booking_path(reg.id), :confirm => "Are you sure you want to DELETE this reservation?", :method => :delete, :class => "btn btn-danger pull-right" %></td>
	    </tr>
	    <% end %>
	  </tbody>
	</table>
	
<% end %>
</div>
@endsection