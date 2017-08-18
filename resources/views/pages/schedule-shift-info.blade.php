@extends("layouts.app2")

@section('head')
    <style>
        td{
            padding: 0;
        }
        .white_cell{
            background-color:white;
        }
        .green_cell{
            background-color:#95FF95;
        }
        .yellow_cell{
            background-color:#FFFF79;
        }
        .red_cell{
            background-color:#FF5353;
        }
    </style>
@endsection

@section('navbar')
    <font class="brand-logo light">正式班表 <i class="material-icons arrow_right-icon">keyboard_arrow_right</i>換班資訊</font>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">    <!--	 style="background-color:red;"-->
		<div class="container-section">
		    <div class="row">
                <div class="col s12 m12">
                    <div class="card">
                        <div class="card-action">
      		  	  			<!-- <img src="../img/announcement.png" class="logo-img"> -->
      		  	  			<font class="card-title">換班資訊區</font>
      		  	  			<a class="btn-floating halfway-fab waves-effect waves-light red accent-2" href="#modal1"><i class="material-icons">add</i></a>
      		  	  			<!-- <a class="btn-floating halfway-fab waves-effect waves-light blue-grey darken-1"><i class="material-icons">add</i></a> -->
      		  	  		</div>
      		  	  		<div class="divider"></div>
      		  	  	  	
      		  	  	  	<div class="card-content">
                            <table class="centered striped highlight">
                                <thead>
                                    <tr>
                                        <th>申請人</th>
                                        <th>申請日期</th>
                                        <th>換班內容</th>
                                        
                                    </tr>
                                </thead>

                               <tbody>
                                  @foreach($shiftRecords as $record)
                                        <tr>
                                         <td class="td-padding">{{ $record[0] }} </td> <!--申請人-->
                                         <td class="td-padding">{{ $record[6] }}</td>  <!--申請日期-->
                                         <td class="td-padding">{{ $record[2] }}  <!--申請人想換班的日期-->
                                         <font class="font-w-b"> {{ $record[0] }} <!--申請人的名字--> 
                                         {{ $record[4] }} <!--申請人換班名字--> 
                                         </font> 
                                         與{{ $record[3] }} <!--被換班人的班日期-->
                                        <font class="font-w-b">{{ $record[1] }} <!--被換班人-->
                                        {{ $record[5] }}<!--被換班人的班名稱-->
                                        </font>
                                        互換</td>
                                        
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
			<div class="row">
                <div class="col s12 m12">
      		  	  	<div class="card">
                        <div class="card-action">
      		  	  			<font class="card-title">換班待確認</font>
      		  	  		</div>
      		  	  		<div class="divider"></div>
      		  	  	  	
      		  	  	  	<div class="card-content">
                            <table class="centered striped highlight">
                                <thead>
                                    <tr>
                                        <th>申請人</th>
                                        <th>申請日期</th>
                                        <th>換班內容</th>
                                        <th>功能</th>
                                    </tr>
                                </thead>

                                <tbody>
                                   @foreach($shiftDataByDoctorID as $record)
                                    <tr>
                                        <td class="td-padding">{{ $record[0] }}</td>
                                        <td class="td-padding">{{ $record[6] }}</td>
                                        <td class="td-padding">{{ $record[2] }} <font class="font-w-b">{{ $record[0] }} {{ $record[4] }}</font> 與 {{ $record[3] }} <font class="font-w-b">{{ $record[1] }} {{ $record[5] }} </font> 互換</td>
                                        <td class="td-padding">
                                            <a href = checkShift/{{$record[7]}} = class="waves-effect waves-light btn" name=confirm>允許</a>
                                            <a href= rejectShift/{{$record[7]}} = class="waves-effect waves-light btn deep-orange darken-3" name=reject>拒絕</a>
                                        </td>
                                    </tr>
                                     @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
      		</div>
      		
      		
            <div id="modal1" class="modal modal-fixed-footer modal-shift">
                <form action="#!" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-announcement-title">換班申請</h5>
                    </div>
                    <div class="modal-content modal-content-customize1">
                        <div class="row margin-b0">
                            <div class="col s12 center padding-b10">
                                <img src="../img/exchange.svg" style="height: 220px;width: 220px;">
                            </div>
                            
                            <div class="col s6">
                                <label>醫生:</label>
                                <select class="browser-default" disabled>
                                    <option value="1" selected>簡定國</option>
                                </select>
                            </div>
                            <div class="col s6">
                                <label>醫生:</label>
                                <select class="browser-default">
                                    <option value="" disabled selected>請選擇醫生</option>
                                    <option value="1">邱毓惠</option>
                                    <option value="2">馮嚴毅</option>
                                    <option value="3">陳心堂</option>
                                    <option value="1">邱毓惠</option>
                                    <option value="2">馮嚴毅</option>
                                    <option value="3">陳心堂</option>
                                    <option value="1">邱毓惠</option>
                                    <option value="2">馮嚴毅</option>
                                    <option value="3">陳心堂</option>
                                    <option value="1">邱毓惠</option>
                                    <option value="2">馮嚴毅</option>
                                    <option value="3">陳心堂</option>
                                    <option value="1">邱毓惠</option>
                                    <option value="2">馮嚴毅</option>
                                    <option value="3">陳心堂</option>
                                    <option value="1">邱毓惠</option>
                                    <option value="2">馮嚴毅</option>
                                    <option value="3">陳心堂</option>
                                    <option value="1">邱毓惠</option>
                                    <option value="2">馮嚴毅</option>
                                    <option value="3">陳心堂</option>
                                </select>
                            </div>
                            <div class="col s6">
                                <label>日期:</label>
                                <select class="browser-default">
                                    <option value="" disabled selected>請選擇日期</option>
                                    <option value="1">2017/08/05</option>
                                    <option value="2">2017/08/17</option>
                                    <option value="3">2017/08/26</option>
                                    <option value="1">2017/08/05</option>
                                    <option value="2">2017/08/17</option>
                                    <option value="3">2017/08/26</option>
                                    <option value="1">2017/08/05</option>
                                    <option value="2">2017/08/17</option>
                                    <option value="3">2017/08/26</option>
                                    <option value="1">2017/08/05</option>
                                    <option value="2">2017/08/17</option>
                                    <option value="3">2017/08/26</option>
                                    <option value="1">2017/08/05</option>
                                    <option value="2">2017/08/17</option>
                                    <option value="3">2017/08/26</option>
                                </select>
                            </div>
                            <div class="col s6">
                                <label>日期:</label>
                                <select class="browser-default">
                                    <option value="" disabled selected>請選擇日期</option>
                                    <option value="1">2017/08/06</option>
                                    <option value="2">2017/08/09</option>
                                    <option value="3">2017/08/14</option>
                                    <option value="1">2017/08/06</option>
                                    <option value="2">2017/08/09</option>
                                    <option value="1">2017/08/06</option>
                                    <option value="2">2017/08/09</option>
                                    <option value="3">2017/08/14</option>
                                    <option value="1">2017/08/06</option>
                                    <option value="2">2017/08/09</option>
                                    <option value="3">2017/08/14</option>
                                    <option value="1">2017/08/06</option>
                                    <option value="2">2017/08/09</option>
                                    <option value="3">2017/08/14</option>
                                </select>
                            </div>
                            
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save">Save</button>
                        <button class="modal-action modal-close  waves-effect waves-light btn-flat btn-cancel">Cancel</button>
                    </div>
                </form>
            </div>
		</div>
	</div>
@endsection


@section('script')
    <script>
        $(document).ready(function(){
            $('select').material_select();
            $('.collapsible').collapsible();
  		});
    </script>
@endsection

