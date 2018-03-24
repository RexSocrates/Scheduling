<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>馬偕醫院排班系統</title>

    <meta name="viewport" content="width=device-width, initial-scale=0.7, maximum-scale=1.5, user-scalable=1">
     
  	<!--Import Google Icon Font-->
    <link type="text/css" rel="stylesheet" href="../css/icon.css" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="../css/styles.css"/>
   	
   	<style>
        canvas{
            display:block;
            vertical-align:bottom;
        }
        
        #particles-js{
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: 50% 50%;
            background-repeat: no-repeat;
        }
    </style>
   	
</head>
<body class="login-body">
    <div id="particles-js" style="position: absolute"></div>
        <div class="login-box">
            <div class="row margin-0">
                <div class="col s12 m12 card margin-0">
                    <div class="card-action b-t0" style="padding-bottom: 10px;">
                        <center>
                            <img src="../img/logo1.png" class="login-logo">
<!--                            <p class="card-title margin-b0" style="font-weight: 400">馬偕醫院急診室排班系統</p>-->
                        </center>
                    </div>

                    <div class="card-content" style="padding: 0px 24px;">
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
                
            </div>
        </div>
<!--    </div>-->
    
    <script type="text/javascript" src="../js/particles.js"></script>

	<script type="text/javascript" src="../js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="../js/materialize.min.js"></script>
	
	<script type="text/javascript">
        particlesJS.load('particles-js', '../assets/particles.json', function() {
//            console.log('callback - particles.js config loaded');
        });
        
        $(document).ready(function() {
            Materialize.updateTextFields();
//            $.material.options.autofill = true;
//            $.material.init();
        });
        
    </script>

	
</body>
</html>
