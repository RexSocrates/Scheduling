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
		<nav id="navbar" class="blue-grey darken-1">
	    	<div class="nav-wrapper logo-padding-left">
	    		<a onclick="sideNav()" class="blue-grey darken-1 waves-effect waves-light menu-btn">
	    			<i class="material-icons menu-icon" valign="middle">menu</i>
	    		</a>
			    <p class="brand-logo light">個人資料</p>
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
                <div class="col s4">                 
                    <div class="card">
                        <div class="card-action">
                            <font class="card-title">基本資料</font>
                        </div>
                        <div class="divider"></div>
                        <div class="card-content">
                            <center>
                                <img src="../img/boss.png" class="profile-img"/>
                            </center>
                            <p>醫生ID：{{ $doctor->doctorID }}</p>
                            <p>醫生名稱：{{ $doctor->name }}</p>
                            <p>email：{{ $doctor->email }}</p>
                            <p>級別： {{ $doctor->level }}</p>
                            <p>專職：{{ $doctor->major }}</p>
                            <p>職登院區：{{ $doctor->location }}</p>
                            <a href="#modal1">更改密碼</a>
                            
                        </div>
                    </div>
                </div>
                
                <div class="col s8">
                    <div class="card">
                        <div class="card-action">
                            <font class="card-title">排班歷史紀錄</font>
                        </div>
                        <div class="divider"></div>
                        <div class="card-content">

                        </div>
                    </div>	
                </div>
            </div>
        </div>
    </div>
    
    <div id="modal1" class="modal">
        <form action="#!" method="post">
            <div class="modal-content">
                <center>
                    <h4>更改密碼</h4>
                </center>
                <div class="input-field col s12">
                    <input id="title" type="password" value="" required>
                    <label for="title">目前的密碼</label>
                </div>   
                <div class="input-field col s12">
                    <input id="title" type="password" value="" required>
                    <label for="title">新密碼</label>
                </div>
                <div class="input-field col s12">
                    <input id="title" type="password" value="" required>
                    <label for="title">重新輸入新密碼</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save">確認</button>
                <button class="modal-action modal-close waves-effect waves-light btn-flat btn-cancel">關閉</button>
                
            </div>
        </form>
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

	
</body>
</html>

