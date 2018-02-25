<!DOCTYPE html>
<html>
  <head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
  </head>
  <body>
    <h1>{{$registration->user->name}} has registered for {{$registration->event->name}}</h1>
    <p><b>Location: {{$registration->event->reservation->reservation_slot->title}}.
    <p>
      {{$registration->user->name}} has successfully registered for {{$registration->event->name}}.  The class/event is scheduled to start at {{date('g:i A', strtotime($registration->event->reservation->start_time))}}
      on {{date('l, F jS Y', strtotime($registration->event->reservation->start_time))}}.
    </p>
    <p>
      <a href="{{route('show-event', [$registration->event])}}">Event Info.</a>
    </p>
    <p>You can contact this user directly at <a href="mailto:{{$registration->user->email}}">{{$registration->user->email}}</a></p>
  </body>
</html>