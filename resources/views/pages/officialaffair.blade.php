@extends("layouts.app2")

@section('head')
    <link type="text/css" rel="stylesheet" href="../css/dataTables.material.min.css"/>
@endsection

@section('navbar')
    <p class="brand-logo light">醫師公假紀錄</p>
@endsection

@section('nav-content')
    <div class="nav-content blue-grey darken-1">
        <ul class="tabs tabs-transparent">
            <li class="tab"><a class="active" href="#page1">查看紀錄</a></li>
            <li class="tab"><a href="#page2">待確認</a></li>
        </ul>
    </div>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">
		<div class="container-section2">
			<div class="row">
                <div id="page1" class="col s12 m12">
      		  	  	<div class="card">
      		  	  		<div class="card-action">
      		  	  		    <font class="card-title">紀錄</font>
<!--
                            <form action="">
                                <div class="title1">
                                    <font class="card-title">醫生：</font>
                                </div>
                                <div class="input-field left inline">
                                    <select>
                                        <option value="1" selected>全部</option>
                                        @foreach($doctors as $doctor)
                                                <option value="{{ $doctor['id'] }}">{{ $doctor['name'] }}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                                <div class="title1 margin-l20">
                                    <font class="card-title">日期：</font>
                                </div>
                                <div class="input-field left inline">
                                    <select>
                                        <option value="1">All</option>
                                        <option value="2">2017-07</option>
                                        <option value="3">2017-06</option>
                                        <option value="4">2017-05</option>
                                    </select>
                                </div>
                                <div class="title1 margin-l10">
                                    <button type="submit" class="waves-effect waves-light btn blue-grey darken-1 white-text inline margin-l10">確認</button>
                                </div>
                            </form>
-->
                            <a class="btn-floating halfway-fab waves-effect waves-light red accent-2" href="#modal1"><i class="material-icons">add</i></a>
                        </div>
      		  	  		<div class="divider"></div>
      		  	  	  	<div class="card-content padding-t5">
                            <table id="officialLeave" class="mdl-data-table striped highlight" cellspacing="0" width="100%">
<!--      		  	  	  	    <table class="centered striped highlight scroll area4">-->
                                <thead>
                                    <tr>
                                        <th class="td-w-5">日期</th>
                                        <th class="td-w-5">申請人</th>
                                        <th class="td-w-5">對象</th>
                                        <th class="td-w-5">增加/減少</th>
                                        <th class="td-w-5">剩餘時數</th>
                                        <th class="td-w-20">內容</th>
                                    </tr>
                                </thead>

                                <tbody>

<!--
                                    @foreach($leaveArr as $leave)
                                    <tr>
                                        <td class="td-padding td-w-5">{{ $leave['date'] }}</td>
                                        <td class="td-padding td-w-5">{{ $leave['doctor'] }}</td>
                                        <td class="td-padding td-w-5">{{ $leave['confirmingPerson'] }}</td>
                                        @if($leave['hours']<0)
                                            <td class="td-padding td-w-5">{{ $leave['hours'] }}</td>
                                        @else
                                            <td class="td-padding td-w-5">+{{ $leave['hours'] }}</td>
                                        @endif
                                        <td class="td-padding td-w-5">{{ $leave['updatedLeaveHours'] }}</td>
                                        <td class="td-padding td-w-20">{{ $leave['remark'] }}</td>
                                    </tr>
                                    @endforeach
