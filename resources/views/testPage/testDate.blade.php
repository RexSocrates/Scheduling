<html>
    <head>
        <title>Registration form</title>
    </head>
    
    <body>
        <form action="testDate" method="post">
            <label>Date</label>
            <input type="date" name="date" value="">
            <br>
            
            <input type="submit" value="submit">
            {{ csrf_field() }}
        </form>
    </body>
</html>