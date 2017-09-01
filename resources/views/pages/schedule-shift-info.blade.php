@extends("layouts.app2")

@section('head')
    <style>
        td{
            padding: 0;
        }
        .white_cell{
            background-color:white;
        }
        .green_cell{
            background-color:#95FF95;
        }
        .yellow_cell{
            background-color:#FFFF79;
        }
        .red_cell{
            background-color:#FF5353;
        }
        table.scroll {
            width: 100%; /* Optional */
            border-spacing: 0;
        }

        table.scroll tbody, table.scroll thead { 
            display: block; 
        }
    
        table.scroll tbody {
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        table.area1 tbody {
            height: 255px;
        }
        
        table.area2 tbody {
            height: 330px;
        }

        table.area3 tbody {
            height: 260px;
        }

        tbody td:last-child, thead th:last-child {
            border-right: none;
        }
    </style>
@endsection
    
@section('navbar')
    <p class="brand-logo light">換班資訊</p>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">    <!--	 style="background-color:red;"-->
		<div class="container-section">
		    <div class="row">
                <div class="col s12 m12">
                    <div class="card">
                        <div class="card-action">
      		  	  			<!-- <img src="../img/announcement.png" class="logo-img"> -->
      		  	  			<font class="card-title">換班資訊區</font>
      		  	  			<a class="btn-floating halfway-fab waves-effect waves-light red accent-2" href="#modal1"><i class="material-icons">add</i></a>
      		  	  			<!-- <a class="btn-floating halfway-fab waves-effect waves-light blue-grey darken-1"><i class="material-icons">add</i></a> -->
      		  	  		</div>
      		  	  		<div class="divider"></div>
      		  	  	  	
      		  	  	  	<div class="card-content padding-t5">
                            <table class="centered striped highlight scroll area1">
                                <thead>
                                    <tr>
                                        <th class="td-w-5">申請人</th>
                                        <th class="td-w-5">申請日期</th>
                                        <th class="td-w-20">換班內容</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($shiftRecords as $record)
                                    <tr>
                                        <td class="td-padding td-w-5">{{ $record[0] }}</td> <!--申請人-->
                                        <td class="td-padding td-w-5">{{ $record[6] }}</td>  <!--申請日期-->
                                        <td class="td-padding td-w-20">{{ $record[2] }}  <!--申請人想換班的日期-->
                                            <font class="font-w-b"> 
                                                {{ $record[0] }} <!--申請人的名字--> 
                                                {{ $record[4] }}<!--申請人換班名字--> 
                                            </font> 與 {{ $record[3] }} <!--被換班人的班日期-->
                                            <font class="font-w-b">
                                                {{ $record[1] }} <!--被換班人-->
                                                {{ $record[5] }}<!--被換班人的班名稱-->
                                            </font> 互換
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
			<div class="row">
                <div class="col s12 m12">
      		  	  	<div class="card">
                        <div class="card-action">
      		  	  			<font class="card-title">換班待確認</font>
      		  	  		</div>
      		  	  		<div class="divider"></div>
      		  	  	  	
      		  	  	  	<div class="card-content padding-t5">
                            <table class="centered striped highlight scroll area2">
                                <thead>
                                    <tr>
                                        <th class="td-w-5">申請人</th>
                                        <th class="td-w-5">申請日期</th>
                                        <th class="td-w-25">換班內容</th>
                                        <th class="td-w-13">功能</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($shiftDataByDoctorID as $record)
                                    <tr>
                                        <td class="td-padding td-w-5">{{ $record[0] }}</td>
                                        <td class="td-padding td-w-5">{{ $record[6] }}</td>
                                        <td class="td-padding td-w-25">{{ $record[2] }} 
                                            <font class="font-w-b">
                                                {{ $record[0] }} {{ $record[4] }}
                                            </font> 與 {{ $record[3] }} 
                                            <font class="font-w-b">
                                                {{ $record[1] }} {{ $record[5] }}
                                            </font> 互換</td>
                                        <td class="td-padding td-w-13">
                                            <a href="checkShift/{{$record[7]}}" class="waves-effect waves-light btn" name=confirm>允許</a>
                                            <a href="rejectShift/{{$record[7]}}" class="waves-effect waves-light btn deep-orange darken-3" name=reject>拒絕</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
      		</div>
            <div class="row">
                <div class="col s12 m12">
                    <div class="card">
                       
                        <div class="card-action card1">
                            <div class="title1">
                                <font class="card-title">備註</font>
                            </div>
                            <div class="right">
                                時間：
                                <div class="input-field inline">
                                    <select>
                                        <option value="" disabled selected>請選擇月份</option>
                                        <option value="1">2017年8月</option>
                                        <option value="2">2017年7月</option>
                                        <option value="3">2017年6月</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="divider"></div>
                        <div class="card-content padding-t5">
                            <table class="centered striped scroll area3">
                                <thead>
                                    <tr>
                                        <th class="td-w-5">申請人</th>
                                        <th class="td-w-5">申請日期</th>
                                        <th class="td-w-20">備註內容</th>
                                    </tr>
                                </thead>
                                   

                               <tbody>
                                 @foreach($remarks as $remark)
                                    <tr>
                                        <td class="td-padding td-w-5">{{ $remark['author'] }}</td>
                                        <td class="td-padding td-w-5">{{ $remark['date'] }}</td>
                                        <td class="td-padding td-w-20">{{ $remark['content'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
      		
      		
            <div id="modal1" class="modal modal-fixed-footer modal-shift">
                <form action="schedule-shift-info" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-announcement-title">換班申請</h5>
                    </div>
                    <div class="modal-content modal-content-customize1">
                        <div class="row margin-b0">
                            <div class="col s12 center padding-b10">
                                <img src="../img/exchange.svg" style="height: 220px;width: 220px;">
                            </div>
                            
                            <div class="col s6">
                               <label>醫生:</label>
                                <select name= 'schID_1_doctor' class="browser-default" required>
                                    <option value="{{$currentDoctor->doctorID}}" selected>{{$currentDoctor->name}}</option>
                                </select>
                            </div>

                            <div class="col s6">
                                <label>醫生:</label>
                                <select name= 'schID_2_doctor' class="browser-default" id="doctorName" onchange="changeDoctor()" required>
                                    <option value="" disabled selected>請選擇醫生</option> 
                                    @foreach($doctorName as $name)
                                    <option value="{{$name->doctorID}}">{{$name->name}}</option>
                                   @endforeach
                                </select>
                            </div>
                            <div class="col s6">
                                <label>日期:</label>
                                <select name="scheduleID_1" class="browser-default" required>
                                    <option value="" disabled selected>請選擇日期</option>
                                    @foreach($currentDoctorSchedule as $data)
                                    <option value= '{{$data->scheduleID}}' >{{$data->date}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col s6">
                                <label>日期:</label>
                                <select  name='scheduleID_2' class="browser-default" id="date" required>
                                    <option value="" disabled selected>請選擇日期</option>
                                    
                                </select>
                            </div>
                            
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save">Save</button>
                        <button class="modal-action modal-close  waves-effect waves-light btn-flat btn-cancel">Cancel</button>
                        {{ csrf_field() }}
                    </div>
                </form>
            </div>
		</div>
	</div>
@endsection


@section('script')
    <script>
        $(document).ready(function(){
            $('select').material_select();
            $('.collapsible').collapsible();
  		});
    </script>
    
    <script>
        function changeDoctor() {
            $.get('changeDoctor', {
                id : document.getElementById('doctorName').value
            }, function(array) {
                // var selectBox = document.getElementById('doctorName');
                // var userInput = selectBox.options[selectBox.selectedIndex].value;
                changeDate(array);
            });
        }
    
        function changeDate(array) {
                var date = "";
                for(i=0 ; i<array.length ; i++){
                    date += "<option value="+array[i][0]+">"+array[i][2]+"</option>";
                    console.log('1'+array[i][0]);
                }
                document.getElementById("date").innerHTML  = date;
        }
    </script>
@endsection

