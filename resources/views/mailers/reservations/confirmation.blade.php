<!DOCTYPE html>
<html>
  <head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
  </head>
  <body>
    <h1>Thank you for reserving {{$reservation->reservation_slot->title}}</h1>
    <p>
      You reserved the {{$reservation->reservation_slot->title}} from {{date('g:i A', strtotime($reservation->start_time))}} until {{date('g:i A', strtotime($reservation->end_time))}}
      on {{date('l, F jS Y', strtotime($reservation->start_time))}}.
    </p>
    <h2>Notes you included:</h2>
    <p>{{$reservation->notes}}</p>
    <p>
      If you have any questions please contact: <a href="mailto:{{$reservation->reservation_slot->primary_email}}">{{$reservation->reservation_slot->primary_email}}</a>.
    </p>
    <p>Thanks for using our online reservation system and have a great day!</p>
  </body>
</html>
