@extends("layouts.app2")

@section('head')
    <link type="text/css" rel="stylesheet" href="../css/dataTables.material.min.css"/>
@endsection

@section('navbar')
    <p class="brand-logo light">醫師管理</p>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">
		<div class="container-section">
			<div class="row">
                <div class="col s12 m12">
      		  	  	<div class="card">
      		  	  		<div class="card-action b-t0">
      		  	  			<font class="card-title">醫師列表</font>
                            <a class="btn-floating halfway-fab waves-effect waves-light red accent-2" href="#modal1"><i class="material-icons">add</i></a>
      		  	  		</div>
      		  	  		<div class="divider"></div>
      		  	  	  	<div class="card-content">
      		  	  	  	    <table id="doctor" class="mdl-data-table striped highlight" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>名稱</th>
                                        <th>專職科別</th>
                                        <th>級別</th>
                                        <th>職登院區</th>
                                        <th>權限</th>
                                        <th style="width:150px;">功能</th>
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
                <h5 class="modal-announcement-title">新增醫師</h5>
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
                        <input id="title" type="text" value="" name="name" data-length="30" maxlength="30" required>
                        <label for="title">醫師名稱</label>
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
                            <option value="Medical">Medical</option>
                            <option value="Surgical">Surgical</option>
                        </select>
                        <label>專職科別</label>
                    </div>
                    <div class="input-field col s12 margin-b20">
                        <select name="level" required>
                            <option value="" disabled>選擇級別</option>
                            <option value="A1">A1</option>
                            <option value="A2">A2</option>
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
                            <input class="with-gap" name="location" type="radio" id="radio-Danshui" value="淡水" required/>
                            <label for="radio-Danshui">淡水</label>
                        </p>
                    </div>
                    <div class="input-field col s12">
                        <select name="identity" required>
                            <option value="" disabled>選擇權限</option>
                            <option value="Admin">排班人員</option>
                            <option value="General" selected>一般醫師</option>
<!--                            <option value="Announcement">一般醫師(可發送公告)</option>-->
                        </select>
                        <label>權限</label>
                    </div>
                </div>
                
                <div id="modal-right" class="row margin-b0">
                    <div class="input-field col s12">
                        <input value="15" name="totalShift" type="number" min="0" max="100" required>
                        <label for="totalShifts">總班數(包含行政與教學)</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="0" name="mustOnDutyTotalShifts" type="number" min="0" max="100" required>
                        <label for="mustOnDutyTaipeiShifts">臨床總班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="0" name="weekendShifts" type="number" min="0" max="100" required>
                        <label for="weekendShifts">臨床假日班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="0" name="mustOnDutyTaipeiShifts" type="number" min="0" max="100" required>
                        <label for="mustOnDutyTaipeiShifts">臨床台北院區班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="0" name="mustOnDutyTamsuiShifts" type="number" min="0" max="100" required>
                        <label for="mustOnDutyTamsuiShifts">臨床淡水院區班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="0" name="mustOnDutyDayShifts" type="number" min="0" max="100" required>
                        <label for="mustOnDutyDayShifts">臨床白天班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="0" name="mustOnDutyNightShifts" type="number" min="0" max="100" required>
                        <label for="mustOnDutyNightShifts">臨床夜晚班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="0" name="mustOnDutyMedicalShifts" type="number" min="0" max="100" required>
                        <label for="mustOnDutyMedicalShifts">臨床內科班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="0" name="mustOnDutySurgicalShifts" type="number" min="0" max="100" required>
                        <label for="mustOnDutySurgicalShifts">臨床外科班數</label>
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
                <h5 class="modal-announcement-title">修改醫師</h5>
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
                        <input id="doctorName" type="text" name="name" data-length="30" maxlength="30" required>
                        <label for="title">醫師名稱</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="doctorEmail" type="email" class="validate" name="email" required>
                        <label for="email" data-error="wrong" data-success="right">Email</label>
                    </div>
<!--
                    <div class="input-field col s12">
                        <input id="date2" type="date" class="datepicker" value="" name="birthday" onchange="dateFormat()">
                        <label for="date">出生日期</label>
                    </div>
-->
                    <div class="input-field col s12 margin-b20">
                        <select id="doctorMajor" name="major" required>
<!--                            <option value="" disabled>選擇專科</option>-->
                            <option value="All">All</option>
                            <option value="Medical">Medical</option>
                            <option value="Surgical">Surgical</option>
                        </select>
                        <label>專職科別</label>
                    </div>
                    <div class="input-field col s12 margin-b20">
                        <select id="doctorLevel" name="level" required>
<!--                            <option value="" disabled>選擇級別</option>-->
                            <option value="A1">A1</option>
                            <option value="A2">A2</option>
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
                            <input class="with-gap" name="location" type="radio" id="radio-Taipei1" value="台北" required/>
                            <label for="radio-Taipei1">台北</label>
                            <input class="with-gap" name="location" type="radio" id="radio-Danshui1" value="淡水" required/>
                            <label for="radio-Danshui1">淡水</label>
                        </p>
                    </div>
                    <div class="input-field col s12">
                        <select name="identity" id="doctorIdentity" required>
<!--                            <option value="" disabled>選擇權限</option>-->
                            <option value="Admin">排班人員</option>
                            <option value="General">一般醫師</option>
