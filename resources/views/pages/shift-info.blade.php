@extends("layouts.app2")

<!--
@section('head')

@endsection
-->

@section('navbar')
    <font class="brand-logo light">調整班表 <i class="material-icons arrow_right-icon">keyboard_arrow_right</i>換班資訊</font>
@endsection

@section('content')
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
                                        <th>內容</th>
                                        <th>功能</th>
                                    </tr>
                                </thead>

                              <tbody id="shiftRecordsTableBody">
                                   @foreach($shiftRecords as $record)
                                        <tr>
                                            <td class="td-padding">{{ $record['applier'] }}</td>
                                            <td class="td-padding">{{ $record['applyDate'] }}</td>
                                            <td class="td-padding">
                                            <font id="date1">{{ $record['sch1Date'] }} </font>
                                            <font class="font-w-b">{{ $record['sch1Content'] }} </font> 
                                            與 <font id ="date2">{{ $record['sch2Date'] }}  </font>
                                            <font class="font-w-b">{{ $record['sch2Content'] }} </font> 
                                            互換</td>
                                            
                                            @if($record['adminConfirm'] == 1)
                                                <td class="td-padding"><a class="waves-effect waves-light btn pad-btn disabled">已確認</a></td>
                                            @elseif($record['adminConfirm'] == 2)
                                                <td class="td-padding"><a class="waves-effect waves-light btn pad-btn disabled">已拒絕</a></td>
                                            @else
                                                <td class="td-padding">
                                                <a class="waves-effect waves-light btn" onclick="checkStatus({{ $record['changeSerial'] }})">確認</a>
                                                <a href="adminDisagreeShiftRecord/{{ $record['changeSerial'] }}" class="waves-effect waves-light btn deep-orange darken-3" name=reject>拒絕</a>
                                                </td>
                                            @endif
                                        </tr>
                                   @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
      <!--       <div class="row">
                <div class="col s12 m12">
                    <div class="card">
                       
                        <div class="card-action card1">
                            <div class="title1">
                                <font class="card-title">備註</font>
                            </div>
                           
      		  	  		<div class="divider"></div>
      		  	  	  	
      		  	  	  	<div class="card-content">
                            <table class="centered striped highlight">
                                <thead>
                                    <tr>
                                        <th>提出人</th>
                                        <th>申請日期</th>
                                        <th>內容</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($remarks as $remark)
                                        <tr>
                                            <td class="td-padding" id="author">{{ $remark['author'] }}</td>
                                            <td class="td-padding" id="date">{{ $remark['date'] }}</td>
                                            <td class="td-padding" id="content">{{ $remark['content'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> -->
                    </div>
                </div>
            </div> -->
		</div>
	</div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('select').material_select();
  		});


    </script>

    <script>
        function changeMonth() {
            $.get('changeMonth', {
                month : document.getElementById('month').value
            }, function(array) {

                var author = "";
                var date = "";
                var content ="";
                for(i=0 ; i<array.length ; i++){
                    author += "<td>"+array[i]['author']+"</td>";
                    date += "<td>"+array[i]['date']+"</td>";
                    content += "<td>"+array[i]['content']+"</td>";
                }

                document.getElementById("author").innerHTML  = author;
                document.getElementById("date").innerHTML  = date;
                document.getElementById("content").innerHTML  = content;
               
            });
        }

        function checkStatus(id) {
            $.get('getScheduleInfo', {
                id : id,
            }, function(status) {
                // console.log("check status ID : " + id);
                if(status ==1){
                    adminAgreeShiftRecord(id);
                }
                else{
                    alert("此班表已變動，無法確認換班");
                }
               
            });
            
            
        }

        function adminAgreeShiftRecord(id) {
            $.get('adminAgreeShiftRecord', {
                id:id
            }, function() {
                location.reload();
            });

        }

        //      function changeShiftMonth() {
        //      console.log("Month : " + document.getElementById('shiftMonth').value);
        //      $.get('shiftMonth', {
        //          month : document.getElementById('shiftMonth').value
        //      }, function(array) {
        //          // 更新html內容
        //          htmlTableBody = "";
        //          for(i = 0; i < array.length; i++) {
        //              htmlDoc = "<tr>";
        //              htmlDoc += "<td class='td-padding'>" + array[i][0] + "</td>"; // 申請人
        //              htmlDoc += "<td class='td-padding'>" + array[i][7] + "</td>"; // 申請日期
        //              htmlDoc += "<td class='td-padding'>" + array[i][2]; // schedule 1 的日期
                     
        //              // 申請人的名字, 申請人的班的名稱
        //              htmlDoc += "<font class='font-w-b'>" + array[i][0] + " " + array[i][4] + "</font>";
                     
        //              // 申請對象的班的日期, 申請對象的名字, 班的名稱
        //              htmlDoc += " 與 " + array[i][3] + " <font class='font-w-b'>" + array[i][1] + " " + array[i][5] + "</font> 互換 </td>";

        //              if(array[i][8]==1){
        //                 htmlDoc += "<td class='td-padding class=waves-effect waves-light btn pad-btn disabled'>已確認</td>";
        //              }

        //              else if(array[i][8]==2){
        //                 htmlDoc += "<td class='td-padding class=waves-effect waves-light btn pad-btn disabled'>已拒絕</td>";
        //              }

        //              else{
        //                 htmlDoc += "<td class='td-padding'><a class='waves-effect waves-light btn''onclick=checkStatus(array[i][6])'>確認</a>"+
        //                 "<a href='adminDisagreeShiftRecord/array[i][6]' class='waves-effect waves-light btn deep-orange darken-3' 'name=reject'>拒絕</a></td>"
        //              }
                     
        //              htmlDoc += "</tr>";
                     
        //              htmlTableBody += htmlDoc;
        //              console.log(array[i][8]);
        //          }
                 
        //          document.getElementById("shiftRecordsTableBody").innerHTML = htmlTableBody;
        //      });
        // }
    </script>
@endsection
