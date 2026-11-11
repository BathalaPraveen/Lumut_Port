<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
  body,
  html {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: 'Segoe UI', sans-serif;
    overflow: hidden;
  }

  /* Video Background with reduced opacity */
  .video-background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -2;
    overflow: hidden;
    opacity: 0.5; /* Adjust opacity here (0.0 to 1.0) */
  }

  .video-iframe {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100vw;
    height: 56.25vw;
    min-height: 100vh;
    min-width: 177.77vh;
    transform: translate(-50%, -50%);
  }

  /* Dark overlay for better readability */
  .video-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6); /* Adjust darkness here */
    z-index: -1;
  }

  .login-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
  }

  .login-container {
    width: 100%;
    max-width: 400px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.5);
    text-align: center;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(5px);
    border: 1px solid rgba(255, 255, 255, 0.1);
  }

  /* Logo container with curved bottom */
  .logo-container {
    background-color: #ffffff;
    border-radius: 10px 10px 35px 35px;
    overflow: hidden;
    position: relative;
    z-index: 2;
    margin-bottom: -20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  }

  .logo-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 30px 25px 30px;
  }

  .left-logo {
    height: 60px;
    width: 250px;
    object-fit: contain;
  }

  .right-logo {
    height: 60px;
    width: auto;
    object-fit: contain;
  }

  /* Form section with background image */
  .dark-bg {
    background: url('<?php echo BASE_URL . "assets/images/black.jpg"; ?>') no-repeat center center;
    background-size: cover;
    width: 100%;
    border-radius: 0 0 10px 10px;
    padding: 30px 0;
    position: relative;
    overflow: hidden;
  }

  .dark-bg::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    z-index: 0;
  }

  .login-title,
  .forget-title {
    font-size: 22px;
    font-weight: bold;
    color: #daf542;
    margin-bottom: 25px;
    padding: 0 30px;
    position: relative;
    z-index: 1;
    text-transform: uppercase;
  }

  .form-group {
    position: relative;
    margin-bottom: 20px;
    width: 100%;
    padding: 0 30px;
    z-index: 1;
  }

  .form-control {
    width: 100%;
    padding: 10px 15px 10px 40px;
    font-size: 14px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 5px;
    background: rgba(51, 51, 51, 0.8);
    color: #fff;
    box-sizing: border-box;
    height: 40px;
    backdrop-filter: blur(5px);
    transition: all 0.3s ease;
  }

  .form-control:focus {
    border-color: #ffae42;
    outline: none;
    box-shadow: 0 0 0 2px rgba(255, 174, 66, 0.3);
  }

  .input-icon {
    position: absolute;
    left: 45px;
    top: 50%;
    transform: translateY(-50%);
    color: #fff;
    font-size: 14px;
    z-index: 2;
  }

  .login-btn {
    padding: 10px 20px;
    background-color: white;
    color: #333;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s ease;
  }

  .login-btn:hover {
    background-color: #f0f0f0;
    transform: translateY(-2px);
  }

  .forgot-link-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 30px;
    margin-top: 20px;
    position: relative;
    z-index: 1;
  }

  .forgot-link {
    font-size: 14px;
    color: #aaa;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .forgot-link:hover {
    color: #daf542;
    text-decoration: underline;
  }

  .alert-message {
    color: #ff6b6b;
    font-size: 14px;
    margin-bottom: 15px;
    padding: 0 30px;
    position: relative;
    z-index: 1;
  }

  /* Forgot Password Styles */
  .forgetPasswordDet {
    /* display: none; */
    padding: 0 30px 20px;
    position: relative;
    z-index: 1;
  }

  .forget-subtitle {
    font-size: 16px;
    color: #fff;
    margin-bottom: 25px;
    text-align: center;
    position: relative;
    z-index: 1;
  }

  .action-buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 25px;
  }

  .action-btn {
    width: 120px;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    font-weight: bold;
    transition: all 0.3s ease;
  }

  .continue-btn {
    background-color: white;
    color: #333;
  }

  .continue-btn:hover {
    background-color: #f0f0f0;
    transform: translateY(-2px);
  }

  .cancel-btn {
    background-color: transparent;
    color: white;
    border: 1px solid #fff;
  }

  .cancel-btn:hover {
    background-color: rgba(255, 255, 255, 0.1);
    transform: translateY(-2px);
  }

  .count_timer {
    display: none;
    color: #fff;
    text-align: center;
    margin: 15px 0;
    font-size: 14px;
    padding: 0 30px;
    position: relative;
    z-index: 1;
  }

  /* Responsive adjustments */
  @media (max-width: 480px) {
    .login-container {
      max-width: 90%;
    }

    .login-title,
    .forget-title {
      font-size: 20px;
    }

    .form-control {
      padding: 8px 15px 8px 35px;
      font-size: 13px;
      height: 36px;
    }

    .input-icon {
      left: 35px;
    }

    .action-buttons {
      flex-direction: column;
      gap: 10px;
    }

    .action-btn {
      width: 100%;
    }

    .left-logo {
      height: 50px;
      width: 200px;
    }

    .right-logo {
      height: 40px;
    }
  }
