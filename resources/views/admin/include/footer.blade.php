
    @yield('footer')  
      
        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="{{ url('panelarea/logout')}}" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="{{ asset('public/admin/audio/alert.mp3') }}" preload="auto"></audio>
        <audio id="audio-fail" src="{{ asset('public/admin/audio/fail.mp3') }}" preload="auto"></audio>
        <!-- END PRELOADS -->                  
<script type="text/javascript">
    window.setTimeout(function() {
        $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
            $(this).remove(); 
        });
    }, 5000);

$(function() { 
    $('.datepic').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    if ($('input[type=date]').length > 0) {
        $('input[type=date]').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    };

    $('.x-navigation-minimize').click(function(){
        setTimeout(function(){ $('.page-content').height($(window).height());}, 205);
    });
 });

</script>
    <!-- START SCRIPTS -->
		<script type="text/javascript" src="{{ asset('public/admin/js/plugins/bootstrap/bootstrap-file-input.js') }}"></script>
        <!-- START THIS PAGE PLUGINS-->        
        <script type='text/javascript' src="{{ asset('public/admin/js/plugins/icheck/icheck.min.js') }}"></script>        
        <script type="text/javascript" src="{{ asset('public/admin/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/admin/js/plugins/scrolltotop/scrolltopcontrol.js') }}"></script>
        
	   
        <script type="text/javascript" src="{{ asset('public/admin/js/plugins/rickshaw/d3.v3.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/admin/js/plugins/rickshaw/rickshaw.min.js') }}"></script>
        <script type='text/javascript' src="{{ asset('public/admin/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
        <script type='text/javascript' src="{{ asset('public/admin/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>                
        <script type='text/javascript' src="{{ asset('public/admin/js/plugins/bootstrap/bootstrap-datepicker.js') }}"></script>                
        <script type='text/javascript' src="{{ asset('public/admin/js/plugins/bootstrap/bootstrap-select.js') }}"></script>                
        <script type="text/javascript" src="{{ asset('public/admin/js/plugins/owl/owl.carousel.min.js') }}"></script>                 
        
        <script type="text/javascript" src="{{ asset('public/admin/js/plugins/moment.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/admin/js/plugins/daterangepicker/daterangepicker.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/admin/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <!-- END THIS PAGE PLUGINS-->        

        <!-- START TEMPLATE -->
       <!-- <script type="text/javascript" src="{{ asset('public/admin/js/settings.js') }}"></script> -->
        
        <script type="text/javascript" src="{{ asset('public/admin/js/plugins.js') }}"></script>        
        <script type="text/javascript" src="{{ asset('public/admin/js/actions.js') }}"></script> 
        
        <script type="text/javascript" src="{{ asset('public/admin/js/demo_dashboard.js') }}"></script>
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->

        @yield('foot')
    </div>	
    </body>
</html>

