<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>馬偕醫院排班系統</title>

  	<!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="../css/styles.css"/>
   	<script src="../js/Chart.bundle.js"></script>
    <script src="../js/utils.js"></script>
</head>
<body>
	<header id="header">
		<nav id="slide-out" class="side-nav fixed">
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
	    	  	<li><a href="doctor.html" class="waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/pie-chart.svg"></i>統計圖表</a></li>
    		</ul>
		</nav>
		
		<nav>
	    	<div class="nav-wrapper blue-grey darken-3 logo-padding-left">
	    		<a onclick="sideNav()" class="blue-grey darken-3 waves-effect waves-light menu-btn">
	    			<i class="material-icons menu-icon" valign="middle">menu</i>
	    		</a>
			    <a href="doctor.html" class="brand-logo light">統計圖表</a>
			    <ul id="nav-mobile" class="right hide-on-med-and-down">
			      	<li>
			      		<a href="#.html">
			      			<img src="../img/notifications-button.png" class="notifications-icon">
			      		</a>
			      	</li>
			      	<li>
			      		<a class="dropdown-button" href="#!" data-activates="dropdown1">排班人員A<i class="material-icons right">arrow_drop_down</i>
			      		</a>
			      	</li>
			    </ul>
	    	</div>
	    	<div class="nav-content blue-grey darken-3">
			    <ul class="tabs tabs-transparent">
			        <li class="tab"><a class="active" href="#test1">排班人力配置統計</a></li>
			        <li class="tab"><a href="#test2">日夜班數統計</a></li>

			        <li class="tab"><a href="#test3">白夜班比率</a></li>
			    </ul>
		    </div>
	  	</nav>

	  	<ul id="dropdown1" class="dropdown-content">
		  	<li><a href="setting.html">設定</a></li>
		  	<li><a href="profile.html">個人資料</a></li>
		  	<li class="divider"></li>
		  	<li><a href="logout.html">登出</a></li>
		</ul>
	  	
        <a href="#" data-activates="slide-out" class="button-collapse"></a>
	</header>
	
	<div id="section" class="container-fix trans-left-five">
	    <div class="container-section2">
	    	<div class="row">
		       	<div id="test1" class="col s12">
			       	<div class="card">
	                        <div class="card-action">
	                        
	                            <p class="inline">醫師名稱</p>
							  	<select class="browser-default">
								    <option value="" disabled selected>選擇醫師名稱</option>
								    <option value="1">全部醫師</option>
								    <option value="2">張國訟</option>
								    <option value="3">王樹林</option>
							  	</select>
							  	<a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">確認</a>
	                        </div>
	                        <div class="divider"></div>
	                        <div class="card-content">
								<div class="row">
					     			<div class="col s6">
					                    <center>      
									       	<div style="width: 300px;height: 300px;margin: 40px 0px 0px 0px">
									       		<div id="canvas-holder" style="width:100%">
										        	<canvas id="chart-area"/>
										   		</div>
											</div>
										</center>
									</div>  
									<div class="col s4">
										<table class="bordered centered">
									        <thead>
									            <tr>
									                <th>醫生名字</th>
									                <th>張國訟</th>
									             </tr>
									        </thead>
									        <tbody>
									            <tr>
									                <td>總班數</td>
									                <td>15</td>
									            </tr>
									            <tr>
									                <td>台北白班</td>
									                <td>10</td>
									            </tr>
									            <tr>
									                <td>台北夜班</td>
									                <td>0</td>
									            </tr>
									            <tr>
									                <td>淡水白班</td>
									            	<td>0</td>
									            </tr>
									            <tr>
									            	<td>淡水夜班</td>
									            	<td>2</td>
									            </tr>
									            <tr>
									            	<td>行政教學班</td>
									            	<td>3</td>
									            </tr>
									        </tbody>
									    </table>
									</div>
	                        	</div>
	                		</div>  
		       		</div>
		       	</div>	
				<div id="test2" class="col s12">
					
					<div class="card">
	                        <div class="card-action">
	                            <font class="card-title">基本資訊</font>
	                        </div>
	                        <div class="divider"></div>
	                        <div class="card-content">
	                            <p>醫師名稱</p>
								  <select class="browser-default">
									    <option value="" disabled selected>選擇醫師名稱</option>
									    <option value="1">全部醫師</option>
									    <option value="2">張國訟</option>
									    <option value="3">王樹林</option>
								  </select>
	                            
	                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">確認</a>
	                        </div>
	                </div>
	                <table class="bordered centered">
				        <thead>
				            <tr>
					            <th>醫生名字</th>
					            <th>張國訟</th>
				            </tr>
				        </thead>
				        <tbody>
				            <tr>
				            	<td>總班數</td>
				            	<td>15</td>
				            </tr>
				            <tr>
				            	<td>台北白班</td>
				            	<td>10</td>
				            </tr>
				            <tr>
				            	<td>台北夜班</td>
				            	<td>0</td>
				            </tr>
				            <tr>
				            	<td>淡水白班</td>
				            	<td>0</td>
				            </tr>
				            <tr>
				            	<td>淡水夜班</td>
				            	<td>2</td>
				            </tr>
				            <tr>
				            	<td>行政教學班</td>
				            	<td>3</td>
				            </tr>
				        </tbody>
					</table>
					
			   </div>
				<div id="test3" class="col s12">
					 	<div class="card">
			                <table class="bordered centered striped">
						        <thead>
							        <tr>
							            <th>   </th>
							            <th>總班數</th>
							            <th>15</th>
							            <th>14</th>
							            <th>13</th>
							            <th>12</th>
							            <th>11</th>
							            <th>10</th>
							            <th>9</th>
							            <th>8</th>
							        </tr>
							        <tr>
							            <th>A1</th>
							            <th>白班</th>
							            <th>7</th>
							            <th>6</th>
							            <th>6</th>
							            <th>5</th>
							            <th>5</th>
							            <th>4</th>
							            <th>4</th>
							            <th>3</th>
							        </tr>
							        <tr>
							            <th>A5</th>
							            <th>夜班</th>
							            <th>8</th>
							            <th>8</th>
							            <th>7</th>
							            <th>7</th>
							            <th>6</th>
							            <th>6</th>
							            <th>5</th>
							            <th>5</th>
							        </tr>
							        <tr>
							            <th>A6</th>
							            <th>白班</th>
							            <th>8</th>
							            <th>7</th>
							            <th>7</th>
							            <th>6</th>
							            <th>6</th>
							            <th>5</th>
							            <th>5</th>
							            <th>4</th>
							        </tr>
							        <tr>
							            <th>S4</th>
							            <th>夜班</td>
							            <th>7</th>
							            <th>7</th>
							            <th>6</th>
							            <th>6</th>
							            <th>5</th>
							            <th>5</th>
							            <th>4</th>
							            <th>4</th>
							        </tr>
							        <tr>
							            <th>S5</th>
							            <th>白班</th>
							            <th>9</th>
							            <th>8</th>
							            <th>8</th>
							            <th>7</th>
							            <th>7</th>
							            <th>4</th>
							            <th>4</th>
							            <th>5</th>
							        </tr>
							        <tr>
							            <th>S9</th>
							            <th>夜班</td>
							            <th>6</th>
							            <th>6</th>
							            <th>5</th>
							            <th>5</th>
							            <th>4</th>
							            <th>4</th>
							            <th>3</th>
							            <th>3</th>
							        </tr>
							        <tr>
							            <th>S10</th>
							            <th>白班</th>
							            <th>10</th>
							            <th>9</th>
							            <th>9</th>
							            <th>8</th>
							            <th>8</th>
							            <th>7</th>
							            <th>7</th>
							            <th>6</th>
							        </tr>
							        <tr>
							            <th>以上</th>
							            <th>夜班</th>
							            <th>5</th>
							            <th>5</th>
							            <th>4</th>
							            <th>4</th>
							            <th>3</th>
							            <th>3</th>
							            <th>2</th>
							            <th>2</th>
							        </tr>
						        </tbody>
						    </table>
					    </div>
				</div> 
			</div>
		</div>
	</div>
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
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

		$(".side-nav>ul>li").each(function() {
		    var navItem = $(this);
		    var href = window.location.href;
			var filename = href.replace(/^.*[\\\/]/, '')

		    if (navItem.find("a").attr("href") == filename) {
		      	navItem.addClass("active");
		    }
		});
    </script>
    	
  
    <script>
	    var config = {

	        type: 'pie',
	        data: {
	            datasets: [{
	                data: [
	                    10,
	                    0,
	                    0,
	                    2,
	                    3,
	                ],
	                backgroundColor: [
	                    window.chartColors.red,
	                    window.chartColors.orange,
	                    window.chartColors.yellow,
	                    window.chartColors.green,
	                    window.chartColors.blue,
	                ],
	                label: 'Dataset 1'
	            }],
	            labels: [
	                "台北白斑",
	                "台北夜班",
	                "淡水白班",
	                "淡水夜班",
	                "行政教學班"
	            ]
	        },
	        options: {
	            responsive: true
	        }
	    };

	    window.onload = function() {
	        var ctx = document.getElementById("chart-area").getContext("2d");
	        window.myPie = new Chart(ctx, config);
	    };

    
    </script>
</body>
</html>