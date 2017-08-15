<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>馬偕醫院排班系統</title>

  	<!--Import Google Icon Font-->
    <link type="text/css" rel="stylesheet" href="../css/icon.css" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="../css/styles.css"/>
   	
   	<script src='../codebase/dhtmlxscheduler.js' type="text/javascript" charset="utf-8"></script>
	<script src='../codebase/ext/dhtmlxscheduler_timeline.js' type="text/javascript" charset="utf-8"></script>
	<script src='../codebase/ext/dhtmlxscheduler_container_autoresize.js' type="text/javascript" charset="utf-8"></script>

	<script src='../codebase/ext/dhtmlxscheduler_editors.js' type="text/javascript" charset="utf-8"></script>
	
	<link rel='stylesheet' type='text/css' href='../codebase/dhtmlxscheduler_flat.css'>

    <script src="../codebase/locale/locale_cn.js" type="text/javascript"></script>
    <script src="../codebase/locale/recurring/locale_recurring_cn.js" ></script>

    <script src="../codebase/ext/dhtmlxscheduler_collision.js"></script>
    <script src="../codebase/ext/dhtmlxscheduler_limit.js"></script>
    <script src="../../codebase/ext/dhtmlxscheduler_serialize.js" type="text/javascript" charset="utf-8"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
    <script>
        function sendNewReservation(categorySerial, startDate, endDate) {
            $.post('sendReservation', {
                serial : categorySerial,
                date1 : startDate,
                date2 : endDate
            }, function() {
                alert('預約成功');
            });
        }
        
        function updateReservation(resSerial, categorySerial, startDate, endDate) {
            $.post('sendReservationUpdate', {
                resSerial : resSerial,
                categorySerial : categorySerial,
                startDate : startDate,
                endDate : endDate
            }, function() {
                alert('預約修改成功');
            });
        }
    </script>

    <style>
   
        td{
            padding: 0;
        }

    </style>
</head>
<body>

	<nav id="slide-out" class="side-nav">
		<ul>
			<div class="logo-div">
				<a href="index.html" class="logo-a">
		    		<img src="../img/logo-mackay.png" class="logo-img">
		    		<font class="logo-p">馬偕醫院排班系統</font>
	   			</a>
	   		</div>
	   		<li class="divider"></li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header waves-effect active"><i class="material-icons"><img class="side-nav-icon" src="../img/calendar-prearrange.svg"></i>預班表</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="reservation">個人</a></li>
                                <li><a href="reservation-all">查看全部</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
    	  	<li><a href="first-edition.html" class="waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/calendar-first-edition.svg"></i>初版班表</a></li>
    	  	<li><a href="schedule.html" class="waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/calendar-schedule.svg"></i>正式班表</a></li>
    	  	<li><a href="shift.html" class="waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/calendar-exchange.svg"></i>調整班表</a></li>
    	  	<li><a href="doctor.html" class="waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/doctor.svg"></i>醫師管理</a></li>
    	</ul>
	</nav>
    
	<header id="header" class="container-fix trans-left-five">
		<nav id="navbar" class="nav-extended">
	    	<div class="nav-wrapper blue-grey darken-1 logo-padding-left">
	    		<a onclick="sideNav()" class="blue-grey darken-1 waves-effect waves-light menu-btn">
	    			<i class="material-icons menu-icon" valign="middle">menu</i>
	    		</a>
			    <font class="brand-logo light">預班表 <i class="material-icons arrow_right-icon">keyboard_arrow_right</i>個人</font>
			    <ul class="right">
			      	<li>
			      		<a class="dropdown-notification-button" href="#!" data-activates="dropdown-notification">
			      			<img src="../img/notifications-button.png" class="notifications-icon">
			      		</a>
			      	</li>
			      	<li>
			      		<a class="dropdown-button" href="#!" data-activates="dropdown1">張XX醫生<i class="material-icons right">arrow_drop_down</i>
			      		</a>
			      	</li>
			    </ul>
	    	</div>
	  	</nav>
		
		<ul id="dropdown-notification" class="dropdown-content">
            <li><font class="notification">5/12 李XX醫生換班成功<p>2 days ago</p></font></li>
            <li><font class="notification">5/11 系統公告 請去查閱<p>3 days ago</p></font></li>
        </ul>
        
	  	<ul id="dropdown1" class="dropdown-content">
		  	<li><a href="setting.html">設定</a></li>
		  	<li><a href="profile.html">個人資料</a></li>
		  	<li class="divider"></li>
		  	<li><a href="logout.html">登出</a></li>
		</ul>
        
        <a href="#" data-activates="slide-out" class="button-collapse"></a>
        
	</header>

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
                            
                            
                            <form action="reservation" method="post">
                                <div class="row margin-b0">
                                    <div class="col s5">
                                        <p class="information">開放時間: 2017/06/01 - 2017/06/25</p>
                                        <p class="information">可排天班數: 白班:{{$doctorDay}} 夜班:{{$doctorNight}}</p>
                                        <p class="information">尚需排班數: 白班:{{$countDay}} 夜班:{{$countNight}}</p>    
                                    </div>
                                    <div class="col s7">
                                        <form action="addRemark" method="post" class="col s6">
                                            <div class="input-field">
                                                <textarea id="textarea1" class="materialize-textarea"  name="remark"placeholder="請輸入XXXXX"></textarea>
