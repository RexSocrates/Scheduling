@extends("layouts.app2")

@section('head')
    <style>
        td{
            padding: 0;
        }
        
    </style>
@endsection

@section('navbar')
    <font class="brand-logo light">預班表 <i class="material-icons arrow_right-icon">keyboard_arrow_right</i>查看全部</font>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">
	    
		<div class="container-section">
			<div class="row">
                <div id="all" class="col s12">
                    <div class="card border-t">
                        <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
                            <div class="dhx_cal_navline">
                                <div class="dhx_cal_prev_button"></div>
                                <div class="dhx_cal_next_button"></div>
                                <div class="dhx_cal_today_button"></div>
                                <div class="dhx_cal_date"></div>
                                <div class="dhx_cal_tab" name="timeline_tab" style="display: none;"></div>
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
                            scheduler.config.readonly = true;   //唯讀，不能修改東西
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
                                {key:3, label:"(上限6人) 台北 白班"},
                                {key:4, label:"(上限6人) 台北 夜班"},
                                {key:5, label:"(上限4人) 淡水 白班"},
                                {key:6, label:"(上限3人) 淡水 夜班"},
                                {key:7, label:"(上限12人) OFF"}
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
//                                event_dy: 46,
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
//                            scheduler.templates.event_bar_text = function(start,end,event){
//                                var mode = scheduler.getState().mode;
//                                var text;
//                                if(mode == "timeline"){
//                                    text = "<center class='timeline-event-text'>"+event.text+"</center>";
//                                }
//                                else {
//                                    text = "text for other views";
//                                } 
//                                return text;
//                            };
                            
                            //增加最左邊欄位的class
                            scheduler.templates.timeline_scaley_class = function(key, label, section){ 
                                return "width-200";
                            };
                            
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

                            //進入畫面後顯示的東西
                            scheduler.init('scheduler_here',new Date(res[3],month),"timeline");
                           
                            scheduler.parse([
                            @foreach($reservations as $reservation)
                                @foreach($reservation[1] as $doctor)
                                 { start_date: "{{ $reservation[0]->date}} 00:00", end_date: "{{ $reservation[0]->endDate }} 00:00", text:"{{ $doctor->name }}", section_id:"{{ $reservation[0]->categorySerial}}"},
                               @endforeach
                            @endforeach
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