</style>

<!-- Video Background -->
<div class="video-background">
  <div class="video-iframe">
    <video autoplay muted loop playsinline style="width:100%;height:100%;object-fit:cover;">
      <source src="<?php echo BASE_URL . 'assets/videos/videoplayback.mp4'; ?>" type="video/mp4">
      Your browser does not support the video tag.
    </video>
      <div class="video-tint-overlay"></div>
  </div>
</div>

<!-- Dark overlay -->
<div class="video-overlay"></div>

<div class="login-wrapper">
  <div class="login-container">
    <!-- Logo Section with curved bottom -->
    <div class="logo-container">
      <div class="logo-section">
        <img src="<?php echo BASE_URL . 'assets/images/modules/company_logo/LOGO-LUMUT-PORTju.png'; ?>"
          alt="Lumut Port Logo" class="left-logo"/>
        <img src="<?php echo BASE_URL . 'assets/images/slider/small_logo.png'; ?>"
          alt="Small Logo" class="right-logo"/>
      </div>
    </div>

    <!-- Forgot Password Form -->
    <div class="dark-bg">
      <div id="forgetPasswordDet" class="forgetPasswordDet">
        <div class="forget-title">RESET PASSWORD</div>
        
        <?php $message = $this->session->flashdata('Messges'); ?>
        <?php if (!empty($message)) {
          echo '<div class="alert-message">' . $message . '</div>';
        } ?>
        
        <div class="form-group">
          <i class="fas fa-key input-icon"></i>
          <input type="text" name="encryptMsg" id="encryptMsg" class="form-control" placeholder="Enter Your Encrypt Password">
        </div>
        
        <div id="count_timer" class="count_timer" style="display:none;"></div>
        
        <div class="action-buttons">
          <button type="button" id="save_f" class="action-btn continue-btn">Continue</button>
          <button type="button" id="close_forget" class="action-btn cancel-btn">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo BASE_URL; ?>assets/plugins/jquery/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    // Handle forgot password submission
    $(document).on('click','#save_f',function(){
      // alert("sjsjs");
      var $btn = $(this);
      $btn.prop('disabled', true);
      var encryptMsg = $('#encryptMsg').val().trim();
      var passwordDet = $('#passwordDet').val();
      var confirmPass = $('#confirmPass').val();

      if (!encryptMsg) {
        alert('Please enter your encrypted password');
        $btn.prop('disabled', false);
        return;
      }

      $.ajax({
        type: 'POST',
        url: "<?php echo BASE_URL . 'login/forgetPasswordProcess'; ?>",
        data: {
          encryptMsg: encryptMsg,
          passwordDet:passwordDet,
          confirmPass:confirmPass,
          '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        },
        success: function(response) {
          if (response) {
            $('#count_timer').show().html(response);
          } else {
            alert('An error occurred. Please try again.');
          }
          $btn.prop('disabled', false);
        },
        error: function() {
          alert('Failed to process your request. Please try again.');
          $btn.prop('disabled', false);
        }
      });
    });

    $('#close_forget').click(function() {
      window.location.href = "<?php echo BASE_URL . 'login'; ?>";
    });
  });
</script>