@extends("layouts.app2")

@section('head')
    <script src="../codebase/ext/dhtmlxscheduler_collision.js"></script>
    <script src="../codebase/ext/dhtmlxscheduler_limit.js"></script>
    <script src="../../codebase/ext/dhtmlxscheduler_serialize.js" type="text/javascript" charset="utf-8"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
    <script>
        // 送出新增預班的request
        function sendNewReservation(categorySerial, startDate, endDate) {
            $.post('sendReservationAdd', {
                serial : categorySerial,
                date1 : startDate,
                date2 : endDate
            }, function() {
                // alert('預約成功');
                dhtmlx.message({ type:"error", text:"預約成功"});
            });
        }

        // 送出更新預班的request
        function updateReservation(resSerial, categorySerial, startDate, endDate) {
            $.post('sendReservationUpdate', {
                resSerial : resSerial,
                categorySerial : categorySerial,
                startDate : startDate,
                endDate : endDate
            }, function() {
                dhtmlx.message({ type:"error", text:"預約修改成功" });
            });
        }

        // 送出刪除預班的request
        function deleteReservation(resSerial) {
            $.post('sendReservationDelete', {
                resSerial : resSerial,
            }, function() {
                dhtmlx.message({ type:"error", text:"預約刪除成功" });
            });
        }
        
        function countDay(){
            $.get('countDay', {
              }, function(array) {
                document.getElementById("countDay").innerHTML = "尚需排班數: 白班:"+array[0] +"夜班:"+array[1];
                
            });
        }

       function refresh() {
            location.reload();
        }

        // function alert1(countDay,countNight){
        //     var countDay=countDay;
        //     alert("countDay"+countDay);
        //     return countNight;
        // }

        function alert2(){
            alert("備註送出完成");
        }
        
        // 確認是否可預on班或預off班
        function checkResAmount(isOnRes, startDate, endDate) {
            var resAmount = 0;
            
            if(isOnRes) {
                // 檢查on班預約
                resAmount = document.getElementById('hiddenCountOn').value;
            }else {
                // 檢查off班預約
                resAmount = document.getElementById('hiddenCountOff').value;
            }
            
            var startArr = startDate.split(" ");
            var endArr = endDate.split(" ");
            
            var days = parseInt(endArr[2]) - parseInt(startArr[2]);
            
            if(resAmount <= 0 || resAmount < days) {
                // 剩餘可預約班數為0，無法預班
                dhtmlx.message({ type:"error", text:"可預約班數不足，無法預班"});
                return false;
            }else {
                return true;
            }
        }
        
    </script>

    <style>
        td{
            padding: 0;
        }
    </style>
@endsection

@section('navbar')
    <font class="brand-logo light">預班表 <i class="material-icons arrow_right-icon">keyboard_arrow_right</i>個人</font>
@endsection

