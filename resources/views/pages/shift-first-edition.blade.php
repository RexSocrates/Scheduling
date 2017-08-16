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
    </style>
@endsection

@section('navbar')
    <font class="brand-logo light">調整班表 <i class="material-icons arrow_right-icon">keyboard_arrow_right</i>初版班表</font>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">    <!--	 style="background-color:red;"-->
		<div class="container-section">
		    <div class="row">
                <div class="col s12 m12">
      		  	  	<div class="card border-t">
                       
                        <div id="my_form">
<!--                            <form action="!#">-->
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
                                        <select name="doctor" class="browser-default" id="doctor" required>
                                            <option value="" disabled selected>請選擇醫生</option>
                                            <option value="1">王志平</option>
                                            <option value="2">黃明源</option>
                                            <option value="3">莊錦康</option>
                                            <option value="4">簡立仁</option>
                                            <option value="5">陳長志</option>
                                            <option value="6">劉良嶸</option>
                                            <option value="7">陳楷宏</option>
                                            <option value="8">黃明源</option>
                                            <option value="9">鄭婓茵</option>
                                            <option value="10">劉蕙慈</option>
                                            <option value="11">柳志翰</option>
                                            <option value="12">蘇柏樺</option>
                                        </select>
                                    </div>
                                    <div class="col s6">
                                        <label>醫生:</label>
                                        <select class="browser-default" required>
                                            <option value="" disabled selected>請選擇醫生</option>
                                            <option value="1">王志平</option>
                                            <option value="2">黃明源</option>
                                            <option value="3">莊錦康</option>
                                            <option value="4">簡立仁</option>
                                            <option value="5">陳長志</option>
                                            <option value="6">劉良嶸</option>
                                            <option value="7">陳楷宏</option>
                                            <option value="8">黃明源</option>
                                            <option value="9">鄭婓茵</option>
                                            <option value="10">劉蕙慈</option>
                                            <option value="11">柳志翰</option>
                                            <option value="12">蘇柏樺</option>
                                        </select>
                                    </div>
                                    <div class="col s6">
                                        <label>日期:</label>
                                        <select class="browser-default" required>
                                            <option value="" disabled selected>請選擇日期</option>
                                            <option value="1">2017/08/05</option>
                                            <option value="2">2017/08/17</option>
                                            <option value="3">2017/08/26</option>
                                            <option value="4">2017/08/05</option>
                                            <option value="5">2017/08/17</option>
                                            <option value="6">2017/08/26</option>
                                            <option value="7">2017/08/05</option>
                                            <option value="8">2017/08/17</option>
                                            <option value="9">2017/08/26</option>
                                            <option value="10">2017/08/05</option>
                                            <option value="12">2017/08/17</option>
                                            <option value="13">2017/08/26</option>
                                            <option value="14">2017/08/05</option>
                                            <option value="15">2017/08/17</option>
                                            <option value="16">2017/08/26</option>
                                        </select>
                                    </div>
                                    <div class="col s6">
                                        <label>日期:</label>
                                        <select class="browser-default" required>
                                            <option value="" disabled selected>請選擇日期</option>
                                            <option value="1">2017/08/05</option>
                                            <option value="2">2017/08/17</option>
                                            <option value="3">2017/08/26</option>
                                            <option value="4">2017/08/05</option>
                                            <option value="5">2017/08/17</option>
                                            <option value="6">2017/08/26</option>
                                            <option value="7">2017/08/05</option>
                                            <option value="8">2017/08/17</option>
                                            <option value="9">2017/08/26</option>
                                            <option value="10">2017/08/05</option>
                                            <option value="12">2017/08/17</option>
                                            <option value="13">2017/08/26</option>
                                            <option value="14">2017/08/05</option>
                                            <option value="15">2017/08/17</option>
                                            <option value="16">2017/08/26</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="lightbox-footer">
                                <button class="modal-action waves-effect waves-light btn-flat modal-btn1" onclick="delete_event()">Delete</button>
                                <button type="submit" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save modal-btn" onclick="save_form()">Save</button>
                                <button class="modal-action modal-close waves-effect waves-light btn-flat btn-cancel modal-btn" onclick="close_form()">Cancel</button>
                            </div>
