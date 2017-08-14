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
                        <a class="collapsible-header waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/calendar-schedule.svg"></i>正式班表</a>
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
                        <a class="collapsible-header waves-effect active"><i class="material-icons"><img class="side-nav-icon" src="../img/calendar-exchange.svg"></i>調整班表</a>
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
			    <font class="brand-logo light">調整班表 <i class="material-icons arrow_right-icon">keyboard_arrow_right</i>換班資訊</font>
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
                    <div class="card">
                        <div class="card-action">
      		  	  			<font class="card-title">換班資訊區</font>
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
                                   @foreach($shiftRecords as $record)
                                        <tr>
                                            <td class="td-padding">{{ $record['applier'] }}</td>
                                            <td class="td-padding">{{ $record['applyDate'] }}</td>
                                            <td class="td-padding">{{ $record['sch1Date'] }} <font class="font-w-b">{{ $record['sch1Content'] }} </font> 與 {{ $record['sch2Date'] }}  <font class="font-w-b">{{ $record['sch2Content'] }} </font> 互換</td>
                                            
                                            @if($record['adminConfirm'] == 0)
                                                <td class="td-padding"><a class="waves-effect waves-light btn pad-btn disabled">已確認</a></td>
                                            @else
                                                <td class="td-padding"><a href="adminAgreeShiftRecord/{{ $record['changeSerial'] }}" class="waves-effect waves-light btn">確認</a></td>
                                            @endif
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
                       
                        <div class="card-action card1">
                            <div class="title1">
                                <font class="card-title">備註</font>
                            </div>
                            <div class="right">
                                時間：
                                <div class="input-field inline">
                                    <select>
                                        <option value="" disabled selected>請選擇月份</option>
                                        <option value="1">2017年8月</option>
                                        <option value="2">2017年7月</option>
                                        <option value="3">2017年6月</option>
                                    </select>
                                </div>
                            </div>
      		  	  		</div>
      		  	  		
      		  	  		<div class="divider"></div>
      		  	  	  	
      		  	  	  	<div class="card-content">
                            <table class="centered striped highlight">
                                <thead>
                                    <tr>
                                        <th>提出人</th>
                                        <th>申請日期</th>
                                        <th>備註內容</th>
                                    </tr>
                                </thead>

                               <tbody>
                                   @foreach($remarks as $remark)
                                        <tr>
                                            <td class="td-padding">{{ $remark['author'] }}</td>
                                            <td class="td-padding">{{ $remark['date'] }}</td>
                                            <td class="td-padding">{{ $remark['content'] }}</td>
                                        </tr>
                                   @endforeach
                                </tbody>
                               
                            </table>
                        </div>
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
            $('select').material_select();
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
