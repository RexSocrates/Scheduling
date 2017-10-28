@extends("layouts.app2")

@section('head')
    <link type="text/css" rel="stylesheet" href="../css/dataTables.material.min.css"/>
@endsection

@section('navbar')
    <p class="brand-logo light">積欠班狀況</p>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">
		<div class="container-section">
			<div class="row">
                <div class="col s12 m12">
      		  	  	<div class="card">
      		  	  		<div class="card-action">
      		  	  			<font class="card-title">狀況</font>
      		  	  		</div>
      		  	  		<div class="divider"></div>
      		  	  	  	<div class="card-content">
      		  	  	  	    <table id="doctor" class="mdl-data-table striped highlight" cellspacing="0" width="100%">
                                <thead>
                                   
                                    <!-- <tr>
                                        <th>id</th>
                                        <th>名稱</th>
                                        <th>總數</th>
                                         @foreach($monthList as $month)
                                        <th> {{ $month }} 月</th>
                                         @endforeach
                                        <th>動作</th>

                                    </tr> -->
                                      <tr>
                                        <th>id</th>
                                        <th>名稱</th>
                                        <th>總數</th>
                                        <th>12月</th>
                                        <th>11月</th>
                                        <th>10月</th>
                                        <th>9月</th>
                                        <th>8月</th>
                                        <th>7月</th>
                                        <th>動作</th>
                                    </tr>
                                   
                                </thead>
                                <tbody>
                                    @foreach($doctorsRecords as $record)
                                    <tr>
                                        <td>{{ $record[1]['doctorID'] }}</td>
                                        <td>{{ $record[1]['doctorName'] }}</td>
                                        <td>-2</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>+3</td>
                                        <td>-2</td>
                                        <td>-2</td>
                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal1" onclick="getRecord({{ $record[1]['doctorID'] }})">更多</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>    
                                <!-- <tbody>
                                     @foreach($doctorsRecords as $record)
                                        @foreach($shiftHours as $hour)
                                    <tr>
                                        <td>{{ $record[1]['doctorID'] }}</td>
                                        <td>{{ $record[1]['doctorName'] }}</td>
                                        
                                        @if ( $record[1]['totalShiftHours'] >0 )
                                            <td> {{ $record[1]['totalShiftHours'] }}</td>
                                        @else
                                            <td>{{ $record[1]['totalShiftHours'] }}</td>
                                        @endif

                                        <td>{{ $hour[0] }}</td>
                                       

                                        <td class="doctor-td">
                                            <a class="waves-effect waves-light teal lighten-1 btn doctor-td-btn" href="#modal1" onclick="getRecord({{ $record[1]['doctorID'] }})">更多</a>
                                        </td>
                                    </tr>
                                     @endforeach
                                    @endforeach
                                </tbody>     -->
                            </table>
      		  	  	  	</div>
      		  	  	</div>
      		  	</div>
      		</div>
		</div>
	</div>
	  
    <!-- Modal Structure -->
    <div id="modal1" class="modal modal-fixed-footer modal-announcement max-h80">
        <div class="modal-header">
            <h5 class="modal-announcement-title">歷史紀錄</h5>
        </div>

        <div class="modal-content modal-content-customize1 padding-t5">
            <div class="row margin-b0">
                <h5 id=name></h5>
                <table class="striped">
                    <thead>
                        <tr>
                            <th>日期</th>
                            <th>班數情況</th>
                        </tr>
                    </thead>
                    <tbody id = "shiftHours">
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        
<!--
                    <thead>
                        <tr>
                            <th>日期</th>
                            <th>情況</th>
                            <th>班數</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2017-10</td>
                            <td>積</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <td>2017-09</td>
                            <td>積</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td>2017-08</td>
                            <td>欠</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td>2017-07</td>
                            <td>積</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <td>2017-06</td>
                            <td>積</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td>2017-05</td>
                            <td>欠</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td>2017-04</td>
                            <td>積</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <td>2017-03</td>
                            <td>積</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td>2017-02</td>
                            <td>欠</td>
                            <td>3</td>
                        </tr>
-->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button class="modal-action modal-close waves-effect waves-light btn-flat btn-cancel">Close</button>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../js/dataTables.material.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#doctor').DataTable();
            $('select').material_select();
            document.getElementById("doctor_length").style.display = 'none';
            document.getElementById("doctor_filter").style.cssText = 'text-align: left';
            document.getElementById("doctor_filter").getElementsByTagName("label")[0].getElementsByTagName("input")[0].style.marginLeft = '0';
        });
        
        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 200 // Creates a dropdown of 15 years to control year
        });

        function getRecord(doctorID) {
            $.get('getRecord', {
                doctorID : doctorID

            }, function(array) {

                htmlTableBody = "";
                 for(i = 0; i < array.length; i++) {
                     htmlDoc = "<tr>";
                     htmlDoc += "<td>" + array[i]['date'] + "</td>"; // 日期
                     htmlDoc += "<td>" + array[i]['shiftHours'] + "</td>"; // 班數
                     
                     htmlDoc += "</tr>";
                     
                     htmlTableBody += htmlDoc;
                 }
                    document.getElementById("name").innerHTML  = "醫生名稱："+array[0]['doctorName'];
                    document.getElementById("shiftHours").innerHTML = htmlTableBody;
             });

               
               
            

            console.log(doctorID);
        }
    </script>
@endsection
