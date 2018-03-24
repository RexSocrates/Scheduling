@extends("layouts.app2")

<!--
@section('head')

@endsection
-->

@section('navbar')
    <p class="brand-logo light">個人資料</p>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">
        <div class="container-section">
            <div class="row">
                <div class="col s4">                 
                    <div class="card">
                        <div class="card-action b-t0">
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
<!--                            <a href="#modal1">更改密碼</a>-->
                        </div>
                    </div>
                </div>
                
                
<!--
                        <div class="card-action">
                            <font class="card-title">使用公假記錄</font>
                            @foreach($doctorShiftRecords as $record)
                            <ul>
                                <li>Schedule 1 name and date: {{ $record[4]}} {{ $record[2]}}</li> 
                                <li>Schedule 1 doctor: {{ $record[0] }}</li>
                                <li>Schedule 2 name and date: {{ $record[5]}} {{ $record[3]}}</li> 
                                <li>Schedule 2 doctor: {{ $record[1] }}</li>
                            </ul>
                             @endforeach
                             <a class="btn-floating halfway-fab waves-effect waves-light red accent-2" href="#modal2"><i class="material-icons">add</i></a>
                             
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
-->
               <!--  <div class="col s8">
                    <div class="card">
                        <div class="card-action card1">
                            <div class="title1">

                                <font class="card-title">特休使用記錄</font>

                                <font class="card-title">時數存摺</font>
                            </div>
                            <div class="title1 margin-l20">
                                <font class="card-title">剩餘時數: {{$doctor->currentOfficialLeaveHours}}</font>
                            </div>
                            <a class="btn-floating halfway-fab waves-effect waves-light red accent-2" href="#modal2"><i class="material-icons">add</i></a>
                        </div>
                        
                        <div class="divider"></div>
                        <div class="card-content padding-t5">
                            <table class="centered striped highlight scroll area5">
                                <thead>
                                    <tr>
                                        <th class="td-w-7">日期</th>
                                        <th class="td-w-5">類型</th>
                                        <th class="td-w-5">時數</th>
                                        <th class="td-w-15">原因</th> -->
<!--                                        <th class="td-w-5">狀態</th>-->
                                  <!--   </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td class="td-padding td-w-7">2017-10-22</td>
                                        <td class="td-padding td-w-5">積欠班</td>
                                        <td class="td-padding td-w-5">+10</td>
                                        <td class="td-padding td-w-15">文字測試文字測試文字測試文字測試文字測試</td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding td-w-7">2017-10-22</td>
                                        <td class="td-padding td-w-5">特休</td>
                                        <td class="td-padding td-w-5">-10</td>
                                        <td class="td-padding td-w-15"><font class="red-text">(拒絕)</font>文字測試文字測試文字測試文字測試文字測試</td>
                                        
                                    </tr>
                                    <tr>
                                        <td class="td-padding td-w-7">2017-10-22</td>
                                        <td class="td-padding td-w-5">特休</td>
                                        <td class="td-padding td-w-5">-10</td>
                                        <td class="td-padding td-w-15"><font class="green-text text-darken-1">(確認)</font>文字測試文字測試文字測試文字測試文字測試</td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding td-w-7">2017-10-22</td>
                                        <td class="td-padding td-w-5">特休</td>
                                        <td class="td-padding td-w-5">-10</td>
                                        <td class="td-padding td-w-15"><font class="grey-text text-darken-1">(等候確認)</font>文字測試文字測試文字測試文字測試文字測試</td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="td-padding td-w-7">2017-10-22</td>
                                        <td class="td-padding td-w-5">積欠班</td>
                                        <td class="td-padding td-w-5">+10</td>
                                        <td class="td-padding td-w-15">文字測試文字測試文字測試文字測試文字測試</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>	
                </div> -->
                
                <div class="col s8">
                    <div class="card">
                        <div class="card-action b-t0 card1">
                            <div class="title1">
                                <font class="card-title">特休記錄</font>
                            </div>
                            <div class="title1 margin-l20">
                                <font class="card-title">剩餘時數: {{$doctor->currentOfficialLeaveHours}}</font>
                            </div>
                            <a class="btn-floating halfway-fab waves-effect waves-light red accent-2" href="#modal2"><i class="material-icons">add</i></a>
                        </div>
                        
                        <div class="divider"></div>
                        <div class="card-content padding-t5">
                            <table class="centered striped highlight scroll area5">
                                <thead>
                                    <tr>
                                        <th class="td-w-5">申請日期</th>
                                        <th class="td-w-15">申請原因</th>
                                        <th class="td-w-5">增加/減少</th>
                                        <th class="td-w-5">時數</th>
                                        <th class="td-w-5">狀態</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($doctorOfficialLeave as $leave)
                                    <tr>
                                        <td class="td-padding td-w-5">{{ $leave['date'] }}</td>
                                        <td class="td-padding td-w-15">{{ $leave['remark'] }}</td>
                                        @if ( $leave['hour'] >0 )
                                            <td class="td-padding td-w-5">增加</td>
                                        @else
                                            <td class="td-padding td-w-5">減少</td>
                                        @endif
                                        <td class="td-padding td-w-5">{{ $leave['hour'] }}</td>
                                        <td class="td-padding td-w-5">{{ $leave['status'] }}</td>   
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>	
                </div>
                
