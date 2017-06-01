<!doctype html>
<html>
    <head>
        <title>Show Reservation</title>
    </head>
    <body>

        <ul>
        @foreach($reservations as $reservation)
            <li>resSerial: {{ $reservation->resSerial}}</li> 
            <li>periodSerial : {{ $reservation->periodSerial}}</li> 
            <li>isWeekday : {{ $reservation->isWeekday}}</li> 
            <li>location : {{ $reservation->location}}</li> 
            <li>isOn : {{ $reservation->isOn}}</li> 
            <li>date : {{ $reservation->date}}</li> 
            <a href="{{ url('reservation/updateReservation', ['id' => $reservation->resSerial]) }}">修改</a>
         <a href="{{ url('reservation/delete', ['id' => $reservation->resSerial]) }}">刪除</a>
        @endforeach
    
      </ul>

    </body>
</html>
