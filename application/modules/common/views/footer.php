<!-- /.content-wrapper -->
<footer class="main-footer">
    <!--<strong>All Copyright are reserved to <a href="<?php // echo BASE_URL;  ?>">Biztech Softsys Pte Ltd</a>.</strong>-->
    <strong>Powered By <a href="<?php // echo BASE_URL;  ?>">NEOEHS</a>.</strong>

    <!--    <div class="float-right d-none d-sm-inline-block">
	  <b>Version</b> 3.0.2
	</div>-->
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- jQuery -->
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo LAYOUT_PLUG_PATH; ?>jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $(document).ready(function () {
	var url = window.location;
	var path = url.pathname;
	var pathn = path.split("/");
	var name = pathn[5];
	var Exp = /((^[0-9]+[a-z]+)|(^[a-z]+[0-9]+))+[0-9a-z]+$/i;
	if (name && !name.match(Exp)) {
	    switch (name) {
		case "addLocation":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + pathn[3] + '/' + pathn[4] + '/' + "location";
		    break;
		case "addUnit":
		case "addunit":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + pathn[3] + '/' + pathn[4] + '/' + "unit";
		    break;
		case "addProject":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + pathn[3] + '/' + pathn[4] + '/' + "project";
		    break;
		case "addInscompany":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + pathn[3] + '/' + pathn[4] + '/' + "insurance_comp";
		    break;
		case "addCauseanalysis":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + pathn[3] + '/' + pathn[4] + '/' + "causeAnalysis";
		    break;
		case "add_causeChecklist":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + pathn[3] + '/' + pathn[4] + '/' + "causeChecklist";
		    break;
		case "add_capa":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + pathn[3] + '/' + pathn[4] + '/' + "capa";
		    break;
		case "addClinic":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + pathn[3] + '/' + pathn[4] + '/' + "clinic";
		    break;
		case "add_sub_body_parts":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + pathn[3] + '/' + pathn[4] + '/' + "sub_body_parts";
		    break;
		case "addNotification":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + pathn[3] + '/' + pathn[4] + '/' + "notiForm";
		    break;
		case "addInspection":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + pathn[3] + '/' + "inspection/index";
		    break;
		case "add_insp_subtype":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + pathn[3] + '/' + pathn[4] + '/' + "insp_clsubtype";
		    break;
		case "add_insp_subtypedata":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + pathn[3] + '/' + pathn[4] + '/' + "insp_clsubtypedata";
		    break;
		case "addEmployee":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + pathn[3] + '/' + pathn[4] + '/' + "employee";
		    break;
		case "EmployeeView":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + pathn[3] + '/' + pathn[4] + '/' + "employee";
		    break;
		case "add_finalreport":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + pathn[3] + '/' + pathn[4] + '/' + "final_report";
		    break;
	    }
	} else {
	    name = pathn[4];
	    switch (name) {
		case "add_company":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + pathn[3] + '/' + "register_company";
		    break;
		case "add_contractor":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + pathn[3] + '/' + "contractor_list";
		    break;
		case "add_agreement":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + pathn[3] + '/' + "contractor_agreement";
		    break;
		case "addCauseanalysis":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + pathn[3] + '/' + "causeAnalysis";
		    break;
		case "add_insp_subtype":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + "insp_clsubtype";
		    break;
		case "add_insp_subtypedata":
		    url = "https://" + document.location.hostname + '/' + pathn[1] + '/' + pathn[2] + '/' + "insp_clsubtypedata";
		    break;
	    }
	}
	$('li a[href="' + url + '"]').parentsUntil('nav-item').addClass('active');
	if ($('li.nav-item.has-treeview  a[href="' + url + '"]').parentsUntil('active').addClass('menu-open')) {
	    $('ul.nav.nav-treeview.active.menu-open').css('display', 'block');
	}
    });
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->

