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
			    <p class="brand-logo light">醫師公假紀錄</p>
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
                <div class="col s12 m12">
      		  	  	<div class="card">
      		  	  		<div class="card-action">
      		  	  			<font class="card-title">醫生列表</font>
      		  	  		</div>
      		  	  		<div class="divider"></div>
      		  	  	  	<div class="card-content">
      		  	  	  	    <table id="example" class="mdl-data-table striped highlight" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <tr>
                                        <th>醫生id</th>
                                        <th>醫生名稱</th>
                                        <th>專職科別</th>
                                        <th>級別</th>
                                        <th>職登院區</th>
                                        <th>權限</th>
                                        <th style="width:150px;">動作</th>
                                    </tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($doctorsLeave as $doctorObj)
                                        <tr>
                                            <td>{{ $doctorObj[0]->doctorID }}</td>
                                            <td>{{ $doctorObj[0]->name }}</td>
                                            <td>{{ $doctorObj[0]->major }}</td>
                                            <td>{{ $doctorObj[0]->level }}</td>
                                            <td>{{ $doctorObj[0]->location }}</td>
                                            <td>{{ $doctorObj[0]->identity }}</td>
                                            <td class="doctor-td">
                                                <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">詳細資料</a>
                                            </td>
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
	
    <!-- Modal Structure -->
    <div id="modal2" class="modal modal-fixed-footer modal-announcement">
        <form action="#!" method="post">
            <div class="modal-header" >
                <h5 class="modal-announcement-title">醫師公假紀錄</h5>
                <div class="nav-content">
                    <ul class=" tabs-fixed-width blue-grey darken-1">
                        <div class="indicator" style="right: 352px; left: 0px;"></div>
                    </ul>
                </div>
            </div>
<table id="example" class="mdl-data-table striped highlight" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width:90px;">提出時間</th>
                                        <th style="width:90px;">提出人</th>
                                        <th style="width:160px;">公假期間</th>
                                        <th style="width:120px;">內容</th>
                                        <th>時數</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($doctorsLeave as $leaves)
                                        @foreach($leaves[1] as $leave)
                                            <tr>
                                                <td>{{ $leave->recordDate }}</td>
                                                <td>{{ $leave->confirmingPersonID }}</td>
                                                <td>{{ $leave->leaveDate }}</td>
                                                <td>{{ $leave->remark }}</td>
                                                <td>{{ $leave->leaveHours }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
<!-- 
            <div class="modal-footer">
                <button type="submit" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save">Save</button> -->
                <button type="submit" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save">Cancel</button>
            </div>
        </form>
    </div>
    
        
	<script type="text/javascript" src="../js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="../js/materialize.min.js"></script>
    <script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../js/dataTables.material.min.js"></script>
    
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
        
        // 查看side-nav現在是處於哪一頁
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
        
        function sleep(milliseconds) {
            var start = new Date().getTime();
            for (var i = 0; i < 1e7; i++) {
                if ((new Date().getTime() - start) > milliseconds){
                    break;
                }
            }
        }
        
        $(document).ready(function() {
            $('#example').DataTable( {
                columnDefs: [
                    {
                        targets: [ 0, 1, 2 ],
                        className: 'mdl-data-table__cell--non-numeric'
                    }
                ]
            });
            
            $('select').material_select();
            
            
            var count = 0;
            
            for(i=0;i<4;i++){
                document.getElementById("example_length").getElementsByTagName("li")[i].addEventListener("click", ff);
            }            
            
        });
        
        var tttt = 0;
        
        function ff() {
            f1();
            f2();
        }
        
        

        

        
        function f1() {
            console.log("111");
            console.log(document.getElementById("example_length").getElementsByTagName("ul"));
            sleep(10000);
        }
        
        function f2() {
            console.log("222");
            console.log(document.getElementById("example_length").getElementsByTagName("ul"));
            sleep(10000);
        }
        

        
        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 200 // Creates a dropdown of 15 years to control year
        });
        
    </script>

	
</body>
</html>
