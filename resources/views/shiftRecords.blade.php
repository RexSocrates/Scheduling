<!doctype html>
<html>
    <head>
        <title>Show ShiftRecords</title>
    </head>
    <body>

        <ul>
        @foreach($shiftRecords as $shiftRecord)
            <li>changeSerial: {{ $shiftRecord->changeSerial }}</li> 
            <li>scheduleID_1 : {{ $shiftRecord->scheduleID_1}}</li> 
            <li>scheduleID_2 : {{ $shiftRecord->scheduleID_2}}</li> 
            <li>schID_1_doctor : {{ $shiftRecord->schID_1_doctor}}</li> 
            <li>schID_2_doctor : {{ $shiftRecord->schID_2_doctor}}</li> 
            <li>doc2Confirm : {{ $shiftRecord->doc2Confirm}}</li> 
            <li>adminConfirm : {{ $shiftRecord->adminConfirm}}</li> 
            <li>created_at : {{ $shiftRecord->created_at}}</li> 
            <li>updated_at : {{ $shiftRecord->updated_at}}</li> 
        @endforeach
      </ul>
    </body>
</html>