<!--                            <option value="Announcement">一般醫師(可發送公告)</option>-->
                        </select>
                        <label>權限</label>
                    </div>
                </div>
                
                <div id="modal-right1" class="row margin-b0">
                    <div class="input-field col s12">
                        <input value="15" name="totalShift" id="totalShift" type="number" min="0" max="100" required>
                        <label for="totalShifts">總班數(包含行政與教學)</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="0" name="mustOnDutyTotalShifts" id="mustOnDutyTotalShifts" type="number" min="0" max="100" required>
                        <label for="mustOnDutyTaipeiShifts">臨床總班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="0" name="weekendShifts" id="weekendShifts" type="number" min="0" max="100" required>
                        <label for="weekendShifts">臨床假日班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="0" name="mustOnDutyTaipeiShifts" id="mustOnDutyTaipeiShifts" type="number" min="0" max="100" required>
                        <label for="mustOnDutyTaipeiShifts">臨床台北院區班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="0" name="mustOnDutyTamsuiShifts" id="mustOnDutyTamsuiShifts" type="number" min="0" max="100" required>
                        <label for="mustOnDutyTamsuiShifts">臨床淡水院區班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="0" name="mustOnDutyDayShifts" id="mustOnDutyDayShifts" type="number" min="0" max="100" required>
                        <label for="mustOnDutyDayShifts">臨床白天班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="0" name="mustOnDutyNightShifts" id="mustOnDutyNightShifts" type="number" min="0" max="100" required>
                        <label for="mustOnDutyNightShifts">臨床夜晚班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="0" name="mustOnDutyMedicalShifts" id="mustOnDutyMedicalShifts" type="number" min="0" max="100" required>
                        <label for="mustOnDutyMedicalShifts">臨床內科班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="0" name="mustOnDutySurgicalShifts" id="mustOnDutySurgicalShifts" type="number" min="0" max="100" required>
                        <label for="mustOnDutySurgicalShifts">臨床外科班數</label>
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
        
        $(document).ready(function() {
            $('#doctor').DataTable();
            
            $('select').material_select();
            
            document.getElementById("doctor_length").style.display = 'none';
            
            document.getElementById("doctor_filter").style.cssText = 'text-align: left';
            
            document.getElementById("doctor_filter").getElementsByTagName("label")[0].getElementsByTagName("input")[0].style.marginLeft = '0';
        
        });
        
        // 編輯醫師的ajax
        function editDoctor(doctorID) {
            $.get('editDoctorInfo', {
                doctorID : doctorID
            }, function(doctorData) {
//                alert("GET doctor data");
                document.getElementById("hiddenDoctorID").value = doctorData[0];
                document.getElementById("doctorEmail").value = doctorData[1];
                document.getElementById("doctorName").value = doctorData[2];
                
                // problematic drop down list
                // level 3
//                document.getElementById("doctorLevel").value = doctorData[3];
                var doctorLevelValue  = doctorData[3];
                document.getElementsByClassName("select-dropdown")[10].value = doctorLevelValue;
                $("#doctorLevel").val(doctorLevelValue).find("option[value=" + doctorLevelValue +"]").attr('selected', true);
                
                // major 4
//                document.getElementById('doctorMajor').value = doctorData[4];
//                document.getElementById('doctorMajor').value = "Surgical";
//                console.log("Major : " + doctorData[4]);
                
                document.getElementsByClassName("select-dropdown")[8].value = doctorData[4];
                var majorValue  = doctorData[4];
                document.getElementsByClassName("select-dropdown")[8].value = majorValue;
                $("#doctorMajor").val(majorValue).find("option[value=" + majorValue +"]").attr('selected', true);
                
//                document.getElementById("doctorMajor").innerHTML = "<option value='All'>All</option>";
                
                // location 5
                if(doctorData[5] == "台北") {
                    document.getElementById("radio-Taipei1").checked = true;
                }else {
                    document.getElementById("radio-Danshui1").checked = true;
                }
                
                // identity 6
                var identity = doctorData[6];
                $("#doctorIdentity").val(identity).find("option[value=" + identity +"]").attr('selected', true);
                if (identity == "Admin") {
                    identity = "排班人員";
                } else if(identity == "General"){
                    identity = "一般醫師";
                }
                
//                else if(identity == "Announcement"){
//                    identity = "一般醫師(可發送公告)";
//                } 
                
                document.getElementsByClassName("select-dropdown")[12].value = identity;
                
                // must on duty XX shifts
                document.getElementById("totalShift").value = doctorData[7];
                document.getElementById("mustOnDutyTotalShifts").value = doctorData[8];
                document.getElementById("mustOnDutyMedicalShifts").value = doctorData[9];
                document.getElementById("mustOnDutySurgicalShifts").value = doctorData[10];
                document.getElementById("mustOnDutyTaipeiShifts").value = doctorData[11];
                document.getElementById("mustOnDutyTamsuiShifts").value = doctorData[12];
                document.getElementById("mustOnDutyDayShifts").value = doctorData[13];
                document.getElementById("mustOnDutyNightShifts").value = doctorData[14];
                document.getElementById("weekendShifts").value = doctorData[15];
                
                Materialize.updateTextFields();
                
            });
        }
        
        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 200 // Creates a dropdown of 15 years to control year
        });
    </script>
@endsection