<!--                            </form>-->
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
                //            scheduler.config.dblclick_create = false;   //雙擊新增
                //            scheduler.config.drag_create = false;   //拖拉新增
                            scheduler.xy.margin_left = -19;
                            scheduler.config.container_autoresize = true;

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
                                name:	"timeline",
                                x_unit:	"day",
                                x_date:	"%d %D",
                                x_step:	1,
                                x_size: 14,
                                y_unit:	sections,
                                y_property:	"section_id",
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
                            
                            //進入畫面後顯示的東西
                            scheduler.init('scheduler_here',new Date(2017,5,26),"timeline");
                            
                            //彈出客制化的lightbox
                            var html = function(id) { return document.getElementById(id); }; //just a helper
                            scheduler.showLightbox = function(id) {
                                var ev = scheduler.getEvent(id);
                                scheduler.startLightbox(id, html("my_form"));
                                var doctorID = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"];
                                var doctorName = ["王志平", "黃明源", "莊錦康", "簡立仁", "陳長志", "劉良嶸", "陳楷宏", "黃明源", "鄭婓茵", "劉蕙慈", "柳志翰", "蘇柏樺"];
                                var array = doctorName.indexOf(ev.text);
                                
                                if (ev.text == "New" || ev.text == "") {
                                    var id = "";
                                } else {
                                    var id = doctorID[array];
                                }
                                
                                html("doctor").focus();
                                html("doctor").value = id;
//                                html("custom1").value = ev.custom1 || "";
//                                html("custom2").value = ev.custom2 || "";
                            };

                            function save_form() {
                                var ev = scheduler.getEvent(scheduler.getState().lightbox_id);
                                
                                ev.text = html("doctor").value;

                                scheduler.endLightbox(true, html("my_form"));
                            }
                            
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
                            
                            function close_form() {
                                scheduler.endLightbox(false, html("my_form"));
                            }

                            function delete_event() {
                                var event_id = scheduler.getState().lightbox_id;
                                scheduler.endLightbox(false, html("my_form"));
                                scheduler.deleteEvent(event_id);
                            }


                            
                            scheduler.parse([
                                { start_date: "2017-06-30 00:00", end_date: "2017-07-01 00:00", text:"王志平", section_id:1},
                                { start_date: "2017-06-30 00:00", end_date: "2017-07-01 00:00", text:"黃明源", section_id:2},
                                { start_date: "2017-06-30 00:00", end_date: "2017-07-01 00:00", text:"莊錦康", section_id:3},
                                { start_date: "2017-06-30 00:00", end_date: "2017-07-01 00:00", text:"簡立仁", section_id:4},

                                { start_date: "2017-07-02 00:00", end_date: "2017-07-03 00:00", text:"王志平", section_id:1},
                                { start_date: "2017-07-02 00:00", end_date: "2017-07-03 00:00", text:"黃明源", section_id:2},
                                { start_date: "2017-07-02 00:00", end_date: "2017-07-03 00:00", text:"莊錦康", section_id:3},
                                { start_date: "2017-07-02 00:00", end_date: "2017-07-03 00:00", text:"簡立仁", section_id:4},
                                { start_date: "2017-07-02 00:00", end_date: "2017-07-03 00:00", text:"陳長志", section_id:5},
                                { start_date: "2017-07-02 00:00", end_date: "2017-07-03 00:00", text:"劉良嶸", section_id:6},
                                { start_date: "2017-07-02 00:00", end_date: "2017-07-03 00:00", text:"陳楷宏", section_id:7},
                                { start_date: "2017-07-02 00:00", end_date: "2017-07-03 00:00", text:"黃明源", section_id:8},
                                { start_date: "2017-07-02 00:00", end_date: "2017-07-03 00:00", text:"鄭婓茵", section_id:9},
                                { start_date: "2017-07-02 00:00", end_date: "2017-07-03 00:00", text:"劉蕙慈", section_id:10},
                                { start_date: "2017-07-02 00:00", end_date: "2017-07-03 00:00", text:"王志平", section_id:11},
                                { start_date: "2017-07-02 00:00", end_date: "2017-07-03 00:00", text:"柳志翰", section_id:12},
                                { start_date: "2017-07-02 00:00", end_date: "2017-07-03 00:00", text:"蘇柏樺", section_id:13},

                                { start_date: "2017-07-03 00:00", end_date: "2017-07-04 00:00", text:"王志平", section_id:1},
                                { start_date: "2017-07-03 00:00", end_date: "2017-07-04 00:00", text:"黃明源", section_id:2},
                                { start_date: "2017-07-03 00:00", end_date: "2017-07-04 00:00", text:"莊錦康", section_id:3},
                                { start_date: "2017-07-03 00:00", end_date: "2017-07-04 00:00", text:"簡立仁", section_id:4},
                                { start_date: "2017-07-03 00:00", end_date: "2017-07-04 00:00", text:"陳長志", section_id:5},
                                { start_date: "2017-07-03 00:00", end_date: "2017-07-04 00:00", text:"劉良嶸", section_id:6},
                                { start_date: "2017-07-03 00:00", end_date: "2017-07-04 00:00", text:"陳楷宏", section_id:7},
                                { start_date: "2017-07-03 00:00", end_date: "2017-07-04 00:00", text:"黃明源", section_id:8},
                                { start_date: "2017-07-03 00:00", end_date: "2017-07-04 00:00", text:"鄭婓茵", section_id:9},
                                { start_date: "2017-07-03 00:00", end_date: "2017-07-04 00:00", text:"劉蕙慈", section_id:10},
                                { start_date: "2017-07-03 00:00", end_date: "2017-07-04 00:00", text:"王志平", section_id:11},
                                { start_date: "2017-07-03 00:00", end_date: "2017-07-04 00:00", text:"柳志翰", section_id:12},
                                { start_date: "2017-07-03 00:00", end_date: "2017-07-04 00:00", text:"蘇柏樺", section_id:13}
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
  		});
    </script>
@endsection
