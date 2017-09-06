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
<body>
    <div id="particles-js" style="position: absolute"></div>
<!--        <div style="top: 140px;position: relative;">-->
        <div style="-webkit-transform: translate(-50%,-50%);transform: translate(-50%,-50%);position: absolute;top: 50%;left: 50%;width: 33%;">
            <div class="row" style="margin: 0px;">
                
                <div class="col s12 m12 card" style="margin: 0px;">
                    <div class="card-action">
                        <center>
                            <p class="card-title margin-b0" style="font-weight: 400">馬階醫院急診室排班系統</p>
<!--                            <img src="../img/logo.jpg" style="width: 320px;height: 90px;">-->
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
                                        <label class="active" for="icon_telephone">Password</label>
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
            console.log('callback - particles.js config loaded');
        });
        
        $(document).ready(function() {
            Materialize.updateTextFields();
        });
    </script>

	
</body>
</html>
