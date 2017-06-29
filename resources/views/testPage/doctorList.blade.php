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
            <a href='getDoctorShifts/{{$doctor->doctorID}}'>取得該醫師班數</a>
            <br>
            <br>
        @endforeach
    </body>
</html>