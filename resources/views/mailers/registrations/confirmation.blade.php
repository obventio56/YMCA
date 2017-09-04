<!DOCTYPE html>
<html>
  <head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
  </head>
  <body>
    <h1>Thank you for registering for {{$registration->event->name}}, {{$registration->user->name}}</h1>
    <p><b>Location: {{$registration->event->reservation->reservation_slot->title}}.
    <p>
      You have successfully registered for {{$registration->event->name}}.  The class/event is scheduled to start at {{date('g:i A', strtotime($registration->event->reservation->start_time))}}
      on {{date('l, F jS Y', strtotime($registration->event->reservation->start_time))}}.
    </p>
    <p>
      <a href="{{route('show-event', [$registration->event])}}">Event Info</a>.
    </p>
    <p>Thanks for registering and have a great day!</p>
  </body>
</html>