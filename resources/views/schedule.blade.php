<!doctype html>
<html>
    <head>
        <title>Show Schedule</title>
    </head>
    <body>

        <ul>
        @foreach($schedule as $schedule)
            <form action='toEdit' method="post">
                <input type="hidden" name="serial" value={{$schedule->resSerial}}>
                <ul>
                    <li>doctorID: {{ $schedule->doctorID}}</li> 
                    <li>periodSerial : {{ $schedule->periodSerial}}</li> 
                    <li>isWeekday : {{ $schedule->isWeekday}}</li> 
                    <li>location : {{ $schedule->location}}</li> 
                    <li>category : {{ $schedule->category}}</li> 
                    <li>date : {{ $schedule->date}}</li> 
                    <li>confirmed : {{ $schedule->confirmed}}</li> 
                </ul>

                <input type="submit" value="submit">
                {{ csrf_field() }}
            </form>
        @endforeach
    
      </ul>

    </body>
</html>
