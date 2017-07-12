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
    
<!--    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js">-->
<!--    <link type="text/css" rel="stylesheet" href="../css/dataTables.material.min.css"/>-->

<!--this-->
<!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-lite/1.1.0/material.min.css">-->
<!--    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">-->


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
			    <p class="brand-logo light">醫師管理</p>
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
                            <a class="btn-floating halfway-fab waves-effect waves-light red accent-2" href="#modal1"><i class="material-icons">add</i></a>
      		  	  		</div>
      		  	  		<div class="divider"></div>
      		  	  	  	<div class="card-content">
      		  	  	  	    <table id="example" class="mdl-data-table striped highlight" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>醫生id</th>
                                        <th>醫生名稱</th>
                                        <th>專職科別</th>
                                        <th>級別</th>
                                        <th>職登院區</th>
                                        <th>權限</th>
                                        <th style="width:150px;">動作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>$320,800</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Garrett Winters</td>
                                        <td>Accountant</td>
                                        <td>Tokyo</td>
                                        <td>63</td>
                                        <td>2011/07/25</td>
                                        <td>$170,750</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ashton Cox</td>
                                        <td>Junior Technical Author</td>
                                        <td>San Francisco</td>
                                        <td>66</td>
                                        <td>2009/01/12</td>
                                        <td>$86,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cedric Kelly</td>
                                        <td>Senior Javascript Developer</td>
                                        <td>Edinburgh</td>
                                        <td>22</td>
                                        <td>2012/03/29</td>
                                        <td>$433,060</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Airi Satou</td>
                                        <td>Accountant</td>
                                        <td>Tokyo</td>
                                        <td>33</td>
                                        <td>2008/11/28</td>
                                        <td>$162,700</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Brielle Williamson</td>
                                        <td>Integration Specialist</td>
                                        <td>New York</td>
                                        <td>61</td>
                                        <td>2012/12/02</td>
                                        <td>$372,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Herrod Chandler</td>
                                        <td>Sales Assistant</td>
                                        <td>San Francisco</td>
                                        <td>59</td>
                                        <td>2012/08/06</td>
                                        <td>$137,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Rhona Davidson</td>
                                        <td>Integration Specialist</td>
                                        <td>Tokyo</td>
                                        <td>55</td>
                                        <td>2010/10/14</td>
                                        <td>$327,900</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Colleen Hurst</td>
                                        <td>Javascript Developer</td>
                                        <td>San Francisco</td>
                                        <td>39</td>
                                        <td>2009/09/15</td>
                                        <td>$205,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sonya Frost</td>
                                        <td>Software Engineer</td>
                                        <td>Edinburgh</td>
                                        <td>23</td>
                                        <td>2008/12/13</td>
                                        <td>$103,600</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jena Gaines</td>
                                        <td>Office Manager</td>
                                        <td>London</td>
                                        <td>30</td>
                                        <td>2008/12/19</td>
                                        <td>$90,560</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Quinn Flynn</td>
                                        <td>Support Lead</td>
                                        <td>Edinburgh</td>
                                        <td>22</td>
                                        <td>2013/03/03</td>
                                        <td>$342,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Charde Marshall</td>
                                        <td>Regional Director</td>
                                        <td>San Francisco</td>
                                        <td>36</td>
                                        <td>2008/10/16</td>
                                        <td>$470,600</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Haley Kennedy</td>
                                        <td>Senior Marketing Designer</td>
                                        <td>London</td>
                                        <td>43</td>
                                        <td>2012/12/18</td>
                                        <td>$313,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tatyana Fitzpatrick</td>
                                        <td>Regional Director</td>
                                        <td>London</td>
                                        <td>19</td>
                                        <td>2010/03/17</td>
                                        <td>$385,750</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Michael Silva</td>
                                        <td>Marketing Designer</td>
                                        <td>London</td>
                                        <td>66</td>
                                        <td>2012/11/27</td>
                                        <td>$198,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Paul Byrd</td>
                                        <td>Chief Financial Officer (CFO)</td>
                                        <td>New York</td>
                                        <td>64</td>
                                        <td>2010/06/09</td>
                                        <td>$725,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gloria Little</td>
                                        <td>Systems Administrator</td>
                                        <td>New York</td>
                                        <td>59</td>
                                        <td>2009/04/10</td>
                                        <td>$237,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Bradley Greer</td>
                                        <td>Software Engineer</td>
                                        <td>London</td>
                                        <td>41</td>
                                        <td>2012/10/13</td>
                                        <td>$132,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dai Rios</td>
                                        <td>Personnel Lead</td>
                                        <td>Edinburgh</td>
                                        <td>35</td>
                                        <td>2012/09/26</td>
                                        <td>$217,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jenette Caldwell</td>
                                        <td>Development Lead</td>
                                        <td>New York</td>
                                        <td>30</td>
                                        <td>2011/09/03</td>
                                        <td>$345,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Yuri Berry</td>
                                        <td>Chief Marketing Officer (CMO)</td>
                                        <td>New York</td>
                                        <td>40</td>
                                        <td>2009/06/25</td>
                                        <td>$675,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Caesar Vance</td>
                                        <td>Pre-Sales Support</td>
                                        <td>New York</td>
                                        <td>21</td>
                                        <td>2011/12/12</td>
                                        <td>$106,450</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Doris Wilder</td>
                                        <td>Sales Assistant</td>
                                        <td>Sidney</td>
                                        <td>23</td>
                                        <td>2010/09/20</td>
                                        <td>$85,600</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Angelica Ramos</td>
                                        <td>Chief Executive Officer (CEO)</td>
                                        <td>London</td>
                                        <td>47</td>
                                        <td>2009/10/09</td>
                                        <td>$1,200,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gavin Joyce</td>
                                        <td>Developer</td>
                                        <td>Edinburgh</td>
                                        <td>42</td>
                                        <td>2010/12/22</td>
                                        <td>$92,575</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jennifer Chang</td>
                                        <td>Regional Director</td>
                                        <td>Singapore</td>
                                        <td>28</td>
                                        <td>2010/11/14</td>
                                        <td>$357,650</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Brenden Wagner</td>
                                        <td>Software Engineer</td>
                                        <td>San Francisco</td>
                                        <td>28</td>
                                        <td>2011/06/07</td>
                                        <td>$206,850</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fiona Green</td>
                                        <td>Chief Operating Officer (COO)</td>
                                        <td>San Francisco</td>
                                        <td>48</td>
                                        <td>2010/03/11</td>
                                        <td>$850,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Shou Itou</td>
                                        <td>Regional Marketing</td>
                                        <td>Tokyo</td>
                                        <td>20</td>
                                        <td>2011/08/14</td>
                                        <td>$163,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Michelle House</td>
                                        <td>Integration Specialist</td>
                                        <td>Sidney</td>
                                        <td>37</td>
                                        <td>2011/06/02</td>
                                        <td>$95,400</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Suki Burks</td>
                                        <td>Developer</td>
                                        <td>London</td>
                                        <td>53</td>
                                        <td>2009/10/22</td>
                                        <td>$114,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Prescott Bartlett</td>
                                        <td>Technical Author</td>
                                        <td>London</td>
                                        <td>27</td>
                                        <td>2011/05/07</td>
                                        <td>$145,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gavin Cortez</td>
                                        <td>Team Leader</td>
                                        <td>San Francisco</td>
                                        <td>22</td>
                                        <td>2008/10/26</td>
                                        <td>$235,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Martena Mccray</td>
                                        <td>Post-Sales support</td>
                                        <td>Edinburgh</td>
                                        <td>46</td>
                                        <td>2011/03/09</td>
                                        <td>$324,050</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Unity Butler</td>
                                        <td>Marketing Designer</td>
                                        <td>San Francisco</td>
                                        <td>47</td>
                                        <td>2009/12/09</td>
                                        <td>$85,675</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Howard Hatfield</td>
                                        <td>Office Manager</td>
                                        <td>San Francisco</td>
                                        <td>51</td>
                                        <td>2008/12/16</td>
                                        <td>$164,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hope Fuentes</td>
                                        <td>Secretary</td>
                                        <td>San Francisco</td>
                                        <td>41</td>
                                        <td>2010/02/12</td>
                                        <td>$109,850</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Vivian Harrell</td>
                                        <td>Financial Controller</td>
                                        <td>San Francisco</td>
                                        <td>62</td>
                                        <td>2009/02/14</td>
                                        <td>$452,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Timothy Mooney</td>
                                        <td>Office Manager</td>
                                        <td>London</td>
                                        <td>37</td>
                                        <td>2008/12/11</td>
                                        <td>$136,200</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jackson Bradshaw</td>
                                        <td>Director</td>
                                        <td>New York</td>
                                        <td>65</td>
                                        <td>2008/09/26</td>
                                        <td>$645,750</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Olivia Liang</td>
                                        <td>Support Engineer</td>
                                        <td>Singapore</td>
                                        <td>64</td>
                                        <td>2011/02/03</td>
                                        <td>$234,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Bruno Nash</td>
                                        <td>Software Engineer</td>
                                        <td>London</td>
                                        <td>38</td>
                                        <td>2011/05/03</td>
                                        <td>$163,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sakura Yamamoto</td>
                                        <td>Support Engineer</td>
                                        <td>Tokyo</td>
                                        <td>37</td>
                                        <td>2009/08/19</td>
                                        <td>$139,575</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Thor Walton</td>
                                        <td>Developer</td>
                                        <td>New York</td>
                                        <td>61</td>
                                        <td>2013/08/11</td>
                                        <td>$98,540</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Finn Camacho</td>
                                        <td>Support Engineer</td>
                                        <td>San Francisco</td>
                                        <td>47</td>
                                        <td>2009/07/07</td>
                                        <td>$87,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Serge Baldwin</td>
                                        <td>Data Coordinator</td>
                                        <td>Singapore</td>
                                        <td>64</td>
                                        <td>2012/04/09</td>
                                        <td>$138,575</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Zenaida Frank</td>
                                        <td>Software Engineer</td>
                                        <td>New York</td>
                                        <td>63</td>
                                        <td>2010/01/04</td>
                                        <td>$125,250</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Zorita Serrano</td>
                                        <td>Software Engineer</td>
                                        <td>San Francisco</td>
                                        <td>56</td>
                                        <td>2012/06/01</td>
                                        <td>$115,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jennifer Acosta</td>
                                        <td>Junior Javascript Developer</td>
                                        <td>Edinburgh</td>
                                        <td>43</td>
                                        <td>2013/02/01</td>
                                        <td>$75,650</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cara Stevens</td>
                                        <td>Sales Assistant</td>
                                        <td>New York</td>
                                        <td>46</td>
                                        <td>2011/12/06</td>
                                        <td>$145,600</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hermione Butler</td>
                                        <td>Regional Director</td>
                                        <td>London</td>
                                        <td>47</td>
                                        <td>2011/03/21</td>
                                        <td>$356,250</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lael Greer</td>
                                        <td>Systems Administrator</td>
                                        <td>London</td>
                                        <td>21</td>
                                        <td>2009/02/27</td>
                                        <td>$103,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jonas Alexander</td>
                                        <td>Developer</td>
                                        <td>San Francisco</td>
                                        <td>30</td>
                                        <td>2010/07/14</td>
                                        <td>$86,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Shad Decker</td>
                                        <td>Regional Director</td>
                                        <td>Edinburgh</td>
                                        <td>51</td>
                                        <td>2008/11/13</td>
                                        <td>$183,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Michael Bruce</td>
                                        <td>Javascript Developer</td>
                                        <td>Singapore</td>
                                        <td>29</td>
                                        <td>2011/06/27</td>
                                        <td>$183,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Donna Snider</td>
                                        <td>Customer Support</td>
                                        <td>New York</td>
                                        <td>27</td>
                                        <td>2011/01/25</td>
                                        <td>$112,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jennifer Chang</td>
                                        <td>Regional Director</td>
                                        <td>Singapore</td>
                                        <td>28</td>
                                        <td>2010/11/14</td>
                                        <td>$357,650</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Brenden Wagner</td>
                                        <td>Software Engineer</td>
                                        <td>San Francisco</td>
                                        <td>28</td>
                                        <td>2011/06/07</td>
                                        <td>$206,850</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fiona Green</td>
                                        <td>Chief Operating Officer (COO)</td>
                                        <td>San Francisco</td>
                                        <td>48</td>
                                        <td>2010/03/11</td>
                                        <td>$850,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Shou Itou</td>
                                        <td>Regional Marketing</td>
                                        <td>Tokyo</td>
                                        <td>20</td>
                                        <td>2011/08/14</td>
                                        <td>$163,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Michelle House</td>
                                        <td>Integration Specialist</td>
                                        <td>Sidney</td>
                                        <td>37</td>
                                        <td>2011/06/02</td>
                                        <td>$95,400</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Suki Burks</td>
                                        <td>Developer</td>
                                        <td>London</td>
                                        <td>53</td>
                                        <td>2009/10/22</td>
                                        <td>$114,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Prescott Bartlett</td>
                                        <td>Technical Author</td>
                                        <td>London</td>
                                        <td>27</td>
                                        <td>2011/05/07</td>
                                        <td>$145,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gavin Cortez</td>
                                        <td>Team Leader</td>
                                        <td>San Francisco</td>
                                        <td>22</td>
                                        <td>2008/10/26</td>
                                        <td>$235,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Martena Mccray</td>
                                        <td>Post-Sales support</td>
                                        <td>Edinburgh</td>
                                        <td>46</td>
                                        <td>2011/03/09</td>
                                        <td>$324,050</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Unity Butler</td>
                                        <td>Marketing Designer</td>
                                        <td>San Francisco</td>
                                        <td>47</td>
                                        <td>2009/12/09</td>
                                        <td>$85,675</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Howard Hatfield</td>
                                        <td>Office Manager</td>
                                        <td>San Francisco</td>
                                        <td>51</td>
                                        <td>2008/12/16</td>
                                        <td>$164,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hope Fuentes</td>
                                        <td>Secretary</td>
                                        <td>San Francisco</td>
                                        <td>41</td>
                                        <td>2010/02/12</td>
                                        <td>$109,850</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Vivian Harrell</td>
                                        <td>Financial Controller</td>
                                        <td>San Francisco</td>
                                        <td>62</td>
                                        <td>2009/02/14</td>
                                        <td>$452,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Timothy Mooney</td>
                                        <td>Office Manager</td>
                                        <td>London</td>
                                        <td>37</td>
                                        <td>2008/12/11</td>
                                        <td>$136,200</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jackson Bradshaw</td>
                                        <td>Director</td>
                                        <td>New York</td>
                                        <td>65</td>
                                        <td>2008/09/26</td>
                                        <td>$645,750</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Olivia Liang</td>
                                        <td>Support Engineer</td>
                                        <td>Singapore</td>
                                        <td>64</td>
                                        <td>2011/02/03</td>
                                        <td>$234,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Bruno Nash</td>
                                        <td>Software Engineer</td>
                                        <td>London</td>
                                        <td>38</td>
                                        <td>2011/05/03</td>
                                        <td>$163,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sakura Yamamoto</td>
                                        <td>Support Engineer</td>
                                        <td>Tokyo</td>
                                        <td>37</td>
                                        <td>2009/08/19</td>
                                        <td>$139,575</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Thor Walton</td>
                                        <td>Developer</td>
                                        <td>New York</td>
                                        <td>61</td>
                                        <td>2013/08/11</td>
                                        <td>$98,540</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Finn Camacho</td>
                                        <td>Support Engineer</td>
                                        <td>San Francisco</td>
                                        <td>47</td>
                                        <td>2009/07/07</td>
                                        <td>$87,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Serge Baldwin</td>
                                        <td>Data Coordinator</td>
                                        <td>Singapore</td>
                                        <td>64</td>
                                        <td>2012/04/09</td>
                                        <td>$138,575</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Zenaida Frank</td>
                                        <td>Software Engineer</td>
                                        <td>New York</td>
                                        <td>63</td>
                                        <td>2010/01/04</td>
                                        <td>$125,250</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Zorita Serrano</td>
                                        <td>Software Engineer</td>
                                        <td>San Francisco</td>
                                        <td>56</td>
                                        <td>2012/06/01</td>
                                        <td>$115,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jennifer Acosta</td>
                                        <td>Junior Javascript Developer</td>
                                        <td>Edinburgh</td>
                                        <td>43</td>
                                        <td>2013/02/01</td>
                                        <td>$75,650</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cara Stevens</td>
                                        <td>Sales Assistant</td>
                                        <td>New York</td>
                                        <td>46</td>
                                        <td>2011/12/06</td>
                                        <td>$145,600</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hermione Butler</td>
                                        <td>Regional Director</td>
                                        <td>London</td>
                                        <td>47</td>
                                        <td>2011/03/21</td>
                                        <td>$356,250</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lael Greer</td>
                                        <td>Systems Administrator</td>
                                        <td>London</td>
                                        <td>21</td>
                                        <td>2009/02/27</td>
                                        <td>$103,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jonas Alexander</td>
                                        <td>Developer</td>
                                        <td>San Francisco</td>
                                        <td>30</td>
                                        <td>2010/07/14</td>
                                        <td>$86,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Shad Decker</td>
                                        <td>Regional Director</td>
                                        <td>Edinburgh</td>
                                        <td>51</td>
                                        <td>2008/11/13</td>
                                        <td>$183,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Michael Bruce</td>
                                        <td>Javascript Developer</td>
                                        <td>Singapore</td>
                                        <td>29</td>
                                        <td>2011/06/27</td>
                                        <td>$183,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Donna Snider</td>
                                        <td>Customer Support</td>
                                        <td>New York</td>
                                        <td>27</td>
                                        <td>2011/01/25</td>
                                        <td>$112,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jennifer Chang</td>
                                        <td>Regional Director</td>
                                        <td>Singapore</td>
                                        <td>28</td>
                                        <td>2010/11/14</td>
                                        <td>$357,650</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Brenden Wagner</td>
                                        <td>Software Engineer</td>
                                        <td>San Francisco</td>
                                        <td>28</td>
                                        <td>2011/06/07</td>
                                        <td>$206,850</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fiona Green</td>
                                        <td>Chief Operating Officer (COO)</td>
                                        <td>San Francisco</td>
                                        <td>48</td>
                                        <td>2010/03/11</td>
                                        <td>$850,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Shou Itou</td>
                                        <td>Regional Marketing</td>
                                        <td>Tokyo</td>
                                        <td>20</td>
                                        <td>2011/08/14</td>
                                        <td>$163,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Michelle House</td>
                                        <td>Integration Specialist</td>
                                        <td>Sidney</td>
                                        <td>37</td>
                                        <td>2011/06/02</td>
                                        <td>$95,400</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Suki Burks</td>
                                        <td>Developer</td>
                                        <td>London</td>
                                        <td>53</td>
                                        <td>2009/10/22</td>
                                        <td>$114,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Prescott Bartlett</td>
                                        <td>Technical Author</td>
                                        <td>London</td>
                                        <td>27</td>
                                        <td>2011/05/07</td>
                                        <td>$145,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gavin Cortez</td>
                                        <td>Team Leader</td>
                                        <td>San Francisco</td>
                                        <td>22</td>
                                        <td>2008/10/26</td>
                                        <td>$235,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Martena Mccray</td>
                                        <td>Post-Sales support</td>
                                        <td>Edinburgh</td>
                                        <td>46</td>
                                        <td>2011/03/09</td>
                                        <td>$324,050</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Unity Butler</td>
                                        <td>Marketing Designer</td>
                                        <td>San Francisco</td>
                                        <td>47</td>
                                        <td>2009/12/09</td>
                                        <td>$85,675</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Howard Hatfield</td>
                                        <td>Office Manager</td>
                                        <td>San Francisco</td>
                                        <td>51</td>
                                        <td>2008/12/16</td>
                                        <td>$164,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hope Fuentes</td>
                                        <td>Secretary</td>
                                        <td>San Francisco</td>
                                        <td>41</td>
                                        <td>2010/02/12</td>
                                        <td>$109,850</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Vivian Harrell</td>
                                        <td>Financial Controller</td>
                                        <td>San Francisco</td>
                                        <td>62</td>
                                        <td>2009/02/14</td>
                                        <td>$452,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Timothy Mooney</td>
                                        <td>Office Manager</td>
                                        <td>London</td>
                                        <td>37</td>
                                        <td>2008/12/11</td>
                                        <td>$136,200</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jackson Bradshaw</td>
                                        <td>Director</td>
                                        <td>New York</td>
                                        <td>65</td>
                                        <td>2008/09/26</td>
                                        <td>$645,750</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Olivia Liang</td>
                                        <td>Support Engineer</td>
                                        <td>Singapore</td>
                                        <td>64</td>
                                        <td>2011/02/03</td>
                                        <td>$234,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Bruno Nash</td>
                                        <td>Software Engineer</td>
                                        <td>London</td>
                                        <td>38</td>
                                        <td>2011/05/03</td>
                                        <td>$163,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sakura Yamamoto</td>
                                        <td>Support Engineer</td>
                                        <td>Tokyo</td>
                                        <td>37</td>
                                        <td>2009/08/19</td>
                                        <td>$139,575</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Thor Walton</td>
                                        <td>Developer</td>
                                        <td>New York</td>
                                        <td>61</td>
                                        <td>2013/08/11</td>
                                        <td>$98,540</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Finn Camacho</td>
                                        <td>Support Engineer</td>
                                        <td>San Francisco</td>
                                        <td>47</td>
                                        <td>2009/07/07</td>
                                        <td>$87,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Serge Baldwin</td>
                                        <td>Data Coordinator</td>
                                        <td>Singapore</td>
                                        <td>64</td>
                                        <td>2012/04/09</td>
                                        <td>$138,575</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Zenaida Frank</td>
                                        <td>Software Engineer</td>
                                        <td>New York</td>
                                        <td>63</td>
                                        <td>2010/01/04</td>
                                        <td>$125,250</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Zorita Serrano</td>
                                        <td>Software Engineer</td>
                                        <td>San Francisco</td>
                                        <td>56</td>
                                        <td>2012/06/01</td>
                                        <td>$115,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jennifer Acosta</td>
                                        <td>Junior Javascript Developer</td>
                                        <td>Edinburgh</td>
                                        <td>43</td>
                                        <td>2013/02/01</td>
                                        <td>$75,650</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cara Stevens</td>
                                        <td>Sales Assistant</td>
                                        <td>New York</td>
                                        <td>46</td>
                                        <td>2011/12/06</td>
                                        <td>$145,600</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hermione Butler</td>
                                        <td>Regional Director</td>
                                        <td>London</td>
                                        <td>47</td>
                                        <td>2011/03/21</td>
                                        <td>$356,250</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lael Greer</td>
                                        <td>Systems Administrator</td>
                                        <td>London</td>
                                        <td>21</td>
                                        <td>2009/02/27</td>
                                        <td>$103,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jonas Alexander</td>
                                        <td>Developer</td>
                                        <td>San Francisco</td>
                                        <td>30</td>
                                        <td>2010/07/14</td>
                                        <td>$86,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Shad Decker</td>
                                        <td>Regional Director</td>
                                        <td>Edinburgh</td>
                                        <td>51</td>
                                        <td>2008/11/13</td>
                                        <td>$183,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Michael Bruce</td>
                                        <td>Javascript Developer</td>
                                        <td>Singapore</td>
                                        <td>29</td>
                                        <td>2011/06/27</td>
                                        <td>$183,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Donna Snider</td>
                                        <td>Customer Support</td>
                                        <td>New York</td>
                                        <td>27</td>
                                        <td>2011/01/25</td>
                                        <td>$112,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jennifer Chang</td>
                                        <td>Regional Director</td>
                                        <td>Singapore</td>
                                        <td>28</td>
                                        <td>2010/11/14</td>
                                        <td>$357,650</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Brenden Wagner</td>
                                        <td>Software Engineer</td>
                                        <td>San Francisco</td>
                                        <td>28</td>
                                        <td>2011/06/07</td>
                                        <td>$206,850</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fiona Green</td>
                                        <td>Chief Operating Officer (COO)</td>
                                        <td>San Francisco</td>
                                        <td>48</td>
                                        <td>2010/03/11</td>
                                        <td>$850,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Shou Itou</td>
                                        <td>Regional Marketing</td>
                                        <td>Tokyo</td>
                                        <td>20</td>
                                        <td>2011/08/14</td>
                                        <td>$163,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Michelle House</td>
                                        <td>Integration Specialist</td>
                                        <td>Sidney</td>
                                        <td>37</td>
                                        <td>2011/06/02</td>
                                        <td>$95,400</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Suki Burks</td>
                                        <td>Developer</td>
                                        <td>London</td>
                                        <td>53</td>
                                        <td>2009/10/22</td>
                                        <td>$114,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Prescott Bartlett</td>
                                        <td>Technical Author</td>
                                        <td>London</td>
                                        <td>27</td>
                                        <td>2011/05/07</td>
                                        <td>$145,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gavin Cortez</td>
                                        <td>Team Leader</td>
                                        <td>San Francisco</td>
                                        <td>22</td>
                                        <td>2008/10/26</td>
                                        <td>$235,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Martena Mccray</td>
                                        <td>Post-Sales support</td>
                                        <td>Edinburgh</td>
                                        <td>46</td>
                                        <td>2011/03/09</td>
                                        <td>$324,050</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Unity Butler</td>
                                        <td>Marketing Designer</td>
                                        <td>San Francisco</td>
                                        <td>47</td>
                                        <td>2009/12/09</td>
                                        <td>$85,675</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Howard Hatfield</td>
                                        <td>Office Manager</td>
                                        <td>San Francisco</td>
                                        <td>51</td>
                                        <td>2008/12/16</td>
                                        <td>$164,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hope Fuentes</td>
                                        <td>Secretary</td>
                                        <td>San Francisco</td>
                                        <td>41</td>
                                        <td>2010/02/12</td>
                                        <td>$109,850</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Vivian Harrell</td>
                                        <td>Financial Controller</td>
                                        <td>San Francisco</td>
                                        <td>62</td>
                                        <td>2009/02/14</td>
                                        <td>$452,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Timothy Mooney</td>
                                        <td>Office Manager</td>
                                        <td>London</td>
                                        <td>37</td>
                                        <td>2008/12/11</td>
                                        <td>$136,200</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jackson Bradshaw</td>
                                        <td>Director</td>
                                        <td>New York</td>
                                        <td>65</td>
                                        <td>2008/09/26</td>
                                        <td>$645,750</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Olivia Liang</td>
                                        <td>Support Engineer</td>
                                        <td>Singapore</td>
                                        <td>64</td>
                                        <td>2011/02/03</td>
                                        <td>$234,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Bruno Nash</td>
                                        <td>Software Engineer</td>
                                        <td>London</td>
                                        <td>38</td>
                                        <td>2011/05/03</td>
                                        <td>$163,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sakura Yamamoto</td>
                                        <td>Support Engineer</td>
                                        <td>Tokyo</td>
                                        <td>37</td>
                                        <td>2009/08/19</td>
                                        <td>$139,575</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Thor Walton</td>
                                        <td>Developer</td>
                                        <td>New York</td>
                                        <td>61</td>
                                        <td>2013/08/11</td>
                                        <td>$98,540</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Finn Camacho</td>
                                        <td>Support Engineer</td>
                                        <td>San Francisco</td>
                                        <td>47</td>
                                        <td>2009/07/07</td>
                                        <td>$87,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Serge Baldwin</td>
                                        <td>Data Coordinator</td>
                                        <td>Singapore</td>
                                        <td>64</td>
                                        <td>2012/04/09</td>
                                        <td>$138,575</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Zenaida Frank</td>
                                        <td>Software Engineer</td>
                                        <td>New York</td>
                                        <td>63</td>
                                        <td>2010/01/04</td>
                                        <td>$125,250</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Zorita Serrano</td>
                                        <td>Software Engineer</td>
                                        <td>San Francisco</td>
                                        <td>56</td>
                                        <td>2012/06/01</td>
                                        <td>$115,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jennifer Acosta</td>
                                        <td>Junior Javascript Developer</td>
                                        <td>Edinburgh</td>
                                        <td>43</td>
                                        <td>2013/02/01</td>
                                        <td>$75,650</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cara Stevens</td>
                                        <td>Sales Assistant</td>
                                        <td>New York</td>
                                        <td>46</td>
                                        <td>2011/12/06</td>
                                        <td>$145,600</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hermione Butler</td>
                                        <td>Regional Director</td>
                                        <td>London</td>
                                        <td>47</td>
                                        <td>2011/03/21</td>
                                        <td>$356,250</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lael Greer</td>
                                        <td>Systems Administrator</td>
                                        <td>London</td>
                                        <td>21</td>
                                        <td>2009/02/27</td>
                                        <td>$103,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jonas Alexander</td>
                                        <td>Developer</td>
                                        <td>San Francisco</td>
                                        <td>30</td>
                                        <td>2010/07/14</td>
                                        <td>$86,500</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Shad Decker</td>
                                        <td>Regional Director</td>
                                        <td>Edinburgh</td>
                                        <td>51</td>
                                        <td>2008/11/13</td>
                                        <td>$183,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Michael Bruce</td>
                                        <td>Javascript Developer</td>
                                        <td>Singapore</td>
                                        <td>29</td>
                                        <td>2011/06/27</td>
                                        <td>$183,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Donna Snider</td>
                                        <td>Customer Support</td>
                                        <td>New York</td>
                                        <td>27</td>
                                        <td>2011/01/25</td>
                                        <td>$112,000</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">編輯</a>
                                            <a class="waves-effect waves-light red accent-2 btn doctor-td-btn">刪除</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
      		  	  	  	</div>
      		  	  	</div>
      		  	</div>
      		</div>
		</div>
	</div>
	
	<!-- Modal Structure -->
    <div id="modal1" class="modal modal-fixed-footer modal-announcement">
        <form action="#!" method="post">
           
            <div class="modal-header">
                <h5 class="modal-announcement-title">新增醫生</h5>
                <div class="nav-content">
                    <ul class="tabs tabs-transparent tabs-fixed-width blue-grey darken-1">
                        <li class="tab"><a href="#modal-left" class="active">一般資訊</a></li>
                        <li class="tab"><a href="#modal-right">班數</a></li>
                        <div class="indicator" style="right: 352px; left: 0px;"></div>
                    </ul>
                </div>
            </div>
            
            
            <div class="modal-content modal-content-customize">
                <div id="modal-left" class="row margin-b0">
                    <div class="input-field col s12">
                        <input id="title" type="text" name="name" value="" required>
                        <label for="title">醫生名稱</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="email" type="email" class="validate" name="email" value="" required>
                        <label for="email" data-error="wrong" data-success="right">Email</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="date" type="date" class="datepicker" name="password" value="">
                        <label for="date">出生日期</label>
                    </div>
                    <div class="input-field col s12">
                        <select name="major" required>
                            <option value="" disabled selected>選擇專科</option>
                            <option value="all">All</option>
                            <option value="medical">Medical</option>
                            <option value="surgical">Surgical</option>
                        </select>
                        <label>專職科別</label>
                    </div>
                    <div class="input-field col s12">
                        <select name="level" required>
                            <option value="" disabled selected>選擇級別</option>
                            <option value="1">Option 1</option>
                            <option value="2">Option 2</option>
                            <option value="3">Option 3</option>
                        </select>
                        <label>級別</label>
                    </div>
                    <div class="input-field col s12 margin-t0">
                        <p class="margin-0">職登院區</p>
                        <p class="radio-location">
                            <input class="with-gap" name="group1" type="radio" id="radio-Taipei" value="" required/>
                            <label for="radio-Taipei">台北</label>
                            <input class="with-gap" name="group1" type="radio" id="radio-Danshui" value="" />
                            <label for="radio-Danshui">淡水</label>
                        </p>
                    </div>
                    <div class="input-field col s12">
                        <select name="identity" required>
                            <option value="" disabled selected>選擇權限</option>
                            <option value="general">General</option>
                            <option value="admin">Admin</option>
                        </select>
                        <label>權限</label>
                    </div>
                </div>
                
                <div id="modal-right" class="row margin-b0">
                    <div class="input-field col s12">
                        <input value="15" id="看你怎麼取" type="number" required>
                        <label for="和id一樣">台北院區班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" id="看你怎麼取" type="number" required>
                        <label for="和id一樣">XXX班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" id="看你怎麼取" type="number" required>
                        <label for="和id一樣">XXX班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" id="看你怎麼取" type="number" required>
                        <label for="和id一樣">XXX班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" id="看你怎麼取" type="number" required>
                        <label for="和id一樣">XXX班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" id="看你怎麼取" type="number" required>
                        <label for="和id一樣">XXX班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" id="看你怎麼取" type="number" required>
                        <label for="和id一樣">XXX班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" id="看你怎麼取" type="number" required>
                        <label for="和id一樣">XXX班數</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save">Save</button>
                <button class="modal-action modal-close waves-effect waves-light btn-flat btn-cancel">Cancel</button>
            </div>
        </form>
    </div>
       
    <!-- Modal Structure -->
    <div id="modal2" class="modal modal-fixed-footer modal-announcement">
        <form action="#!" method="post">
           
            <div class="modal-header">
                <h5 class="modal-announcement-title">修改醫生</h5>
                <div class="nav-content">
                    <ul class="tabs tabs-transparent tabs-fixed-width blue-grey darken-1">
                        <li class="tab"><a href="#modal-left1" class="active">一般資訊</a></li>
                        <li class="tab"><a href="#modal-right1">班數</a></li>
                        <div class="indicator" style="right: 352px; left: 0px;"></div>
                    </ul>
                </div>
            </div>
            
            
            <div class="modal-content modal-content-customize">
                <div id="modal-left1" class="row margin-b0">
                    <div class="input-field col s12">
                        <input id="title" type="text" value="陳常樂" required>
                        <label for="title">醫生名稱</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="email" type="email" class="validate" value="ben@gmail.com" required>
                        <label for="email" data-error="wrong" data-success="right">Email</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="date" type="date" class="datepicker" value="2017-05-28">
                        <label for="date">出生日期</label>
                    </div>
                    <div class="input-field col s12">
                        <select required>
                            <option value="" disabled>選擇專科</option>
                            <option value="1">Option 1</option>
                            <option value="2" selected>Option 2</option>
                            <option value="3">Option 3</option>
                        </select>
                        <label>專職科別</label>
                    </div>
                    <div class="input-field col s12">
                        <select required>
                            <option value="" disabled>選擇級別</option>
                            <option value="1">Option 1</option>
                            <option value="2" selected>Option 2</option>
                            <option value="3">Option 3</option>
                        </select>
                        <label>級別</label>
                    </div>
                    <div class="input-field col s12 margin-t0">
                        <p class="margin-0">職登院區</p>
                        <p class="radio-location">
                            <input class="with-gap" name="group1" type="radio" id="radio-Taipei" value="1" required/>
                            <label for="radio-Taipei">台北</label>
                            <input class="with-gap" name="group1" type="radio" id="radio-Danshui" value="2" checked="checked"/>
                            <label for="radio-Danshui">淡水</label>
                        </p>
                    </div>
                    <div class="input-field col s12">
                        <select required>
                            <option value="" disabled>選擇權限</option>
                            <option value="1">Option 1</option>
                            <option value="2">Option 2</option>
                            <option value="3" selected>Option 3</option>
                        </select>
                        <label>權限</label>
                    </div>
                </div>
                
                <div id="modal-right1" class="row margin-b0">
                    <div class="input-field col s12">
                        <input value="15" id="看你怎麼取" type="number" required>
                        <label for="和id一樣">台北院區班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" id="看你怎麼取" type="number" required>
                        <label for="和id一樣">XXX班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" id="看你怎麼取" type="number" required>
                        <label for="和id一樣">XXX班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" id="看你怎麼取" type="number" required>
                        <label for="和id一樣">XXX班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" id="看你怎麼取" type="number" required>
                        <label for="和id一樣">XXX班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" id="看你怎麼取" type="number" required>
                        <label for="和id一樣">XXX班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" id="看你怎麼取" type="number" required>
                        <label for="和id一樣">XXX班數</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="15" id="看你怎麼取" type="number" required>
                        <label for="和id一樣">XXX班數</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save">Save</button>
                <button class="modal-action modal-close waves-effect waves-light btn-flat btn-cancel">Cancel</button>
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
            
            
//            console.log(document.getElementById("example_length").getElementsByTagName("li"));
            var count = 0;
            
            for(i=0;i<4;i++){
                document.getElementById("example_length").getElementsByTagName("li")[i].addEventListener("click", ff);
                
//                document.getElementById("example_length").getElementsByTagName("li")[i].addEventListener("click", ff);
//                document.getElementById("example_length").getElementsByTagName("li")[i].addEventListener("mouseup", myFunction2);
            }
            
            
//            var x = document.getElementsByTagName("li");
//            var y = document.getElementsByTagName("ul");
////            var y = document.getElementsByTagName("input");
//            x[17].addEventListener("click", function(){
//                console.log("ttttt")
//                y[4].id = "tqwe";
//                
//                console.log(document.getElementById("tqwe").className);
////                $('select').material_select('destroy');
//                
//            });
            
//            var x = document.getElementsByTagName("li");
//            x[17].addEventListener("mouseup", function(){
//                sleep(3000);
//                console.log("sss")                
//    //            $('select').material_select();
//            });
            
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
