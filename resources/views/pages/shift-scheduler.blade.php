@extends("layouts.app2")

@section('head')
    <script src="../codebase/ext/dhtmlxscheduler_collision.js"></script>
    <script src="../codebase/ext/dhtmlxscheduler_limit.js"></script>
    <script src="../../codebase/ext/dhtmlxscheduler_serialize.js" type="text/javascript" charset="utf-8"></script>
    
    <style>
        td{
            padding: 0;
        }
        .block_section {
            background-color: white;
            opacity: 0;
            filter: alpha(opacity = 0);
        }
    </style>
@endsection

@section('navbar')
    <font class="brand-logo light">調整班表 <i class="material-icons arrow_right-icon">keyboard_arrow_right</i>正式班表</font>
@endsection

@section('content')
<input type='hidden' id="getDate">
 <input type="hidden" id="scheduleID_2" value=""><!--不能刪 -->
  <input type="hidden" id="scheduleID_1" value=""><!--不能刪 -->
  <input type="hidden" id="shiftDate" value=""> <!--不能刪 -->
 <input type="hidden" id="shiftSessionID" value=""> <!--不能刪 -->
    <div id="section" class="container-fix trans-left-five">    <!--     style="background-color:red;"-->
        <div class="container-section">
            <div class="row">
                <div class="col s12 m12">
                    <div class="card border-t">
                       
                     
                        
                        <div id="my_form">
                            <!-- <form action="change-shift-first-edition" method="post" > -->
                            <div class="modal-header">
                                <h5 class="modal-announcement-title">換班調整</h5>
                            </div>
                            <div class="lightbox">
                                <div class="row margin-b0">
                                    <div class="col s12 center padding-b10">
                                        <img src="../img/exchange.svg" style="height: 220px;width: 220px;">
                                    </div>
                                     <div class="col s6">
                                        <label>醫生:</label>   <!-- 要求換班 -->
                                        <select name= 'schID_1_doctor' class="browser-default" id="schID_1_doctor" onchange="changeDoctor_1()" required>
                                            <option  disabled selected>請選擇醫生</option>
                                                <option disabled value=""></option>
                                                @foreach($doctorName as $name)
                                                <option value="{{$name->doctorID}}">{{$name->name}} </option>
                                                @endforeach
                                        </select>
                                    </div>

                                   <!--  <div class="col s6">
                                        <label>醫生:</label>
                                        <select name= 'schID_2_doctor' class="browser-default" id="schID_2_doctor" onchange="changeDoctor()" required>
                                            <option value="" disabled selected>請選擇醫生</option> 
                                            @foreach($doctorName as $name)
                                            <option value="{{$name->doctorID}}">{{$name->name}}</option>
                                            @endforeach
                                        </select>
                                    </div> -->

                                      <div class="col s6">  <!--換班日期  資料庫拉資料--> 
                                        <label>日期:</label>
                                        <select  name='scheduleID_2' class="browser-default" id="date2" onchange="changeDoctor()" required>
                                            <option value="" disabled selected>請選擇日期</option>
                                            <option value=""></option>
                                        </select>
                                    </div>

                                    <div class="col s6">
                                        <label>日期:</label><!-- 要求換班日期 -->
                                        <select name="scheduleID_1" class="browser-default" id="date1" required>
                                            <option value="" disabled selected>請選擇日期</option>
                                            <option value=""></option>

                                        </select>
                                    </div>

                                   <!--  <div class="col s6">  換班日期  資料庫拉資料 
                                        <label>日期:</label>
                                        <select  name='scheduleID_2' class="browser-default" id="date2" required>
                                            <option value="" disabled selected>請選擇日期</option>
                                            <option value=""></option>
                                        </select>
                                    </div> -->

                                     <div class="col s6">
                                        <label>醫生:</label> <!-- 換班醫生 -->
                                        <select name= 'schID_2_doctor' class="browser-default" id="schID_2_doctor"  required>
                                            <option value="" disabled selected>請選擇醫生</option> 
                                             <option value=""></option>
                                            <!-- @foreach($doctorName as $name) -->
                                            <!-- <option value="{{$name->doctorID}}">{{$name->name}}</option> -->
                                            <!-- @endforeach -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="lightbox-footer">
                                
                                <button type="submit" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save modal-btn" onclick="save()">Save</button>
                                <button class="modal-action modal-close waves-effect waves-light btn-flat btn-cancel modal-btn" onclick="close_form()">Cancel</button>
                            </div>

                        <!-- </form> -->
<!--
                            <label for="description">Event text </label><input type="text" name="description" value="" id="description"><br>
                            <label for="custom1">Custom 1 </label><input type="text" name="custom1" value="" id="custom1"><br>
                            <label for="custom2">Custom 2 </label><input type="text" name="custom2" value="" id="custom2"><br><br>
                            <input type="button" name="save" value="Save" id="save" style='width:100px;' onclick="save_form()">
                            <input type="button" name="close" value="Close" id="close" style='width:100px;' onclick="close_form()">
                            <input type="button" name="delete" value="Delete" id="delete" style='width:100px;' onclick="delete_event()">