<!--                                                     data-length="150"-->
                                                <label for="textarea1">備註:</label>
                                            </div>
                                            <!-- <input type="submit" class="waves-effect waves-light btn blue-grey darken-1 white-text right">提交</button> -->
                                            <input type="submit" class="waves-effect waves-light btn blue-grey darken-1 white-text right" value="提交">
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
                                 
                                var event = scheduler.getEvent(id);
                                
                                event.text = event.priority;
                                
//                                console.log(event.text);
                                
                                return true;
                            });

                            scheduler.attachEvent("onEventAdded", function(id,e){
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
                                }else if(event.priority == null){
                                    event.text = "沒選到班";
                                }
                                
                                // call ajax function
                                sendNewReservation(event.priority, event.start_date, event.end_date);
                                
                                console.log(event.priority);
                                console.log(event.start_date);
                                console.log(event.end_date);
                                
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
                                
                                updateReservation(event.hidden, event.priority, event.start_date, event.end_date);
                                
                                console.log(event.priority);
                                console.log(event.start_date);
                                console.log(event.end_date);
                                console.log(id);
                                console.log(event.hidden);
                                
                            });
                            
                            scheduler.attachEvent("onEventDeleted", function(id){
                                // 按下刪除之後
                                console.log(id);
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
                                // for(var i = 0 ; i<evs.length ; i++){
                                //     if(ev.start_date != evs[i].start_date){
                                //         return true;
                                //     }
                                //     else{
                                //         return false;
                                //     }
                                // }
                                
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

                            var startd =new Date(res[3], month-1, 1); 
                            var endd = new Date(res[3], month, 1); 
                            
                            console.log("startd "+startd);
                            console.log("endd "+endd);

                            scheduler.config.limit_start = new Date(startd);
                            scheduler.config.limit_end = new Date(endd);

                            scheduler.attachEvent("onLimitViolation", function  (id, obj){
                            dhtmlx.message({ type:"error", text:"此時段無法接受排班" })
                            });

                            
                            //進入畫面後顯示的東西

                           
                            scheduler.init('scheduler_here',new Date(),"month");

                            scheduler.load("./reservation_data");
//                            var dp = new dataProcessor("./reservation_data");
//                            dp.init(scheduler);

                            // scheduler.load("./reservation_data");
                            //  var dp = new dataProcessor("./reservation_data");
                            //   dp.init(scheduler);

                            
                              
                         //    //讀取資料

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

	<script type="text/javascript" src="../js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="../js/materialize.min.js"></script>
	<script type="text/javascript">
		var sideNav = (function() {
		  	var first = true;
		  	return function() {
		  	  	first ? slideToLeft() : slideToRight();
		  	  	first = !first;
		  	}
		})();
		
		function slideToLeft() {
		  	document.getElementById("slide-out").style.width = "0";
		    document.getElementById("header").style.marginLeft = "0";
		    document.getElementById("section").style.marginLeft = "0";
		};
		function slideToRight() {
			document.getElementById("slide-out").style.width = "250px";
		    document.getElementById("header").style.marginLeft = "250px";
		  	document.getElementById("section").style.marginLeft = "250px";
		};
        
//        查看side-nav現在是處於哪一頁
		$(".side-nav>ul>li").each(function() {
		    var navItem = $(this);
		    var href = window.location.href;
			var filename = href.replace(/^.*[\\\/]/, '')

		    if (navItem.find("a").attr("href") == filename) {
		      	navItem.addClass("active");
		    }
		});

		$(document).ready(function(){
  		  	// the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
  		  	$('.modal').modal();
  		});
        
        $('.dropdown-notification-button').dropdown({
            inDuration: 300,
            outDuration: 225,
            constrainWidth: false, // Does not change width of dropdown to that of the activator
            hover: true, // Activate on hover
            gutter: 0, // Spacing from edge
            belowOrigin: true, // Displays dropdown below the button
            alignment: 'right', // Displays dropdown with edge aligned to the left of button
            stopPropagation: false // Stops event propagation
        });
        
    </script>

	 {{ csrf_field() }}
</body>
</html>
