<html>
    <head>
        <title>Registration form</title>
    </head>
    
    <body>
        <form method="post">
            <label>Email</label>
            <input type="email" name="email" value="">
            <br>
            
            <label>Birthday</label>
            <input type="date" name="password" value="">
            <br>
            
            <label>Name</label>
            <input type="text" name="name" value="">
            <br>
            
            <label>level</label>
            <input type="text" name="level" value="">
            <br>
            
            <label>Major</label>
            <input type="text" name="major" value="">
            <br>
            
            <label>Location</label>
            <input type="text" name="location" value="">
            <br>
            
            <label>Identity</label>
            <input type="text" name="identity" value="">
            <br>
            
            <input type="submit" value="submit">
            {{ csrf_field() }}
        </form>
    </body>
</html>