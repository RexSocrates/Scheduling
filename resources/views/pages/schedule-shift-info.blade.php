@extends("layouts.app2")

@section('head')
    <style>
        td{
            padding: 0;
        }
    </style>
@endsection
    
@section('navbar')
    <p class="brand-logo light">換班資訊</p>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">    <!--     style="background-color:red;"-->
        <div class="container-section">
            <div class="row">
                <div class="col s12 m12">
                    <div class="card">
                        <div class="card-action b-t0 card1">
                            <!-- <img src="../img/announcement.png" class="logo-img"> -->
                            <div class="title1">
                                <font class="card-title">換班資訊區</font>
                            </div>
                            <div class="right" style="margin-right: 60px;">
                                時間：
                                <div class="input-field inline">
                                    <select id="shiftMonth" name ="shiftMonth" onchange="changeShiftMonth()">
                                        <option value="" disabled selected>請選擇月份</option>
                                        @foreach($monthList as $month)
                                            <option value="{{ $month }}">{{ $month }}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                            </div>
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
                                        <th class="td-w-20">內容</th>
                                    </tr>
                                </thead>

                                <tbody id="shiftRecordsTableBody">
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
                        <div class="card-action b-t0">
                            <!-- <img src="../img/announcement.png" class="logo-img"> -->
                            <font class="card-title">換班確認狀態</font>
                        </div>
                        <div class="divider"></div>
                        
                        <div class="card-content padding-t5">
                            <table class="centered striped highlight scroll area1">
                                <thead>
                                    <tr>
                                        <th class="td-w-5">申請人</th>
                                        <th class="td-w-5">申請日期</th>
                                        <th class="td-w-5">換班醫生</th>
                                        <th class="td-w-5">排班人員</th>
                                        <th class="td-w-20">內容</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($allRejectShiftData as $record)
                                    <tr>
                                        <td class="td-padding td-w-5">{{ $record[0] }}</td> <!--申請人-->
                                        <td class="td-padding td-w-5">{{ $record[6] }}</td>  <!--申請日期-->
                                        @if($record[8] == "已拒絕")
                                        <td class="td-padding td-w-5"><font class="red-text">{{ $record[8] }}</font></td>
                                        @else
                                        <td class="td-padding td-w-5">{{ $record[8] }}</td>
                                        @endif
                                        @if($record[9] == "已拒絕")
                                        <td class="td-padding td-w-5"><font class="red-text">{{ $record[9] }}</font></td>
                                        @elseif($record[9] == "未確認")
                                        <td class="td-padding td-w-5"><font class="red-text">{{ $record[9] }}</font></td>
                                        @else
                                        <td class="td-padding td-w-5">{{ $record[9] }}</td>
                                        @endif
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
                        <div class="card-action b-t0">
                            <font class="card-title">換班待確認</font>
                        </div>
                        <div class="divider"></div>
                        
                        <div class="card-content padding-t5">
                            <table class="centered striped highlight scroll area2">
                                <thead>
                                    <tr>
                                        <th class="td-w-5">申請人</th>
                                        <th class="td-w-5">申請日期</th>
                                        <th class="td-w-25">內容</th>
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
                                            <a class="waves-effect waves-light btn" name=confirm onclick="checkStatus({{$record[7]}} )">確認</a>
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
                        <div class="card-action b-t0 card1">
                            <div class="title1">
                                <font class="card-title">備註</font>
                            </div>
                            <div class="right">
                                時間：
                                <div class="input-field inline">
                                    <select id=month onchange="changeRemarkMonth()">
                                        <option value="" disabled selected>請選擇月份</option>
                                        @foreach($monthList as $month)
                                            <option value="{{ $month }}">{{ $month }}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <div class="divider"></div>
                        <div class="card-content padding-t5">
                            <table class="centered striped scroll area3">
                                <thead>
                                    <tr>
                                        <th class="td-w-5">申請人</th>
                                        <th class="td-w-5">申請日期</th>
                                        <th class="td-w-20">內容</th>
                                    </tr>
                                </thead>
                                   

                               <tbody id="remarkTableBody">
                                 @foreach($remarks as $remark)
                                    <tr>
                                        <td class="td-padding td-w-5" id=author>{{ $remark['author'] }}</td>
                                        <td class="td-padding td-w-5" id=date>{{ $remark['date'] }}</td>
                                        <td class="td-padding td-w-20" id=content>{{ $remark['content'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div id="modal1" class="modal modal-fixed-footer modal-shift">
                <!-- <form action="schedule-shift-info" method="POST"> -->
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
                                <select name= 'schID_1_doctor' class="browser-default"  id= "schID_1_doctor" required >
                                    <option value="{{$currentDoctor->doctorID}}" selected>{{$currentDoctor->name}}</option>
                                </select>
                            </div>

                             

                            <div class="col s6">
                                <label>日期:</label>
                                
                                <select  name='scheduleID_2' class="browser-default" id="date2" onchange="changeDoctor()" required>
                                    <option  value="" disabled selected>請選擇日期</option>
                                     <!-- @foreach($date as $d) -->
                                    <option value=""></option>
                                    <!-- @endforeach -->
                                </select>
                            </div>

                            <div class="col s6">
                                <label>日期:</label>
                                <select name="scheduleID_1" class="browser-default"  id="date1" onchange="changeDoctor_1()" required>
                                    <option value="" disabled selected>請選擇日期</option>
                                    @foreach($currentDoctorSchedule as $data)
                                    <option value='{{ $data[0] }}'>{{ $data[1] }} - {{ $data[2] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col s6">
                                <label>醫生:</label>
                                <select name= 'schID_2_doctor' class="browser-default" id="schID_2_doctor" required>
                                    <option value="" disabled selected>請選擇醫生</option> 
                                   
                                </select>
                            </div>
                           
                            
                            
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save" onclick="save()">Save</button>
                        <button class="modal-action modal-close  waves-effect waves-light btn-flat btn-cancel">Cancel</button>
                        {{ csrf_field() }}
                    </div>
                <!-- </form> -->
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
        function changeDoctor(date) {

            $.get('getDoctor', {
                scheduleID_1 :document.getElementById("date1").value,
                scheduleID_2 :document.getElementById("date2").value

            }, function(array) {
                 var doctor = "";
                for(i=0 ; i<array.length ; i++){
                    doctor += "<option value="+array[i][0]+">"+array[i][1]+"-"+array[i][2]+"</option>";
                    console.log('1'+array[i][1]);
                    console.log(array[i][0]);
                }
                document.getElementById("schID_2_doctor").innerHTML  = doctor;

            });
        }

         function changeDoctor_1() {
            $.get('getDoctorDate', {
                scheduleID :document.getElementById("date1").value

            }, function(array) {
                 var date = "";
                for(i=0 ; i<array.length ; i++){
                    date += "<option value="+array[i]+">"+array[i]+"</option>";
                    console.log(array[0]);
                }
                document.getElementById("date2").innerHTML  = date;
                changeDoctor(array[0]);
            });
            console.log(document.getElementById("date1").value);
            
           
        }
    
        // function changeDate(array) {
        //         var date = "";
        //         for(i=0 ; i<array.length ; i++){
        //             date += "<option value="+array[i][0]+">"+array[i][2]+"</option>";
        //             console.log('aaa'+array[i][0]);
        //         }
        //         document.getElementById("date2").innerHTML  = date;
               
        // }

        function changeShiftMonth() {
             console.log("Month : " + document.getElementById('shiftMonth').value);
             $.get('changeShiftMonth', {
                 month : document.getElementById('shiftMonth').value
             }, function(array) {
                 // 更新html內容
                 htmlTableBody = "";
                 for(i = 0; i < array.length; i++) {
                     htmlDoc = "<tr>";
                     htmlDoc += "<td class='td-padding td-w-5'>" + array[i][0] + "</td>"; // 申請人
                     htmlDoc += "<td class='td-padding td-w-5'>" + array[i][7] + "</td>"; // 申請日期
                     htmlDoc += "<td class='td-padding td-w-20'>" + array[i][2]; // schedule 1 的日期
                     
                     // 申請人的名字, 申請人的班的名稱
                     htmlDoc += "<font class='font-w-b'>" + array[i][0] + " " + array[i][4] + "</font>";
                     
                     // 申請對象的班的日期, 申請對象的名字, 班的名稱
                     htmlDoc += " 與 " + array[i][3] + " <font class='font-w-b'>" + array[i][1] + " " + array[i][5] + "</font> 互換 </td>";
                     
                     htmlDoc += "</tr>";
                     
                     htmlTableBody += htmlDoc;
                 }
                 
                 document.getElementById("shiftRecordsTableBody").innerHTML = htmlTableBody;
             });
        }

        // 依照月份取得備註
        function changeRemarkMonth() {
            $.get('changeRemarkMonth', {
                month : document.getElementById('month').value
            }, function(array) {
                htmlTableBody = "";
                for(i = 0; i < array.length; i++) {
                    htmlDoc = "<tr>";
                    htmlDoc += "<td class='td-padding td-w-5' >" +  array[i]['author']+ "</td>";
                    htmlDoc += "<td class='td-padding td-w-5' >" +  array[i]['date']+ "</td>";
                    htmlDoc += "<td class='td-padding td-w-20' >" +  array[i]['content']+ "</td>";
                    htmlDoc +=  "</tr>";
                    htmlTableBody += htmlDoc;
                }

                document.getElementById("remarkTableBody").innerHTML = htmlTableBody;
               
            });
        }

        
        function checkStatus(id) {
            $.get('getScheduleInfo', {
                id : id
            }, function(array) {
                if(array[0]['status'] !=1){
                     alert("此班表已變動，無法確認換班");
                }
                
                else if(array[0]['doc1Location']>=2){
                    alert(array[0]['doc1']+"醫生本週已有2班非值登院區班");
                   
                }

                else if(array[0]['doc2Location']>=2){
                    alert(array[0]['doc2']+"醫生本週已有2班非值登院區班");
                     
                    
                }

                else if(array[0]['date2'] == array[0]['date1']  ){
                    if(array[0]['doc1Night']!=0){
                        alert( array[0]['doc1']+ " 在 " + array[0]['date1']+"前一晚已有夜班\n無法換班嗎")
                        refresh();
                    }

                     else if(array[0]['doc2Night']!=0){
                        alert( array[0]['doc2']+ " 在 " + array[0]['date2']+"前一天已有夜班\n無法換班嗎");
                        refresh();
                    }
                    else if(array[0]['doc1Day']!=0){
                        alert( array[0]['doc1']+ " 在 " + array[0]['date1']+"後一天已有早班\n無法換班嗎");
                        refresh();
                        
                    }
                    else if(array[0]['doc2Night']!=0){
                        alert( array[0]['doc2']+ " 在 " + array[0]['date2']+"前一天已有夜班\n無法換班嗎");
                        refresh();
                       
                    }
                    else{
                     checkShift(id);
                    }
                    
                }

                else if(array[0]['count1']!=0){
                    alert(array[0]['doc1']+"醫生"+array[0]['date1']+"已有班");
                    //dhtmlx.message({ type:"error", text:array[0]['doc1']+"醫生"+array[0]['date1']+"已有班" });
                    refresh();
                    console.log("doc1"+array[0]['count1']);

                }

                else if(array[0]['count2']!=0){
                    alert(array[0]['doc2']+"醫生"+array[0]['date2']+"已有班");
                    //dhtmlx.message({ type:"error", text:array[0]['doc2']+"醫生"+array[0]['date2']+"已有班" });
                    refresh();
                    console.log("doc2"+array[0]['count2']);
                }

                else if ( array[0]['doc1Night']!=0 || array[0]['doc1Day']!=0 ){
                    
                    if(array[0]['doc1Night']!=0){
                        alert(array[0]['doc1']+ " 在 " + array[0]['date1']+"前一晚已有夜班\n無法換班")
                        refresh();
                    }
                    else if(array[0]['doc1Day']!=0){
                        alert(array[0]['doc1']+ " 在 " + array[0]['date1']+"後一天已有白班\n無法換班")
                        refresh();
                    }

                   
                    
                }

                else if ( array[0]['doc2Night']!=0 || array[0]['doc2Day']!=0 ){
                   if(array[0]['doc2Night']!=0){
                        alert(array[0]['doc2']+ " 在 " + array[0]['date2']+"前一晚已有夜班\n無法換班");
                        refresh();
                    }
                    else if(array[0]['doc2Day']!=0){
                        alert(array[0]['doc2']+ " 在 " + array[0]['date2']+"後一天已有白班\n無法換班");
                        refresh();
                    }
                   
                                    
                }
                // else if(array[0]['doc1off']!=0){
                //         var r = confirm( array[0]['doc1']+ " 在 " + array[0]['date1']+"已有off班?\n確定要換班嗎dd?");
                //             if (r == true) {
                //                 checkShift(id);
                //             } 
                //             else {
                //                 alert("已取消");
                //                 refresh();
                //             }
                // }
                // else if(array[0]['doc2off']!=0){
                //         var r = confirm( array[0]['doc2']+ " 在 " + array[0]['date2']+"已有off班?\n確定要換班嗎33");
                //             if (r == true) {
                //                 checkShift(id);
                //             } 
                //             else {
                //                 alert("已取消");
                //                 refresh();
                //             }
                //     }
            
                else{
                    checkShift(id);
                }
                
               
            });
            
        }
        function checkShift(id) {
            $.get('checkShift', {
                id:id
            }, function() {
                location.reload();
            });
        }

        function save(){
            var ID_1 = document.getElementById('date1').value;
            var ID_2 = document.getElementById('date2').value;

            var doctorID_1 = document.getElementById('schID_1_doctor').value;
            var doctorID_2 = document.getElementById('schID_2_doctor').value;

            if(ID_1 == ""){
                dhtmlx.message({ type:"error", text:"請選擇日期" });

            }
            else if(ID_1 == ID_2){
                     dhtmlx.message({ type:"error", text:"請選擇不同時段醫生" });
            }

            else if(ID_2 == ""){
                    dhtmlx.message({ type:"error", text:"請選擇醫生" });
            }

            else if(doctorID_1 == doctorID_2){
                    dhtmlx.message({ type:"error", text:"請選擇不同醫生" });
            }

            

            else{
                save_form_alert();
            }

        }

         function save_form_alert(){
            
            $.get('checkDocStatus',{
            scheduleID_1 : document.getElementById('date1').value,
            scheduleID_2 : document.getElementById('schID_2_doctor').value,

            }, function(array){
                var ID_1 = document.getElementById('date1').value;
                var ID_2 = document.getElementById('schID_2_doctor').value;    

                var weekday1 = array[0]['weekday1'];
                var weekday2 = array[0]['weekday2'];
                
                if(array[0]['doc1Location']>=2){
                    //alert(array[0]['doc1']+"醫生本週已有2班非值登院區班");
                    dhtmlx.message({ type:"error", text:array[0]['doc1']+"醫生本週已有2班非值登院區班" });
                    
                }

                else if(array[0]['doc2Location']>=2){
                    //alert(array[0]['doc2']+"醫生本週已有2班非值登院區班");
                     dhtmlx.message({ type:"error", text:array[0]['doc2']+"醫生本週已有2班非值登院區班" });
                     
                }

                else if(array[0]['doc1Major'] != 0){
                    //alert(array[0]['doc1']+"醫生非該科醫生");
                     dhtmlx.message({ type:"error", text:array[0]['doc2']+"醫生非該科醫生" });
                     
                }

                else if(array[0]['doc2Major'] != 0){
                    alert(array[0]['doc2']+"醫生非該科醫生");
                     //dhtmlx.message({ type:"error", text:array[0]['doc2']+"醫生本週已有2班非值登院區班" });
                     refresh();
                }
                else if(array[0]['date2'] == array[0]['date1']  ){
                    if(array[0]['doc2Night']!=0){
                        alert(array[0]['doc2']+ " 在 " + array[0]['date2']+"前一晚已有夜班\n無法換班");
                        refresh();
                        
                    }
                    else if(array[0]['doc1Night']!=0){
                        alert(array[0]['doc1']+ " 在 " + array[0]['date1']+"前一晚已有夜班\n無法換班");
                        refresh();
                    }
                    else if(array[0]['doc1Day']!=0){
                        alert(array[0]['doc1']+ " 在 " + array[0]['date1']+"後一天已有早班\n無法換班");
                        refresh();
                    }
                    else if(array[0]['doc2Day']!=0){
                        alert(array[0]['doc2']+ " 在 " + array[0]['date2']+"後一天已有早班\n無法換班");
                        refresh();
                    }
                    else{
                        save_form();
                    }
                }

                else if(array[0]['count1']!=0){
                    dhtmlx.message({ type:"error", text:array[0]['doc1']+"醫生"+array[0]['date1']+"已有班" });
                    console.log("doc1"+array[0]['date1']);

                }

                else if(array[0]['count2']!=0){
                    dhtmlx.message({ type:"error", text:array[0]['doc2']+"醫生"+array[0]['date2']+"已有班" });
                    console.log("doc2"+array[0]['date2']);
                }

                

                else if (array[0]['doc1Night']!=0 || array[0]['doc1Day']!=0 ){
                    if(array[0]['doc1Night']!=0 ){
                       alert(array[0]['doc1']+ " 在 " + array[0]['date1']+"前一晚已有夜班\n無法換班56");
                    }

                    else if(array[0]['doc1Day']!=0){
                        alert(array[0]['doc1']+ " 在 " + array[0]['date1']+"後一天已有早班\n無法換班");
                        refresh();
                    }

                    
                }

                else if( array[0]['doc2Night']!=0 || array[0]['doc2Day']!=0){
                    console.log("night"+array[0]['doc2Night']);
                    
                    if(array[0]['doc2Night']!=0 ){
                        alert(array[0]['doc2']+ " 在 " + array[0]['date2']+"前一晚已有夜班\n無法換班");
                        refresh();
                    }

                    else if(array[0]['doc2Day']!=0){
                        alert(array[0]['doc2']+ " 在 " + array[0]['date2']+"後一天已有早班\n無法換班");
                        refresh();
                    }

                    
                   
                }
                else if(array[0]['doc1off']!=0){
                        var r = confirm( array[0]['doc1']+ " 在 " + array[0]['date1']+"已有off班?\n確定要換班嗎");
                            if (r == true) {
                                updateShift(scheduleID_1,scheduleID_2);
                            }
                            else {
                                alert("已取消");
                                refresh();
                            }
                }
                else if(array[0]['doc2off']!=0){
                        var r = confirm( array[0]['doc2']+ " 在 " + array[0]['date2']+"已有off班?\n確定要換班嗎");
                            if (r == true) {
                                save_form();
                            } 
                            else {
                                alert("已取消");
                                refresh();
                            }
                    }

                // else if( (array[0]['doc1weekend']<=4) && ( weekday2==6 || weekday2 ==7)  && ( weekday1!=6 && weekday1!=7) ){
                //     dhtmlx.message({ type:"error", text:array[0]['doc1']+"醫生假日班不得少於4" });
                //     console.log("$week1"+weekday1);
                //     console.log("$week1"+weekday2);
                // }
                // else if((array[0]['doc2weekend']<4) &&  ( weekday1==6 || weekday1 ==7) && ( weekday2!=6 && weekday2!=7) ){
                //     dhtmlx.message({ type:"error", text:array[0]['doc2']+"醫生假日班不得少於4" });

                // }

                else{
                save_form();

                }
                    console.log("$week1"+weekday1);
                    console.log("$week1"+weekday2);
                
           });

        }

           function refresh() {
            location.reload();
        }
         function save_form() {
            $.get('addShifts', {
                scheduleID_1 : document.getElementById('date1').value,
                scheduleID_2 : document.getElementById('schID_2_doctor').value
                
            }, function (){
               location.reload();
            });

        }
    </script>
@endsection
