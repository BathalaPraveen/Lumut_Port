<link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH_CSS; ?>loginstyle.css">

<style>
    body,
    html {
        margin: 0;
        padding: 0;
        height:auto;

    }

    .centered{
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .LogoImage {
        background-color: #F3F4F8;
        height:auto;
    }
    .user_card {
        height: 468px;
        width: 722px;
        display: block;
        margin-left: 17%;
        margin-top: 5%;
    }

    alert-success {
        color: #fff;
        background: #28a745;
        border-color: #23923d;
        margin-top: 10px;
        malert-successargin-left: 50px;

    }
    .fixedfooter{
        position: fixed; 
        bottom:20px; 
        right:0;
    }


    .mLogo{
        height:auto;
        width: 50%;
    }

    .logheading{
        margin-top:20%;
        text-align:center;
    }
    .footerLumutLogo{
        width:100px;
    }


    hr.lineBreak {
        border-top: 1px solid #ccc ;
        width:65%;
        text-align:center;
        margin-bottom: 0px;

    }
    #save_f{
       
        width: 150px;
        margin-top: 20px;
        
    }

    .login_btn {
        padding: 1px 1px !important;
        background: #ffae42 !important;
        color: black !important;
        border-radius:  10px;
        text-align: center;
        height: 40px;
        font-size:20px;
    }
    .lg-btn{
        background: #ffae42 !important;
        border-radius:  10px;
        border-color: #ffae42;
        color: #000;
        text-transform:uppercase;
        font-family: 'northern army Regular';
    }
    .lg-btn:not(:disabled):not(.disabled).active, .lg-btn:not(:disabled):not(.disabled):active, .show>.lg-btn.dropdown-toggle {
        color: #000;
        background-color: #ffae42;
        border-color: #ffae42;
    }
    .lg-btn:hover {
        color: #000;
        background-color: #ffae42;
        border-color: #ffae42;
    }
    .login-text{
        font-family: 'northern army Regular';
        font-size: 64px;
    }
    .vl {
        border-left: 2px solid #ccc;
        display: inline-block;
        width: 0;
        height: 0.75em;
        margin-left: -5px;
        margin-right: -10px;
    }
    .flogin-text{
        font-family: 'northern army Regular';
        font-size: 40px;
        font-weight: 100;
    }
    
    .forget-text {
            font-size: 34px;
            font-weight: bold;
      }


    .input_user
    {
        box-shadow: none !important;
        outline: 0px !important;
        height: 50px;
        margin-top: 2rem;
    }
    .forgetUser{
        box-shadow: none !important;
        outline: 0px !important;
        height: 50px;
        margin-top:30px;
    }
    .input_pass {
        box-shadow: none !important;
        outline: 0px !important;
        height: 50px;

    }


    .headLn{
        font-size: 30px;
        font-weight: bolder;
        text-align: left;

    }

    .link {
        color : #808080 !important;
    }
    .overallView{
        margin-left: 70px !important;
        margin-top: -590px;
    }
    body {
        background-image: url('<?php echo BASE_URL . 'assets/images/login-page-3.jpg'; ?> ');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    }
    .alert-dismissible{
        background-color: red !important;
        width: 90% !important;
        min-height: 50px !important;
        margin: 0 auto;

    }
    .alert_for_forget_password{
        background-color: red;
        width: 400px;
        height: 50px;
        margin-left: 50px;
    }
    .count_timer{
        margin-top: 10px !important;
    }

    .mobileViewPur{
        padding:0px !important; 
        height: 100%;
    }

    .portLogo{
        color: #000000;
        margin-bottom: 1rem;
        font-size: 10px;
        font-weight:10;
    }
    .back_to_login{
        display: inline-block;
        text-align: right;
        padding: 30px 0 0 0;
        width:100%;

    }
    #close_forget{
        background:#E82B27 !important;
        border-color: #E82B27 !important;
        margin-top: 20px;
        width: 150px;
    }

    #confirmPass {
        margin-top: 10px;
    }
    .container{width: 100%;

               height: 100%;}
    .LogForm{
        width:50%;
    }
    
    
    .lfsign{
        width:40px;
        margin-top:-20px;
    }
    .footerLogo{
        width:26px;
    }
    .fsection{
        margin-top: 5px; color: gray;text-align: left;
    }
    @-moz-document url-prefix() {
      .lsign{
        width: 50px;
        margin-top: 0px !important; 
      }
    }
    @media screen and (-webkit-min-device-pixel-ratio:0){
  .lsign{
      margin-top: -15px;
      width: 50px;
       }  
      }
      
   
    @media (min-width: 1300px){
        .LogoImage {
            background-color: #f7f7f7;
            height: auto;
            max-width: 80%;
            margin: 0px auto;
        }
        .mLogo{
            height:auto;
            width: 60%;
        }
    }
    @media (min-width: 1400px){
        .LogoImage {
            background-color: #f7f7f7;
            height: auto;
            max-width: 80%;
            margin: 80px auto;
        }
        .fixedfooter {
            position: fixed;
            bottom: 90px;
            right: 0;
        }
    }

    @media (min-width: 1850px){
        .LogoImage {
            background-color: #f7f7f7;
            height: auto;
            max-width: 80%;
            margin: 60px auto;
        }
    }
    @media (min-width: 1450px) and (max-width: 1600px){
        .container {
            padding:30px 20px 30px;
        }
    }
    @media (min-width: 1900px){
        .container {
            max-width: 1700px;
        }

        .mLogo{
            height:auto;
            width: 50%;
        }

        .lumut,.lumut_fpass {
            font-size: 60px;

        }

        .input_user
        {

            height: 70px;
            margin-top: 4rem;
            font-size:1.5rem;
        }
        .input_pass{
            height: 70px;

            font-size:1.5rem;
        }
        .login_btn {
            height: 60px;
        }
        .login_btn button.btn {
            font-size: 1.5rem;
            line-height:1.75;
        }
        .link{
            font-size: 1.5rem;
            line-height:2;
        }
        .fixedfooter {
            position: fixed;
            bottom: 65px;
            right: 0;
        }

        .login-text{
            font-family: 'northern army Regular';
            font-size: 70px;
        }

        .flogin-text{
            font-family: 'northern army Regular';
            font-size: 70px;
            font-weight: 100;
        }
        .lsign{
            width:80px;
        }

    }

    @media (min-width: 2500px){

        /*        .mLogo{
                    height:360px;
                    width: auto;
                }*/

        .login-text{
            font-family: 'northern army Regular';
            font-size: 70px;
        }
        .vl {
            border-left: 2px solid #ccc;
            height:auto;
        }
        .flogin-text{
            font-family: 'northern army Regular';
            font-size: 70px;
            font-weight: 100;
        }
        .lsign{
            width:60px;
        }
        .lumut,.lumut_fpass {
            font-size: 60px;

        }

        .input_user
        {

            height: 70px;
            margin-top: 4rem;
            font-size:1.5rem;
        }
        .input_pass{
            height: 70px;
            font-size:1.5rem;
            margin-top:2rem;
            margin-bottom:2rem;
        }
        .login_btn {
            height: 60px;
        }
        .login_btn button.btn {
            font-size: 1.5rem;
            line-height:1.75;
        }
        .link{
            font-size: 1.5rem;
            line-height:2;
        }
        .footerLogo{
            width:64px;
        }
        .fsection{
            margin-bottom:5rem;
        }
    }

    @media (min-width: 1000px) and (max-width: 1100px){
        .LogoImage {

            margin: 90px 40px;
        }
        .fixedfooter {
            position: fixed;
            bottom: 90px;
            right: 0;
        }
    }

    @media (min-width: 760px) and (max-width: 900px){
        .LogoImage {
            margin: 90px 40px;
        }
        .LogForm{
            width:65%;
        }
        .footerLogo{
            width:50px;
        }
        .mLogo{
            height:auto;
            width: 100%;
        }
        .flogin-text {
            font-family: 'northern army Regular';
            font-size: 30px;
            font-weight: 100;
        }
        .fixedfooter{
            display:none;
        }
    }

    @media only screen and (max-width: 600px) {
        .LogForm{
            width:85%;
        }
        .LogoImage {
            margin: 20px;
            min-height: 600px;
        }
        .link{
            font-size: 1rem;

        }
        .fsection{
            margin-bottom: 10px;
        }
        .fgetuser{
            width:85%;
        }
        .mLogo{
            height:auto;
            width: 100%;
        }
        .login-text {
            font-family: 'northern army Regular';
            font-size: 50px;
        }
        .lsign {
            width: 40px;
        }
        flogin-text {
            font-family: 'northern army Regular';
            font-size: 34px;
            font-weight: 100;
        }
        .fixedfooter {
            position: fixed;
            bottom: 40px;
            right: 0;
        }
    }


