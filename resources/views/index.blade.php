<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Hello World</h1>
    <ul
    @foreach ($reservations as $reservation)

   <li>Name: {{ $reservation->user->name }}</li>
    <li>Date: {{ $reservation->recurrence->created_at }}</li>

    @endforeach
  
    </ul>
    
</body>
</html>