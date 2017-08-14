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
    	  	<li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/calendar-first-edition.svg"></i>初版班表</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="first-edition.html">個人</a></li>
                                <li><a href="first-edition-all.html">查看全部</a></li>
                                <li><a href="first-edition-shift-info.html">換班資訊</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
    	  	<li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header waves-effect active"><i class="material-icons"><img class="side-nav-icon" src="../img/calendar-schedule.svg"></i>正式班表</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="schedule.html">個人</a></li>
                                <li><a href="schedule-all.html">查看全部</a></li>
                                <li><a href="schedule-shift-info.html">換班資訊</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
    	  	<li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/calendar-exchange.svg"></i>調整班表</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="shift-first-edition.html">初版班表</a></li>
                                <li><a href="shift-scheduler.html">正式班表</a></li>
                                <li><a href="shift-info.html">換班資訊</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
    	  	<li><a href="doctor.html" class="waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/doctor.svg"></i>醫師管理</a></li>
    	  	
    	</ul>
    	
        
	</nav>
    
	<header id="header" class="container-fix trans-left-five">
		<nav id="navbar">
	    	<div class="nav-wrapper blue-grey darken-1 logo-padding-left">
	    		<a onclick="sideNav()" class="blue-grey darken-1 waves-effect waves-light menu-btn">
	    			<i class="material-icons menu-icon" valign="middle">menu</i>
	    		</a>
                <font class="brand-logo light">正式班表 <i class="material-icons arrow_right-icon">keyboard_arrow_right</i>換班資訊</font>
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
<!--
	    	<div class="nav-content blue-grey darken-1">
                <ul class="tabs1 tabs-transparent">
                    <li class="tab1"><a href="first-edition.html">個人</a></li>
                    <li class="tab1"><a href="first-edition-all.html">查看全部</a></li>
                    <li class="tab1"><a href="first-edition-shift.html" class="tab-active">換班資訊</a></li>
                </ul>
            </div>
