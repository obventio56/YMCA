<!DOCTYPE html>
<html>
  <head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
  </head>
  <body>
    <h1>{{$user->name}} signed up for the Carlisle Family YMCA scheduler</h1>
    <p>View user info <a href="{{route('edit-user', $user)}}">here.</a>
    </p>
    <p>Thank you!</p>
  </body>
</html>