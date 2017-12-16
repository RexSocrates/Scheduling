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
    <font class="brand-logo light">初版班表 <i class="material-icons arrow_right-icon">keyboard_arrow_right</i>個人</font>
    
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">
		<div class="container-section">
			<div class="row">
                <div class="col s12">
                    <div class="card border-t">
                        <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:1750px;'>
                            <div class="dhx_cal_navline">
                                <div class="dhx_cal_prev_button">&nbsp;</div>
                                <div class="dhx_cal_next_button">&nbsp;</div>
                                <div class="dhx_cal_today_button"></div>
                                <div class="dhx_cal_date"></div>
                                <div class="dhx_cal_tab" name="month_tab" style="display: none;"></div>
        
<!--                                <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>-->
<!--                                <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>-->
<!--                                <div class="dhx_cal_tab" name="timeline_tab" style="right:280px;"></div>-->
<!--                                <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>-->
        
                            </div>
                            <div class="dhx_cal_header">
                            </div>
                            <div class="dhx_cal_data">
                            </div>		
                        </div>

                        <script type="text/javascript" charset="utf-8">
                    

                            scheduler.config.xml_date="%Y-%m-%d %H:%i";
//                            scheduler.config.dblclick_create = false;   //雙擊新增
                            scheduler.config.readonly = true;   //唯讀，不能修改東西
//                            scheduler.config.drag_create = false;   //拖拉新增

                            var priorities = [
                                { key: 1, label: '行政' },
                                { key: 2, label: '教學' },
                                { key: 3, label: '台北白班' },
                                { key: 4, label: '台北夜班' },
                                { key: 5, label: '淡水白班' },
                                { key: 6, label: '淡水夜班' },
                                { key: 7, label: 'off' }
                            ];
                            
                            scheduler.locale.labels.section_priority = 'Priority';
                            
                            //彈出視窗的選項
                            scheduler.config.lightbox.sections=[
//                                {name:"description", height:130, map_to:"text", type:"textarea" , focus:true},
//                                {name:"custom", height:23, type:"select", options:sections, map_to:"section_id" },
                                {name:"班別名稱", height:180, options:priorities, map_to:"priority", type:"radio", vertical:true},
//                                {name:"time", height:72, type:"time", map_to:"auto"}
                            ];
                            
                            //在Lightbox按下save時執行
                            scheduler.attachEvent("onEventSave",function(id,ev,is_new){
                                var event = scheduler.getEvent(id);
                                event.text = event.priority;
                                return true;
                            });
                            
                            scheduler.attachEvent("onEventChanged", function(id,e){
                                var event = scheduler.getEvent(id);
                                if(event.priority == 1){
                                    event.text = "行政";
                                }else if(event.priority == 2){
                                    event.text = "教學";
                                }else if(event.priority == 3){
                                    event.text = "台北白班";
                                }else if(event.priority == 4){
                                    event.text = "台北夜班";
                                }else if(event.priority == 5){
                                    event.text = "淡水白班";
                                }else if(event.priority == 6){
                                    event.text = "淡水夜班";
                                }else if(event.priority == 7){
                                    event.text = "off";
                                }
                            });
                            

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
                            scheduler.init('scheduler_here',new Date(res[3],month),"month");
                            
                            //讀取資料
                             @foreach($schedule as $data)

                                scheduler.parse([
                                    
                                { start_date: "{{ $data['date'] }} 00:00", end_date: "{{$data['endDate']}} 00:00", text: "{{ $data['categoryName'] }}"},    
                                ],"json");
                            
                            @endforeach

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