-->
                        </div>
                        
                        <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
                            <div class="dhx_cal_navline">
                                <div class="dhx_cal_prev_button"></div>
                                <div class="dhx_cal_next_button"></div>
                                <div class="dhx_cal_today_button"></div>
                                <div class="dhx_cal_date"></div>
                                <div class="dhx_cal_tab margin-l20 noUnderline">
                                    <form action="shift-scheduler-personal" method="post">
                                        <font class="dhx-font">醫師:</font>
                                        <select  name="doctor" class="browser-default select-custom" required>
                                            <option value="" disabled selected>選擇醫師</option>
                                            @foreach($doctorName as $name)
                                                <option value="{{$name->doctorID}}">{{$name->name}} </option>
                                            @endforeach
                                        </select>
                                        <button class="dhx_cal_tab submit-inline" type="submit">確認</button>
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                                
                            </div>
                            <div class="dhx_cal_header">
                            </div>
                            <div class="dhx_cal_data">
                            </div>      
                        </div>

                        <script type="text/javascript" charset="utf-8">
                    
                            scheduler.locale.labels.timeline_tab = "Timeline";
                            scheduler.locale.labels.section_custom="Section";
                            scheduler.config.details_on_create=true;
                            scheduler.config.details_on_dblclick = true;
                            scheduler.config.xml_date="%Y-%m-%d %H:%i";
//                            scheduler.config.readonly = true;   //唯讀，不能修改東西
//                            scheduler.config.dblclick_create = false;   //雙擊新增
                            scheduler.config.drag_create = false;   //拖拉新增
                            scheduler.xy.margin_left = -19;
                            scheduler.config.container_autoresize = true;
                            scheduler.config.collision_limit = 2; 
                            scheduler.config.drag_resize= false;

                            scheduler.form_blocks["hidden"] = {
                                render:function(sns) {
                                    return "<div class='dhx_cal_ltext'><input type='hidden'></div>";
                                },
                                set_value:function(node, value, ev) {
                                    node.childNodes[0].value = value || "";
                                },
                                get_value:function(node, ev) {
                                    return node.childNodes[0].value;
                                },
                                focus:function(node) {
                                    var a = node.childNodes[0];
                                    a.select();
                                    a.focus();
                                }
                            };
                            //彈出視窗的選項
                            scheduler.config.lightbox.sections=[
                               
                                {name:"hidden", height:400, map_to:"hidden", type:"hidden" , focus:true}
                            ];
                            //===============
                            //Configuration
                            //===============
                            var sections=[
                                {key:1, label:"行政"},
                                {key:2, label:"教學"},
                                {key:3, label:"北白急救"},
                                {key:4, label:"北白發燒"},
                                {key:5, label:"北白內1"},
                                {key:6, label:"北白內2"},
                                {key:7, label:"北白外1"},
                                {key:8, label:"北白外2"},
                                {key:9, label:"淡白內1"},
                                {key:10, label:"淡白內2"},
                                {key:11, label:"淡白外1"},
                                {key:12, label:"淡白外1"},
                                {key:13, label:"北夜急救"},
                                {key:14, label:"北夜發燒"},
                                {key:15, label:"北夜內1"},
                                {key:16, label:"北夜內2"},
                                {key:17, label:"北夜外1"},
                                {key:18, label:"北夜外2"},
                                {key:19, label:"淡夜內1"},
                                {key:20, label:"淡夜內2"},
                                {key:21, label:"淡夜外"}
                            ];
                            scheduler.createTimelineView({
                                name:   "timeline",
                                x_unit: "day",
                                x_date: "%d %D",
                                x_step: 1,
                                x_size: 14,
                                y_unit: sections,
                                y_property: "section_id",
                                render:"bar",
                                round_position:true,    //有點像磁石
                                event_dy: 46,
                            });
                            
                            //===============
                            //Customization
                            //===============
                            //週末有特別顏色
                            scheduler.templates.timeline_cell_class = function(evs,x,y){
                                var day = x.getDay();
                                return (day==0 || day == 6) ? "yellow_cell" : "white_cell";
                            };
                            scheduler.templates.timeline_scalex_class = function(date){
                                if (date.getDay()==0 || date.getDay()==6)  return "yellow_cell";
                                return "";
                            }
                            
                            
                            //test
                            
