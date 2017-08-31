@extends("layouts.app2")

<!--
@section('head')

@endsection
-->

@section('navbar')
    <p class="brand-logo light">個人資料</p>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">
        <div class="container-section">
            <div class="row">
                <div class="col s4">                 
                    <div class="card">
                        <div class="card-action">
                            <font class="card-title">基本資料</font>
                        </div>
                        <div class="divider"></div>
                        <div class="card-content">
                            <center>
                                <img src="../img/boss.png" class="profile-img"/>
                            </center>
                            <p>醫生ID：{{ $doctor->doctorID }}</p>
                            <p>醫生名稱：{{ $doctor->name }}</p>
                            <p>email：{{ $doctor->email }}</p>
                            <p>級別： {{ $doctor->level }}</p>
                            <p>專職：{{ $doctor->major }}</p>
                            <p>職登院區：{{ $doctor->location }}</p>
                            <a href="#modal1">更改密碼</a>
                            
                        </div>
                    </div>
                </div>
                
                <div class="col s8">
                    <div class="card">
                        <div class="card-action">
                            <font class="card-title">排班歷史紀錄</font>
                            @foreach($doctorShiftRecords as $record)
                            <ul>
                            <li>Schedule 1 name and date: {{ $record[4]}} {{ $record[2]}}</li> 
                            <li>Schedule 1 doctor: {{ $record[0] }}</li>
                            <li>Schedule 2 name and date: {{ $record[5]}} {{ $record[3]}}</li> 
                            <li>Schedule 2 doctor: {{ $record[1] }}</li>
                            </ul>
                             @endforeach
                        </div>
                        <div class="divider"></div>
                        <div class="card-content">

                        </div>
                    </div>	
                </div>
            </div>
        </div>
    </div>
    
    <div id="modal1" class="modal">
        <form action="#!" method="post">
            <div class="modal-content">
                <center>
                    <h4>更改密碼</h4>
                </center>
                <div class="input-field col s12">
                    <input id="title" type="password" value="" required>
                    <label for="title">目前的密碼</label>
                </div>   
                <div class="input-field col s12">
                    <input id="title" type="password" value="" required>
                    <label for="title">新密碼</label>
                </div>
                <div class="input-field col s12">
                    <input id="title" type="password" value="" required>
                    <label for="title">重新輸入新密碼</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="modal-action waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save">確認</button>
                <button class="modal-action modal-close waves-effect waves-light btn-flat btn-cancel">關閉</button>
                
            </div>
        </form>
    </div>
@endsection

<!--
@section('script')

@endsection
-->


    
	