@section('content')
<input type="hidden" id='hiddenCountDay' value={{$countDay}}>
<input type="hidden" id='hiddenCountNight' value={{$countNight}}>
<input type="hidden" id='hiddenCountOn' value={{$onAmount}}>
<input type="hidden" id='hiddenCountOff' value={{$offAmount}}>

    <div id="section" class="container-fix trans-left-five">
        <div class="container-section">
            <div class="row">
                <div id="self" class="col s12">
                    <div class="card">
                        <div class="card-action">
                            <font class="card-title">排班資訊</font>
                        </div>
                        <div class="divider"></div>
                        <div class="card-content">


                            <form action="addRemark" method="post">
                                <div class="row margin-b0">
                                    <div class="col s5">
                                        <p class="information">開放時間: 2017/06/01 - 2017/06/25</p>
                                        
                                        <p class="information">可排天班數: on班:{{$onAmount}} off班:{{$offAmount}}</p>
                                        <!-- <p class="information" id='countDay'>尚需排班數: 白班:{{$countDay}} 夜班:{{$countNight}}</p> 
                                         -->
                                    </div>

                                    <div class="col s7">
                                        <form action="addRemark" method="post" class="col s6">
                                            <div class="input-field">
                                                <textarea id="textarea1" class="materialize-textarea" name="remark"placeholder="請輸入XXXXX">{{$remark}}</textarea>
    <!--                                                     data-length="150"-->
                                                <label for="textarea1">備註:</label>

                                            </div>
                                            <!-- <input type="submit" class="waves-effect waves-light btn blue-grey darken-1 white-text right">提交</button> -->
                                            <button type="submit" class="waves-effect waves-light btn blue-grey darken-1 white-text right" value="提交" onclick="alert2()">提交</button>
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                    <div class="card border-t">
                        <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:1750px;'>
                            <div class="dhx_cal_navline">
                                <div class="dhx_cal_prev_button">&nbsp;</div>
                                <div class="dhx_cal_next_button">&nbsp;</div>
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

                            scheduler.config.xml_date="%Y-%m-%d %H:%i";
                            scheduler.config.api_date="%Y-%m-%d %H:%i";
                            scheduler.config.dblclick_create = false;   //雙擊新增
                          //scheduler.config.readonly = true;   //唯讀，不能修改東西
                          //scheduler.config.drag_create = false;   //拖拉新增
                            scheduler.config.details_on_create = false;
                            scheduler.config.details_on_dblclick = true;
                            scheduler.config.prevent_cache = true;
                            scheduler.config.show_loading = true;
                            

                            var priorities = [
                                { key: 1, label: '行政' },
                                { key: 2, label: '教學' },
                                { key: 3, label: '台北白班' },
                                { key: 4, label: '台北夜班' },
                                { key: 5, label: '淡水白班' },
                                { key: 6, label: '淡水夜班' },
                                { key: 7, label: 'off班' }
                            ];

                            scheduler.locale.labels.section_priority = 'Priority';

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
                                {name:"班別名稱", height:180, options:priorities, map_to:"priority", type:"radio", vertical:true},
                                {name:"hidden", height:400, map_to:"hidden", type:"hidden" , focus:true}
                            ];

                            //打開lightbox時執行
                            scheduler.attachEvent("onLightbox", function (id){
                                document.getElementsByClassName("dhx_cal_light")[0].style.height = "285px";
                                document.getElementsByClassName("dhx_cal_larea")[0].style.height = "195px";
                            });


                            //在Lightbox關掉
                            scheduler.attachEvent("onBeforeLightbox", function (id){
                                var event = scheduler.getEvent(id);

                                return true;
                            });

                            //在Lightbox按下save時執行
                            scheduler.attachEvent("onEventSave",function(id,ev,is_new){
                               
                                return true;
                            });

                          scheduler.attachEvent("onEventAdded", function(id,e){
                              var event = scheduler.getEvent(id);
                              var isOnShift = true;
                              var hasSelected = true;
                              
                              
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
                                  event.text = "off班";
                                  isOnShift = false;
                              }else if(event.priority == null){
                                  event.text = "沒選到班";
                                  hasSelected = false;
                              }
//                              console.log("TYPE : " + typeof event.start_date);
                              
                              if(hasSelected) {
                                  console.log("新增");
                                  
                                  // 假設只能夠選一天的班
                                  if(isOnShift) {
                                      // 預約on班
                                      if(checkResAmount(true, String(event.start_date), String(event.end_date))) {
                                          sendNewReservation(event.priority, event.start_date, event.end_date);
                                      }
                                  }else {
                                      // 預約off班
                                      if(checkResAmount(false, String(event.start_date), String(event.end_date))) {
                                          sendNewReservation(event.priority, event.start_date, event.end_date);
                                      }
                                  }
                              }
//                              countDay();
                              location.reload();
                                        
                            });


                            scheduler.attachEvent("onEventChanged", function(id,e){
                                var event = scheduler.getEvent(id);
                                var isOnShift = true;

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
                                    event.text = "off班";
                                    isOnShift = false;
                                }
                                
                                // 一次只能夠改一天的預班
                                if(isOnShift) {
                                    // 預約on班
                                    if(checkResAmount(true, String(event.start_date), String(event.end_date))) {
                                        updateReservation(event.hidden, event.priority, event.start_date, event.end_date);
                                    }
                                }else {
                                    // 預約off班
                                    if(checkResAmount(false, String(event.start_date), String(event.end_date))) {
                                        updateReservation(event.hidden, event.priority, event.start_date, event.end_date);
                                    }
                                }

                                location.reload();
//                                countDay();
                                
                            
                                console.log(event.priority);
                                console.log(event.start_date);
                                console.log(event.end_date);
                                console.log(id);
                                console.log("hidden"+event.hidden);

                            });

                            scheduler.attachEvent("onBeforeEventDelete", function(id,e){
                                // 刪除 reservation
                                var event = scheduler.getEvent(id);


                                deleteReservation(event.hidden);
//                                countDay();
                                console.log(event.hidden);
                                console.log(id);
                                location.reload();
                                return true;
                            });

                            scheduler.attachEvent("onEventCollision", function (ev, evs){
                                  //any custom logic here
                                var count = scheduler.getEvents(ev.start_date, ev.end_date).length;
                                if(count>1){
                                    dhtmlx.message({ type:"error", text:"此日期已選過" });
                                    return true;
                                }
                                else{
                                    return false;

                                }

                                 return true;
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

                            //鎖定時間

                            var startd =new Date(res[3], month, 1); 
                            var endd = new Date(res[3], month+1, 1); 

                            console.log("startd "+startd);
                            console.log("endd "+endd);

                            scheduler.config.limit_start = new Date(startd);
                            scheduler.config.limit_end = new Date(endd);

                            scheduler.attachEvent("onLimitViolation", function  (id, obj){
                                dhtmlx.message({ type:"error", text:"此時段無法接受排班" })
                            });

                            scheduler.templates.lightbox_header = function(start, end, event){
                                if (event.text == "New") {
                                    return "預班";
                                } else {
                                    return "預班 " + event.text;
                                }
                            }

                            //進入畫面後顯示的東西
                            scheduler.init('scheduler_here',new Date(res[3],month),"month");

//                            scheduler.load("./reservation_data");
    //                            var dp = new dataProcessor("./reservation_data");
    //                            dp.init(scheduler);

                            // scheduler.load("./reservation_data");
                            //  var dp = new dataProcessor("./reservation_data");
                            //   dp.init(scheduler);

                           //讀取資料

                            @foreach($reservations as $reservation)

                                scheduler.parse([

                                { start_date: "{{ $reservation[0]->date }} 00:00", end_date: "{{$reservation[0]->endDate}} 00:00", text: "{{ $reservation[1] }}", priority:"{{ $reservation[0]->categorySerial}}", hidden:"{{ $reservation[0]->resSerial}}"},

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