</style>
<div class ="container-fluid centered">

    <div class=" LogoImage row">
        <div class="col-md-5 d-none d-md-block d-lg-block d-xl-block" style="padding:0px !important;">
            <img class="mobileViewPur" src="<?php echo BASE_URL . 'assets/images/login-page-2.jpg'; ?>" width="100%" alt="sideImg">
        </div>
        <div class="col-md-7" style="text-align: center;color: black;">

            <div class="row" >

                <div class="col-md-12 " >

                    <div class=" logheading">
                        <span  class="login-text login-sign"> <span >LOGIN </span> <span class="vl "></span> <img  src="<?php echo BASE_URL . 'assets/images/slider/small_logo.png'; ?>" class="lsign "  alt="main"> </span>



                        <span class='lumut_fpass forgetPasswordDet d-none'>  
                            <span class="forget-text">FORGOT PASSWORD </span> 

                        </span>
                    </div>


                    <?php
                    $message = $this->session->flashdata('Messges');
                    if (!empty($message)) {
                        ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" >
                            <center><b> <?php echo $message; ?></b></center>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>
                    <?php
                    $message = $this->session->flashdata('Messges');
                    if (!empty($message)) {
                        ?>
                        <div class="alert alert-success  d-none" role="alert" >
                            <center><b> <?php echo $message; ?></b></center>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>
                </div> 

            </div>
            <div class="row" >

                <div class="col-md-12 " >
                    <div class="d-flex justify-content-center" style="color: white;">

                        <div class="LogForm">
                            <?php echo form_open('loginSubmit'); ?>   

                            <div class="row mb-4">

                                <div class="col-sm-12">
                                    <input type="text" name="username" id="username" class="form-control input_user" value="" placeholder="Username" maxlength="40">
                                </div>
                            </div>
                            <div class="row mb-4">

                                <div class="col-sm-12 ">
                                    <input type="password" name="password" id="password" class="form-control input_pass" value="" placeholder="Password" maxlength="40">
                                </div>
                            </div>
                            <div class="row  mb-2">
                                <div class="col-sm-6">
                                    <div class="fsection" >
                                        <a href="javascript:void(0)" id="forget" class="link">Forgot Password</a>
                                    </div>
                                </div>
                                <div class="col-sm-6 "> 
                                    <button type="submit"  class="btn btn-primary btn-lg btn-block lg-btn">Enter</button>
                                </div>

                            </div>



                            </form>



                        </div>


                    </div>

                    <div class = "forgetPasswordDet d-none">

                        <div class="alert_for_forget_password d-none" style="display:none;">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <span aria-hidden="true">&times;</span>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-8 fgetuser">
                                <input type="text" name="forgetUser" id="forgetUser" class="form-control forgetUser" value="" placeholder="Enter Your Username" maxlength="40">

                                <div id="count_timer" class="count_timer" style="display:none;">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                    <span aria-hidden="true">&times;</span>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                       
                                        <input type="button" class="btn btn-primary btn-lg  lg-btn"  id="save_f" value="Continue">
                                        <button type="submit" id="close_forget" class="btn btn-primary btn-lg  lg-btn">Cancel</button>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>


                </div>        

            </div>
            <hr class="lineBreak">
            <div style="clear:both"></div>
            <div class=" col-sm-4  fixedfooter"  >
                <img class="footerLumutLogo" src="<?php echo BASE_URL . 'assets/images/modules/company_logo/LOGO-LUMUT-PORTju.png'; ?>"  alt="mylogo">
                <img class="footerLogo" src="<?php echo BASE_URL . 'assets/images/slider/neo-ehs-tie-logo.png'; ?>"  alt="mylogo">
            </div>




        </div> 
    </div>    


</div>

<script src="<?php echo BASE_URL; ?>assets/plugins/jquery/jquery.min.js"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>-->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script>

       $(document).ready(function(){

                 var $_GET = get_query();

       });


        function get_query(){

               var url_string = window.location.href;
                  var url = new URL(url_string);
                  var qs = url.substring(url.indexOf('?') + 1).split('&');

                  for(var i = 0, result = {}; i < qs.length; i++){
                       qs[i] = qs[i].split('=');            
                       result[qs[i][0]] = decodeURIComponent(qs[i][1]);                                 

                  }

                  var myJSON = JSON.stringify(result);
                  var object = JSON.parse(myJSON);
                  $("#username").val(atob(object.username));
                  $("#password").val(atob(object.password));

            }

</script>

<script type="text/javascript">
//    function setSizes() {
//   var containerHeight = $(".mobileViewPur").height();
//   $(".LogoImage").height(containerHeight - 40);
//}
//$(window).resize(function() { setSizes(); });
    $(document).ready(function () {
//    setSizes();

	var userNm = '<?php echo $getDecuname; ?>'
	var userpass = '<?php echo $getDecPass; ?>'
                
                $("#username").val(userNm);
                $("#password").val(userpass);

        $('.LogForm').show();

        $(document).on('click', '#forget', function () {
            $('.forgetPasswordDet').removeClass('d-none');
            $('.LogForm').hide();
            $('.login-sign').hide();
            $('.alert-dismissible').hide();

        });


        $(document).on('click', '#save_f', function () {
            $('#save_f').prop('disabled', true);
            var forgetUser = $('#forgetUser').val();


//      if(forgetUser != ""){
            var url = "<?php echo BASE_URL() . "login/forgetPassword" ?>";
            var data = {forgetUser: forgetUser, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'};

            $.ajax({
                type: 'post',
                url: url,
                data: data,
                cache: false,
                success: function (data) {
                    if (data != 0) {
                        $("#count_timer").show();
                        $("#count_timer").html(data);
                        $('#save_f').prop('disabled', false);

                    }

                }

            });

//      }

//      else{
//         $("#save_f").show();
//        $('.alert-dismissible').hide();
//        $(".alert_for_forget_password").show();
//               $(".alert_for_forget_password").html('<div class="alert alert-danger"><button class="close"data-close="alert" data-dismiss="alert" aria-label="Close"></button><span>Please enter the valid Username or Email Id</span></div>');
//         }


        });


        $(document).on('click', '#close_forget', function ()
        {
            $('.forgetPasswordDet').addClass('d-none');
            $('#forgetUser').val('');
            $('.LogForm').show();
            $('.login-sign').show();
            location.reload();

        });
        $(document).on('click', '.close', function () {
            $(".alert_for_forget_password").addClass('d-none');
            $(".alert_for_forget_password").hide();
            $(".alert-dismissible").addClass('d-none');
            $('.alert-dismissible').hide();
            $("#count_timer").hide();
            $('.alert-danger').addClass('d-none');
            $('.alert-danger').hide();
            $('.alert-success').hide();
            $('.close').addClass('d-none');

        })



    });








</script>

