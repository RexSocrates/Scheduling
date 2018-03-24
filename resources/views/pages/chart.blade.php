@extends("layouts.app2")

<!--
@section('head')

@endsection
-->

@section('navbar')
    <p class="brand-logo light">個人資料</p>
@endsection

@section('nav-content')
    <div class="nav-content blue-grey darken-1">
        <ul class="tabs tabs-transparent">
            <li class="tab"><a class="active" href="#page1">排班人力配置統計</a></li>
<!--            <li class="tab"><a href="#test2">日夜班數統計</a></li>-->
            <li class="tab"><a href="#page3">白夜班比率</a></li>
        </ul>
    </div>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">
        <div class="container-section2">
            <div class="row">
                <div id="page1" class="col s12">
                    <div class="card">
                        <div class="card-action b-t0 card1">
                            <form action="doctorsChart" method="post">
                                <div class="title1">
                                    <font class="card-title">醫師名稱：</font>
                                </div>
                                <div class="input-field left inline">
                                    <select name="selectedUserID" class="browser-default" id=userID required>
                                        <option value="" disabled selected>選擇醫師名稱</option>
                                        @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->doctorID }}">{{ $doctor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="title1 margin-l10">
                                    <button type="submit" class="waves-effect waves-light btn blue-grey darken-1 white-text inline margin-l10">確認</button>
                                </div>
                                {{ csrf_field() }}
                            </form>
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
                                                <th id=name>{{ $currentUser }}</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>總班數</td>
                                                <td id =totalShift>{{ $totalShift }}</td>
                                            </tr>
                                            <tr>
                                                <td>台北白班</td>
                                                <td id=taipeiDay>{{ $shiftsData['taipeiDay'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>台北夜班</td>
                                                <td id=taipeiNight>{{ $shiftsData['taipeiNight'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>淡水白班</td>
                                                <td id=tamsuiDay>{{ $shiftsData['tamsuiDay'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>淡水夜班</td>
                                                <td id=tamsuiNight>{{ $shiftsData['tamsuiNight'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>行政教學班</td>
                                                <td id=others>{{ $shiftsData['others'] }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>  
                    </div>
		       	</div>	
<!--
				<div id="test2" class="col s12">
					<div class="card">
                        <div class="card-action">
                            <font class="card-title">基本資訊</font>
                        </div>
                        <div class="divider"></div>
                        <div class="card-content">
                            <p class="inline">醫師名稱</p>
                            <select name="selectedUserID" class="browser-default" id=ID>
                                <option value="" disabled selected>選擇醫師名稱</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->doctorID }}">{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                            <button class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" type="submit" value="確認" onclick="selectedID_alert()">確認</button>
                        </div>
	                </div>
	                <table class="bordered centered">
				        <thead>
				            <tr>
					            <th>醫生名字</th>
					            <th id=doctorName>{{ $currentUser }}</th>
				            </tr>
				        </thead>
				        <tbody>
				            <tr>
				            	<td>總班數</td>
				            	<td id =totalShifts>{{ $totalShift }}</td>
				            </tr>
				            <tr>
				            	<td>台北白班</td>
				            	<td id=taipeiDays>{{ $shiftsData['taipeiDay'] }}</td>
				            </tr>
				            <tr>
				            	<td>台北夜班</td>
				            	<td id=taipeiNights>{{ $shiftsData['taipeiNight'] }}</td>
				            </tr>
				            <tr>
				            	<td>淡水白班</td>
				            	<td id=tamsuiDays>{{ $shiftsData['tamsuiDay'] }}</td>
				            </tr>
				            <tr>
				            	<td>淡水夜班</td>
				            	<td id=tamsuiNights>{{ $shiftsData['tamsuiNight'] }}</td>
				            </tr>
				            <tr>
				            	<td>行政教學班</td>
				            	<td id=other>{{ $shiftsData['others'] }}</td>
				            </tr>
				        </tbody>
					</table>
                </div>
-->
				<div id="page3" class="col s12">
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
                                    <th>夜班</th>
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
                                    <th>夜班</th>
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
                            </thead>
                        </table>
                    </div>
				</div> 
			</div>
		</div>
	</div>
@endsection

@section('script')
    <script src="../js/Chart.bundle.js"></script>
    <script src="../js/utils.js"></script>
    <script>
	    var config = {

	        type: 'pie',
	        data: {
	            datasets: [{
	                data: [
	                    {{ $shiftsData['taipeiDay'] }},
	                    {{ $shiftsData['taipeiNight'] }},
	                    {{ $shiftsData['tamsuiDay'] }},
	                    {{ $shiftsData['tamsuiNight'] }},
	                    {{ $shiftsData['others'] }},
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


        function selectedID_alert(){
            var doctor=document.getElementById('ID').value
                if(doctor==""){
                dhtmlx.message({ type:"error", text:"請選擇醫生" });
                }
                else{
                selectedID();
                }
            }
        
        function selectedID() {
            $.get('doctorsChart_selectedUserID', {
                selectedUserID : document.getElementById('ID').value
            }, function (array){
                document.getElementById("doctorName").innerHTML = array[0];
                document.getElementById("totalShifts").innerHTML = array[1];
                document.getElementById("taipeiDays").innerHTML = array[2]['taipeiDay'];
                document.getElementById("taipeiNights").innerHTML = array[2]['taipeiNight'];
                document.getElementById("tamsuiDays").innerHTML = array[2]['tamsuiDay'];
                document.getElementById("tamsuiNights").innerHTML = array[2]['tamsuiNight'];
                document.getElementById("other").innerHTML = array[2]['others'];

            });
        }
    </script>
@endsection
