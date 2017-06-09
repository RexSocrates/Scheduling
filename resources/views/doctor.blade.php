<!doctype html>
<html>
    <head>
        <title>Doctor</title>
    </head>
    <body>

        
            <form action='doctor' method="post">
                <input type="hidden" name="id" value="1">
                
                <label>id:1</label>
                <input type="submit" value="submit">
                {{ csrf_field() }}
            </form>
       
    </body>
</html>
