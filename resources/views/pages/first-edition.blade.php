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
		<div class="container-section">
			<div class="row">
                <div class="col s12 m12">
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
                                {key:1, label:"副院長臨床/行政"},
                                {key:2, label:"台北 臨床/行政"},
                                {key:3, label:"淡水 臨床/行政"},
                                {key:4, label:"臨床/教學"},
                                {key:5, label:"FeCR重症/外傷"},
                                {key:6, label:"北白急救"},
                                {key:7, label:"北白發燒"},
                                {key:8, label:"北白內1"},
                                {key:9, label:"北白內2"},
                                {key:10, label:"內科1010"},
                                {key:11, label:"北白外1"},
                                {key:12, label:"北白外2"},
                                {key:13, label:"北夜急救"},
                                {key:14, label:"北夜發燒"},
                                {key:15, label:"北夜內1"},
                                {key:16, label:"北夜內2"},
                                {key:17, label:"北夜外1"},
                                {key:18, label:"北夜外2"},
                                {key:19, label:"淡白內1"},
                                {key:20, label:"淡白內2"},
                                {key:21, label:"淡白外1"},
                                {key:22, label:"淡白外2"},
                                {key:23, label:"淡夜內1"},
                                {key:24, label:"淡夜內2"},
                                {key:25, label:"北白內1"},
                                {key:26, label:"北白內2"},
                                {key:27, label:"北白發燒"},
                                {key:28, label:"北白外"},
                                {key:29, label:"北夜內1"},
                                {key:30, label:"北夜內2"},
                                {key:31, label:"北夜外"},
                                {key:32, label:"內科白"},
                                {key:33, label:"淡夜外"}
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
        
    </script>

	
</body>
</html>
