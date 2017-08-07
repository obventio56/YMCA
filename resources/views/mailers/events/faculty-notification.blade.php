<!DOCTYPE html>
<html>
  <head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
  </head>
  <body>
    <h1>{{$event->name}} is scheduled for {{$event->reservation->reservation_slot->title}}</h1>
    <p>The class/event is scheduled to start at {{date('g:i A', strtotime($event->reservation->start_time))}}
      on {{date('m/d/Y', strtotime($event->reservation->start_time))}}.
    </p>
    <p>The event organizer has left the following notes:<br/>{{$event->reservation->notes}}</p>
    <p>Event Info:<br/>{{$event->description}}</p>
    <p>You can contact the organizer directly at <a href="mailto:{{$event->notification_email}}">{{$event->notification_email}}</a></p>
  </body>
</html>