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
                                        <th>換班內容</th>
                                        <th>功能</th>
                                    </tr>
                                </thead>

                               <tbody>
                                   @foreach($shiftRecords as $record)
                                        <tr>
                                            <td class="td-padding">{{ $record['applier'] }}</td>
                                            <td class="td-padding">{{ $record['applyDate'] }}</td>
                                            <td class="td-padding">{{ $record['sch1Date'] }} <font class="font-w-b">{{ $record['sch1Content'] }} </font> 與 {{ $record['sch2Date'] }}  <font class="font-w-b">{{ $record['sch2Content'] }} </font> 互換</td>
                                            
                                            @if($record['adminConfirm'] == 1)
                                                <td class="td-padding"><a class="waves-effect waves-light btn pad-btn disabled">已確認</a></td>
                                            @else
                                                <td class="td-padding"><a href="adminAgreeShiftRecord/{{ $record['changeSerial'] }}" class="waves-effect waves-light btn">確認</a></td>
                                            @endif
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
                       
                        <div class="card-action card1">
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
      		  	  		
      		  	  		<div class="divider"></div>
      		  	  	  	
      		  	  	  	<div class="card-content">
                            <table class="centered striped highlight">
                                <thead>
                                    <tr>
                                        <th>提出人</th>
                                        <th>申請日期</th>
                                        <th>備註內容</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($remarks as $remark)
                                        <tr>
                                            <td class="td-padding">{{ $remark['author'] }}</td>
                                            <td class="td-padding">{{ $remark['date'] }}</td>
                                            <td class="td-padding">{{ $remark['content'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('select').material_select();
  		});
    </script>
@endsection