@extends('layouts.app')

@section('content')
<div class="container">
	<h3>{{$role}} Members</h3>
	<p>You'll find all of the users listed below.</p>
	<br/>
	<table class="table table-bordered table-striped">
	  <tbody>
	  	@foreach ($users as $user)
	    <tr>
	    	<td>
	        <h4>{{$user->name}}</h4><p><a href="mailto:{{$user->email}}">{{$user->email}}</a></p>
					<a class="btn btn-danger pull-right" href="{{route('destroy-user', [$user])}}">Delete User</a>
					<a class="btn btn-info pull-right" style="margin-right: 9px;" href="{{route('edit-user', [$user])}}">Edit User</a>
	      </td>
	    </tr>
	    @endforeach
	  </tbody>
	</table>
</div>
@endsection