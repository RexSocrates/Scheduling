<!doctype html>
<html>
    <head>
        <title>Add Reservation</title>
    </head>
    <body>
        <form action="addReservation" method="post">
            <label>isWeekday :</label>
            <br>
            <input type="boolean" name="isWeekday">
            <br>
            <label>location :</label>
            <br>
            <input type="text" name="location">
            <br>
            <label>isOn :</label>
            <br>
            <input type="boolean" name="isOn">
            <br>
            <label>remark :</label>
            <br>
            <input type="text" name="remark">
            <br>
            <label>date :</label>
            <br>
            <input type="date" name="date">
            <br>
            <input type="submit" name="submit" value="Submit">
            {{ csrf_field() }}
        </form>
        
    </body>
</html>
