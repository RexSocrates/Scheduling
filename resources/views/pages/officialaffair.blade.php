@extends("layouts.app2")

<!--
@section('head')

@endsection
-->

@section('navbar')
    <p class="brand-logo light">醫師公假紀錄</p>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">
		<div class="container-section">
			<div class="row">
                <div class="col s12 m12">
      		  	  	<div class="card">
      		  	  		<div class="card-action">
      		  	  			<font class="card-title">醫生列表</font>
      		  	  		</div>
      		  	  		<div class="divider"></div>
      		  	  	  	<div class="card-content">
      		  	  	  	    <table id="example" class="mdl-data-table striped highlight" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
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
                                    @foreach($doctorsLeave as $doctorObj)
                                        <tr>
                                            <td> {{ $doctorObj[0]->doctorID }}</td>
                                            <td>{{ $doctorObj[0]->name }}</td>
                                            <td>{{ $doctorObj[0]->major }}</td>
                                            <td>{{ $doctorObj[0]->level }}</td>
                                            <td>{{ $doctorObj[0]->location }}</td>
                                            <td>{{ $doctorObj[0]->identity }}</td>
                                            <td class="doctor-td">
                                                <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2" onclick="showOfficialLeaveInfo({{ $doctorObj[0]->doctorID }})">詳細資料</a>
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
    <div id="modal2" class="modal modal-fixed-footer modal-announcement">
        <form action="officialLeave">
            <div class="modal-header" >
                <h5 class="modal-announcement-title">醫師公假紀錄</h5>
                <div class="nav-content">
                    <ul class=" tabs-fixed-width blue-grey darken-1">
                        <div class="indicator" style="right: 352px; left: 0px;"></div>
                    </ul>
                </div>
            </div>
            <table id="example" class="mdl-data-table striped highlight" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th style="width:90px;">提出時間</th>
                        <th style="width:90px;">提出人</th>
                        <th style="width:160px;">公假期間</th>
                        <th style="width:120px;">內容</th>
                        <th>時數</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctorsLeave as $leaves)
                        @foreach($leaves[1] as $leave) 
                        
                            <tr>
                                <td id=recordDate></td>
                                <td id=confirmingPersonID></td>
                                <td id=leaveDate></td>
                                <td id=remark></td>
                                <td id=leaveHours></td>
                            </tr>
                        
                        @endforeach
                    @endforeach
                </tbody>
            </table>
 
            <div class="modal-footer">
<!--                <button type="submit" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save">Save</button> -->
                <button type="submit" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save">Cancel</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../js/dataTables.material.min.js"></script>
    <script>
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
        });
        
        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 200 // Creates a dropdown of 15 years to control year
        });
        
    </script>
    <script>

     function showOfficialLeaveInfo(id) {
            $.get('showOfficialLeaveInfo', {
                id :id,
            }, function (array){
                var recordDate = "";
                var confirmingPersonID="";
                var leaveDate="";
                var remark ="";
                var leaveHours="";

                for(i=0 ; i<array.length ; i++){
                   recordDate += "<td>"+array[i][0]+"</td><br>";
                   confirmingPersonID += "<td>"+array[i][1]+"</td><br>";
                   leaveDate += "<td>"+array[i][2]+"</td><br>";
                   remark += "<td>"+array[i][3]+"</td><br>";
                   leaveHours += "<td>"+array[i][4]+"</td><br>";
                
                    console.log("aaa");
                
                }
                document.getElementById("recordDate").innerHTML  = recordDate; 
                document.getElementById("confirmingPersonID").innerHTML = confirmingPersonID;
                document.getElementById("leaveDate").innerHTML = leaveDate;
                document.getElementById("remark").innerHTML = remark;
                document.getElementById("leaveHours").innerHTML = leaveHours;
            
                 
            });
        }
    </script>
@endsection


	