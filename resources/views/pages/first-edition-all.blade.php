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
    	  	<li><a href="reservation.html" class="waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/calendar-prearrange.svg"></i>預班表</a></li>
    	  	<li><a href="first-edition.html" class="waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/calendar-first-edition.svg"></i>初版班表</a></li>
    	  	<li><a href="schedule.html" class="waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/calendar-schedule.svg"></i>正式班表</a></li>
    	  	<li><a href="shift.html" class="waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/calendar-exchange.svg"></i>調整班表</a></li>
    	  	<li><a href="doctor.html" class="waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/doctor.svg"></i>醫師管理</a></li>
    	</ul>
	</nav>
    
	<header id="header" class="container-fix trans-left-five">
		<nav id="navbar">
	    	<div class="nav-wrapper blue-grey darken-1 logo-padding-left">
	    		<a onclick="sideNav()" class="blue-grey darken-1 waves-effect waves-light menu-btn">
	    			<i class="material-icons menu-icon" valign="middle">menu</i>
	    		</a>
			    <p class="brand-logo light">初版班表</p>
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
	    	<div class="nav-content blue-grey darken-1">
                <ul class="tabs1 tabs-transparent">
                    <li class="tab1"><a href="first-edition.html">個人</a></li>
                    <li class="tab1"><a href="first-edition-all.html" class="tab-active">查看全部</a></li>
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

	<div id="section" class="container-fix trans-left-five">    <!--	 style="background-color:red;"-->
		<div class="container-section2">
		    <div class="row">
                <div class="col s12 m12">
                    <div class="card">
                        <div class="card-action">
      		  	  			<!-- <img src="../img/announcement.png" class="logo-img"> -->
      		  	  			<font class="card-title">換班資訊區</font>
      		  	  			<a class="btn-floating halfway-fab waves-effect waves-light red accent-2" href="#modal1"><i class="material-icons">add</i></a>
      		  	  			<!-- <a class="btn-floating halfway-fab waves-effect waves-light blue-grey darken-1"><i class="material-icons">add</i></a> -->
      		  	  		</div>
      		  	  		<div class="divider"></div>
      		  	  	  	
      		  	  	  	<div class="card-content">
                            <table class="centered striped highlight">
<!--
                                <thead>
                                    <tr>
                                        <th>申請人</th>
                                        <th>申請日期</th>
                                        <th>換班內容</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td class="td-padding">簡定國</td>
                                        <td class="td-padding">2017/07/19</td>
                                        <td class="td-padding">8/11 簡定國 與 8/14 陳心堂 互換</td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding">邱毓惠</td>
                                        <td class="td-padding">2017/07/21</td>
                                        <td class="td-padding">8/11 邱毓惠 與 8/14 黃章喜 互換</td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding">馮嚴毅</td>
                                        <td class="td-padding">2017/07/24</td>
                                        <td class="td-padding">8/11 馮嚴毅 與 8/14 謝尚霖 互換</td>
                                    </tr>
                                </tbody>
-->
                                
                                <thead>
                                    <tr>
                                        <th>申請人</th>
                                        <th>申請日期</th>
                                        <th>換班內容</th>
                                        <!-- <th>申請人</th>
                                        <th>申請日期</th>
                                        <th>換班內容</th> -->
                                    </tr>
                                </thead>

                                <tbody>

                                    <!--  <?php $count //= 0; 
                                     //@foreach($shiftRecords as $record)
                                       //  <?php 
                                             //if ($count % 2 == 0)
                                                 //echo '<tr>';
                                        ?>  -->
                                        @foreach($shiftRecords as $record)
                                   
                                    <tr>
                                        <td class="td-padding">{{ $record[0] }} </td> <!--申請人-->
                                        <td class="td-padding">{{ $record[6] }}</td>  <!--申請日期-->
                                        <td class="td-padding">{{ $record[2] }}  <!--申請人想換班的日期-->
                                            {{ $record[0] }} <!--申請人的名字-->
                                            {{ $record[4] }} <!--申請人換班名字-->
                                            與
                                            {{ $record[3] }} <!--被換班人的班日期-->
                                             {{ $record[1] }} <!--被換班人-->
                                            <font class="font-w-b">{{ $record[5] }}</font><!--被換班人的班名稱-->
                                            互換
                                        </td>
 <!-- 
                                        <?php 
                                         $count//++; 
                                         
                                         //if ($count % 2 == 0)
                                            // echo '</tr>'
                                        ?> -->
                                    </tr>
                                        @endforeach
                                    
                                    
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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
                            
                            //進入畫面後顯示的東西
                            scheduler.init('scheduler_here',new Date(),"timeline");
                             scheduler.parse([
                            @foreach($schedule as $data)
                                 { start_date: "{{ $data->date }} 00:00", end_date: "{{ $data->endDate }} 00:00", text:"{{ $data->doctorID }}", section_id:"{{ $data->schCategorySerial }}"},
                            @endforeach
                            ],"json");
                        </script>
                    </div>
                </div>
      		</div>
      		
      		
            <div id="modal1" class="modal modal-fixed-footer modal-shift">
                <form action='first-edition-all' method="POST">
                    <div class="modal-header">
                        <h5 class="modal-announcement-title">換班申請</h5>
                    </div>
                    <div class="modal-content modal-content-customize1">
                        <div class="row margin-b0">
                            <div class="col s12 center">
                                <img src="../img/exchange.svg" style="height: 220px;width: 220px;">
                            </div>
                            
                            
                            <div class="col s6">
                                <label>醫生:</label>
                                <select name= 'schID_1_doctor' class="browser-default" required>
                                    <option value="{{$currentDoctor->doctorID}}" selected>{{$currentDoctor->name}}</option>
                                </select>
                            </div>
                            <div class="col s6">
                                <label>醫生:</label>
                                <select name= 'schID_2_doctor' class="browser-default" required>
                                    <option value="" disabled selected>請選擇醫生</option>
                                    <option value="{{$doctorName->doctorID}}">{{$doctorName->name}}</option>
                                   
                                </select>
                            </div>
                            <div class="col s6">
                                <label>日期:</label>
                                <select name="scheduleID_1" class="browser-default" required>
                                    <option value="" disabled selected>請選擇日期</option>
                                    @foreach($currentDoctorSchedule as $data)
                                    <option value= '{{$data->scheduleID}}' >{{$data->date}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col s6">
                                <label>日期:</label>
                                <select  name='scheduleID_2' class="browser-default" required>
                                    <option value="" disabled selected>請選擇日期</option>
                                    @foreach($doctorSchedule as $data)
                                    <option value='{{$data->scheduleID}}'>{{$data->date}}</option>
                                    @endforeach
                                   
                                </select>
                            </div>
                            
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save">Save</button>
                        <button class="modal-action modal-close  waves-effect waves-light btn-flat btn-cancel">Cancel</button>
                        {{ csrf_field() }}
                    </div>
                </form>
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
//            document.getElementById("scheduler_here").style.width = "1500px";
		};
		function slideToRight() {
			document.getElementById("slide-out").style.width = "250px";
		    document.getElementById("header").style.marginLeft = "250px";
		  	document.getElementById("section").style.marginLeft = "250px";
//            document.getElementById("scheduler_here").style.width = "1000px";
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
        
        $(document).ready(function() {
            $('select').material_select();
        });
        
    </script>

	
</body>
</html>
