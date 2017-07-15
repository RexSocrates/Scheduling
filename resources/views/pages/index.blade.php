@extends('layouts.admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Speaker
                        <!--<small>Subheading</small>-->
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href={{url('dashboard')}}>Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-male"></i> Speaker
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-sm-11">
                            <h2>Speaker</h2>
                        </div>
                        <div class="col-sm-1">
                            <button type="submit" class="btn btn-default" id="btn-add">
                                <i class="fa fa-btn fa-plus"></i> Create
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>English Name</th>
                                <th>Company</th>
                                <th>Title</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($speakers as $speaker)
                                <tr>
                                    <td>{{$speaker->id}}</td>
                                    <td>{{$speaker->speaker_name}}</td>
                                    <td>{{$speaker->speaker_englishname}}</td>
                                    <td>{{$speaker->speaker_company}}</td>
                                    <td>{{$speaker->speaker_title}}</td>
                                    <td>{{$speaker->speaker_email}}</td>
                                    <td>
                                        <div>
                                        <button class="btn btn-info open-modal" name="speaker_update" value="{{$speaker->id}}" id="btn-update">Update</button>
                                        @role('admin')
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'style' => 'display:inline-block',
                                                'url' => 'speaker/'.$speaker->id
                                            ]) !!}
                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        @endrole
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>  
                    </div>
                    {{ $speakers->render() }}
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        <!--Modal-->
        <div id="gridSystemModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">Create Speaker</h4>
                    </div>
                    <div class="modal-body">
                        <form id="speakerForm" action='{{url('speaker')}}' method="POST" class="form-horizontal" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    {{ csrf_field() }}
                                    <div class="form-group col-md-12">
                                        <h3><label for="speaker-name">講師的中文姓名</label><font class="redStar"> *</font></h3>
                                        <p>英文講師：如沒有中文名字，請用英文名字</p>
                                        <input type="text" name="speaker-name" id="speaker-name" class="form-control" placeholder="例如：黃韋力" value="{{old('speaker-name')}}"> @if ($errors->has('speaker-name'))
                                            <br>
                                            <p class="alert alert-danger">{{ $errors->first('speaker-name') }}</p> @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <h3><label for="speaker-en-name">講師的英文姓名</label></h3>
                                        <input type="text" name="speaker-en-name" id="speaker-en-name" class="form-control" placeholder="例如：Willie Huang" value="{{old('speaker-en-name')}}"> @if ($errors->has('speaker-en-name'))
                                            <br>
                                            <p class="alert alert-danger">{{ $errors->first('speaker-en-name') }}</p> @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <h3><label for="speaker-company">講師的公司</label><font class="redStar"> *</font></h3>
                                        <p></p>
                                        <input type="text" name="speaker-company" id="speaker-company" class="form-control" value="{{old('speaker-company')}}"> @if ($errors->has('speaker-company'))
                                            <br>
                                            <p class="alert alert-danger">{{ $errors->first('speaker-company') }}</p> @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <h3><label for="speaker-title">講師的職位</label></h3>
                                        <p></p>
                                        <input type="text" name="speaker-title" id="speaker-title" class="form-control" value="{{old('speaker-title')}}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <h3><label for="speaker-description">講師的簡單介紹</label></h3>
                                        <p>盡量廣泛，不要限制於本次的演講。如果網路上尚有講師的簡介可以直接複製到這裡或者提供超鏈接</p>
                                        <textarea rows="5" name="speaker-description" id="speaker-description" class="form-control">{{old('speaker-description')}}</textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <h3><label for="speaker-source">介紹的來源</label></h3>
                                        <p></p>
                                        <input type="text" name="speaker-source" id="speaker-source" class="form-control" value="{{old('speaker-source')}}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <h3><label for="speaker-email">講師的email</label></h3>
                                        <p>有了講師的email就可以邀請他設定他的profile。不知道可以留空白。</p>
                                        <input type="text" name="speaker-email" id="speaker-email" class="form-control" value="{{old('speaker-email')}}">
                                        @if ($errors->has('speaker-email'))
                                        <br>
                                        <p class="alert alert-danger">{{ $errors->first('speaker-email') }}</p> @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        
                                        <h3><label for="speaker-photo">講師的照片</label></h3>
                                        <p>有了講師的照片，就可以把它加在講師的profile上</p>
                                        <button type="button" id="crop" class="btn btn-default" data-toggle="modal" data-target="#cropImage" data-backdrop="static">選擇圖片</button>
                                        <div id="speaker-photo">
                                            <?php 
                                                if(old('hidden-speaker-img') == NULL) {
                                                    echo "<img id='speaker-img' src='../../img/user.png' value=''>";
                                                } else {
                                                    echo "<img id='speaker-img' src=".old('hidden-speaker-img')." value=''>";
                                                }
                                            ?>
                                            <!-- <img id="speaker-img" src="../../img/user.png" value=""> -->
                                            <input type="hidden" name="hidden-speaker-img" id="hidden-speaker-img" value="{{old('hidden-speaker-img')}}">
                                            <input type="hidden" name="hidden-speaker-img-name" id="hidden-speaker-img-name" value="{{old('hidden-speaker-img-name')}}">
                                            <input type="hidden" name="hidden-img-name" id="hidden-img-name" value="{{old('hidden-img-name')}}">
                                        </div>
                                        <!-- {!! Form::file('image', null ) !!}
                                        @if ($errors->has('image'))
                                            <br>
                                            <p class="alert alert-danger">{{ $errors->first('image') }}</p> 
                                        @endif -->
                                        <!-- <div class="image-editor">
                                            <input type="file" name="image" class="cropit-image-input" value="{{old('image')}}">
                                            <input type="hidden" name="hidden-speaker-photo" id="hidden-speaker-photo" value="">
                                            <div class="cropit-preview"></div>
                                            <div class="image-size-label"></div>
                                            <input type="range" class="cropit-image-zoom-input range" style="width: 50%;">
                                        </div> -->
                                    </div>
                                    <div class="form-group col-md-12" style="display:none">
                                        <input type="text" name="form-type" class="form-control" value="single">
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary export">Save changes</button>
                    </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <div id="cropImage" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Cropping</h4>
                    </div>
                    <div class="modal-body overflow-h">
                        <div class="row">
                            <div class="image-editor">
                                <center>
                                    <!-- <input type="file" name="image" class="cropit-image-input" value="{{old('image')}}">
                                    <input type="hidden" name="hidden-speaker-photo" id="hidden-speaker-photo" value="">
                                    <div class="cropit-preview"></div>
                                    <div class="image-size-label"></div>
                                    <input type="range" class="cropit-image-zoom-input range" style="width: 50%;"> -->
                                    <div class="actions"> 
                                        <button class="file-btn btn-default"> 
                                            <span>選擇照片</span> 
                                            <input type="file" id="upload" name="upload" value="{{old('upload')}}" /> 
                                        </button> 
                                        <div class="crop"> 
                                            <div id="upload-demo" class="overflow-h"></div> 
                                            <!-- <button class="upload-result btn-primary">裁剪</button> -->
                                        </div> 
                                        <!-- <div id="result"></div> -->
                                    </div> 
                                </center>
                            </div>
                        </div>    
                    </div>
                    <div class="modal-footer">
                        <button class="upload-result btn-primary">裁剪</button>
                        <!-- <button class="cropCommit btn-primary">確定</button>      -->
                    </div>
                    
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    <!-- /#page-wrapper -->
    @if ($errors->any())
        <script>
            $('#gridSystemModal').modal('show');
            // $('#cropImage').modal('show');
        </script>
    @endif
    <script>
    $(document).ready(function(){
        var url = "/admin/speaker";
        //display modal form for creating new speaker
        $('#btn-add').click(function(){
            $('#gridSystemModal').modal({
                backdrop: 'static',
                // keyboard: false , // to prevent closing with Esc button (if you want this too)
            });
            $('.alert').remove();
            // $('.cropit-preview-image').attr('src', '');
            $('#speakerForm').trigger("reset");
            $('#speaker-img').attr('src','../../img/user.png');    
            $('#speakerForm').attr('action','{{url('speaker')}}');
            $('#speakerForm').attr('method','POST');
            $('#gridSystemModalLabel').text('Create Speaker');
            $('#gridSystemModal').modal('show');
        });

        // $('#crop').click(function(){
        //     $('#cropImage').modal({
        //         // backdrop: 'static',
        //     });
        // });

        $('.open-modal').click(function(){
            $('#speakerForm').trigger("reset");
            $('.alert').remove();
            var speaker_id = $(this).val(); 
            
            $.ajax({
                type: 'GET',
                url: url+'/'+speaker_id,
                success: function (data) {
                    console.log(data);
                    $('#speaker-name').val(data.speaker_name);
                    $('#speaker-en-name').val(data.speaker_englishname);
                    $('#speaker-company').val(data.speaker_company);
                    $('#speaker-title').val(data.speaker_title);
                    $('#speaker-description').val(data.speaker_description);
                    $('#speaker-source').val(data.source);
                    $('#speaker-email').val(data.speaker_email);
                    $('#hidden-img-name').val(data.speaker_photo);
                    if(data.local_path == null){
                        $('#speaker-img').attr('src','../../img/user.png');    
                    } else {
                        $('#speaker-img').attr('src', data.local_path);
                    }
                    $('#speakerForm').attr('action',url+'/'+speaker_id);
                    $('#speakerForm').attr('method','POST');
                    $('#gridSystemModalLabel').text('Update Speaker');
                    $('#gridSystemModal').modal('show');

                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
    });
    </script>
    <!-- <script>
      $(function() {
        $('.image-editor').cropit({
            exportZoom: 0.75,
            imageBackground: true,
        });
        $('.export').click(function() {
            var imageData = $('.image-editor').cropit('export');
            $('#hidden-speaker-photo').val(imageData);
        });
      });
    </script> -->
    <script>
        $(function(){ 
            var $uploadCrop; 
            var cropImageBase64;
         
                function readFile(input) { 
                     if (input.files && input.files[0]) { 
                        var reader = new FileReader(); 
                         
                        reader.onload = function (e) { 
                            $uploadCrop.croppie('bind', { 
                                url: e.target.result 
                            }); 
                        } 
                         
                        reader.readAsDataURL(input.files[0]); 
                    } 
                    else { 
                        alert("Sorry - you're browser doesn't support the FileReader API"); 
                    } 
                } 
         
                $uploadCrop = $('#upload-demo').croppie({ 
                    viewport: { 
                        width: 400, 
                        height: 400, 
                        type: 'square' 
                    }, 
                    boundary: { 
                        width: 900, 
                        height: 500 
                    } 
                }); 
         
                $('#upload').on('change', function () {  
                    $(".crop").show(); 
                    readFile(this);  
                }); 

                $('.upload-result').on('click', function (ev) { 
                    $uploadCrop.croppie('result', 'canvas').then(function (resp) { 
                        popupResult({ 
                            src: resp 
                        }); 
                    }); 
                    $('#cropImage').modal('hide');
                    
                    var fullPath = document.getElementById('upload').value;
                    if (fullPath) {
                        var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
                        var filename = fullPath.substring(startIndex);
                        if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                            filename = filename.substring(1);
                        }
                        $('#hidden-speaker-img-name').val(filename);
                    }
                }); 
                 
                function popupResult(result) { 
                    var html; 
                    if (result.html) { 
                        html = result.html; 
                    } 
                    if (result.src) { 
                        html = '<img src="' + result.src + '" />'; 
                        cropImageBase64 = result.src;
                        document.getElementById('speaker-img').setAttribute( 'src', cropImageBase64);
                        $('#hidden-speaker-img').val(cropImageBase64);
                    } 
                    // $("#result").html(html); 
                }
            // $('.cropCommit').click(function() {
            //     // console.log(cropImageBase64);
            //     html = '<img src="' + cropImageBase64 + '" />';
            //     $("#speaker-photo").html(html);
            //     $('#cropImage').modal('hide');
            // });
        }); 
    </script>
    <style>
        button, a.btn { 
            /*background-color: #189094; */
            color: white; 
            padding: 10px 15px; 
            border-radius: 3px; 
            border: 1px solid rgba(255, 255, 255, 0.5); 
            font-size: 16px; 
            cursor: pointer; 
            text-decoration: none; 
            text-shadow: none; 
        } 
        button:focus { 
            outline: 0; 
        } 
         
        .file-btn { 
            position: relative; 
        } 
        .file-btn input[type="file"] { 
            position: absolute; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            opacity: 0; 
        } 
         
        .actions { 
            padding: 5px 0; 
        } 
        .actions button { 
            margin-right: 5px; 
        } 
        .crop{
            display:none;
        }
        #crop{
            margin-bottom: 20px;
        }
    </style>
    <style>
        .cropit-preview {
            background-color: #f8f8f8;
            background-size: cover;
            border: 5px solid #ccc;
            border-radius: 3px;
            margin-top: 7px;
            width: 400px;
            height: 400px;
        }
    
        .cropit-preview-image-container {
            cursor: move;
        }
    
        .cropit-preview-background {
            opacity: .2;
            cursor: auto;
        }  
        .image-size-label {
            margin-top: 10px;
        }
    
        input{
            position: relative;
            z-index: 10;
            display: block;
        }
    
        .range{
            margin-top: 20px;
        }
        
        .overflow-h{
            overflow: hidden;
        }
    
        #speaker-photo{
            width: 400px;
            height: 400px;
        }

        #speaker-img{
            width: 400px;
            height: 400px;
            border-radius: 20px;
        }
        .modal {
            overflow-y: scroll;
        }
        .cr-slider{
            cursor: move;
        }
    </style>
@endsection