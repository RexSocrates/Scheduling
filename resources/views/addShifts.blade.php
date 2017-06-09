<!doctype html>
<html>
    <head>
        <title>Add shifts</title>
    </head>
    <body>
        <form action="addShifts" method="post">
            <label>scheduleID_1 :</label>
            <br>
            <input type="text" name="scheduleID_1">
            <br>
            <label>scheduleID_2 :</label>
            <br>
            <input type="text" name="scheduleID_2">
            <br>
            <label>schID_1_doctor :</label>
            <br>
            <input type="text" name="schID_1_doctor">
            <br>
            <label>schID_2_doctor :</label>
            <br>
            <input type="text" name="schID_2_doctor">
            <br>
            <input type="submit" name="submit" value="Submit">
            {{ csrf_field() }}
        </form>
        
    </body>
</html>
