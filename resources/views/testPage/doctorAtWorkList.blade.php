<html>
    <head>
        <title>Doctor list</title>
    </head>
    
    <body>
        @foreach($doctors as $doctor)
            <form action="resign" method="post">
                <label>Name : {{ $doctor->name }}  </label>
                <input type="hidden" name="doctorID" value={{ $doctor->doctorID }}>
                <input type="submit" value="離職">
                {{ csrf_field() }}
            </form>
            <br>
        @endforeach
    </body>
</html>