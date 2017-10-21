@extends("layouts.app2")

@section('head')
    <style>
        td{
            padding: 0;
        }
        .dhx_cal_event.event_1 div, .dhx_cal_event_line.event_1{
            background-color: #FC5BD5 !important;
            border-color: #839595 !important;
        }
        .dhx_cal_event_clear.event_1{
            color:#B82594 !important;
        }

    </style>
@endsection

@section('navbar')
    <font class="brand-logo light">初版班表 <i class="material-icons arrow_right-icon">keyboard_arrow_right</i>查看全部</font>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">    <!--     style="background-color:red;"-->
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
                                <div class="dhx_cal_tab" name="timeline_tab" style="display: none;"></div>
                                
                                <div class="dhx_cal_tab margin-l20 noUnderline">
                                    <form action="first-edition-all-personal" method="post">
                                        <font class="dhx-font">醫師:</font>
                                        <select name="doctor" class="browser-default select-custom" required>
                                            <option value="" disabled selected>選擇醫師</option>
                                             @foreach($doctorName as $name)
                                                <option value="{{$name->doctorID}}">{{$name->name}}</option>
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

                             scheduler.templates.event_class=function(start, end, event){
                                var css = "";

                                if(event.subject) // if event has subject property then special class should be assigned
                                 css += "event_"+event.subject;

                                if(event.id == scheduler.getState().select_id){
                                    css += " selected";
                                }
                                return css; // default return       
                         };


                            //進入畫面後顯示的東西
                            scheduler.init('scheduler_here',new Date(res[3],month),"timeline");
                            
                            scheduler.parse([
                            @foreach($schedule as $data)
                                 { start_date: "{{ $data->date }} 00:00", end_date: "{{ $data->endDate }} 00:00", text:"{{ $data->doctorID }}", section_id:"{{ $data->schCategorySerial }}", subject:"{{ $data->status }}"},
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
        $(document).ready(function() {
            $('select').material_select();
        });
    </script>
@endsection

