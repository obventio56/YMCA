<!DOCTYPE html>
<html>
  <head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
  </head>
  <body>
    <h1>{{$reservation->reservation_slot->title}} is scheduled for the {{$reservation->reservation_slot->location->title}}</h1>
    <p>The reservation is scheduled to start at {{date('g:i A', strtotime($reservation->start_time))}}
      on {{date('m/d/Y', strtotime($reservation->start_time))}}.
    </p>
    <p>The organizer has left the following notes:<br/>{{$reservation->notes}}</p>
    <p>You can contact the organizer, {{$reservation->user->name}}, directly at <a href="mailto:{{$reservation->user->email}}">{{$reservation->user->email}}</a></p>
  </body>
</html>