<!doctype html>
<html>
    <head>
        <title>Update Reservation</title>
    </head>
    <body>
        <form action="updateReservation" method="post">
            <input type="hidden" name="serial" value={{$serial}}>
            
            <label>periodSerial :</label>
            <br>
            <input type="text" name="periodSerial" >
            <br>
            <label>isWeekday :</label>
            <br>
            <input type="boolean" name="isWeekday" >
            <br>
            <label>location :</label>
            <br>
            <input type="text" name="location">
            <br>
            <label>isOn :</label>
            <br>
            <input type="boolean" name="isOn" >
            <br>
            <label>remark :</label>
            <br>
            <input type="text" name="remark" >
            <br>
            <label>date :</label>
            <br>
            <input type="date" name="date" >
            <br>
            <input type="submit" name="submit" value="Submit">
            {{ csrf_field() }}
        </form>
        
    </body>
</html>
