<html>
    <head>
        <title>Doctor list</title>
    </head>
    
    <body>
        @foreach($doctors as $doctor)
            <label>Email : {{ $doctor->email }}</label>
            <br>
            <label>Name : {{ $doctor->name }}</label>
            <br>
        @endforeach
    </body>
</html>