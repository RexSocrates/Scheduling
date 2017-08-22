<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>馬偕醫院排班系統</title>

  	<!--Import Google Icon Font-->
    <link type="text/css" rel="stylesheet" href="../css/icon.css" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="../css/styles.css"/>
   	
</head>
<body style="background-image: url(../img/pattern.png)">
    <div style="top: 40px;position: relative;">
        <div class="row">
            <div class="col s12 m4">
            </div>
            <div class="col s12 m4 card">
                <div class="card-action">
                    <center>
                        <p class="card-title" style="font-weight: 400">馬階醫院急診室排班系統</p>
                        <img src="../img/pharmacy.svg" style="width: 200px;height: 200px;">
                    </center>
                </div>
                
                <div class="card-content" style="padding: 0px 24px 0px 24px">
                    <div class="row">
                        <form class="col s12" action="{{ route('login') }}" method="post">
                            <div class="row margin-b0 inline">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">email</i>
                                    <input id="icon_prefix" type="text" class="validate" name="email">
                                    <label for="icon_prefix">Email</label>
                                </div>
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">lock_outline</i>
                                    <input id="icon_telephone" type="password" class="validate" name="password">
                                    <label for="icon_telephone">Password</label>
                                </div>
                                <div class="col s12 margin-t20">
                                    <button type="submit" class="waves-effect waves-light btn teal lighten-2" style="width: 100%;">login</button>
                                </div>
                                <div class="col s12 margin-t20">
                                    <center>
                                        <a href="http://localhost:8000/password/reset" style="margin-top: 140px;">忘記密碼?</a>
                                    </center>
                                </div>
                            </div>
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
            </div>
        </div>
	</div>

	

	<script type="text/javascript" src="../js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="../js/materialize.min.js"></script>
	
	<script type="text/javascript">
        
    </script>

	
</body>
</html>
