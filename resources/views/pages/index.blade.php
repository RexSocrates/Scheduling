@extends("layouts.app2")

@section('head')
    <link rel="stylesheet" href="../css/dropload.css">
@endsection

@section('navbar')
    <p class="brand-logo light">首頁</p>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">
		<div class="container-section">
			<div class="row">
      		  	<div class="col s12 m8">
      		  	  	<div class="card">
      		  	  		<div class="card-action b-t0">
      		  	  			<font class="card-title">系統公告</font>
      		  	  			@if(Auth::user()->identity == 'Admin')
      		  	  			<a class="btn-floating halfway-fab waves-effect waves-light red accent-2" href="#modal1" onclick="reset()"><i class="material-icons">add</i></a>
      		  	  			@endif
      		  	  		</div>
      		  	  		<div class="divider"></div>
      		  	  	  	
      		  	  	  	<div class="card-content">
                            <div class="announcement">
                                @foreach($announcements as $announcement)
                                <div class="row">
                                    <div class="col s2">
                                        <img src="../img/user.png" class="boss-img">
                                    </div>
                                    <div class="col s10">
                                        <span class="card-title">
                                            @if(Auth::user()->identity == 'Admin')
                                            <a class="dropdown-edit-button right" href="" data-activates='dropdown-announcement'><i class="material-icons" onclick="passAnnouncementSerial({{ $announcement->announcementSerial }})">more_vert</i></a>
                                            @endif
                                            <p class="ellipsis">{{ $announcement->title }}</p>
                                        </span>
                                        <p class="announcement-ellipsis">{{ $announcement->content }}</p>
                                        <a href="#modal-more" onclick="getAnnouncement({{ $announcement->announcementSerial }})">more</a>
                                    </div>
                                </div>
                                <div class="divider margin-b20"></div>
                                @endforeach
                                <ul id='dropdown-announcement' class='dropdown-content'>
                                    <li><a href="#modal1">編輯</a></li>
                                    <li><a href="deleteAnnouncement" id="deleteLink">刪除</a></li>
                                </ul>
                            </div>
      		  	  	  	</div>
      		  	  	</div>
      		  	</div>
				
        @if( $status ==1)
				<div class="col s12 m4">
      		  	  	<div class="card center">
              			<img src="../img/solar-system.png" class="solar-system">
              			<h3 class="blue-grey-text text-darken-3">開放預班中</h3>
      		  	  		<p class="blue-grey-text text-darken-3" style="font-weight: 500;">{{ $startDate }} ~ {{ $endDate }}</p>
      		  	  	  	<div class="card-action center">
      		  	  	  	  	<a href="reservation" class="margin-r0">前往預班表</a>
      		  	  	  	</div>
      		  	  	</div>
      		  	</div>
       @elseif( $status ==2)
      		  	<div class="col s12 m4">
      		  	  	<div class="card center">
              			<img src="../img/galaxy.svg" class="solar-system">
              			<h4 class="blue-grey-text text-darken-3 margin-t20">初版班表已公佈</h4>
      		  	  	  	<div class="card-action center">
      		  	  	  	  	<a href="first-edition" class="margin-r0">前往初版班表 - 個人</a>
      		  	  	  	</div>
      		  	  	</div>
      		  	</div>
         @else
      		  	<div class="col s12 m4">
      		  	  	<div class="card center">
              			<img src="../img/sunset.svg" class="solar-system">
              			<h4 class="blue-grey-text text-darken-3 margin-t20">正式班表已公佈</h4>
      		  	  	  	<div class="card-action center">
      		  	  	  	  	<a href="schedule" class="margin-r0">前往正式班表 - 個人</a>
      		  	  	  	</div>
      		  	  	</div>
      		  	</div>
          @endif
      		  	<div class="col s12 m4">
      		  	  	<div class="card center padding-t5">
                        <h1 class="teal-text text-lighten-2">{{ $currentOfficialLeaveHours }}</h1>
      		  	  		<p class="blue-grey-text text-darken-3" style="font-weight: 500;">剩餘特休時數</p>
      		  	  	  	<div class="card-action center">
      		  	  	  	  	<a href="profile" class="margin-r0">申請使用</a>
      		  	  	  	</div>
      		  	  	</div>
      		  	</div>
         
      		</div>
			
			
			<!-- Modal Structure -->
            <div id="modal1" class="modal modal-fixed-footer modal-announcement">
                <form id="form-modal1" action="addAnnouncement" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="hiddenSerial" id="hiddenSerial" value="-1">
                    <div class="modal-header">
                        <h5 class="modal-announcement-title">公告</h5>
                    </div>
                    <div class="modal-content modal-content-customize1">
                        <div class="row margin-b0">
                            <div class="input-field col s12">
                                <i class="material-icons prefix modal-icons">chat_bubble</i>
                                <input id="title" type="text" name="title" data-length="40" onkeyup="title_words_deal();" required>
                                <label for="title">標題</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix modal-icons">mode_edit</i>
                                <textarea id="textarea1" class="materialize-textarea margin-b0" type="text" name="content" data-length="700" onkeyup="textarea1_words_deal();" required></textarea>
                                <label class="active" for="textarea1">內容</label>
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
                <div class="modal-content modal-content-customize1">
                    <div class="row margin-b0">  
    				    <div class="col s12">
                            <h5 class="card-title" id="announcementTitle"></h5>
                            <p class="inline margin-0" id="name"></p>
                            <p class="inline margin-0 margin-l10 grey-text" id="date"></p>
    				    	<pre id="announcementContent"></pre>
    				    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="modal-action modal-close waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-cancel">Close</button>
                </div>
            </div>

		</div>
	</div>
