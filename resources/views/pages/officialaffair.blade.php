@extends("layouts.app2")

<!--
@section('head')
    
@endsection
-->

@section('navbar')
    <p class="brand-logo light">醫師公假紀錄</p>
@endsection

@section('nav-content')
    <div class="nav-content blue-grey darken-1">
        <ul class="tabs tabs-transparent">
            <li class="tab"><a class="active" href="#test1">查看醫生</a></li>
            <li class="tab"><a href="#test2">待確認</a></li>
        </ul>
    </div>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">
		<div class="container-section2">
			<div class="row">
                <div id="test1" class="col s12 m12">
      		  	  	<div class="card">
      		  	  		<div class="card-action card1">
                            <form action="">
                                <div class="title1">
                                    <font class="card-title">醫生：</font>
                                </div>
                                <div class="input-field left inline">
                                    <select>
                                        <option value="1" selected>全部</option>
                                        <option value="2">簡定國</option>
                                        <option value="3">邱毓惠</option>
                                        <option value="4">馮嚴毅</option>
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
                            <a class="btn-floating halfway-fab waves-effect waves-light red accent-2" href="#modal1"><i class="material-icons">add</i></a>
                        </div>
      		  	  		<div class="divider"></div>
      		  	  	  	<div class="card-content padding-t5">
      		  	  	  	    <table class="centered striped highlight scroll area4">
                                <thead>
                                    <tr>
                                        <th class="td-w-5">日期</th>
                                        <th class="td-w-5">申請人</th>
                                        <th class="td-w-5">對象</th>
                                        <th class="td-w-5">種類</th>
                                        <th class="td-w-5">時數</th>
                                        <th class="td-w-25">內容</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td class="td-padding td-w-5">2017-10-15</td>
                                        <td class="td-padding td-w-5">蔡維德</td>
                                        <td class="td-padding td-w-5">簡定國</td>
                                        <td class="td-padding td-w-5">增加</td>
                                        <td class="td-padding td-w-5">+3.5小時</td>
                                        <td class="td-padding td-w-25">增加時數的原因,增加時數的原因,增加時數的原因,增加時數的原因,增加時數的原因,增加時數的原因,增加時數的原因</td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding td-w-5">2017-10-21</td>
                                        <td class="td-padding td-w-5">簡定國</td>
                                        <td class="td-padding td-w-5">簡定國</td>
                                        <td class="td-padding td-w-5">使用/減少</td>
                                        <td class="td-padding td-w-5">-12小時</td>
                                        <td class="td-padding td-w-25">使用公假內容</td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding td-w-5">2017-10-21</td>
                                        <td class="td-padding td-w-5">簡定國</td>
                                        <td class="td-padding td-w-5">簡定國</td>
                                        <td class="td-padding td-w-5">使用/減少</td>
                                        <td class="td-padding td-w-5">-12小時</td>
                                        <td class="td-padding td-w-25">使用公假內容</td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding td-w-5">2017-10-15</td>
                                        <td class="td-padding td-w-5">蔡維德</td>
                                        <td class="td-padding td-w-5">簡定國</td>
                                        <td class="td-padding td-w-5">增加</td>
                                        <td class="td-padding td-w-5">+3.5小時</td>
                                        <td class="td-padding td-w-25">增加時數的原因,增加時數的原因,增加時數的原因</td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding td-w-5">2017-10-21</td>
                                        <td class="td-padding td-w-5">簡定國</td>
                                        <td class="td-padding td-w-5">簡定國</td>
                                        <td class="td-padding td-w-5">使用/減少</td>
                                        <td class="td-padding td-w-5">-12小時</td>
                                        <td class="td-padding td-w-25">使用公假內容</td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding">2017-10-21</td>
                                        <td class="td-padding">簡定國</td>
                                        <td class="td-padding">簡定國</td>
                                        <td class="td-padding">使用/減少</td>
                                        <td class="td-padding">-12小時</td>
                                        <td class="td-padding">使用公假內容</td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding">2017-10-21</td>
                                        <td class="td-padding">簡定國</td>
                                        <td class="td-padding">簡定國</td>
                                        <td class="td-padding">使用/減少</td>
                                        <td class="td-padding">-12小時</td>
                                        <td class="td-padding">使用公假內容</td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding">2017-10-21</td>
                                        <td class="td-padding">簡定國</td>
                                        <td class="td-padding">簡定國</td>
                                        <td class="td-padding">使用/減少</td>
                                        <td class="td-padding">-12小時</td>
                                        <td class="td-padding">使用公假內容</td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding">2017-10-21</td>
                                        <td class="td-padding">簡定國</td>
                                        <td class="td-padding">簡定國</td>
                                        <td class="td-padding">使用/減少</td>
                                        <td class="td-padding">-12小時</td>
                                        <td class="td-padding">使用公假內容</td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding">2017-10-21</td>
                                        <td class="td-padding">簡定國</td>
                                        <td class="td-padding">簡定國</td>
                                        <td class="td-padding">使用/減少</td>
                                        <td class="td-padding">-12小時</td>
                                        <td class="td-padding">使用公假內容</td>
                                    </tr>
                                </tbody>
                            </table>
      		  	  	  	</div>
      		  	  	</div>
      		  	</div>
      		  	<div id="test2" class="col s12">
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
                                    <tr>
                                        <td class="td-padding td-w-5">簡定國</td>
                                        <td class="td-padding td-w-5">2017-10-21</td>
                                        <td class="td-padding td-w-20">使用公假內容,使用公假內容,使用公假內容使用公假內容,使用公假內容</td>
                                        <td class="td-padding td-w-5">12小時</td>
                                        <td class="td-padding td-w-13">
                                            <a href="" class="waves-effect waves-light btn" name=confirm>允許</a>
                                            <a href="" class="waves-effect waves-light btn deep-orange darken-3" name=reject>拒絕</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding td-w-5">簡定國</td>
                                        <td class="td-padding td-w-5">2017-10-21</td>
                                        <td class="td-padding td-w-20">使用公假內容,使用公假內容,使用公假內容</td>
                                        <td class="td-padding td-w-5">12小時</td>
                                        <td class="td-padding td-w-10">
                                            <a href="" class="waves-effect waves-light btn" name=confirm>允許</a>
                                            <a href="" class="waves-effect waves-light btn deep-orange darken-3" name=reject>拒絕</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding td-w-5">簡定國</td>
                                        <td class="td-padding td-w-5">2017-10-21</td>
                                        <td class="td-padding td-w-20">使用公假內容,使用公假內容,使用公假內容</td>
                                        <td class="td-padding td-w-5">12小時</td>
                                        <td class="td-padding td-w-10">
                                            <a href="" class="waves-effect waves-light btn" name=confirm>允許</a>
                                            <a href="" class="waves-effect waves-light btn deep-orange darken-3" name=reject>拒絕</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding td-w-5">簡定國</td>
                                        <td class="td-padding td-w-5">2017-10-21</td>
                                        <td class="td-padding td-w-20">使用公假內容,使用公假內容,使用公假內容</td>
                                        <td class="td-padding td-w-5">12小時</td>
                                        <td class="td-padding td-w-10">
                                            <a href="" class="waves-effect waves-light btn" name=confirm>允許</a>
                                            <a href="" class="waves-effect waves-light btn deep-orange darken-3" name=reject>拒絕</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding td-w-5">簡定國</td>
                                        <td class="td-padding td-w-5">2017-10-21</td>
                                        <td class="td-padding td-w-20">使用公假內容,使用公假內容,使用公假內容</td>
                                        <td class="td-padding td-w-5">12小時</td>
                                        <td class="td-padding td-w-10">
                                            <a href="" class="waves-effect waves-light btn" name=confirm>允許</a>
                                            <a href="" class="waves-effect waves-light btn deep-orange darken-3" name=reject>拒絕</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="td-padding td-w-5">簡定國</td>
                                        <td class="td-padding td-w-5">2017-10-21</td>
                                        <td class="td-padding td-w-20">使用公假內容,使用公假內容,使用公假內容</td>
                                        <td class="td-padding td-w-5">12小時</td>
                                        <td class="td-padding td-w-10">
                                            <a href="" class="waves-effect waves-light btn" name=confirm>允許</a>
                                            <a href="" class="waves-effect waves-light btn deep-orange darken-3" name=reject>拒絕</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
      		</div>
		</div>
	</div>
	
	
	
    <div id="modal1" class="modal modal-fixed-footer modal-announcement">
        <form action="" method="post">
            <div class="modal-header">
                <h5 class="modal-announcement-title">時數</h5>
            </div>
            
            <div class="modal-content modal-content-customize1">
                <div class="row margin-b0">
                    <div class="input-field col s12 margin-b20">
                        <select name="doctor" required>
                            <option value="" selected disabled>選擇醫生</option>
                            <option value="1">簡定國</option>
                            <option value="2">簡定國</option>
                            <option value="3">簡定國</option>
                            <option value="4">簡定國</option>
                            <option value="5">簡定國</option>
                            <option value="6">簡定國</option>
                            <option value="7">簡定國</option>
                            <option value="8">簡定國</option>
                            <option value="9">簡定國</option>
                            <option value="10">簡定國</option>
                            <option value="">簡定國</option>
                            <option value="">簡定國</option>
                            <option value="">簡定國</option>
                            <option value="">簡定國</option>
                            <option value="">簡定國</option>
                            <option value="">簡定國</option>
                            <option value="">簡定國</option>
                            <option value="">簡定國</option>
                            <option value="">簡定國</option>
                            <option value="">簡定國</option>
                        </select>
                        <label>醫生</label>
                    </div>
                    <div class="input-field col s12 margin-t0">
                        <p class="margin-0">種類</p>
                        <p class="radio-location">
                            <input class="with-gap" name="location" type="radio" id="radio-plus" value="1" checked required/>
                            <label for="radio-plus">增加</label>
                            <input class="with-gap" name="location" type="radio" id="radio-minus" value="0" />
                            <label for="radio-minus">減少</label>
                        </p>
                    </div>
                    <div class="input-field col s12">
                        <input id="hour" type="number" value="" name="hour" required>
                        <label for="hour">時數</label>
                    </div>
                    <div class="input-field col s12 margin-t0">
                        <textarea id="textarea1" class="materialize-textarea" type="text" name="content"></textarea>
                        <label for="textarea1">內容</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save">Save</button>
                <button class="modal-action modal-close waves-effect waves-light btn-flat btn-cancel">Cancel</button>
            </div>
        </form>
    </div>
    
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('select').material_select();
  		});
    </script>
    
@endsection


	