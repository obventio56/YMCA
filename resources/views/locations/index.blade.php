<div class="container">
	<h3>Locations</h3>
	<p>You'll find all of your locations listed below. Locations are places that events can be held.</p>
	<br/><br/>
	<table class="table table-bordered table-striped">
	  <thead>
	    <tr>
	    	<th>Location</th>
	      <th>Description</th>
	      <th>Manager Email</th>
	      <th>Actions</th>
	    </tr>
	  </thead>
	  <tbody>
	  	@foreach ($locations as $location)
	    <tr>
	    	<td style="width: 120px;"><b>{{ $location->title }}</b></td>
	      <td><p>{{ $location->description }}</td>
	      <td>{{ $location->user->email }}</td>
        <td><a href="#">Delete Location</a><a href="#">Edit Location</a></td>
	    </tr>
	    @endforeach
	  </tbody>
	</table>
</div>

<form action="/location/create" method="post">
  {{ csrf_field() }}
  <input name="title" type="text" placeholder="Title" />
  <textarea name="description" placeholder="Description" ></textarea>
  <input type="Submit"/>
</form>