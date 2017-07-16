<!doctype html>
<html>
    <head>
        <title>Add Schedule</title>
    </head>
    <body>
        <form action="addReservation" method="post">
            
            
            <label>doctorID:</label>
            <br>
            <input type="text" name="doctorID">
            <br>
            <label>periodSerial:</label>
            <br>
            <input type="text" name="periodSerial">
            <br>
            <label>isWeekday :</label>
            <br>
            <input type="boolean" name="isWeekday">
            <br>
            <label>location :</label>
            <br>
            <input type="text" name="location">
            <br>
            <label>category :</label>
            <br>
            <input type="text" name="category">
            <br>
            <label>date :</label>
            <br>
            <input type="date" name="date">
            <br>
            <label>confirmed :</label>
            <br>
            <input type="text" name="remark">
            <br>
            <input type="submit" name="submit" value="Submit">
            {{ csrf_field() }}
        </form>
        
    </body>
</html>