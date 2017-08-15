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
    <font class="brand-logo light">調整班表 <i class="material-icons arrow_right-icon">keyboard_arrow_right</i>正式班表</font>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">    <!--	 style="background-color:red;"-->
		<div class="container-section">
		    <div class="row">
                <div class="col s12 m12">
      		  	  	<div class="card border-t">
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

<!--
@section('script')

@endsection
-->

