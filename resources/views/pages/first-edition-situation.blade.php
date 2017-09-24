@extends("layouts.app2")

@section('head')
<!--    <link type="text/css" rel="stylesheet" href="../css/dataTables.material.min.css"/>-->
@endsection

@section('navbar')
    <font class="brand-logo light">調整班表 <i class="material-icons arrow_right-icon">keyboard_arrow_right</i>初版班表 <i class="material-icons arrow_right-icon">keyboard_arrow_right</i>醫生排班現況</font>
@endsection

@section('content')
    <div id="section" class="container-fix trans-left-five">
		<div class="container-section">
			<div class="row">
                <div class="col s12 m12">
      		  	  	<div class="card">
      		  	  		<div class="card-action">
      		  	  			<font class="card-title">初版班表XX</font>
      		  	  		</div>
      		  	  		<div class="divider"></div>
      		  	  	  	<div class="card-content">
      		  	  	  	    <table id="doctor" class="mdl-data-table striped highlight" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
<!--                                    多加一個欄位叫做id-->
                                        <th>名稱</th>
                                        <th>種類</th>
                                        <th>班數</th>
                                        <th>台北</th>
                                        <th>淡水</th>
                                        <th>內科</th>
                                        <th>外科</th>
                                        <th>白班</th>
                                        <th>夜班</th>
                                        <th>假日班</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>張國頌</th>
                                        <th>應上</th>
                                        <th>15</th>
                                        <th>8</th>
                                        <th>7</th>
                                        <th>10</th>
                                        <th>5</th>
                                        <th>10</th>
                                        <th>5</th>
                                        <th>3</th>
                                    </tr>
                                    <tr>
                                        <th>張國頌</th>
                                        <th>已上</th>
                                        <th>8</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>5</th>
                                        <th>3</th>
                                        <th>9</th>
                                        <th>3</th>
                                        <th>2</th>
                                    </tr>
                                    <tr>
                                        <th>沈靜宜</th>
                                        <th>應上</th>
                                        <th>15</th>
                                        <th>8</th>
                                        <th>7</th>
                                        <th>10</th>
                                        <th>5</th>
                                        <th>10</th>
                                        <th>5</th>
                                        <th>3</th>
                                    </tr>
                                    <tr>
                                        <th>沈靜宜</th>
                                        <th>已上</th>
                                        <th>8</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>5</th>
                                        <th>3</th>
                                        <th>9</th>
                                        <th>3</th>
                                        <th>2</th>
                                    </tr>
                                    <tr>
                                        <th>周敬堯</th>
                                        <th>應上</th>
                                        <th>15</th>
                                        <th>8</th>
                                        <th>7</th>
                                        <th>10</th>
                                        <th>5</th>
                                        <th>10</th>
                                        <th>5</th>
                                        <th>3</th>
                                    </tr>
                                    <tr>
                                        <th>周敬堯</th>
                                        <th>已上</th>
                                        <th>8</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>5</th>
                                        <th>3</th>
                                        <th>9</th>
                                        <th>3</th>
                                        <th>2</th>
                                    </tr>
                                    <tr>
                                        <th>解晉一</th>
                                        <th>應上</th>
                                        <th>15</th>
                                        <th>8</th>
                                        <th>7</th>
                                        <th>10</th>
                                        <th>5</th>
                                        <th>10</th>
                                        <th>5</th>
                                        <th>3</th>
                                    </tr>
                                    <tr>
                                        <th>解晉一</th>
                                        <th>已上</th>
                                        <th>8</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>5</th>
                                        <th>3</th>
                                        <th>9</th>
                                        <th>3</th>
                                        <th>2</th>
                                    </tr>
                                    <tr>
                                        <th>黃書田</th>
                                        <th>應上</th>
                                        <th>15</th>
                                        <th>8</th>
                                        <th>7</th>
                                        <th>10</th>
                                        <th>5</th>
                                        <th>10</th>
                                        <th>5</th>
                                        <th>3</th>
                                    </tr>
                                    <tr>
                                        <th>黃書田</th>
                                        <th>已上</th>
                                        <th>8</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>5</th>
                                        <th>3</th>
                                        <th>9</th>
                                        <th>3</th>
                                        <th>2</th>
                                    </tr>
                                    <tr>
                                        <th>邱毓惠</th>
                                        <th>應上</th>
                                        <th>15</th>
                                        <th>8</th>
                                        <th>7</th>
                                        <th>10</th>
                                        <th>5</th>
                                        <th>10</th>
                                        <th>5</th>
                                        <th>3</th>
                                    </tr>
                                    <tr>
                                        <th>邱毓惠</th>
                                        <th>已上</th>
                                        <th>8</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>5</th>
                                        <th>3</th>
                                        <th>9</th>
                                        <th>3</th>
                                        <th>2</th>
                                    </tr>
                                    <tr>
                                        <th>鄧立明</th>
                                        <th>應上</th>
                                        <th>15</th>
                                        <th>8</th>
                                        <th>7</th>
                                        <th>10</th>
                                        <th>5</th>
                                        <th>10</th>
                                        <th>5</th>
                                        <th>3</th>
                                    </tr>
                                    <tr>
                                        <th>鄧立明</th>
                                        <th>已上</th>
                                        <th>8</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>5</th>
                                        <th>3</th>
                                        <th>9</th>
                                        <th>3</th>
                                        <th>2</th>
                                    </tr>
                                    <tr>
                                        <th>謝尚霖</th>
                                        <th>應上</th>
                                        <th>15</th>
                                        <th>8</th>
                                        <th>7</th>
                                        <th>10</th>
                                        <th>5</th>
                                        <th>10</th>
                                        <th>5</th>
                                        <th>3</th>
                                    </tr>
                                    <tr>
                                        <th>謝尚霖</th>
                                        <th>已上</th>
                                        <th>8</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>5</th>
                                        <th>3</th>
                                        <th>9</th>
                                        <th>3</th>
                                        <th>2</th>
                                    </tr>
                                    
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        
        $(document).ready(function() {
            $('#doctor').DataTable( {
                columnDefs: [
                    {
                        targets: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                        className: 'mdl-data-table__cell--non-numeric',
                        orderable: false, 
                    }
                ]
            });
            
            $('select').material_select();
            
            document.getElementById("doctor_length").style.display = 'none';
            
            document.getElementById("doctor_filter").style.cssText = 'text-align: left';
            
            document.getElementById("doctor_filter").getElementsByTagName("label")[0].getElementsByTagName("input")[0].style.marginLeft = '0';
        
        });
        
        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 200 // Creates a dropdown of 15 years to control year
        });
    </script>
@endsection
