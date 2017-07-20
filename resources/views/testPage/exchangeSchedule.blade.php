<html>
    <head>
        <title>Doctor list</title>
    </head>
    
    <body>
        
        <form action="exchangeSchedule" method="post">
        	<label>Enter change serial : </label>
        	<input type="number" name="changeSerial">
        	<br>
        	<label>Enter the confirm status : </label>
        	<input type="number" name="adminConfirm">
        	<br>

        	<input type="submit" value="Submit">
        	{{ csrf_field() }}
        </form>
        
    </body>
</html>