-->
                                    <tr>
                                        <td class="td-padding td-w-5">2017-06-22</td>
                                        <td class="td-padding td-w-5">陳常樂</td>
                                        <td class="td-padding td-w-5">陳常樂</td>
                                        <td class="td-padding td-w-5">0</td>
                                        <td class="td-padding td-w-5">25</td>
                                        <td class="td-padding td-w-20"><font class="red-text">(拒絕)</font>內容內容內容內容內容內容內容內容內容內容內容內容</td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding td-w-5">2017-06-12</td>
                                        <td class="td-padding td-w-5">陳常樂</td>
                                        <td class="td-padding td-w-5">陳常樂</td>
                                        <td class="td-padding td-w-5">-12</td>
                                        <td class="td-padding td-w-5">0</td>
                                        <td class="td-padding td-w-20">內容內容內容內容內容內容內容內容內容內容內容內容</td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding td-w-5">2017-06-15</td>
                                        <td class="td-padding td-w-5">陳常樂</td>
                                        <td class="td-padding td-w-5">陳常樂</td>
                                        <td class="td-padding td-w-5">0</td>
                                        <td class="td-padding td-w-5">2</td>
                                        <td class="td-padding td-w-20"><font class="red-text">(拒絕)</font>內容內容內容內容內容內容內容內容內容內容內容內容</td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding td-w-5">2017-06-25</td>
                                        <td class="td-padding td-w-5">陳常樂</td>
                                        <td class="td-padding td-w-5">陳常樂</td>
                                        <td class="td-padding td-w-5">+4</td>
                                        <td class="td-padding td-w-5">14</td>
                                        <td class="td-padding td-w-20">內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容內容</td>
                                    </tr>
                                   
                                </tbody>
                            </table>
      		  	  	  	</div>
      		  	  	</div>
      		  	</div>
      		  	<div id="page2" class="col s12">
					<div class="card">
                        <div class="card-action">
      		  	  			<font class="card-title">換班待確認</font>
      		  	  		</div>
      		  	  		<div class="divider"></div>
      		  	  	  	
      		  	  	  	<div class="card-content padding-t5">
                            <table class="centered striped highlight scroll area4">
                                <thead>
                                    <tr>
                                        <th class="td-w-5">申請人</th>
                                        <th class="td-w-5">申請日期</th>
                                        <th class="td-w-20">申請理由</th>
                                        <th class="td-w-5">時數</th>
                                        <th class="td-w-13">功能</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($unconfirmLeaveArr as $leave)
                                    <tr>
                                        <td class="td-padding td-w-5">{{ $leave['doctor'] }}</td>
                                        <td class="td-padding td-w-5">{{ $leave['date'] }}</td>
                                        <td class="td-padding td-w-25">{{ $leave['remark'] }}</td>
                                        <td class="td-padding td-w-5">{{ $leave['hours'] }}</td> 
                                        <td class="td-padding td-w-13">
                                            <a href="confirmOffcialLeave/{{ $leave['serial']}}" class="waves-effect waves-light btn" name=confirm>允許</a>
                                            <a href="unconfirmOffcialLeave/{{ $leave['serial']}}" class="waves-effect waves-light btn deep-orange darken-3" name=reject>拒絕</a>
                                        </td>
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
	
    
    <div id="modal1" class="modal modal-fixed-footer modal-announcement">
        <form action="addOfficialLeave" method="post">
            <div class="modal-header">
                <h5 class="modal-announcement-title">時數</h5>
            </div>
            
            <div class="modal-content modal-content-customize1">
                <div class="row margin-b0">
                    <div class="input-field col s12 margin-b20">
                        <select name="doctor" required  id= "doctor" >
                           @foreach($doctors as $doctor)
                                <option value="{{ $doctor['id'] }}">{{ $doctor['name'] }}</option>
                            @endforeach
                        </select>
                        <label>醫生</label>
                    </div>
                    <div class="input-field col s12 margin-t0">
                        <p class="margin-0">種類</p>
                        <p class="radio-location">
                            <input class="with-gap" name="classification"  type="radio" id="radio-plus" value="1" checked required/>
                            <label for="radio-plus">增加</label>
                            <input class="with-gap" name="classification"  type="radio" id="radio-minus" value="0" />
                            <label for="radio-minus">減少</label>
                        </p>
                    </div>
                    <div class="input-field col s12">
                        <input id="hour" type="number" value="" name="hour" required>
                        <label for="hour">時數</label>
                    </div>
                    <div class="input-field col s12 margin-t0">
                        <textarea id="textarea1" class="materialize-textarea" type="text" name="content" required></textarea>
                        <label for="textarea1">內容</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save">Save</button>
                <button class="modal-action modal-close waves-effect waves-light btn-flat btn-cancel">Cancel</button>
                
            </div>
            {{ csrf_field() }}
        </form>
    </div>
    
@endsection

@section('script')
    <script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../js/dataTables.material.min.js"></script>
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->

    <script>
        $(document).ready(function() {
            $('select').material_select();
            
            $('#officialLeave').DataTable( {
                columnDefs: [
                    {
                        targets: [ 0, 1, 2 ],
                        className: 'mdl-data-table__cell--non-numeric'
                    }
                ]
            });
            
            document.getElementById("officialLeave_length").style.display = 'none';
            
            document.getElementById("officialLeave_filter").style.cssText = 'text-align: left';
            
            document.getElementById("officialLeave_filter").getElementsByTagName("label")[0].getElementsByTagName("input")[0].style.marginLeft = '0';
        
        });
    </script>
@endsection


	