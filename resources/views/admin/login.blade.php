<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>        
        <!-- META SECTION -->
        <title>Football evolution - Admin Login</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="{{ asset('public/admin/favicon.ico') }}" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="{{ asset('public/admin/css/theme-default.css') }}"/>
        <!-- EOF CSS INCLUDE -->                                     
    </head>
    <body>
        
        <div class="login-container lightmode">
        
            <div class="login-box animated fadeInDown">
                <div class="login-logo"></div>
                <div class="login-body">
                    <div class="login-title"><strong>Log In</strong> to your account</div>
                     {!! Form::open(array('url' => 'sspanel/login', 'method' => 'post', 'class' => 'form-horizontal',)) !!}

                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="form-group">
                        <div class="col-md-12">
                            {!! Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required')) !!}
                            {{ $errors->first('username') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            {!! Form::password('password',array('class' => 'form-control', 'placeholder' => 'Password',  'required' => 'required')) !!}
                            {{ $errors->first('password') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <label class="check">
                                  {!! Form::checkbox('remember', 1, null, ['class' => 'field']) !!}
                                  Remember Me
                                </label><br />
                            </div>
                            <div class="col-md-6">
                                {!! Form::submit('Log In', array('class' => 'btn btn-info btn-block')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                                <a href="{{ url('/sspanel/forgetpassword') }}" class="btn btn-link btn-block" style="#color:#fff;">Forgot your password?</a>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="login-footer">
                    <div class="pull-left">
                        &copy; 2015 Football evolution
                    </div>
                </div>
            </div>
            
        </div>
        
    </body>
</html>






