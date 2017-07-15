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
		<nav id="navbar">
	    	<div class="nav-wrapper blue-grey darken-1 logo-padding-left">
	    		<a onclick="sideNav()" class="blue-grey darken-1 waves-effect waves-light menu-btn">
	    			<i class="material-icons menu-icon" valign="middle">menu</i>
	    		</a>
			    <p class="brand-logo light">首頁</p>
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
<!--
        <ul id="dropdown-notification" class="dropdown-content">
            <li><a href="#!">換班成功</a></li>
            <li><a href="#!">5/12換班成功</a></li>
        </ul>
-->
        
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
      		  	<div class="col s12 m8">
      		  	  	<div class="card">
      		  	  		<div class="card-action">
      		  	  			<!-- <img src="../img/announcement.png" class="logo-img"> -->
      		  	  			<font class="card-title">系統公告</font>
      		  	  			<a class="btn-floating halfway-fab waves-effect waves-light red accent-2" href="#modal1"><i class="material-icons">add</i></a>
      		  	  			<!-- <a class="btn-floating halfway-fab waves-effect waves-light blue-grey darken-1"><i class="material-icons">add</i></a> -->
      		  	  		</div>
      		  	  		<div class="divider"></div>
      		  	  	  	
      		  	  	  	<div class="card-content"><!--  style="height: 500px; overflow-y: scroll;" -->
      		  	  	  	
      		  	  	  		<div class="row">
    						  	<div class="col s2">
    						  		<img src="../img/user.png" class="boss-img">
    						  	</div>
    						  	<div class="col s10">
    						  		<span class="card-title">Card Title<a class="dropdown-edit-button right" href="#!" data-activates='dropdown-announcement'><i class="material-icons">more_vert</i></a></span>
    						  		<p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card. I am good at... <a href="#modal-more">more</a></p>
    						  	</div>
    						</div>
    						<ul id='dropdown-announcement' class='dropdown-content'>
                                <li><a href="#!">編輯</a></li>
                                <li><a href="#!">刪除</a></li>
                            </ul>
    						<div class="divider margin-bottom-20"></div>
    						
    						<div class="row">
    						  	<div class="col s2">
    						  		<img src="../img/user.png" class="boss-img">
    						  	</div>
    						  	<div class="col s10">
    						  		<span class="card-title">Card Title<a class="dropdown-edit-button right" href="#!" data-activates='dropdown-announcement'><i class="material-icons">more_vert</i></a></span>
    						  		<p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card. I am good at... <a href="#modal-more">more</a></p>
    						  	</div>
    						</div>
    						<ul id='dropdown-announcement' class='dropdown-content'>
                                <li><a href="#!">編輯</a></li>
                                <li><a href="#!">刪除</a></li>
                            </ul>
    						<div class="divider margin-bottom-20"></div>
    						
    						
    						
    						<!-- <div class="row">
    						  	<div class="col s2">
    						  		<img src="../img/user.png" class="boss-img">
    						  	</div>
    						  	<div class="col s10">
    						  		<span class="card-title">Card Title</span>
    						  		<p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.</p>
    						  	</div>
    						</div>
    						<div class="divider margin-bottom-20"></div>
    						<div class="row">
    						  	<div class="col s2">
    						  		<img src="../img/user.png" class="boss-img">
    						  	</div>
    						  	<div class="col s10">
    						  		<span class="card-title">Card Title</span>
    						  		<p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.</p>
    						  	</div>
    						</div>
    						<div class="divider margin-bottom-20"></div>
    						<div class="row">
    						  	<div class="col s2">
    						  		<img src="../img/user.png" class="boss-img">
    						  	</div>
    						  	<div class="col s10">
    						  		<span class="card-title">Card Title</span>
    						  		<p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.</p>
    						  	</div>
    						</div>
    						<div class="divider margin-bottom-20"></div>
    						<div class="row">
    						  	<div class="col s2">
    						  		<img src="../img/user.png" class="boss-img">
    						  	</div>
    						  	<div class="col s10">
    						  		<span class="card-title">Card Title</span>
    						  		<p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.</p>
    						  	</div>
    						</div>
    						<div class="divider margin-bottom-20"></div> -->
    						<div class="row margin-b0">
    						  	<div class="col s2">
    						  		<img src="../img/user.png" class="boss-img">
    						  	</div>
    						  	<div class="col s10">
    						  		<span class="card-title">Card Title<a class="dropdown-edit-button right" href="#!" data-activates='dropdown-announcement'><i class="material-icons">more_vert</i></a></span>
    						  		<p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card. I am good at... <a href="#modal-more">more</a></p>
    						  	</div>
    						</div>
                            <ul id='dropdown-announcement' class='dropdown-content'>
                                <li><a href="#!">編輯</a></li>
                                <li><a href="#!">刪除</a></li>
                            </ul>
      		  	  	  	</div>
      		  	  	  	
      		  	  	</div>
      		  	</div>
				
				<div class="col s12 m4">
      		  	  	<div class="card center">
              			<img src="../img/solar-system.png" class="solar-system">
              			<p></p>
              			<h3 class="blue-grey-text text-darken-3">開放預班中</h3>
      		  	  		<p class="blue-grey-text text-darken-3" style="font-weight: 500;">01/05/2017 ~ 20/05/2017</p>
      		  	  	  	<div class="card-action center">
      		  	  	  	  	<a href="reservation.html" class="margin-r0">前往預班表</a>
      		  	  	  	</div>
      		  	  	</div>
      		  	</div>
      		  	
      		</div>
			
			
			<!-- Modal Structure -->
            <div id="modal1" class="modal modal-fixed-footer modal-announcement">
                <form action="#!" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-announcement-title">公告</h5>
                    </div>
                    <div class="modal-content modal-content-customize">
                        <div class="row margin-b0">
                            <div class="input-field col s12">
                                <i class="material-icons prefix modal-icons">chat_bubble</i>
                                <input id="title" type="text">
                                <label for="title">標題</label>
                            </div>
                        
                            <div class="input-field col s12">
                                <i class="material-icons prefix modal-icons">mode_edit</i>
                                <textarea id="textarea1" class="materialize-textarea margin-b0" type="text"></textarea>
                                <label for="textarea1">內容</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save">Save</button>
                        <button class="modal-action modal-close waves-effect waves-light btn-flat btn-cancel">Cancel</button>
                    </div>
                </form>
            </div>
            
            <div id="modal-more" class="modal modal-fixed-footer modal-announcement">
                <div class="modal-header">
                    <h5 class="modal-announcement-title">公告</h5>
                </div>
                
                <div class="modal-content modal-content-customize">
                    <div class="row margin-b0">
    				    <div class="col s12">
                            <h5 class="card-title">Card Title</h5>
    				    	<p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.</p>
    				    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#!" class="modal-action modal-close waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save">Close</a>
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
        
        $('.dropdown-edit-button').dropdown({
            inDuration: 300,
            outDuration: 225,
            constrainWidth: false, // Does not change width of dropdown to that of the activator
            hover: false, // Activate on hover
            gutter: 0, // Spacing from edge
            belowOrigin: false, // Displays dropdown below the button
            alignment: 'right', // Displays dropdown with edge aligned to the left of button
            stopPropagation: false // Stops event propagation
        });
        
    </script>

	
</body>
</html>
