<!doctype html>
<html>
    <head>
        <title>doctor ReservationPeriod</title>
    </head>
    <body>
        <ul>
     
        @foreach($doctors as $doctor)
            <li>doctorID: {{ $doctor->doctorID }}</li> 
           
        @endforeach
    
      </ul>
       </form>
    </body>
</html>
