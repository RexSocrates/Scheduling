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
    <font class="brand-logo light">正式班表 <i class="material-icons arrow_right-icon">keyboard_arrow_right</i>個人</font>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">
	    
		<div class="container-section">
			<div class="row">
                <div id="self" class="col s12">
                    
                    
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
                            scheduler.config.api_date="%Y-%m-%d %H:%i";
                            scheduler.config.dblclick_create = false;   //雙擊新增
                            scheduler.config.readonly = true;   //唯讀，不能修改東西
                            scheduler.config.drag_create = false;   //拖拉新增

                            
                            
                            
                            
                            //進入畫面後顯示的東西
                            scheduler.init('scheduler_here',new Date(),"month");
                            
                            //讀取資料
                            
                        	
                        	@foreach($schedule as $data)

	                            scheduler.parse([
	                            	
	                            { start_date: "{{ $data->date }} 00:00", end_date: "{{$data->endDate}} 00:00", text: "{{ $data->schCategorySerial }}"},    
	                            ],"json");
							
                            @endforeach

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


<!--{{ csrf_field() }}-->

