@extends('layouts.app')

@section('content')

<div class="container">
	<h3>Edit Location: {{$location->name}}</h3>
	
  
  <form class="well" action="{{route('update-location', [$location])}}" method="POST">
    {{ csrf_field() }}
    <label>Name</label>
    <input value="{{$location->title}}" type="text" name="title"/><br><br>
    <label>Description</label>
    <textarea cols="60" rows="12" name="description">{{$location->description}}</textarea>
    <label>Manager email</label>
    <input value="{{$location->manager_email}}" type="email" name="manager_email"/><br><br>
    <input class="btn btn-success" type="submit" value="Create New Location">
  </form>

</div>
@endsection