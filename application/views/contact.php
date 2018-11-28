<!--page title start-->
        <section class="page-title ptb-70">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-bold">Contact Us</h2>
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url(); ?>">Home</a></li>
                            <li class="active">Contact Us</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <!--page title end-->

        <!-- contact-form-section -->
        <section class="section-padding">
          
          <div class="container">

              <div class="text-center mb-80">
                  <h2 class="section-title text-uppercase">Contact Us</h2>
                  <p class="section-sub">If you have questions, comments, suggestion or interest in a type of service not listed here, contact our support team, we look forward to providing you additional information and discussing new and exciting services to meet your needs.</p>
<p><strong>Phone General Inquiries: 08077747917</strong></p>
              </div>

            <div class="row">
                <div class="col-md-8">
                <?php echo  $this->session->flashdata('msg'); ?>
                
                    <form name="contact-form" action="<?php echo base_url(); ?>page/contact" method="POST" enctype="multipart/form-data">

                      <div class="row">
                        <div class="col-md-6">
                          <div class="input-field">
                            <input type="text" name="name" class="validate" id="name" required>
                            <label for="name">Name</label>
                          </div>

                        </div><!-- /.col-md-6 -->

                        <div class="col-md-6">
                          <div class="input-field">
                            <label class="sr-only" for="email">Email</label>
                            <input id="email" type="email" name="email" class="validate" required >
                            <label for="email" data-error="wrong" data-success="right">Email</label>
                          </div>
                        </div><!-- /.col-md-6 -->
                      </div><!-- /.row -->

                      <div class="row">
                        <div class="col-md-6">
                          <div class="input-field">
                            <input id="phone" type="tel" name="phone" class="validate" required >
                            <label for="phone">Phone Number</label>
                          </div>
                        </div><!-- /.col-md-6 -->

                        <div class="col-md-6">
                          <div class="input-field">
                            <input id="subject" type="text" name="subject" class="validate" >
                            <label for="subject">Subject</label>
                          </div>
                        </div><!-- /.col-md-6 -->
                      </div><!-- /.row -->

                      <div class="input-field">
                        <textarea name="message" id="message" class="materialize-textarea" required ></textarea>
                        <label for="message">Message</label>
                      </div>
                    
                      <button type="submit" name="submit" class="waves-effect waves-light btn submit-button text-capitalize mt-30">Send Message</button>
                    </form>
                </div><!-- /.col-md-8 -->

                <div class="col-md-4 contact-info">

                    <address>
                      <i class="material-icons brand-color">&#xE55F;</i>
                      <div class="address">
                        House 15a City Layout <br>
                        New Haven Enugu. Nigeria

                        <hr>

                    
                      </div>

                      <i class="material-icons brand-color">&#xE61C;</i>
                      <div class="phone">
                        <p>Phone: (234) 703 152 5786<br>
                        Phone: (234) 807 774 7917</p>
                      </div>

                      <i class="material-icons brand-color">&#xE0E1;</i>
                      <div class="mail">
                        <p><a href="mailto:contact@noblecontracts.com">contact@noblecontracts.com</a><br>
                        <a href="<?php echo base_url(); ?>">www.noblecontracts.com</a></p>
                      </div>
                    </address>

                </div><!-- /.col-md-4 -->
            </div><!-- /.row -->
          </div>
        </section>
        <!-- contact-form-section End -->