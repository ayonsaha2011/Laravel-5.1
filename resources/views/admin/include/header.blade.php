<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Panel | @yield('title')</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="{{ asset('public/admin/favicon.ico') }}" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="{{ asset('public/admin/css/theme-default.css') }}"/>
        {{-- <link rel="stylesheet" type="text/css" id="theme" href="{{ asset('public/admin/css/bootstrap/bootstrap.min.css') }}"/> --}}
        <link rel="stylesheet" type="text/css" id="theme" href="{{ asset('public/admin/custom.css') }}"/>
        <!-- EOF CSS INCLUDE -->  

        <!-- START PLUGINS -->
        <script type="text/javascript" src="{{ asset('public/admin/js/plugins/jquery/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/admin/js/plugins/jquery/jquery-ui.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/admin/js/plugins/bootstrap/bootstrap.min.js') }}"></script>  
         
        <script type="text/javascript">
            var base_url="{{asset('/') }}";
        </script>       
        <!-- END PLUGINS -->

        @yield('head')                                   
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">