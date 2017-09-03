@extends("layouts.app2")

<!--
@section('head')

@endsection
-->

@section('navbar')
    <p class="brand-logo light">醫師管理</p>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">
		<div class="container-section">
			<div class="row">
                <div class="col s12 m12">
      		  	  	<div class="card">
      		  	  		<div class="card-action">
      		  	  			<font class="card-title">醫生列表</font>
                            <a class="btn-floating halfway-fab waves-effect waves-light red accent-2" href="#modal1"><i class="material-icons">add</i></a>
      		  	  		</div>
      		  	  		<div class="divider"></div>
      		  	  	  	<div class="card-content">
      		  	  	  	    <table id="example" class="mdl-data-table striped highlight" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>醫生id</th>
                                        <th>醫生名稱</th>
                                        <th>專職科別</th>
                                        <th>級別</th>
                                        <th>職登院區</th>
                                        <th>權限</th>
                                        <th style="width:150px;">動作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($doctors as $doctor)
                                    <tr>
                                        <td>{{ $doctor->doctorID }}</td>
                                        <td>{{ $doctor->name }}</td>
                                        <td>{{ $doctor->major }}</td>
                                        <td>{{ $doctor->level }}</td>
                                        <td>{{ $doctor->location }}</td>
                                        <td>{{ $doctor->identity }}</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2" onclick="editDoctor({{ $doctor->doctorID }})">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn" href="resign/{{ $doctor->doctorID }}">刪除</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
      		  	  	  	</div>
      		  	  	</div>
      		  	</div>
      		</div>
		</div>
	</div>
	
	<!-- Modal Structure -->
    <div id="modal1" class="modal modal-fixed-footer modal-announcement">
        <form action="register" method="post">
           
            <div class="modal-header">
                <h5 class="modal-announcement-title">新增醫生</h5>
                <div class="nav-content">
                    <ul class="tabs tabs-transparent tabs-fixed-width blue-grey darken-1">
                        <li class="tab"><a href="#modal-left" class="active">一般資訊</a></li>
                        <li class="tab"><a href="#modal-right">班數</a></li>
                        <div class="indicator" style="right: 352px; left: 0px;"></div>
                    </ul>
                </div>
            </div>
            
            
            <div class="modal-content modal-content-customize">
                <div id="modal-left" class="row margin-b0">
                    <div class="input-field col s12">
                        <input id="title" type="text" value="" name="name" required>
                        <label for="title">醫生名稱</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="email" type="email" class="validate" value="" name="email" required>
                        <label for="email" data-error="wrong" data-success="right">Email</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="date" type="date" class="datepicker" value="" name="birthday" onchange="dateFormat()">
                        <label for="date">出生日期</label>
                    </div>
                    <div class="input-field col s12 margin-b20">
                        <select name="major" required>
                            <option value="" disabled>選擇專科</option>
                            <option value="All">All</option>
                            <option value="Medical" selected>Medical</option>
                            <option value="Surgical">Surgical</option>
                        </select>
                        <label>專職科別</label>
                    </div>
                    <div class="input-field col s12 margin-b20">
                        <select name="level" required>
                            <option value="" disabled>選擇級別</option>
                            <option value="A1">A1</option>
                            <option value="A2" selected>A2</option>
                            <option value="A3">A3</option>
                            <option value="A4">A4</option>
                            <option value="A5">A5</option>
                            <option value="A6">A6</option>
                            <option value="A7">A7</option>
                            <option value="A8">A8</option>
                            <option value="A9">A9</option>
                            <option value="A10">A10</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                            <option value="S4">S4</option>
                            <option value="S5">S5</option>
                            <option value="S6">S6</option>
                            <option value="S7">S7</option>
                            <option value="S8">S8</option>
                            <option value="S9">S9</option>
                            <option value="S10">S10</option>
                        </select>
                        <label>級別</label>
                    </div>
                    <div class="input-field col s12 margin-t0">
                        <p class="margin-0">職登院區</p>
                        <p class="radio-location">
                            <input class="with-gap" name="location" type="radio" id="radio-Taipei" value="台北" required/>
                            <label for="radio-Taipei">台北</label>
                            <input class="with-gap" name="location" type="radio" id="radio-Danshui" value="淡水" />
                            <label for="radio-Danshui">淡水</label>
                        </p>
                    </div>
                    <div class="input-field col s12">
                        <select name="identity" required>
                            <option value="" disabled>選擇權限</option>
                            <option value="Admin">排班人員</option>
                            <option value="General">一般醫師</option>
                            <option value="Announcement" selected>一般醫師(可發送公告)</option>
                        </select>
                        <label>權限</label>
                    </div>
                </div>
                
                <div id="modal-right" class="row margin-b0">
                    <div class="input-field col s12">
                        <input value="15" name="mustOnDutyTotalShifts" type="number" required>
                        <label for="和id一樣">總班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" name="mustOnDutyTaipeiShifts" type="number" required>
                        <label for="和id一樣">台北院區班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" name="mustOnDutyTamsuiShifts" type="number" required>
                        <label for="和id一樣">淡水院區班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" name="mustOnDutyDayShifts" type="number" required>
                        <label for="和id一樣">白天班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" name="mustOnDutyNightShifts" type="number" required>
                        <label for="和id一樣">夜晚班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" name="mustOnDutyMedicalShifts" type="number" required>
                        <label for="和id一樣">內科班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" name="mustOnDutySurgicalShifts" type="number" required>
                        <label for="和id一樣">外科班數</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save">Save</button>
                <button class="modal-action modal-close waves-effect waves-light btn-flat btn-cancel">Cancel</button>
            </div>
            {{ csrf_field() }}
        </form>
    </div>
       
    <!-- Modal Structure -->
    <div id="modal2" class="modal modal-fixed-footer modal-announcement">
        <form action="doctorInfoUpdate" method="post">
            {{ csrf_field() }}
            <input type="hidden" id="hiddenDoctorID" name="hiddenDoctorID" value="">
            <div class="modal-header">
                <h5 class="modal-announcement-title">修改醫生</h5>
                <div class="nav-content">
                    <ul class="tabs tabs-transparent tabs-fixed-width blue-grey darken-1">
                        <li class="tab"><a href="#modal-left1" class="active">一般資訊</a></li>
                        <li class="tab"><a href="#modal-right1">班數</a></li>
                        <div class="indicator" style="right: 352px; left: 0px;"></div>
                    </ul>
                </div>
            </div>
            
            <div class="modal-content modal-content-customize">
                <div id="modal-left1" class="row margin-b0">
                    <div class="input-field col s12">
                        <input id="doctorName" type="text" value="" name="name" required>
                        <label for="title">醫生名稱</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="doctorEmail" type="email" class="validate" value="" name="email" required>
                        <label for="email" data-error="wrong" data-success="right">Email</label>
                    </div>
