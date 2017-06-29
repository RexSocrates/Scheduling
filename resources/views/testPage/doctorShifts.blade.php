<html>
    <head>
        <title>Doctor shifts</title>
    </head>
    
    <body>
        <form action="updateShifts" method="post">
            <label>應上總班數：</label>
            <input type="number" name="mustOnDutyTotalShifts" value={{ $userData->mustOnDutyTotalShifts }}>
            <br>
            
            <label>應上內科班數：</label>
            <input type="number" name="mustOnDutyMedicalShifts" value={{ $userData->mustOnDutyMedicalShifts }}>
            <br>
            
            <label>應上外科班數：</label>
            <input type="number" name="mustOnDutySurgicalShifts" value={{ $userData->mustOnDutySurgicalShifts }}>
            <br>
            
            <label>應上台北班數：</label>
            <input type="number" name="mustOnDutyTaipeiShifts" value={{ $userData->mustOnDutyTaipeiShifts }}>
            <br>
            
            <label>應上淡水班數：</label>
            <input type="number" name="mustOnDutyTamsuiShifts" value={{ $userData->mustOnDutyTamsuiShifts }}>
            <br>
            
            <input type="submit" value="更新">
            <input type="hidden" name="doctorID" value={{ $userData->doctorID }}>
            {{ csrf_field() }}
        </form>
    </body>
</html>