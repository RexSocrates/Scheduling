<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>馬偕醫院排班系統</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.1, maximum-scale=3.0, user-scalable=1">
    
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
    <script src="../codebase/locale/locale_cn.js" type="text/javascript"></script>
    <script src="../codebase/locale/recurring/locale_recurring_cn.js" ></script>
    
    @yield('head')
    
</head>
<body>

    <nav id="slide-out" class="side-nav">
        <ul>
            <div class="logo-div">
                <a href="index" class="logo-a">
                    <img src="../img/logo-mackay.png" class="logo-img">
                    <font class="logo-p">馬偕醫院排班系統</font>
                </a>
            </div>
            <li class="divider"></li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/calendar-prearrange.svg"></i>預班表</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="reservation">個人</a></li>
                                <li><a href="reservation-all">查看全部</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/calendar-first-edition.svg"></i>初版班表</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="first-edition">個人</a></li>
                                <li><a href="first-edition-all">查看全部</a></li>
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
                                <li><a href="schedule">個人</a></li>
                                <li><a href="schedule-all">查看全部</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            <li><a href="schedule-shift-info" class="waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/file.svg"></i>換班資訊</a></li>
            
            @if(Auth::user()->identity == 'Admin')

               <!--  <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        <li>
                            <a class="collapsible-header waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/calendar-exchange.svg"></i>調整班表</a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="shift-first-edition">初版班表</a></li>
                                    <li><a href="shift-scheduler">正式班表</a></li>
                                    <li><a href="first-edition-situation">醫生排班現況</a></li>
                                    <li><a href="shift-info">換班資訊</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </li>
                <li><a href="doctors" class="waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/doctor.svg"></i>醫師管理</a></li>
                <li><a href="officialLeave" class="waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/note.svg"></i>醫師特休紀錄</a></li> -->
<!--                <li><a href="accumulatedShifts" class="waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/clipboard.svg"></i>積欠班狀況</a></li>-->
                

            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/calendar-exchange.svg"></i>調整班表</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="shift-first-edition">初版班表</a></li>
                                <li><a href="shift-scheduler">正式班表</a></li>
                                <li><a href="first-edition-situation">醫生排班現況</a></li>
                                <li><a href="shift-info">換班資訊</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            <li><a href="doctors" class="waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/doctor.svg"></i>醫師管理</a></li>
<!--            <li id="timeRecord"><a href="timeRecord" class="waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/note.svg"></i>時數存摺</a></li>-->
            <li><a href="officialLeave" class="waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/note.svg"></i>醫師特休紀錄</a></li>

            @endif
            <!--                <li><a href="accumulatedShifts" class="waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/clipboard.svg"></i>積欠班狀況</a></li>-->
            
            <li><a href="doctorsChart" class="waves-effect"><i class="material-icons"><img class="side-nav-icon" src="../img/pie-chart.svg"></i>統計圖表</a></li>
        </ul>
    </nav>
    
    <header id="header" class="trans-left-five">
        <nav id="navbar" class="nav-extended">
            <div class="nav-wrapper blue-grey darken-1 logo-padding-left">
                <a onclick="sideNav()" class="blue-grey darken-1 waves-effect waves-light menu-btn">
                    <i class="material-icons menu-icon" valign="middle">menu</i>
                </a>
                @yield('navbar')
                <ul class="right">
<!--
                    <li>
                        <a class="dropdown-notification-button" href="#!" data-activates="dropdown-notification">
                            <img src="../img/notifications-button.png" class="notifications-icon">
                        </a>
                    </li>
-->
                    <li>
                        <a class="dropdown-button" href="#!" data-activates="dropdown1">{{ Auth::user()->name }}<i class="material-icons right">arrow_drop_down</i>
                        </a>
                    </li>
                </ul>
            </div>
            @yield('nav-content')
        </nav>
        
        <ul id="dropdown-notification" class="dropdown-content">
            <li><font class="notification">5/12 李XX醫生換班成功<p>2 days ago</p></font></li>
            <li><font class="notification">5/11 系統公告 請去查閱<p>3 days ago</p></font></li>
        </ul>
        
        <ul id="dropdown1" class="dropdown-content">
            <li><a href="profile">個人資料</a></li>
            @if(Auth::user()->identity == 'Admin')
                <li><a href="setting">設定</a></li>
            @endif
            <li class="divider"></li>
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                    登出
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
        
        <a href="#" data-activates="slide-out" class="button-collapse"></a>
    </header>


    @yield('content')
    
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
            
            var classLength = document.getElementsByClassName("dhx_cal_tab").length;
            
            if (classLength != 0) {
                document.getElementsByClassName("dhx_cal_tab")[0].classList.remove("active");
                var delay = function(s){
                    return new Promise(function(resolve,reject){
                        setTimeout(resolve,s); 
                    });
                };
                delay().then(function(){
                    return delay(500); // 延遲0.5秒
                }).then(function(){
                    document.getElementsByClassName("dhx_cal_tab")[0].click();
                });
            }
        };
        
        function slideToRight() {
            document.getElementById("slide-out").style.width = "250px";
            document.getElementById("header").style.marginLeft = "250px";
            document.getElementById("section").style.marginLeft = "250px";
            
            var classLength = document.getElementsByClassName("dhx_cal_tab").length;
            
            if (classLength != 0) {
                document.getElementsByClassName("dhx_cal_tab")[0].classList.remove("active");
                var delay = function(s){
                    return new Promise(function(resolve,reject){
                        setTimeout(resolve,s); 
                    });
                };
                delay().then(function(){
                    return delay(500); // 延遲0.5秒
                }).then(function(){
                    document.getElementsByClassName("dhx_cal_tab")[0].click();
                });
            }
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
        
        $(".collapsible-body>ul>li").each(function() {
		    var navItem = $(this);
		    var href = window.location.href;
			var filename = href.replace(/^.*[\\\/]/, '')

		    if (navItem.find("a").attr("href") == filename) {
		      	navItem.addClass("active");
                navItem.parents().eq(2).find("a").addClass("active");
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

    @yield('script')
</body>
</html>