//                            scheduler.attachEvent("onBeforeDrag", function (id, mode, e){
//                                dragged_event=scheduler.getEvent(id); //use it to get the object of the dragged event
//                                console.log("123");
//                                return true;
//                            });
//
//                            scheduler.attachEvent("onDragEnd", function(){
//                                var event_obj = dragged_event;
//                                console.log("555");
//                            });
                            
                            //更改timeline event 文字
                            scheduler.templates.event_bar_text = function(start,end,event){
                                var mode = scheduler.getState().mode;
                                var text;
                                if(mode == "timeline"){
                                    text = "<center class='timeline-event-text'>"+event.text+"</center>";
                                }
                                else {
                                    text = "text for other views";
                                } 
                                return text;
                            };
                            
                            //增加最左邊欄位的class
                            scheduler.templates.timeline_scaley_class = function(key, label, section){ 
                                return "width-200";
                            };
                            
                            //彈出客制化的lightbox
                            var html = function(id) { return document.getElementById(id); }; //just a helper
                            scheduler.showLightbox = function(id) {
                                var ev = scheduler.getEvent(id);
                                var date =Date.parse(document.getElementById("getDate").value).valueOf();

                                var now  = new Date();
                                var today = Date.parse(now.getFullYear()+"-"+(now.getMonth()+2)+"-1").valueOf();

                                window.scrollTo(0,0);  //開啟後移動到最上面
                                
                                if(ev.text == "New"){
                                    scheduler.startLightbox(id, html("my_form1"));
                                } 
                                // else if(date>today){
                                //     console.log('nothing');
                                // }
                                else {
                                    scheduler.startLightbox(id, html("my_form"));
                                }
                                console.log("111"+date);
                                console.log("111"+today);
                                console.log(now.getFullYear()+"-"+(now.getMonth()+2)+"-1");
                                
                                // var doctorID = ["1"];
                                // var doctorName = ["張國頌"];
                                // var array = doctorName.indexOf(ev.text);
                                
                                // if (ev.text == "New" || ev.text == "") {
                                //     var id = "";
                                // } else {
                                //     var id = doctorID[array];
                                // }
                                
                                    //html("schID_2_doctor").focus();
                                    //html("schID_2_doctor").value = id;
//                                  html("custom1").value = ev.custom1 || "";
//                                  html("custom2").value = ev.custom2 || "";
                            };
                           
                            
