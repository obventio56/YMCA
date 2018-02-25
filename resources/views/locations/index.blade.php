@extends('layouts.app')

@section('content')

<div class="container">
	<h3>Locations</h3>
	<p>You'll find all of your locations listed below. Locations are places that events can be held.</p>
	<a href="{{route("new-location")}}" class="btn btn-success" style="margin-right: 9px;">Create Location</a>
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
	      <td><a href="mailto:{{ $location->manager_email }}">{{ $location->manager_email }}</td>
        <td><a class="btn btn-danger pull-right" href="{{ route("destroy-location", [$location] ) }}" >Delete Location</a>
						<a style="margin-right: 9px;"  class="btn btn-info pull-right" href="{{ route("edit-location", [$location] ) }}">Edit Location</a></td>
	    </tr>
	    @endforeach
	  </tbody>
	</table>
</div>

@endsection