<!--
                    <div class="input-field col s12">
                        <input id="date2" type="date" class="datepicker" value="" name="birthday" onchange="dateFormat()">
                        <label for="date">出生日期</label>
                    </div>
-->
                    <div class="input-field col s12">
                        <select id="doctorMajor" name="major" required>
                            <option value="" disabled>選擇專科</option>
                            <option value="All">All</option>
                            <option value="Medical">Medical</option>
                            <option value="Surgical">Surgical</option>
                        </select>
                        <label>專職科別</label>
                    </div>
                    <div class="input-field col s12">
                        <select id="doctorLevel" name="level" required>
                            <option value="" disabled>選擇級別</option>
                            <option value="A1">A1</option>
                            <option value="A2" selected>A2</option>
                            <option value="A3">A3</option>
                            <option value="A4">A4</option>
                            <option value="A5">A5</option>
                            <option value="A6">A6</option>
                            <option value="A7">A7</option>
                            <option value="A8">A8</option>
                            <option value="A9">A9</option>
                            <option value="A10">A10</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                            <option value="S4">S4</option>
                            <option value="S5">S5</option>
                            <option value="S6">S6</option>
                            <option value="S7">S7</option>
                            <option value="S8">S8</option>
                            <option value="S9">S9</option>
                            <option value="S10">S10</option>
                        </select>
                        <label>級別</label>
                    </div>
                    <div class="input-field col s12 margin-t0">
                        <p class="margin-0">職登院區</p>
                        <p class="radio-location">
                            <input class="with-gap" name="location" type="radio" id="radio-Taipei" value="台北" required/>
                            <label for="radio-Taipei">台北</label>
                            <input class="with-gap" name="location" type="radio" id="radio-Danshui" value="淡水" checked="checked"/>
                            <label for="radio-Danshui">淡水</label>
                        </p>
                    </div>
                    <div class="input-field col s12">
                        <select name="identity" id="doctorIdentity" required>
                            <option value="" disabled>選擇權限</option>
                            <option value="Admin">排班人員</option>
                            <option value="General">一般醫師</option>
                            <option value="Announcement" selected>一般醫師(可發送公告)</option>
                        </select>
                        <label>權限</label>
                    </div>
                </div>
                
                <div id="modal-right1" class="row margin-b0">
                    <div class="input-field col s12">
                        <input value="15" id="mustOnDutyTotalShifts" name="mustOnDutyTotalShifts" type="number" required>
                        <label for="和id一樣">總班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" id="mustOnDutyTaipeiShifts" name="mustOnDutyTaipeiShifts" type="number" required>
                        <label for="和id一樣">台北院區班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" id="mustOnDutyTamsuiShifts" name="mustOnDutyTamsuiShifts" type="number" required>
                        <label for="和id一樣">淡水院區班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" id="mustOnDutyDayShifts" name="mustOnDutyDayShifts" type="number" required>
                        <label for="和id一樣">白天班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" id="mustOnDutyNightShifts" name="mustOnDutyNightShifts" type="number" required>
                        <label for="和id一樣">夜晚班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" id="mustOnDutyMedicalShifts" name="mustOnDutyMedicalShifts" type="number" required>
                        <label for="和id一樣">內科班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" id="mustOnDutySurgicalShifts" name="mustOnDutySurgicalShifts" type="number" required>
                        <label for="和id一樣">外科班數</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save">Save</button>
                <button class="modal-action modal-close waves-effect waves-light btn-flat btn-cancel">Cancel</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../js/dataTables.material.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        function dateFormat() {
            var dateValue = document.getElementById("date").value;
            var splitDate = dateValue.split(/(?:,| )+/);
            var months = {
                January: 1,
                February: 2,
                March: 3,
                April: 4,
                May: 5,
                June: 6,
                July: 7,
                August: 8,
                September: 9,
                October: 10,
                November: 11,
                December: 12,
            };
            var monthNumber = months[splitDate[1]];
            var mysqlDate = splitDate[2] + "-" + monthNumber + "-" + splitDate[0]
            document.getElementById("date").value = mysqlDate
        }
        
        function sleep(milliseconds) {
            var start = new Date().getTime();
            for (var i = 0; i < 1e7; i++) {
                if ((new Date().getTime() - start) > milliseconds){
                    break;
                }
            }
        }
        
        $(document).ready(function() {
            $('#example').DataTable( {
                columnDefs: [
                    {
                        targets: [ 0, 1, 2 ],
                        className: 'mdl-data-table__cell--non-numeric'
                    }
                ]
            });
            
            $('select').material_select();
            
            var count = 0;
            for(i=0;i<4;i++){
                document.getElementById("example_length").getElementsByTagName("li")[i].addEventListener("click", ff);
            }
        });
        
        var tttt = 0;
        
        function ff() {
            f1();
            f2();
        }
        
        function f1() {
            console.log("111");
            console.log(document.getElementById("example_length").getElementsByTagName("ul"));
//            sleep(10000);
        }
        
        function f2() {
            console.log("222");
            console.log(document.getElementById("example_length").getElementsByTagName("ul"));
//            sleep(10000);
        }
        
        function editDoctor(doctorID) {
            $.get('editDoctorInfo', {
                doctorID : doctorID
            }, function(doctorData) {
//                alert("GET doctor data");
                document.getElementById("hiddenDoctorID").value = doctorData[0];
                document.getElementById("doctorEmail").value = doctorData[1];
                document.getElementById("doctorName").value = doctorData[2];
                
                // problematic drop down list
                document.getElementById("doctorLevel").value = doctorData[3];
                document.getElementById('doctorMajor').value = doctorData[4];
                console.log("Major : " + doctorData[4]);
                
                // location 5
                if(doctorData[5] == "台北") {
                    document.getElementById("radio-Taipei").checked = true;
                }else {
                    document.getElementById("radio-Danshui").checked = true;
                }
                
                // identity 6
                document.getElementById("doctorIdentity").value = doctorData[6];
                
                // must on duty XX shifts
                document.getElementById("mustOnDutyTotalShifts").value = doctorData[7];
                document.getElementById("mustOnDutyMedicalShifts").value = doctorData[8];
                document.getElementById("mustOnDutySurgicalShifts").value = doctorData[9];
                document.getElementById("mustOnDutyTaipeiShifts").value = doctorData[10];
                document.getElementById("mustOnDutyTamsuiShifts").value = doctorData[11];
                document.getElementById("mustOnDutyDayShifts").value = doctorData[12];
                document.getElementById("mustOnDutyNightShifts").value = doctorData[13];
                
                
                
                
                // doctor major
//                if(doctorData[4] == "All") {
//                    document.getElementById("doctorMajor").innerHTML = 
//                        "<option value='All' selected>All</option>" + 
//                            "<option value='Medical'>Medical</option>" + 
//                            "<option value='Surgical'>Surgical</option>";
//                }else if(doctorData[4] == "Medical") {
//                    document.getElementById("doctorMajor").innerHTML = 
//                        "<option value='All'>All</option>" + 
//                            "<option value='Medical' selected>Medical</option>" + 
//                            "<option value='Surgical'>Surgical</option>";
//                }else {
//                    document.getElementById("doctorMajor").innerHTML = 
//                        "<option value='All'>All</option>" + 
//                            "<option value='Medical'>Medical</option>" + 
//                            "<option value='Surgical' selected>Surgical</option>";
//                }
                
                
                
            });
        }
        

        
        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 200 // Creates a dropdown of 15 years to control year
        });
    </script>
@endsection