//                            scheduler.attachEvent("onEventAdded", function(id,e){
//                                console.log("5345");
//                                var ev = scheduler.getEvent(scheduler.getState().lightbox_id);
//                                
//                                var doctorID = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"];
//                                var doctorName = ["王志平", "黃明源", "莊錦康", "簡立仁", "陳長志", "劉良嶸", "陳楷宏", "黃明源", "鄭婓茵", "劉蕙慈", "柳志翰", "蘇柏樺"];
//                                
//                                var array = doctorName.indexOf(ev.text);
//                                
//                                var name = doctorName[array];
//                                
//                                ev.text = name;
//                            }
                            
                            var date = new Date();
                            var toString =  date.toString();
                            var res = toString.split(" ");
                            var month = 0;
                            switch(res[1]){
                                case "Jan":
                                    month = 1;
                                    break;
                                case "Feb":
                                    month = 2;
                                    break;
                                case "Mar":
                                    month = 3;
                                    break;
                                case "Apr":
                                    month = 4;
                                    break;
                                case "May":
                                    month = 5;
                                    break;
                                case "Jun":
                                    month = 6;
                                    break;
                                case "Jul":
                                    month = 7;
                                    break;
                                case "Aug":
                                    month = 8;
                                    break;
                                case "Sep":
                                    month = 9;
                                    break;
                                case "Oct":
                                    month = 10;
                                    break;
                                case "Nov":
                                    month = 11;
                                    break;
                                case "Dec":
                                    month = 12;
                                    break;
                            }
                             //鎖定時間
                            var startd =new Date(res[3], month, 1); 
                            var endd = new Date(res[3], month+1, 1); 

                            var block_startd =new Date(res[3], month-1, 1); 
                            var block_endd = new Date(res[3], month, 1); 

                            console.log("startd "+startd);
                            console.log("endd "+endd);

                            scheduler.config.limit_start = new Date(block_startd);
                            scheduler.config.limit_end = new Date(endd);

                            scheduler.attachEvent("onLimitViolation", function  (id, obj){
                                dhtmlx.message({ type:"error", text:"此時段無法接受換班" })
                            });

                             //限制非當月利用點擊視窗換班
                            scheduler.addMarkedTimespan({  
                                start_date: '1900-1-1',
                                end_date:   block_startd,
                                zones: "fullday", 
                                css: "block_section", 
                                type: "dhx_time_block"
                            
                            });

                            //scheduler.updateView();
                           
                            
                            
                            // //空白處新增醫生班表
                            // scheduler.attachEvent("onBeforeEventChanged", function(ev, e, is_new, original){
                                
                            //     addNewSchedule(ev.start_date,ev.section_id);
                            //     showScheduleInfo(ev.start_date,ev.section_id);
                            //     return true;
                            // });
                            // scheduler.attachEvent("onEventChanged", function (id, e){
                            //     var event = scheduler.getEvent(id);
                            //     getScheduleID(event.hidden);
                            //     return true;
                            // });


                            //空白處新增醫生班表
                            scheduler.attachEvent("onBeforeEventChanged", function(ev, e, is_new, original){

                                showScheduleInfo(ev.start_date,ev.section_id,ev.hidden);

                                console.log("111"+ev.text);
                                console.log("111"+ev.start_date+ev.hidden);

                                return true;
                            });

                            scheduler.attachEvent("onEventChanged", function (id, e){
                                var event = scheduler.getEvent(id);
                               
                                checkDoctorSchedule(event.hidden); //schedule id

                                return true;
                            });


                            scheduler.attachEvent("onClick", function (id, e){
                                var event = scheduler.getEvent(id);
                            
                                changeDoctor_1(event.hidden);
                                return true;
                            });
                           
                           
                            //進入畫面後顯示的東西
                            scheduler.init('scheduler_here',new Date(res[3], month-1),"timeline");
                            scheduler.parse([
                                @foreach($schedule as $data)
                                 { start_date: "{{ $data->date }} 00:00", end_date: "{{ $data->endDate }} 00:00", text:"{{ $data->doctorID }}", section_id:"{{ $data->schCategorySerial }}" ,hidden:"{{ $data->scheduleID}}" },
                               
                                @endforeach
                            ],"json");
                            
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<!--
    <div id="modal1" class="modal modal-fixed-footer modal-announcement">
        <form action="" method="post">
            <div class="modal-header">
                <h5 class="modal-announcement-title">新增</h5>
            </div>
            
            <div class="modal-content modal-content-customize1">
                <div class="row margin-b0">
                    <div class="input-field col s12 margin-b20">
                        <select name="doctor" required>
                            <option value="" selected disabled>選擇醫生</option>
                            <option value="1">簡定國</option>
                            <option value="2">簡定國</option>
                            <option value="3">簡定國</option>
                            <option value="4">簡定國</option>
                            <option value="5">簡定國</option>
                            <option value="6">簡定國</option>
                            <option value="7">簡定國</option>
                            <option value="8">簡定國</option>
                            <option value="9">簡定國</option>
                            <option value="10">簡定國</option>
                        </select>
                        <label>醫生</label>
                    </div>
                    <div class="input-field col s12 margin-b20">
                        <select name="level" required>
                            <option value="" selected disabled>選擇班種</option>
                            <option value="1">行政</option>
                            <option value="2">教學</option>
                            <option value="3">北白急救</option>
                            <option value="4">北白發燒</option>
                            <option value="5">北白內1</option>
                            <option value="6">北白內2</option>
                            <option value="7">北白外1</option>
                            <option value="8">北白外2</option>
                            <option value="9">淡白內1</option>
                            <option value="10">淡白內2</option>
                            <option value="11">淡白外1</option>
                            <option value="12">淡白外1</option>
                            <option value="13">北夜急救</option>
                            <option value="14">北夜發燒</option>
                            <option value="15">北夜內1</option>
                            <option value="16">北夜內2</option>
                            <option value="17">北夜外1</option>
                            <option value="18">北夜外2</option>
                            <option value="19">淡夜內1</option>
                            <option value="20">淡夜內2</option>
                            <option value="21">淡夜外</option>
                        </select>
                        <label>班種</label>
                    </div>
                    <div class="input-field col s12 margin-b20">
                        <select name="level" required>
                            <option value="" selected disabled>選擇日期</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                        </select>
                        <label>日期</label>
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
-->
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('select').material_select();
        });
    
         function changeDoctor_1(id){ //醫生1
            $.get('changeDoctor1',{
                id : id
            }, function(array){
                document.getElementById("schID_1_doctor").innerHTML= "<option value="+array[3]+">"+array[1]+"-"+array[4]+"</option>";
                changeDate1(array);
            });
        }

        function changeDoctor() { //醫生2
            $.get('changeDoctor', {
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

            console.log("date"+document.getElementById("date1").value);
        }

        function changeDate1(array) { //要求換班日期
                document.getElementById("date1").innerHTML= "<option value="+array[0]+">"+array[2]+"</option>" 

                changeDate2(array[2],array[3]);
        }

        function changeDate2(date,doctorID){
            $.get('changeDate2' ,{
                date:date,
                doctorID : doctorID
            },function(array){
                var date = "";
                for(i=0 ; i<array.length ; i++){
                    date += "<option value="+array[i][0]+">"+array[i][0]+"</option>";
                    console.log('1'+array[2]);
                }
                document.getElementById("date2").innerHTML  = date;
                changeDoctor();
            });

        
            
        }

        function alert1() {
                alert("不可選擇相同醫生相同時段");
        }

        function updateShift(scheduleID_1,scheduleID_2){
            $.post('sendShiftUpdate',{
                scheduleID_1:scheduleID_1,
                scheduleID_2:scheduleID_2
            }, function(){
                //alert("換班成功");
                //refresh();
                showInfo(scheduleID_1,scheduleID_2);   
            });
            //alert(schedule_1+"和"+schedule_2+"換班成功");
        }

        function showInfo(scheduleID_1,scheduleID_2) {
            $.get('showInfo', {
                id : scheduleID_1,
                id2 : scheduleID_2
            }, function (array){
                // dhtmlx.message({ type:"error", text: array[2]+array[1]+"\n和\n"+array[0]+array[3]+"換班成功" })
                if(array[0] == ""){
                    alert(array[2]+array[1]+"的班換至"+array[3]);
                }
                else{
                    alert(array[2]+array[1]+"和"+array[0]+array[3]+"換班成功");
                }
                refresh();
            });
        }

        function refresh() {
            location.reload();
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

            else if(doctorID_2 == ""){
                    dhtmlx.message({ type:"error", text:"請選擇醫生" });
            }

            else if(doctorID_1 == doctorID_2){
                    dhtmlx.message({ type:"error", text:"請選擇不同醫生" });
            }

            else{
                save_form_alert();
            }

            console.log("111+"+doctorID_1);
            console.log("111+"+doctorID_2);

        }

        
       function save_form_alert(){

            $.get('checkDocStatus',{
            scheduleID_1 : document.getElementById('date1').value,
            scheduleID_2 : document.getElementById('schID_2_doctor').value,

            }, function(array){

                var  scheduleID_1 = document.getElementById('date1').value;
                var  scheduleID_2 = document.getElementById('schID_2_doctor').value;

                var weekday1 = array[0]['weekday1'];
                var weekday2 = array[0]['weekday2'];

                var date = array[0]['date2'];


                if(array[0]['doc2']==null){
                    updateShift(scheduleID_1,scheduleID_2);
                }

                else if(array[0]['doc1Location']>=2){
                    alert(array[0]['doc1']+"醫生本週已有2班非值登院區班");
                    //dhtmlx.message({ type:"error", text:array[0]['doc1']+"醫生本週已有2班非值登院區班" });
                   
                }

                else if(array[0]['doc2Location']>=2){
                    alert(array[0]['doc2']+"醫生本週已有2班非值登院區班");
                     //dhtmlx.message({ type:"error", text:array[0]['doc2']+"醫生本週已有2班非值登院區班" });
                    
                }

                else if(array[0]['date2'] == array[0]['date1']  ){
                    if(array[0]['doc1Night']!=0){
                        var r = confirm( array[0]['doc1']+ " 在 " + array[0]['date1']+"前一晚已有夜班?\n確定要換班嗎");
                            if (r == true) {
                                updateShift(scheduleID_1,scheduleID_2);
                            } 
                            else {
                                alert("已取消");
                                refresh();
                            }
                    }
                     else if(array[0]['doc2Night']!=0){
                        var r = confirm( array[0]['doc2']+ " 在 " + array[0]['date2']+"前一晚已有夜班?\n確定要換班嗎");
                            if (r == true) {
                                updateShift(scheduleID_1,scheduleID_2);
                            } 
                            else {
                                alert("已取消");
                                refresh();
                            }
                    }
                    else{
                     updateShift(scheduleID_1,scheduleID_2);
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

                else if (array[0]['doc1off']!=0 || array[0]['doc1Night']!=0 ){
                    if(array[0]['doc1off']!=0 && array[0]['doc1Night']!=0 ){
                        var r = confirm( array[0]['doc1']+ " 在 " + array[0]['date1']+"已有off班?\n且"+array[0]['date1']+"前一晚有夜班\n確定要換班嗎????");
                            if (r == true) {
                                updateShift(scheduleID_1,scheduleID_2);
                            } 
                            else {
                                alert("已取消");
                                refresh();
                            }
                    }
                    else if(array[0]['doc1off']!=0){
                        var r = confirm( array[0]['doc1']+ " 在 " + array[0]['date1']+"已有off班?\n確定要換班嗎???/");
                            if (r == true) {
                                updateShift(scheduleID_1,scheduleID_2);
                            } 
                            else {
                                alert("已取消");
                                refresh();
                            }
                    }
                    else if(array[0]['doc1Night']!=0){
                        var r = confirm( array[0]['doc1']+ " 在 " + array[0]['date1']+"前一晚已有夜班?\n確定要換班嗎");
                            if (r == true) {
                                updateShift(scheduleID_1,scheduleID_2);
                            } 
                            else {
                                alert("已取消");
                                refresh();
                            }
                    }
                }

                else if (array[0]['doc2off']!=0 || array[0]['doc2Night']!=0 ){
                    if(array[0]['doc2off']!=0 && array[0]['doc2Night']!=0 ){
                        var r = confirm( array[0]['doc2']+ " 在 " + array[0]['date2']+"已有off班?\n且"+array[0]['date2']+"前一晚有夜班\n確定要換班嗎?");
                            if (r == true) {
                                updateShift(scheduleID_1,scheduleID_2);
                            } 
                            else {
                                alert("已取消");
                                refresh();
                            }
                    }
                    else if(array[0]['doc2off']!=0){
                        var r = confirm( array[0]['doc2']+ " 在 " + array[0]['date2']+"已有off班?\n確定要換班嗎???/");
                            if (r == true) {
                                updateShift(scheduleID_1,scheduleID_2);
                            } 
                            else {
                                alert("已取消");
                                refresh();
                            }
                    }
                    else if(array[0]['doc2Night']!=0){
                        var r = confirm( array[0]['doc2']+ " 在 " + array[0]['date2']+"前一晚已有夜班?\n確定要換班嗎");
                            if (r == true) {
                                updateShift(scheduleID_1,scheduleID_2);
                            } 
                            else {
                                alert("已取消");
                                refresh();
                            }
                    }
                }

            
                else{
                    updateShift(scheduleID_1,scheduleID_2);
                }
                
               
             });

                
                console.log("aa"+document.getElementById('scheduleID_1').value);
                console.log("bb"+document.getElementById('scheduleID_2').value);
        }

    
        function save_form() {
            $.get('change-shift-first-edition', {
                scheduleID_1 : document.getElementById('date1').value,
                scheduleID_2 : document.getElementById('date2').value
                
            }, function (){
                scheduler.endLightbox(true, html("my_form"));
                refresh();
            });

        }

        function close_form() {               
            scheduler.endLightbox(false, html("my_form"));             
        }
        
        function checkDoctorSchedule(id){
            document.getElementById("scheduleID_1").value=id;
            $.get('checkDoctorSchedule',{
                scheduleID : id, // event id
                date: document.getElementById("shiftDate").value, //空格日期
                classification:document.getElementById("shiftSessionID").value //空格
    
            }, function(array){
                var scheduleID = id;
                var classification = document.getElementById("shiftSessionID").value;
                var date = document.getElementById("shiftDate").value;

                var weekday = array[0]['weekDay'];
                var weekDayInSchedule =array[0]['weekDayInSchedule'];
                console.log("aa"+array[0]['location']);

                if (array[0]['location'] !=0){
                    alert(array[0]['docName']+"醫生這週已有2班非直登院區班" );
                    refresh();
                }

                else if (array[0]['major'] !=0){
                    alert(array[0]['docName']+"醫生非該科醫生" );
                    refresh();
                }

                else if(id==array[0]['scheduleID']){
                    console.log("111");
                }

                else if(array[0]['date'] == array[0]['dateInSchedule'] && array[0]['scheduleID']!=0 ){
                    checkDocStatus(id,array[0]['scheduleID']);
                }

                // else if(array[0]['date'] == array[0]['dateInSchedule']){
                //      if(array[0]['countNight'] != 0){
                //         var r = confirm( array[0]['docName']+ " 在 " + array[0]['date']+"前一晚已有夜班?\n確定要增班嗎");

                //             if (r == true) {
                //                 updateSchedule(scheduleID,date,classification);
                //             } 
                //             else {
                //                 alert("已取消");
                //                 refresh();
                //             }
                //     }
                //     else{
                //         updateSchedule(scheduleID,date,classification);
                //     }
                    
                // }

                // else if(array[0]['count']!=0){
                //     alert(array[0]['docName']+"醫生"+array[0]['date']+"已有班" );
                //     //dhtmlx.message({ type:"error", text:array[0]['docName']+"醫生"+array[0]['date']+"已有班" });
                //     refresh();
                // }

                // else if (array[0]['countOff']!=0 || array[0]['countNight']!=0){

                //      if(array[0]['countOff']!=0 && array[0]['countNight']!=0){
                //         var r = confirm( array[0]['docName']+ " 在 " + array[0]['date']+"已有off班?\n且"+ array[0]['date']+"前一晚已有夜班\n確定要增班嗎");

                //             if (r == true) {
                //                 updateSchedule(scheduleID,date,classification);
                //             } 
                //             else {
                //                 alert("已取消");
                //                 refresh();
                //             }
                //     }

                //     else if(array[0]['countOff']!=0){
                //         var r = confirm( array[0]['docName']+ " 在 " + array[0]['date']+"已有off班?\n確定要換班嗎");

                //             if (r == true) {
                //                 updateSchedule(scheduleID,date,classification);
                //             } 
                //             else {
                //                 alert("已取消");
                //                 refresh();
                //             }
                //     }

                //     else if(array[0]['countNight'] != 0){
                //         var r = confirm( array[0]['docName']+ " 在 " + array[0]['date']+"前一晚已有夜班?\n確定要增班嗎");

                //             if (r == true) {
                //                 updateSchedule(scheduleID,date,classification);
                //             } 
                //             else {
                //                 alert("已取消");
                //                 refresh();
                //             }
                //     }
                    
                    
                // }
                
                
                else if(array[0]['scheduleID']!=0){
                    document.getElementById("scheduleID_2").value=array[0]['scheduleID'];
                    checkDocStatus(id,array[0]['scheduleID']);
                }
                 
             

                // else if(array[0]['docWeekend']<=4 && (weekday != 6 && weekday != 7) && (weekDayInSchedule==6 || weekDayInSchedule==7)){
                //     var check= confirm(array[0]['docName']+"醫生假日班不得少於4\n確定要換班嗎?");
                //     if(check==true){
                //         updateSchedule(scheduleID,date,classification);
                //     }
                //     else{
                //         alert("已取消");
                //         refresh();
                //     }
                //      console.log(array[0]['docWeekend']);
                //      console.log(weekday);
                // }
                else {
                    refresh();
                //     //updateSchedule(scheduleID,date,classification);
                    
                 }
                // // console.log(id);
                // console.log(array[0]['scheduleID']);
                console.log("id"+id);
                console.log("sc2"+array[0]['scheduleID'])

               
            });


         }
         function checkDocStatus(scheduleID_1,scheduleID_2){
            $.get('checkDocStatus',{
                scheduleID_1:scheduleID_1,
                scheduleID_2:scheduleID_2
                
            }, function(array){ 
        
                // var scheduleID_1= document.getElementById('scheduleID_1').value;
                // var scheduleID_2= document.getElementById('scheduleID_2').value;

                console.log("abc"+array[0]['doc1']+array[0]['doc1Location']);
                console.log("abc"+array[0]['doc2']+array[0]['doc2Location']);

                var weekday1 = array[0]['weekday1'];
                var weekday2 = array[0]['weekday2'];

                var date = array[0]['date2'];

                if(array[0]['doc1Location']>=2){
                    alert(array[0]['doc1']+"醫生本週已有2班非值登院區班");
                    //dhtmlx.message({ type:"error", text:array[0]['doc1']+"醫生本週已有2班非值登院區班" });
                    //refresh();
                }

                else if(array[0]['doc2Location']>=2){
                    alert(array[0]['doc2']+"醫生本週已有2班非值登院區班");
                     //dhtmlx.message({ type:"error", text:array[0]['doc2']+"醫生本週已有2班非值登院區班" });
                     //refresh();
                }

                else if(array[0]['date2'] == array[0]['date1']  ){
                     if(array[0]['doc2Night']!=0){
                        var r = confirm( array[0]['doc2']+ " 在 " + array[0]['date2']+"前一晚已有夜班?\n確定要換班嗎");
                            if (r == true) {
                                updateShift(array[0]['scheduleID_1'],array[0]['scheduleID_2']);
                            } 
                            else {
                                alert("已取消");
                                refresh();
                            }
                    }
                    else if(array[0]['doc1Night']!=0){
                        var r = confirm( array[0]['doc1']+ " 在 " + array[0]['date1']+"前一晚已有夜班?\n確定要換班嗎");
                            if (r == true) {
                                updateShift(array[0]['scheduleID_1'],array[0]['scheduleID_2']);
                            } 
                            else {
                                alert("已取消");
                                refresh();
                            }
                    }
                    else{
                     updateShift(array[0]['scheduleID_1'],array[0]['scheduleID_2']);
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


               else if(array[0]['doc2off']!=0 || array[0]['doc2Night']!=0){
                    console.log("night"+array[0]['doc2Night']);

                    if(array[0]['doc2off']!=0 && array[0]['doc2Night']!=0 ){
                        var r = confirm( array[0]['doc2']+ " 在 " + array[0]['date2']+"已有off班?\n且"+array[0]['date2']+"前一晚已有夜班\n確定要換班嗎");
                            if (r == true) {
                                updateShift(array[0]['scheduleID_1'],array[0]['scheduleID_2']);
                            } 
                            else {
                                alert("已取消");
                                refresh();
                            }
                    }
                    else if(array[0]['doc2off']!=0){
                        var r = confirm( array[0]['doc2']+ " 在 " + array[0]['date2']+"已有off班?\n確定要換班嗎");
                            if (r == true) {
                                updateShift(array[0]['scheduleID_1'],array[0]['scheduleID_2']);
                            } 
                            else {
                                alert("已取消");
                                refresh();
                            }
                    }
                    else if(array[0]['doc2Night']!=0){
                        var r = confirm( array[0]['doc2']+ " 在 " + array[0]['date2']+"前一晚已有夜班?\n確定要換班嗎");
                            if (r == true) {
                                updateShift(array[0]['scheduleID_1'],array[0]['scheduleID_2']);
                            } 
                            else {
                                alert("已取消");
                                refresh();
                            }
                    }
                }
                
                else if(array[0]['doc1off']!=0 || array[0]['doc1Night']!=0){
                    console.log("night"+array[0]['doc2Night']);

                    if(array[0]['doc1off']!=0 && array[0]['doc1Night']!=0 ){
                        var r = confirm( array[0]['doc1']+ " 在 " + array[0]['date1']+"已有off班?\n且"+array[0]['date1']+"前一晚已有夜班\n確定要換班嗎");
                            if (r == true) {
                                updateShift(array[0]['scheduleID_1'],array[0]['scheduleID_2']);
                            } 
                            else {
                                alert("已取消");
                                refresh();
                            }
                    }
                    else if(array[0]['doc1off']!=0){
                        var r = confirm( array[0]['doc1']+ " 在 " + array[0]['date1']+"已有off班?\n確定要換班嗎");
                            if (r == true) {
                                updateShift(array[0]['scheduleID_1'],array[0]['scheduleID_2']);
                            } 
                            else {
                                alert("已取消");
                                refresh();
                            }
                    }
                    else if(array[0]['doc1Night']!=0){
                        var r = confirm( array[0]['doc1']+ " 在 " + array[0]['date1']+"前一晚已有夜班?\n確定要換班嗎");
                            if (r == true) {
                                updateShift(array[0]['scheduleID_1'],array[0]['scheduleID_2']);
                            } 
                            else {
                                alert("已取消");
                                refresh();
                            }
                    }
                }


                else if(array[0]['date2'] == array[0]['date1']  ){
                     updateShift(array[0]['scheduleID_1'],array[0]['scheduleID_2']);
                }
                
                else{
                    updateShift(scheduleID_1,scheduleID_2);
                }
                
               
             });
                
                console.log("aa"+document.getElementById('scheduleID_1').value);
                console.log("bb"+document.getElementById('scheduleID_2').value);
        }

        function updateShift(scheduleID_1,scheduleID_2){
            $.post('sendShiftUpdate',{
                scheduleID_1:scheduleID_1,
                scheduleID_2:scheduleID_2
            }, function(){
                //alert("換班成功");
                //refresh();
                showInfo(scheduleID_1,scheduleID_2);   
            });
            //alert(schedule_1+"和"+schedule_2+"換班成功");
        }

       function showInfo(scheduleID_1,scheduleID_2) {
            $.get('showInfo', {
                id : scheduleID_1,
                id2 : scheduleID_2
            }, function (array){
                // dhtmlx.message({ type:"error", text: array[2]+array[1]+"\n和\n"+array[0]+array[3]+"換班成功" })
                if(array[0] == ""){
                    alert(array[2]+array[1]+"的班換至"+array[3]);
                }
                else{
                    alert(array[2]+array[1]+"和"+array[0]+array[3]+"換班成功");
                }
                refresh();
            });
        }

        function showScheduleInfo(date,section_id,id){
                document.getElementById("shiftDate").value=date;
                document.getElementById("shiftSessionID").value=section_id;
                document.getElementById("scheduleID_1").value=id;
        //     $.get("showDoctorInfo",{
        //         categorySerial: section_id,
        //         date : document.getElementById("shiftDate").value
        //     }, function(array){
                
        //         var info = "";
        //         console.log("length"+array.length);
        //         for(i=0 ; i<array.length ; i++){
        //             info += "<option value="+array[i]['doctorID']+">"+array[i]['doctorName']+(array[i]['totalShift'])+"</option>";
        //             console.log('1'+array[i]['doctorID']);
        //             console.log("section_id"+array[i]['doctorName']);
        //         }
        //         //document.getElementById("doctor").innerHTML  = info;

        // });

             //console.log("date"+document.getElementById("shiftDate").value);
        }
        function updateSchedule(scheduleID,date,classification){
            $.get('updateSchedule',{
                id: scheduleID,
                newDate: date,
                newSessionID: classification
                
            }, function(array){
                alert(array[0]+" "+array[1]+array[2]+"  換到  "+array[3]+array[4]);
                refresh();
                console.log("1111");
            });
        }
        //  function updateSchedule(scheduleID,date,classification){
        //     $.get('updateSchedule',{
        //         id: scheduleID,
        //         newDate: date,
        //         newSessionID: classification
                
        //     }, function(id){
        //         console.log(id);
        //         dhtmlx.message({ type:"error", text:"修改成功" });
        //         refresh();
        //         console.log("1111");
        //     });
        // }
        
    </script>
@endsection