<script src="<?php echo LAYOUT_PLUG_PATH; ?>bootstrap/js/bootstrap.bundle.min.js"></script>

<!--<script src="https://cdn.jsdelivr.net/gh/moment/moment@develop/min/moment-with-locales.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/djibe/bootstrap-material-datetimepicker@83a10c38ee94dd27fd946ea137af6667c65a738f/js/bootstrap-material-datetimepicker-bs4.min.js"></script>-->
<?php
$currentURL = current_url();
if($currentURL == BASE_URL('dashboard')){
    ?>

<!-- ChartJS -->
<script src="<?php echo LAYOUT_PLUG_PATH; ?>chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<!-- <script  src="<?php echo LAYOUT_PLUG_PATH; ?>sparklines/sparkline.js"></script> -->
<!-- JQVMap -->
<!-- <script src="<?php echo LAYOUT_PLUG_PATH; ?>jqvmap/jquery.vmap.min.js"></script> -->
<!-- <script src="<?php echo LAYOUT_PLUG_PATH; ?>jqvmap/maps/jquery.vmap.usa.js"></script> -->
<!-- jQuery Knob Chart -->
<script src="<?php echo LAYOUT_PLUG_PATH; ?>jquery-knob/jquery.knob.min.js"></script>
<?php
}
?>
<!-- daterangepicker -->
<script src="<?php echo LAYOUT_PLUG_PATH; ?>moment/moment.min.js"></script>
<script src="<?php echo LAYOUT_PLUG_PATH; ?>daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo LAYOUT_PLUG_PATH; ?>tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo LAYOUT_PLUG_PATH; ?>summernote/summernote-bs4.min.js"></script>
<!--<script src="<?php echo LAYOUT_PLUG_PATH; ?>daterangepicker/daterangepicker.js"></script>-->
<!-- overlayScrollbars -->
<script src="<?php echo LAYOUT_PLUG_PATH; ?>overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo LAYOUT_PLUG_PATH_JS; ?>adminlte.js"></script>
<?php
$currentURL = current_url();
if($currentURL == BASE_URL('dashboard')){
    ?>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="<?php echo LAYOUT_PLUG_PATH_JS; ?>pages/dashboard.js"></script> -->
<?php
}
?>
<script src="<?php echo LAYOUT_PLUG_PATH; ?>sweetalert/sweetalert.js"></script>
<script src="<?php echo LAYOUT_PLUG_PATH; ?>sweetalert/sweetalert.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo LAYOUT_PLUG_PATH_JS; ?>demo.js"></script>
<script src="<?php echo BASE_URL('assets/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js'); ?> "></script>
<script src="<?php echo LAYOUT_PLUG_PATH; ?>common_jquery/customJquery.js"></script>
<script src="<?php echo LAYOUT_PLUG_PATH; ?>select2/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>-->
<!--<script src="<?php echo LAYOUT_PLUG_PATH; ?>bootstrap/js/bootstrap.min.js"></script>-->
<script src="<?php echo LAYOUT_PLUG_PATH_JS; ?>picedit.js"></script>
<script src="<?php echo LAYOUT_PLUG_PATH; ?>jquery-lazy/jquery.lazy.min.js"></script>
<script src="<?php echo LAYOUT_PLUG_PATH; ?>jquery-lazy/jquery.lazy.plugins.min.js"></script>
<script type="text/javascript" src="<?php echo LAYOUT_PLUG_PATH; ?>fancybox/jquery.fancybox.min.js"></script>
 <!--<script src="<?php echo LAYOUT_PLUG_PATH; ?>bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>-->
<script>
     var baseURL = '<?php echo BASE_URL;?>';
     var loadingImg = '<?php echo LOADING_IMG; ?>';
</script>
<script src="<?php echo LAYOUT_PLUG_PATH_JS; ?>script.js"></script>
<script src="<?php echo LAYOUT_PLUG_PATH; ?>common_jquery/idleJs.js"></script>
</body>
</html>
