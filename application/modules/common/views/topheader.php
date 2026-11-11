<?php  $userdata = $this->session->userinfo;
$prifleImg = postData($userdata,'PROFILE_IMG');

$displayImg = ($prifleImg !='') ? BASE_URL.$prifleImg :  LAYOUT_PLUG_PATH_IMG.'user2-160x160.jpg';

?>
<style>
  .user-panel img {
    height: 50px !important;
    width: 50px !important;
}
</style>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    
    <div id="divLoading" ><div id="loadinggif" class="show" ></div></div>


  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>

    </ul>

<!--    <div class='' style="font-size: 22px;margin-left: 265px;" >
      <b>Terminal Safety System (TSS)</b>
    </div>-->
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    
<li class="nav-item dropdown">
          <?php echo getNotifications();?> </li>



                <li class="nav-item">
<img src="<?php echo BASE_URL.getCompanylogo() ?>" 
           style="opacity: .8;margin-left: 0px;float: none;width: 128px;">
                </li>

    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo BASE_URL; ?>" class="brand-link" style="height: 60px;text-align:center;">
      <img src="<?php echo BASE_URL;?>assets/images/modules/company_logo/fff.png " alt="AdminLTE Logo" class="small brand-image img-circle" style="opacity: .8;margin-left: 0px;float: none;">
              <img src="<?php echo BASE_URL;?>assets/images/modules/company_logo/TSS1.png " alt="AdminLTE Logo" class="big brand-image img-circle" style="opacity: .8;margin-left: 0px;float: none;">
      <span class="brand-text font-weight-light"></span>
    </a>
    
   <!--  <a href="<?php echo BASE_URL; ?>" class="brand-link" style="height: 60px !important;">
      <img src="<?php echo BASE_URL.getCompanylogo() ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
          >
      <span class="brand-text font-weight-light"></span>
    </a>
 -->
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $displayImg;?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info col-md-4">
          <a href="<?php echo BASE_URL.'dashboard/profile';?>" class="d-block">Profile</a>
         
        </div>
        <div class="info col-md-4">
          
          <a href="<?php echo BASE_URL . 'logout'; ?>" class="btn btn-block btn-danger btn-sm" >
                        <span class="glyphicon glyphicon-log-out"></span> Log out
                    </a>
        </div>
      </div>
<script>
$(document).ready(function(){
  $(".small").hide();
    $(".navbar-nav").click(function(){
        if($("body").hasClass("sidebar-collapse")){
          $(".big").show();
          $(".small").hide();
        }else {
          $(".small").show();
          $(".big").hide();
        }
    });
 $(".main-sidebar").hover( function(){
        if($("body").hasClass("sidebar-collapse")){
          $(".big").show();
          $(".small").hide();
        }
    });
$(".content").hover( function(){
        if($("body").hasClass("sidebar-collapse")){
          $(".big").hide();
          $(".small").show();
        }
    });
$("body,.main-header").hover( function(){
        if($("body").hasClass("sidebar-collapse")){
          $(".big").hide();
          $(".small").show();
        }
    });
  });
</script>

  <!-- Content Wrapper. Contains page content -->

  <!-- /.content-wrapper -->