<!--
                <div class="col s8">
                    <div class="card">
                        <div class="card-action card1">
                            <div class="title1">
                                <font class="card-title">積欠班狀況</font>
                            </div>
                            <div class="title1 margin-l20">
                                @if ( $totalScheduleRecords > 0 )
                                <font class="card-title">總數: 積 {{ $totalScheduleRecords }}班</font>
                                @else
                                <font class="card-title">總數: 欠 {{ $totalScheduleRecords }}班</font>
                                @endif
                                <label>每半年結算一次，結算後數目歸零。</label>
                            </div>
                        </div>
                        
                        <div class="divider"></div>
                        <div class="card-content padding-t5">
                            <table class="centered striped highlight scroll area5">
                                <thead>
                                    <tr>
                                        <th class="td-w-5">日期</th>
                                        <th class="td-w-5">情況</th>
                                        <th class="td-w-5">班數</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($doctorScheduleRecords as $record)
                                    <tr>
                                        <td class="td-padding td-w-5">{{ $record['date'] }}</td>
                                        @if ( $record['shiftHours'] >0 )
                                        <td class="td-padding td-w-5">積</td>
                                        @else
                                        <td class="td-padding td-w-5">欠</td>
                                        @endif
                                        <td class="td-padding td-w-5">{{ $record['shiftHours'] }}</td>   
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>	
                </div>
-->
                
            </div>
        </div>
    </div>
    
<<<<<<< HEAD
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
                                <p>醫生ID：1234</p>
                                <p>醫生名稱：王樹林</p>
                                <p>email：ben@gmail.com</p>
                                <p>級別： A5</p>
                                <p>專職：綜合</p>
                                <p>職登院區：台北</p>
                                <a href="#modal1">更改密碼</a>
                            </center>
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
    
=======
>>>>>>> PassingData
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
<<<<<<< HEAD

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
=======
    
    <div id="modal2" class="modal modal-fixed-footer modal-announcement">
        <form action="addOfficialLeaveByDoctor" method="post">
            <div class="modal-header">
                <h5 class="modal-announcement-title">申請使用特休</h5>

            </div>
            <div class="modal-content modal-content-customize1">
                <div class="row margin-b0">
                    <!--  <br><br><input type="month" name="bday" min="2017-09-01" required><br>
                    <label>選擇月份</label>
 -->
                    <div class="input-field col s12 margin-b20">
                        <!-- <input type="month" name="bday" min="2017-09-01" required> -->
                       <select name="leaveMonth" required id='leaveMonth'>
                            <option value="" selected disabled>選擇月份</option>
                            <option value="{{ $currentMonth }}">{{ $currentMonth }}</option>
                            <option value="{{ $nextMonth }}">{{ $nextMonth }}</option>
                        </select>
                        <!-- <label>月份</label> -->
                    </div>

                    <div class="input-field col s12">
                        <input placeholder="申請的時數不能小於剩餘的時數" id="hour" type="number" value="" name="hour" min="0" max="{{$doctor->currentOfficialLeaveHours}}" required>
                        <label for="hour">時數</label>
                    </div>
                    
                    <div class="input-field col s12 margin-t0">
                        <textarea id="textarea1" class="materialize-textarea" type="text" name="content" data-length="150" maxlength="150" required></textarea>
                        <label for="textarea1">申請原因</label>
                    </div>

                   <!--  <div class="input-field col s12 margin-t0">

                        
                        <br><br><input type="month" name="bday" min="2017-09-01" required><br>
                        <label>選擇月份</label
                    </div>
 -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save">Save</button>
                <button class="modal-action modal-close waves-effect waves-light btn-flat btn-cancel">Cancel</button>
                {{ csrf_field() }}
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('select').material_select();
>>>>>>> PassingData
        });
    </script>
@endsection


    
	
<<<<<<< HEAD
</body>
</html>

=======
>>>>>>> PassingData
