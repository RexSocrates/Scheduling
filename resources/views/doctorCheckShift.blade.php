<!doctype html>
<html>
    <head>
        <title>Doctor CheckShift</title>
    </head>
    <body>

        <form action="doctorCheckShift" method="post">
             <input type="hidden" name="serial" value={{$serial}}>
            
            <label>doc2Confirm :</label>
            <br>
            <input type="text" name="doc2Confirm" >
            <br> 
          
            <input type="submit" name="submit" value="Submit">
            {{ csrf_field() }}
        </form>
        
    </body>
</html>
