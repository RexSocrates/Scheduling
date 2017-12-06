@extends("layouts.app2")

@section('head')
    <link type="text/css" rel="stylesheet" href="../css/nouislider.css" rel="stylesheet">
@endsection

@section('navbar')
    <p class="brand-logo light">設定</p>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">
		<div class="container-section">
			<div class="row">
                <div class="col s7">                 
                    <div class="card">
                        <!-- <form action="setDate" method="post"> -->
                            <div class="card-action b-t0">
                                <font class="card-title">預班時段</font>
                            </div>
                            <div class="divider"></div>
                            <div class="card-content">
                                <input type="hidden" id="startDate" name="startDate">
                                <input type="hidden" id="endDate" name="endDate">

                                <p class="slider-text">{{ $month }}月<font id="startFont"></font>日 
                                至 {{ $month }} 月<font id="endFont"></font>日</p>
                                <div id="slider"></div>
                            </div>
                            <div class="card-action">
                                @if($status !=1 )
                                <button type="submit" class="modal-action waves-effect waves-light btn btn-save" 
                                disabled>Save</button>
                                @else
                                <button type="submit" class="modal-action waves-effect waves-light btn btn-save" 
                                onclick="setDate()">Save</button>
                                @endif
                            </div>
                            {{ csrf_field() }}
                        <!-- </form> -->
                    </div>
                </div>
                @if( $status ==1)
      		  	<div class="col s5">                 
                    <div class="card">
                        <div class="card-action b-t0">
                            <font class="card-title">系統狀態</font>
                        </div>
                        <div class="divider"></div>
                        <div class="card-content center">
                            <h5 class="margin-t0">預班進行中</h5>
                            <p>系統將會關閉4小時</p>
                            <p>所有醫生將不能進入系統</p>
                            
                            @if($firstSchedule == 1)
                            <button type="button" class="btn btn-secondary margin-t10" disabled>產生初版班表</button>
                            @else
                            <button type="button" class="btn btn-secondary margin-t10" onclick="announceFirstSchedule()">產生初版班表</button>
                           
                            @endif
                        </div>
                    </div>
                </div>
                @elseif( $status ==2 )
                <div class="col s5">                 
                    <div class="card">
                        <div class="card-action b-t0">
                            <font class="card-title">系統狀態</font>
                        </div>
                        <div class="divider"></div>
                        <div class="card-content center">
                            <h5 class="margin-t0">初版班表調整中</h5>
                            <p>排班人員可以調整初版班表</p>
                            <p>調整完成後按下按鈕公佈正式班表</p>
                            <button type="button" class="btn btn-secondary margin-t10" onclick="announceSchedule()">公佈正式班表</button>
                        </div>
                    </div>
                </div>
                @else
                <div class="col s5">                 
                    <div class="card">
                        <div class="card-action b-t0">
                            <font class="card-title">系統狀態</font>
                        </div>
                        <div class="divider"></div>
                        <div class="card-content center">
                            <h5 class="margin-t0">正式班表已公佈</h5>
                            <p>當預班時段到達時，請按下面按鈕開放預班</p>
                            <button type="button" class="btn btn-secondary margin-t10" onclick="reservation()">開放下一次預班</button>
                        </div>
                    </div>
                </div>
				@endif
      		</div>
		</div>
	</div>
@endsection

@section('script')
    <script src="../js/nouislider.js"></script>
    <script src="../js/wNumb.js"></script>
    <script>
        var slider = document.getElementById('slider');
            
        var start={{ $strDate }};
        var end={{ $endDate }};

        function setDate(){
             $.get('setDate',{
                startDate:document.getElementById('startDate').value,
                endDate:document.getElementById('endDate').value
                
            }, function(){
                change();

            });
        }
        function change(){
             $.get('getDate',{
                
            }, function(array){
                
                start = array[0];
                end = array[1];

                document.getElementById('startFont').innerHTML = start;
                document.getElementById('endFont').innerHTML = end;
                location.reload();
            });
        }
        
        var dt = new Date();
        var year = dt.getFullYear();
        var month = dt.getMonth() + 1;
        var curMonthDays = new Date(year,month,0).getDate();
        
        //計算每年每月最大的日數是多少
        noUiSlider.create(slider, {
            start: [ start, end ],
            step: 1,
            connect: true,
            range: {
                'min': 1,
                'max': curMonthDays,
            }
        });
        
        var startDate = document.getElementById('startDate');
        var endDate = document.getElementById('endDate');
        var startFont = document.getElementById('startFont');
        var endFont = document.getElementById('endFont');

        slider.noUiSlider.on('update', function( values, handle ) {

            var value = values[handle];

            if ( handle ) {
                endDate.value = value;
                endFont.innerHTML = parseInt(value);
            } else {
                startDate.value = value;
                startFont.innerHTML = parseInt(value);
            }
        });

        function announceSchedule(){
            $.get('announceSchedule',{
                
            }, function(){
               alert("正式班表公布成功");
               location.reload();
            });
        }


        function announceFirstSchedule(){
            $.get('announceFirstSchedule',{
                
            }, function(){
               alert("初版班表公布成功");
               location.reload();
            });
           
        }

        function reservation(){
            $.get('toReservation',{
                
            }, function(){
               alert("開放預班");
               location.reload();
            });
           
        }
        


        
//        startDate.addEventListener('change', function(){
//            slider.noUiSlider.set([this.value, null]);
//        });
//        
//        endDate.addEventListener('change', function(){
//            slider.noUiSlider.set([null, this.value]);
//        });
        
    </script>
@endsection
