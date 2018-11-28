    <!-- Landing Page Contents
    ================================================= -->
    <div id="lp-register">
        <div class="container wrapper">
        <div class="row">
            <div class="col-sm-5">
            <div class="intro-texts">
                <h1 class="text-white">Make Cool Friends !!!</h1>
                <p>Friend Finder is a social network template that can be used to connect people. The template offers Landing pages, News Feed, Image/Video Feed, Chat Box, Timeline and lot more. <br /> <br />Why are you waiting for? Buy it now.</p>
              <button class="btn btn-primary">Learn More</button>
            </div>
          </div>
            <div class="col-sm-6 col-sm-offset-1">
            <div class="reg-form-container"> 

              <?php echo $this->session->flashdata('msg') ?>
            
              <!-- Register/Login Tabs-->
              <div class="reg-options">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#register" data-toggle="tab">Register</a></li>
                  <li><a href="#login" data-toggle="tab">Login</a></li>
                </ul><!--Tabs End-->
              </div>
              
              <!--Registration Form Contents-->
              <div class="tab-content">
                <div class="tab-pane active" id="register">
                  <h3>Register Now !!!</h3>
                  <p class="text-muted"> </p>
                  
                  <!--Register Form-->
                 <form name="registration_form" id='registration_form' class="form-inline" action="<?php echo base_url(); ?>account/register" method="post" enctype="multipart/form-data">
                    <div class="row">
                      <div class="form-group col-xs-6">
                        <label for="firstname" class="sr-only">First Name</label>
                        <span class="text-danger"><?php echo form_error('fname'); ?></span>
                        <input id="firstname" class="form-control input-group-lg" type="text" name="fname" title="Enter first name" placeholder="First name" required="" />
                      </div>
                      <div class="form-group col-xs-6">
                        <label for="lastname" class="sr-only">Last Name</label>
                        <span class="text-danger"><?php echo form_error('lname'); ?></span>
                        <input id="lastname" class="form-control input-group-lg" type="text" name="lname" title="Enter last name" placeholder="Last name" required="" />
                      </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="email" class="sr-only">Username</label>
                        <span class="text-danger"><?php echo form_error('username'); ?></span>
                        <input id="email" class="form-control input-group-lg" type="text" name="username" title="Username" placeholder="Username" value="<?php echo set_value('username'); ?>" required="" />
                      </div>
                    </div>


                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="email" class="sr-only">Email</label>
                        <span class="text-danger"><?php echo form_error('email'); ?></span>
                        <input id="email" class="form-control input-group-lg" type="email" name="email" title="Enter Email" placeholder="Your Email" value="<?php echo set_value('email'); ?>" required="" />
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-6">
                        <label for="password" class="sr-only">Password</label>
                        <span class="text-danger"><?php echo form_error('password'); ?></span>
                        <input id="password" class="form-control input-group-lg" type="password" name="password" title="Enter password" placeholder="Password" value="<?php echo set_value('password'); ?>" required="" />
                      </div>
                   
                      <div class="form-group col-xs-6">
                        <label for="confirm_password" class="sr-only">Confirm Password</label>
                        <span class="text-danger"><?php echo form_error('confirm_password'); ?></span>
                        <input id="confirm_password" class="form-control input-group-lg" type="password" name="confirm_password" title="Confirm password" placeholder="Confirm Password" value="<?php echo set_value('confirm_password'); ?>" required="" />
                      </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="email" class="sr-only">Phone </label>
                        <span class="text-danger"><?php echo form_error('phone'); ?></span>
                        <input id="email" class="form-control input-group-lg" type="text" name="phone" title="Phone Number" placeholder="Phone Number" value="<?php echo set_value('phone'); ?>" required="" />
                      </div>
                    </div>

                    <div class="form-group gender">
                      <label class="radio-inline">
                        <input type="radio" name="sex" value="Male" required="">Male
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="sex" value="Female">Female
                      </label>
                    </div>
                    <div class="row">
                     
                     <!--Register Now Form Ends-->
                  <p><a href="#login">Already have an account?</a></p>
                  <button class="btn btn-primary">Register Now</button>
                </div><!--Registration Form Contents Ends-->
                
                 </form>
             </div>
     <!--Login-->
                <div class="tab-pane" id="login">
                  <h3>Login</h3>
                  <p class="text-muted">Log into your account</p>
                  
                  <!--Login Form-->
                  <form name="Login_form" id='Login_form' action="<?php echo base_url(); ?>account/login" method="post" enctype="multipart/form-data">
                     <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="email" class="sr-only">Email</label>
                        <span class="text-danger"><?php echo form_error('email'); ?></span>
                        <input id="email" class="form-control input-group-lg" type="email" name="email" title="Enter Email" placeholder="Your Email" value="<?php echo set_value('email'); ?>" required="" />
                      </div>
                    </div>
                    <div class="row">
                       <div class="form-group col-xs-12">
                        <label for="password" class="sr-only">Password</label>
                        <span class="text-danger"><?php echo form_error('password'); ?></span>
                        <input id="password" class="form-control input-group-lg" type="password" name="password" title="Enter password" placeholder="Password" value="<?php echo set_value('password'); ?>" required="" />
                      </div>
                    </div>
                  
                  <p><a href="#">Forgot Password?</a></p>
                  <button class="btn btn-primary">Login Now</button>

                  </form><!--Login Form Ends--> 

                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 col-sm-offset-6">
          
            <!--Social Icons-->
            <ul class="list-inline social-icons">
              <li><a href="#"><i class="icon ion-social-facebook"></i></a></li>
              <li><a href="#"><i class="icon ion-social-twitter"></i></a></li>
              <li><a href="#"><i class="icon ion-social-googleplus"></i></a></li>
              <li><a href="#"><i class="icon ion-social-pinterest"></i></a></li>
              <li><a href="#"><i class="icon ion-social-linkedin"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

 <!--preloader-->
    <div id="spinner-wrapper">
      <div class="spinner"></div>
    </div>

    <!-- Scripts
    ================================================= -->
    <script src="<?php echo base_url() ?>assets/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery.appear.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery.incremental-counter.js"></script>
    <script src="<?php echo base_url() ?>assets/js/script.js"></script>
    
  </body>
</html>
