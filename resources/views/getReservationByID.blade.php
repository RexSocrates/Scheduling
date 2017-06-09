<!doctype html>
<html>
    <head>
        <title>doctor Reservation</title>
    </head>
    <body>
        <ul>
        
        @foreach($reservations as $reservation)
          <input type="hidden" name="serial" value='1'>
            <li>resSerial: {{ $reservation->resSerial}}</li> 
            <li>periodSerial : {{ $reservation->periodSerial}}</li> 
            <li>isWeekday : {{ $reservation->isWeekday}}</li> 
            <li>location : {{ $reservation->location}}</li> 
            <li>isOn : {{ $reservation->isOn}}</li> 
            <li>date : {{ $reservation->date}}</li> 
        @endforeach
    
      </ul>
       </form>
    </body>
</html>
