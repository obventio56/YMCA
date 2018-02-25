<!DOCTYPE html>
<html>
  <head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
  </head>
  <body>
    <h1>Just reminding you about your reservation for the {{$reservation->reservation_slot->title}} at the Carlisle Family YMCA, {{$reservation->user->name}}!</h1>
    <p><b>Location: {{$reservation->reservation_slot->title}}.
    <p>
      You reserved the {{$reservation->reservation_slot->title}} from {{date('g:i A', strtotime($reservation->start_time))}} until {{date('g:i A', strtotime($reservation->end_time))}}
      on {{date('l, F jS Y', strtotime($reservation->start_time))}}.
    </p>
    <p>Thanks and have a great day!</p>
  </body>
</html>