@endsection

@section('script')
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
    <script src="../js/dropload.min.js"></script>

    <script>
        
//        $(function(){
//            $('.card-content').dropload({
//                scrollArea : window,
//                loadDownFn : function(me){
//                    
//                    // 拼接HTML
//                    var result = '';
//                    $.ajax({
//                        type: 'GET',
//                        url: 'js/more.json',
//                        dataType: 'json',
//                        success: function(data){
//    //                        alert(data);
//    //                        console.log(data.lists[3]);
//                            console.log(data.lists[3].link);
//                            console.log(data.lists[3].title);
//                            console.log(data.lists[3].date);
//                            
//                            var arrLen = data.lists.length;
//                            if(arrLen > 0){
//                                for(var i=0; i<3; i++){
////                                for(var i=0; i<arrLen; i++){
//                                    result +='<div class="row">'
//                                                +'<div class="col s2">'
//                                                    +'<img src="../img/user.png" class="boss-img">'
//                                                +'</div>'
//                                                +'<div class="col s10">'
//                                                    +'<span class="card-title">'
//                                                        +'<a class="dropdown-edit-button right" href="" data-activates="dropdown-announcement"><i class="material-icons" onclick="passAnnouncementSerial(AjaxTEST)">more_vert</i></a>'
//                                                        +'<p class="ellipsis">'+data.lists[i].link+'</p>'
//                                                    +'</span>'
//                                                    +'<p class="announcement-ellipsis">'+data.lists[i].title+'</p>'
//                                                    +'<a href="#modal-more" onclick="getAnnouncement(AjaxTEST)">more</a>'
//                                                +'</div>'
//                                            +'</div>'
//                                            +'<div class="divider margin-b20"></div>';
//                                }
//                            // if no data
//                            }else{
//                                // 锁定
//                                me.lock();
//                                // 无数据
//                                me.noData();
//                            }
//                            
//                            setTimeout(function(){
//                                // 插入数据到页面，放到最后面
//                                $('.announcement').append(result);
//                                // 每次数据插入，必须重置
//                                me.resetload();
//                            },1000);
//                        },
//                        error: function(xhr, type){
//                            alert('Ajax error!');
//                            // 即使加载出错，也得重置
//                            me.resetload();
//                        }
//                    });
//                }
//            });
//        });
        
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
        
        function getAnnouncement(announcementSerial) {
            $.get('getAnnouncement', {
                'serial' : announcementSerial
            }, function(array) {
                document.getElementById("announcementTitle").innerHTML = array[1];
                document.getElementById("announcementContent").innerHTML = array[2];
                document.getElementById("name").innerHTML = array[3];
                document.getElementById("date").innerHTML = array[4];
                console.log(array[3]);
            });
        }
        
        function editAnnouncement(announcementSerial) {
            $.get('getAnnouncement', {
                'serial' : announcementSerial
            }, function(array) {
                document.getElementById("hiddenSerial").value = array[0];
                document.getElementById("title").value = array[1];
                document.getElementById("textarea1").value = array[2];
                $('textarea').trigger('autoresize');
                Materialize.updateTextFields();

            });
            
        }
        
        function passAnnouncementSerial(serial) {
//            document.getElementById("editLink").onclick = function() {editAnnouncement(serial)};
            document.getElementById("deleteLink").href = "deleteAnnouncement/" + serial;
            
            editAnnouncement(serial);
        }
        
        function reset() {
            $('#form-modal1').trigger("reset");
            $('textarea').trigger('autoresize');
        }
        
        //字數限制
        function title_words_deal() {
            var curLength = $("#title").val().length;
            if (curLength > 40) {
                var num = $("#title").val().substr(0, 40);
                $("#title").val(num);
                alert("超過字數限制，多出的字將被移除！");
            } else {
                $("#textCount").text(40 - $("#title").val().length);
            }
        }
        
        //字數限制
        function textarea1_words_deal() {
            var curLength = $("#textarea1").val().length;
            if (curLength > 700) {
                var num = $("#textarea1").val().substr(0, 700);
                $("#textarea1").val(num);
                alert("超過字數限制，多出的字將被移除！");
            } else {
                $("#textCount").text(700 - $("#textarea1").val().length);
            }
        }
    </script>
@endsection
