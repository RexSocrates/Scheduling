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
    <font class="brand-logo light">調整班表<i class="material-icons arrow_right-icon">keyboard_arrow_right</i>正式班表<i class="material-icons arrow_right-icon">keyboard_arrow_right</i>{{$doctor->name}}</font>
@endsection

@section('content')
<input type="hidden" id="shiftDate" value=""> <!--不能刪 -->
 <input type="hidden" id="shiftSessionID" value=""> <!--不能刪 -->
 <input type="hidden" id="doctor1Info" value=""> <!--不能刪 -->
 <input type="hidden" id="doctor2Info" value=""> <!--不能刪 -->
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
                                        <label>醫生:</label>
                                        <select name= 'schID_1_doctor' class="browser-default" id="schID_1_doctor" onchange="changeDoctor_1()" required>
                                            <option  disabled selected>請選擇醫生</option>
                                                <option disabled value=""></option>
                                                @foreach($allDoctor as $name)
                                                <option value="{{$name->doctorID}}">{{$name->name}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <div class="col s6">
                                        <label>醫生:</label>
                                        <select name= 'schID_2_doctor' class="browser-default" id="schID_2_doctor" onchange="changeDoctor()" required>
                                            <option value="" disabled selected>請選擇醫生</option> 
                                            @foreach($allDoctor as $name)
                                            <option value="{{$name->doctorID}}">{{$name->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col s6">
                                        <label>日期:</label>
                                        <select name="scheduleID_1" class="browser-default" id="date1" required>
                                            <option value="" disabled selected>請選擇日期</option>
                                            <option value=""></option>

                                        </select>
                                    </div>

                                    <div class="col s6">
                                        <label>日期:</label>
                                        <select  name='scheduleID_2' class="browser-default" id="date2" required>
                                            <option value="" disabled selected>請選擇日期</option>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="lightbox-footer">
                                
                                <button type="submit" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save modal-btn" onclick="save_form_alert()">Save</button>
                                <button class="modal-action modal-close waves-effect waves-light btn-flat btn-cancel modal-btn" onclick="close_form()">Cancel</button>
                            </div>

                        </div>

                        <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
                            <div class="dhx_cal_navline">
                                <div class="dhx_cal_prev_button"></div>
                                <div class="dhx_cal_next_button"></div>
                                <div class="dhx_cal_today_button"></div>
                                <div class="dhx_cal_date"></div>

                                <div class="dhx_cal_tab" name="timeline_tab" style="display: none;"></div>
                                 
                                <div class="dhx_cal_tab margin-l20 noUnderline">
                                    <form action="shift-scheduler-personal" method="post">
                                        <font class="dhx-font">醫師:</font>
                                        <select  name="doctor" class="browser-default select-custom" required>
                                            <option value="" disabled selected required>選擇醫師</option>
                                            @foreach($allDoctor as $name)
                                                <option value="{{$name->doctorID}}">{{$name->name}} </option>
                                            @endforeach
                                        </select>
                                        <button class="dhx_cal_tab submit-inline" type="submit">確認</button>
                                        {{ csrf_field() }}
                                    </form>
                                </div>
        <!--
                                <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
                                <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
                                <div class="dhx_cal_tab" name="timeline_tab" style="right:280px;"></div>
                                <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
        -->
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
                            scheduler.config.collision_limit = 1; 
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
                                
                                window.scrollTo(0,0);  //開啟後移動到最上面
                                
                                 if(ev.text == "New"){
                                    scheduler.startLightbox(id, html("my_form1"));
                                } 
                                else if(date>today){
                                    console.log('nothing');
                                }
                                else {
                                    scheduler.startLightbox(id, html("my_form"));
                                }
                                
                                
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

                            var startd =new Date(res[3], month-1, 1); 
                            var endd = new Date(res[3], month, 1); 
                            var block_startd =new Date(res[3], month-1, 1); 
                            var block_endd = new Date(res[3], month, 1); 
                            console.log("startd "+startd);
                            console.log("endd "+endd);
                            scheduler.config.limit_start = new Date(startd);
                            scheduler.config.limit_end = new Date(endd);
                            scheduler.attachEvent("onLimitViolation", function  (id, obj){
                                //dhtmlx.message({ type:"error", text:"此時段無法接受換班" })
                            });

                             //限制非當月利用點擊視窗換班
                            scheduler.addMarkedTimespan({  
                                start_date: '1900-1-1',
                                end_date:  new Date(res[3], month-1, 1),
                                zones: "fullday", 
                                css: "block_section", 
                                type: "dhx_time_block"
                            
                             });
                           


                            //scheduler.updateView();

                           //  scheduler.attachEvent("onEventCollision", function (ev, evs){
                           //      var ev = scheduler.getEvent(ev.id);

                           //      var evs =  scheduler.getEvent(evs[0].id);
                           // //     ("onEventCollision", function(ev, evs){ 
                           // //      var c = 0, l = scheduler.config.collision_limit;
                           // //      for (var i=0; i<evs.length; i++) {  
                           // //          if ((ev.room_number == evs[i].room_number)&& ev.id != evs[i].id) c++; 
                           // //      } 
                           // //          return !(c < l);
                           // // });
                                
                           //     //  console.log("1111"+evs.length);

                           //     // for(var i = 0; i<  evs.length; i++){
                                

                           //     //  console.log("1111"+evs.length);
                           //     //  }
                                
                           //      //var count = scheduler.getEvents(ev.start_date, ev.end_date).length;
                           //      console.log("ev "+ev.text)
                           //     // var evs = scheduler.getEvent(evs[0].id);
                           //      var count = scheduler.getEvents(ev.start_date, ev.end_date).length;

                           //      console.log("evs "+evs.text);
                            

                           //      checkDocStatus(ev.hidden,evs.hidden);

                           //      //  console.log('checkDoc1Status'+document.getElementById("doctor1Info").value);
                           //      //  console.log('checkDoc2Status'+document.getElementById("doctor2Info").value);
                           //      // //限制非當月拖拉換班
                           //      // if(ev.start_date < startd || evs.start_date < startd ){
                           //      //     //console.log("No");
                           //      //     dhtmlx.message({ type:"error", text:"此日期無法換班" });
                           //      // }
                           //      // if(document.getElementById("doctor1Info").value!=0){
                           //      //     dhtmlx.message({ type:"error", text:ev.text+"在"+date1+"已有班了" });
                           //      //     alert("1111");
                           //      //     console.log("1"+ev.text);
                           //      // }
                           //      // if(document.getElementById("doctor2Info").value!=0){
                           //      //    dhtmlx.message({ type:"error", text:evs.text+"在"+date2+"已有班了" });
                           //      //    console.log("2"+evs.text);
                           //      // }
                           //      // else{
                           //      //     if(count>=1){
                           //      //         updateShift(ev.hidden,evs.hidden);
                           //      //         //dhtmlx.message({ type:"error", text:"此日期已選過" });
                           //      //         return true;
                           //      //     }
                           //      //     else{
                                        
                           //      //         return false;
                           //      //     }
                           //     //}
                           //      return true;
                           //  });
                            
                        
                            scheduler.attachEvent("onClick", function (id, e){
                                var event = scheduler.getEvent(id);
                            
                                changeDoctor_1(event.hidden);
                                showScheduleInfo(event.start_date,event.section_id);

                                console.log("123"+event.text);

                                return true;
                            });
                           
                           

                            //進入畫面後顯示的東西
                            scheduler.init('scheduler_here',new Date(res[3], month-1),"timeline");

                            scheduler.parse([
                                 @foreach($scheduleData as $data)
                                 { start_date: "{{ $data->date }} 00:00", end_date: "{{ $data->endDate }} 00:00", text:"{{ $data->doctorID }}", section_id:"{{ $data->schCategorySerial }}" ,hidden:"{{ $data->scheduleID}}" },
                               
                                @endforeach
                                
                            ],"json");

                            
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('select').material_select();
            document.getElementsByClassName("collapsible")[3].getElementsByTagName("li")[0].className += "active";
            document.getElementsByClassName("collapsible-body")[3].style.display = "block";
            document.getElementsByClassName("collapsible-body")[3].getElementsByTagName("li")[1].className += "active";
        });
    
     function changeDoctor_1(id){
            $.get('changeDoctor1',{
                id : id
            }, function(array){
                document.getElementById("schID_1_doctor").innerHTML= "<option value="+array[0]+">"+array[1]+"</option>";
                changeDate1(array);
            });
        }
        function changeDoctor() {
            $.get('changeDoctorSchedule', {
                id : document.getElementById('schID_2_doctor').value
            }, function(array) {
                changeDate2(array);
            });
        }
        function changeDate1(array) {
                document.getElementById("date1").innerHTML= "<option value="+array[3]+">"+array[2]+"</option>",
                document.getElementById("getDate").value=array[2]     
        }
        function changeDate2(array) {
                var date = "";
                for(i=0 ; i<array.length ; i++){
                    date += "<option value="+array[i][0]+">"+array[i][2]+"</option>";
                    console.log('1'+array[i][0]);
                }
                document.getElementById("date2").innerHTML  = date;
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
                 dhtmlx.message({ type:"success", text: array[2]+array[1]+"\n和\n"+array[0]+array[3]+"換班成功" })
                 refresh();
            });
        }
        function refresh() {
            location.reload();
        }
        function save_form_alert(){
            $.get('checkDocStatus',{
            scheduleID_1 : document.getElementById('date1').value,
            scheduleID_2 : document.getElementById('date2').value,
            }, function(array){
                var ID_1 = document.getElementById('date1').value;
                var ID_2 = document.getElementById('date2').value;
                var date = new Date();
                var dateStr=date.getFullYear()+"-"+(date.getMonth()+1) + "-" + date.getDate();
                 if(ID_1 == ID_2){
                     dhtmlx.message({ type:"error", text:"請選擇不同時段醫生" });
                }
                else if(ID_2 == ""){
                    dhtmlx.message({ type:"error", text:"請選擇醫生" });
                }
                else if(Date.parse(dateStr)<Date.parse(array[0]['date2']) || Date.parse(dateStr)<Date.parse(array[0]['date1'])){
                    dhtmlx.message({ type:"error", text:"還不能換班" });
                    console.log(dateStr);
                }
                else if(array[0]['count1']!=0){
                    dhtmlx.message({ type:"error", text:array[0]['doc1']+"醫生"+array[0]['date2']+"已有班" });
                    console.log("doc1"+array[0]['count1']);
                }
                else if(array[0]['count2']!=0){
                    dhtmlx.message({ type:"error", text:array[0]['doc2']+"醫生"+array[0]['date1']+"已有班" });
                    console.log("doc2"+array[0]['count2']);
                }
                else{
                save_form();
                }
            
           });
           
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
        function save_form_alert_addSchedule(){
            var id = document.getElementById('doctor').value;
            var date =document.getElementById('date_1').innerText;
            var classification = document.getElementById('section_id').innerText;
            if(id == ""){
                dhtmlx.message({ type:"error", text:"請選擇醫生" });
            }
           else{
            saveSchedule(id,date,classification);
           }
            
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
        
         function checkDocStatus(scheduleID_1,scheduleID_2){
            $.get('checkDocStatus',{
                scheduleID_1:scheduleID_1,
                scheduleID_2:scheduleID_2
                
            }, function(array){
                 if(array[0]['count1']!=0){
                    dhtmlx.message({ type:"error", text:array[0]['doc1']+"醫生"+array[0]['date2']+"已有班" });
                    console.log("doc1"+array[0]['count1']);
                }
                if(array[0]['count2']!=0){
                    dhtmlx.message({ type:"error", text:array[0]['doc2']+"醫生"+array[0]['date1']+"已有班" });
                    console.log("doc2"+array[0]['count2']);
                }
                else{
                    updateShift(scheduleID_1,scheduleID_2);
                }
            });
            
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
    
        
    
        

        
    </script>
@endsection