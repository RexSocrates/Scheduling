@extends("layouts.app2")

@section('head')

@endsection

@section('navbar')
    <p class="brand-logo light">首頁</p>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">
		<div class="container-section">
			<div class="row">
      		  	<div class="col s12 m8">
      		  	  	<div class="card">
      		  	  		<div class="card-action">
      		  	  			<font class="card-title">系統公告</font>
      		  	  			<a class="btn-floating halfway-fab waves-effect waves-light red accent-2" href="#modal1"><i class="material-icons">add</i></a>
      		  	  		</div>
      		  	  		<div class="divider"></div>
      		  	  	  	
      		  	  	  	<div class="card-content">
      		  	  	  	
      		  	  	  		<div class="row">
    						  	<div class="col s2">
    						  		<img src="../img/user.png" class="boss-img">
    						  	</div>
    						  	<div class="col s10">
    						  		<span class="card-title">Card Title<a class="dropdown-edit-button right" href="#!" data-activates='dropdown-announcement'><i class="material-icons">more_vert</i></a></span>
    						  		<p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card. I am good at... <a href="#modal-more">more</a></p>
    						  	</div>
    						</div>
    						<ul id='dropdown-announcement' class='dropdown-content'>
                                <li><a href="#!">編輯</a></li>
                                <li><a href="#!">刪除</a></li>
                            </ul>
    						<div class="divider margin-bottom-20"></div>
    						
    						<div class="row">
    						  	<div class="col s2">
    						  		<img src="../img/user.png" class="boss-img">
    						  	</div>
    						  	<div class="col s10">
    						  		<span class="card-title">Card Title<a class="dropdown-edit-button right" href="#!" data-activates='dropdown-announcement'><i class="material-icons">more_vert</i></a></span>
    						  		<p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card. I am good at... <a href="#modal-more">more</a></p>
    						  	</div>
    						</div>
    						<ul id='dropdown-announcement' class='dropdown-content'>
                                <li><a href="#!">編輯</a></li>
                                <li><a href="#!">刪除</a></li>
                            </ul>
    						<div class="divider margin-bottom-20"></div>
    						
    						
    						<div class="row margin-b0">
    						  	<div class="col s2">
    						  		<img src="../img/user.png" class="boss-img">
    						  	</div>
    						  	<div class="col s10">
    						  		<span class="card-title">Card Title<a class="dropdown-edit-button right" href="#!" data-activates='dropdown-announcement'><i class="material-icons">more_vert</i></a></span>
    						  		<p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card. I am good at... <a href="#modal-more">more</a></p>
    						  	</div>
    						</div>
                            <ul id='dropdown-announcement' class='dropdown-content'>
                                <li><a href="#!">編輯</a></li>
                                <li><a href="#!">刪除</a></li>
                            </ul>
      		  	  	  	</div>
      		  	  	  	
      		  	  	</div>
      		  	</div>
				
				<div class="col s12 m4">
      		  	  	<div class="card center">
              			<img src="../img/solar-system.png" class="solar-system">
              			<p></p>
              			<h3 class="blue-grey-text text-darken-3">開放預班中</h3>
      		  	  		<p class="blue-grey-text text-darken-3" style="font-weight: 500;">01/05/2017 ~ 20/05/2017</p>
      		  	  	  	<div class="card-action center">
      		  	  	  	  	<a href="reservation.html" class="margin-r0">前往預班表</a>
      		  	  	  	</div>
      		  	  	</div>
      		  	</div>
      		  	
      		</div>
			
			
			<!-- Modal Structure -->
            <div id="modal1" class="modal modal-fixed-footer modal-announcement">
                <form action="#!" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-announcement-title">公告</h5>
                    </div>
                    <div class="modal-content modal-content-customize">
                        <div class="row margin-b0">
                            <div class="input-field col s12">
                                <i class="material-icons prefix modal-icons">chat_bubble</i>
                                <input id="title" type="text">
                                <label for="title">標題</label>
                            </div>
                        
                            <div class="input-field col s12">
                                <i class="material-icons prefix modal-icons">mode_edit</i>
                                <textarea id="textarea1" class="materialize-textarea margin-b0" type="text"></textarea>
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
            
            <div id="modal-more" class="modal modal-fixed-footer modal-announcement">
                <div class="modal-header">
                    <h5 class="modal-announcement-title">公告</h5>
                </div>
                
                <div class="modal-content modal-content-customize">
                    <div class="row margin-b0">
    				    <div class="col s12">
                            <h5 class="card-title">Card Title</h5>
    				    	<p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.I am a very simple card.</p>
    				    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#!" class="modal-action modal-close waves-effect blue-grey darken-1 waves-light btn-flat white-text btn-save">Close</a>
                </div>
            </div>

		</div>
	</div>
@endsection

@section('script')
    <script>
        $('.dropdown-edit-button').dropdown({
            inDuration: 300,
            outDuration: 225,
            constrainWidth: false, // Does not change width of dropdown to that of the activator
            hover: false, // Activate on hover
            gutter: 0, // Spacing from edge
            belowOrigin: false, // Displays dropdown below the button
            alignment: 'right', // Displays dropdown with edge aligned to the left of button
            stopPropagation: false // Stops event propagation
        });
    </script>
@stop
