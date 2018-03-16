@extends('admin.adminmaster')
@section('title', 'Edit Profile')

@section('content')
 <!-- PAGE CONTENT -->
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="{{ URL('/panelarea')}}">Dashboard</a></li>
        <li class="active">Profile</li>
    </ul>
    <!-- END BREADCRUMB -->
    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">

        <div class="row">
            <div class="col-md-12">
                {{-- */$user=Auth::user();/* --}}
                {!! Form::model($user, ['method' => 'post', 'action' => ['Admin\PanelareaController@profileUpdate'], 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Edit Profile</strong></h3>
                    </div>
                    <div class="panel-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="panel-body">
                        <div class="col-md-3">
                            <div style="display: table; width: 100%;">
                                <div style="position: relative;">
                                        <img id="blah" src="{{($user->avatar) ? asset('storage/app/'.$user->avatar ) : asset('public/admin/custom/img/avatar.jpg')}}" alt="" width="100%" />
                                        {!! Form::file('avatarImage',array('id'=>'avatar_image', 'class'=>'featured-image')) !!}
                                        <a class="thickbox" style="font-size: 18px; text-align: center; line-height: 2;" title="Change avatar" >Change avatar</a>
                                </div>

                                <div class="col-sm-12 remove-padding" id="logoimage_message" style="display:none; color:#ff0000;">
                                <span class="col-sm-12 remove-padding">Please upload a Image!</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-md-offset-1">
                            <div class="form-group">
                                {!! Form::label('name', 'Name: ', ['class' => 'col-md-12']) !!}
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('email', 'Email: ', ['class' => 'col-md-12']) !!}
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-envelope"></span></span>
                                        {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'readonly' => 'readonly']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('phone', 'Phone No: ', ['class' => 'col-md-12']) !!}
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-phone"></span></span>
                                        {!! Form::text('phone', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('address', 'Address: ', ['class' => 'col-sm-12']) !!}
                                <div class="col-sm-12">
                                    {!! Form::textarea('address', null, ['class' => 'form-control', 'size' => 'x3']) !!}
                                </div>
                            </div>

                            <div>
                                <div class="newpasswordDiv" style="display: none;">
                                    <div class="form-group">
                                        {!! Form::label('newpassword', 'New password: ', ['class' => 'col-md-12']) !!}
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                                {!! Form::password('newpassword', ['class' => 'form-control newpassword']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('confirmpassword', 'Confirm password: ', ['class' => 'col-md-12']) !!}
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                                {!! Form::password('confirmpassword', ['class' => 'form-control confirmpassword']) !!}
                                            </div>
                                                <p class="confirmpassword-help"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <span class="btn btn-success btn-block change-password" style="margin-top: 20px;">Change password</span>
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="panel-footer">
                        <a class="btn btn-default" href="{{ URL('/panelarea')}}">Back</a>
                         {!! Form::submit('Update', ['class' => 'btn btn-primary pull-right pro-Update']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
                </div>
            </div>

        </div>
        <!-- END PAGE CONTENT WRAPPER -->
@endsection

@section('footer')
<script type="text/javascript">
/*************************picture upload********************************/
$(document).ready(function(){
    $('.pro-Update').click(function() {
        var np = $('.newpassword').val();
        var cp = $('.confirmpassword').val();
        if (np !== cp) {
            $(".confirmpassword-help").css("color", "#ff0000");
            $(".confirmpassword-help").text("Passwords Don't Match");
            return false;
        }
    });
    $('.change-password').click(function() {
        if ($(this).hasClass("change-password-cancel")) {
            $(this).removeClass("change-password-cancel");
            $(this).text("Change password");
            $('.newpassword').removeAttr("required");
            $('.newpassword').val("");
            $('.newpasswordDiv').slideUp();
        }else{
            $(this).addClass("change-password-cancel");
            $(this).text("Cancel");
            $('.newpassword').attr("required", "required");
            $('.newpasswordDiv').slideDown();
        }
    });
    $('.confirmpassword').keyup(function() {
        var np = $('.newpassword').val();
        var cp = $(this).val();
        if (np === cp) {
            $(".confirmpassword-help").css("color", "#4CAF50");
             $(".confirmpassword-help").text("Passwords Match");
        }else{
            $(".confirmpassword-help").css("color", "#ff0000");
            $(".confirmpassword-help").text("Passwords Don't Match");
        }
    });
    $('#avatar_image').change(function() {
        var logo = $(this).val();
        var re = /(\.jpg|\.jpeg|\.bmp|\.gif|\.png)$/i;
        if(re.exec(logo))
        {
            $('#logoimage_message').slideUp();
            $('#profile_sub').prop('disabled', false);
        } else {
            $('#logoimage_message').slideDown();
             $('#profile_sub').prop('disabled', true);
        }
            $('#blah')[0].src = window.URL.createObjectURL(this.files[0]);
    });
});
</script>
@endsection
