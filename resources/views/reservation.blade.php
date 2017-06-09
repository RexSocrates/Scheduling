<!doctype html>
<html>
    <head>
        <title>Show Reservation</title>
    </head>
    <body>

        
        @foreach($reservations as $reservation)
            <form action='toEdit' method="post">
                <input type="hidden" name="serial" value={{$reservation->resSerial}}>
                <ul>
                    <li>resSerial: {{ $reservation->resSerial}}</li> 
                    <li>periodSerial : {{ $reservation->periodSerial}}</li> 
                    <li>isWeekday : {{ $reservation->isWeekday}}</li> 
                    <li>location : {{ $reservation->location}}</li> 
                    <li>isOn : {{ $reservation->isOn}}</li> 
                    <li>date : {{ $reservation->date}}</li> 
                </ul>

                <input type="submit" value="submit">
                {{ csrf_field() }}
            </form>
        @endforeach

    </body>
</html>