-->
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
                                <thead>
                                    <tr>
                                        <th>申請人</th>
                                        <th>申請日期</th>
                                        <th>換班內容</th>
                                        
                                    </tr>
                                </thead>

                               <tbody>
                                   @foreach($confirmedArr as $record)
                                        <tr>
                                             <td class="td-padding">{{ $record['applier'] }}</td>
                                             <td class="td-padding">{{ $record['applyDate'] }}</td>
                                             <td class="td-padding">{{ $record['sch1Date'] }} <font class="font-w-b">{{ $record['sch1Content'] }}</font> 與 {{ $record['sch2Date'] }} <font class="font-w-b">{{ $record['sch2Content'] }}</font> 互換</td>
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
      		  	  	<div class="card">
                        <div class="card-action">
      		  	  			<font class="card-title">換班待確認</font>
      		  	  		</div>
      		  	  		<div class="divider"></div>
      		  	  	  	
      		  	  	  	<div class="card-content">
                            <table class="centered striped highlight">
                                <thead>
                                    <tr>
                                        <th>申請人</th>
                                        <th>申請日期</th>
                                        <th>換班內容</th>
                                        <th>功能</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($unconfirmedArr as $record)
                                        <tr>
                                            <td class="td-padding">{{$record['applier']}}</td>
                                            <td class="td-padding">{{$record['applyDate']}}</td>
                                            <td class="td-padding">{{$record['sch1Date']}} <font class="font-w-b">{{$record['sch1Content']}}</font> 與 {{$record['sch2Date']}} <font class="font-w-b">{{ $record['sch2Content'] }}</font> 互換</td>
                                            <td class="td-padding">
                                                <a href="doctor2AgreeShiftRecord/{{$record['changeSerial']}}" class="waves-effect waves-light btn">允許</a>
                                                <a href="doctor2DenyShiftRecord/{{$record['changeSerial']}}" class="waves-effect waves-light btn deep-orange darken-3">拒絕</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                    <tr>
                                        <td class="td-padding">簡定國</td>
                                        <td class="td-padding">2017/07/19</td>
                                        <td class="td-padding">8/11 <font class="font-w-b">簡定國 北白內1</font> 與 8/14 <font class="font-w-b">張XX 淡白內1</font> 互換</td>
                                        <td class="td-padding">
                                            <a class="waves-effect waves-light btn">允許</a>
                                            <a class="waves-effect waves-light btn deep-orange darken-3">拒絕</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding">邱毓惠</td>
                                        <td class="td-padding">2017/07/21</td>
                                        <td class="td-padding">8/16 <font class="font-w-b">邱毓惠 北白內1</font> 與 8/14 <font class="font-w-b">張XX 淡白內1</font> 互換</td>
                                        <td class="td-padding">
                                            <a class="waves-effect waves-light btn">允許</a>
                                            <a class="waves-effect waves-light btn deep-orange darken-3">拒絕</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding">馮嚴毅</td>
                                        <td class="td-padding">2017/07/24</td>
                                        <td class="td-padding">8/20 <font class="font-w-b">馮嚴毅 北白內1</font> 與 8/14 <font class="font-w-b">張XX 淡白內1</font> 互換</td>
                                        <td class="td-padding">
                                            <a class="waves-effect waves-light btn">允許</a>
                                            <a class="waves-effect waves-light btn deep-orange darken-3">拒絕</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
      		</div>
      		
      		
            <div id="modal1" class="modal modal-fixed-footer modal-shift">
                <form action="#!" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-announcement-title">換班申請</h5>
                    </div>
                    <div class="modal-content modal-content-customize1">
                        <div class="row margin-b0">
                            <div class="col s12 center padding-b10">
                                <img src="../img/exchange.svg" style="height: 220px;width: 220px;">
                            </div>
                            
                            <div class="col s6">
                                <label>醫生:</label>
                                <select class="browser-default" disabled>
                                    <option value="1" selected>簡定國</option>
                                </select>
                            </div>
                            <div class="col s6">
                                <label>醫生:</label>
                                <select class="browser-default">
                                    <option value="" disabled selected>請選擇醫生</option>
                                    <option value="1">邱毓惠</option>
                                    <option value="2">馮嚴毅</option>
                                    <option value="3">陳心堂</option>
                                    <option value="1">邱毓惠</option>
                                    <option value="2">馮嚴毅</option>
                                    <option value="3">陳心堂</option>
                                    <option value="1">邱毓惠</option>
                                    <option value="2">馮嚴毅</option>
                                    <option value="3">陳心堂</option>
                                    <option value="1">邱毓惠</option>
                                    <option value="2">馮嚴毅</option>
                                    <option value="3">陳心堂</option>
                                    <option value="1">邱毓惠</option>
                                    <option value="2">馮嚴毅</option>
                                    <option value="3">陳心堂</option>
                                    <option value="1">邱毓惠</option>
                                    <option value="2">馮嚴毅</option>
                                    <option value="3">陳心堂</option>
                                    <option value="1">邱毓惠</option>
                                    <option value="2">馮嚴毅</option>
                                    <option value="3">陳心堂</option>
                                </select>
                            </div>
                            <div class="col s6">
                                <label>日期:</label>
                                <select class="browser-default">
                                    <option value="" disabled selected>請選擇日期</option>
                                    <option value="1">2017/08/05</option>
                                    <option value="2">2017/08/17</option>
                                    <option value="3">2017/08/26</option>
                                    <option value="1">2017/08/05</option>
                                    <option value="2">2017/08/17</option>
                                    <option value="3">2017/08/26</option>
                                    <option value="1">2017/08/05</option>
                                    <option value="2">2017/08/17</option>
                                    <option value="3">2017/08/26</option>
                                    <option value="1">2017/08/05</option>
                                    <option value="2">2017/08/17</option>
                                    <option value="3">2017/08/26</option>
                                    <option value="1">2017/08/05</option>
                                    <option value="2">2017/08/17</option>
                                    <option value="3">2017/08/26</option>
                                </select>
                            </div>
                            <div class="col s6">
                                <label>日期:</label>
                                <select class="browser-default">
                                    <option value="" disabled selected>請選擇日期</option>
                                    <option value="1">2017/08/06</option>
                                    <option value="2">2017/08/09</option>
                                    <option value="3">2017/08/14</option>
                                    <option value="1">2017/08/06</option>
                                    <option value="2">2017/08/09</option>
                                    <option value="1">2017/08/06</option>
                                    <option value="2">2017/08/09</option>
                                    <option value="3">2017/08/14</option>
                                    <option value="1">2017/08/06</option>
                                    <option value="2">2017/08/09</option>
                                    <option value="3">2017/08/14</option>
                                    <option value="1">2017/08/06</option>
                                    <option value="2">2017/08/09</option>
                                    <option value="3">2017/08/14</option>
                                </select>
                            </div>
                            
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save">Save</button>
                        <button class="modal-action modal-close  waves-effect waves-light btn-flat btn-cancel">Cancel</button>
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
            $('select').material_select();
            $('.collapsible').collapsible();
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
