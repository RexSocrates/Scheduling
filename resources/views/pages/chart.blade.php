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
            <li class="tab"><a class="active" href="#test1">排班人力配置統計</a></li>
            <li class="tab"><a href="#test2">日夜班數統計</a></li>
            <li class="tab"><a href="#test3">白夜班比率</a></li>
        </ul>
    </div>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">
        <div class="container-section2">
            <div class="row">
                <div id="test1" class="col s12">
                    <div class="card">
                        <div class="card-action">
                            <form action="doctorsChart" method="post">
                                <p class="inline">醫師名稱</p>
                                    <select name="selectedUserID" class="browser-default">
                                        <option value="" disabled selected>選擇醫師名稱</option>
                                        @foreach($doctors as $doctor)
                                            <option value={{ $doctor->doctorID }}>{{ $doctor->name }}</option>
                                        @endforeach
                                    </select>
                                    <input class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" type="submit" value="確認">
                                    <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal2">確認</a>
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
                                                <th>{{$currentUser}}</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>總班數</td>
                                                <td>{{ $totalShift }}</td>
                                            </tr>
                                            <tr>
                                                <td>台北白班</td>
                                                <td>{{ $shiftsData['taipeiDay'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>台北夜班</td>
                                                <td>{{ $shiftsData['taipeiNight'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>淡水白班</td>
                                                <td>{{ $shiftsData['tamsuiDay'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>淡水夜班</td>
                                                <td>{{ $shiftsData['tamsuiNight'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>行政教學班</td>
                                                <td>{{ $shiftsData['others'] }}</td>
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

    
    </script>
@endsection
