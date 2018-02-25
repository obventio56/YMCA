<!DOCTYPE html>
<html>
  <head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
  </head>
  <body>
    <h1>{{$event->name}} at {{$event->reservation->reservation_slot->title}} has been canceled</h1>
    <p>The class/event was scheduled to start at {{date('g:i A', strtotime($event->reservation->start_time))}}
      on {{date('l, F jS Y', strtotime($event->reservation->start_time))}}.
    </p>
    <p>We apologize for any inconvenience.</p>
    <p>You can contact the organizer directly at <a href="mailto:{{$event->notification_email}}">{{$event->notification_email}}</a></p>
  </body>
</html>