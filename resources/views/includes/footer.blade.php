<footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 5.0.0
    </div>
    <strong>Copyright &copy; 2014-2018 <a href="#">Ken Wango</a>.</strong> All rights
    reserved.
  </footer>

  </div>
<!-- ./wrapper -->

<!-- jQuery 3 -->

<!-- jQuery UI 1.11.4 -->
<script src="{{asset('jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Morris.js charts -->
<script src="{{asset('raphael/raphael.min.js')}}"></script>
<script src="{{asset('morris.js/morris.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap -->
<script src="{{asset('jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('jquery-knob/dist/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('moment/min/moment.min.js')}}"></script>
<script src="{{asset('bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{asset('bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>

<script src="{{asset('datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

<!-- Slimscroll -->
<script src="{{asset('jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('js/adminlte.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('js/demo.js')}}"></script>
<!-- <script src="{{asset('js/jquery.smartCart.js')}}" type="text/javascript"></script> -->
<script src="{{asset('select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{asset('jcart-1.3/jcart/js/jcart.js')}}"></script>

    <!-- Initialize -->
    <!-- <script type="text/javascript">
        $(document).ready(function(){
            // Initialize Smart Cart    	
            $('#smartcart').smartCart();
		});
    </script> -->

    <script type="text/javascript">
                   $(document).ready(function() {
                   $('#amount').priceFormat();
                   });
                  </script>

    <script type="text/javascript">
      $(document).ready(function(){
        //activateMagic();

        function updatebeep(){
          $.ajax({
            url: '{{URL::to("updatebeep")}}',
            method: 'GET',
            success: function(res) {

            }
          });
        }

        function activateMagic() {

        var value = 0;

        setInterval(realTimeData, 1000);
        function realTimeData() {
        $.ajax({
            url: '{{URL::to("getneworders")}}',
            method: 'GET',
            dataType: "json",
            success: function(res) {
                //alert(res.checkbeep);
                var newValue = res.neworders;

                if(newValue != value) {
                    $("#notification").html(newValue);
                    $("#message").text("You have "+newValue+" new orders");
                    $("#pending").html(res.pendingorders);
                    $("#pendingmessage").text("You have "+res.pendingorders+" new orders");
                    if(res.checkbeep > 0) {
                    $('<audio id="chatAudio"><source src="/rpos/public/sound/notify.ogg" type="audio/ogg"><source src="/rpos/public/sound/notify.mp3" type="audio/mpeg"><source src="/rpos/public/sound/notify.wav" type="audio/wav"></audio>').appendTo('body');
                    $('#chatAudio')[0].play(); 
                    }        
                    value = newValue;
                   updatebeep();

                }
            }
      });
      }
    }
  });
    </script>

    <script>
  $(function () {
    $('#example1').DataTable();
     $('.select2').select2();
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })

    //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      format: 'MM dd, yyyy',
    })

  })
</script>
</body>
</html>
