@extends("layouts.app2")

@section('head')
    <link type="text/css" rel="stylesheet" href="../css/dataTables.material.min.css"/>
@endsection

@section('navbar')
    <font class="brand-logo light">時數存摺 <i class="material-icons arrow_right-icon">keyboard_arrow_right</i>{{$doctorName}}(醫生名稱)</font>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">
		<div class="container-section">
			<div class="row">
                <div class="col s12 m12">
      		  	  	<div class="card">
      		  	  		<div class="card-action b-t0">
      		  	  		    <font class="card-title">紀錄</font>
                        </div>
      		  	  		<div class="divider"></div>
      		  	  	  	<div class="card-content padding-t5">
      		  	  	  	    <table id="timeRecordDetails" class="mdl-data-table striped highlight" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="td-w-5">日期</th>
                                        <th class="td-w-5">對象</th>
                                       <!--  <th class="td-w-5">類型</th> -->
                                        <th class="td-w-5">增加/減少</th>
                                        <th class="td-w-5">剩餘時數</th>
                                        <th class="td-w-20">內容</th>
                                    </tr>
                                </thead>

                                <tbody>
                                     @foreach($doctorOfficialLeave as $leave)
                                    <tr>
                                        <td class="td-padding td-w-5">{{ $leave['date'] }}</td>
                                        <td class="td-padding td-w-5">{{ $leave['name'] }}</td>
                                        @if ( $leave['hour'] >0 )
                                            <td class="td-padding td-w-5">增加</td>
                                        @else
                                            <td class="td-padding td-w-5">減少</td>
                                        @endif
                                        <td class="td-padding td-w-5">{{ $leave['hour'] }}</td>
                                        <td class="td-padding td-w-20">{{ $leave['remark'] }}</td>
                                           
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
    <script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../js/dataTables.material.min.js"></script>
    
    <script>
        $(document).ready(function(){
            $('select').material_select();
            
            $('#timeRecordDetails').DataTable({
                "order": [[ 0, "desc" ]]    //  排序的位置
            });
            document.getElementById("timeRecordDetails_length").style.display = 'none';
            document.getElementById("timeRecordDetails_filter").style.cssText = 'text-align: left';
            document.getElementById("timeRecordDetails_filter").getElementsByTagName("label")[0].getElementsByTagName("input")[0].style.marginLeft = '0';
            
            document.getElementById("timeRecord").className += "active";
  		});
    </script>
@endsection


	