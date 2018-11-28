<script src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>  


                <div class="col-md-7">

  <?php echo $this->session->flashdata('msg')  ?>
            <!-- Post Create Box
            ================================================= -->

          <h4 class="grey"> <i class="ion-ios-information-outline icon-in-title"></i> Post New Article</h4>
            <div class="create-post">
                <div class="row">
                    <form class="contact-form" action="<?php echo base_url(); ?>doctor/post" method="post" enctype="multipart/form-data">
                    <div class="form-group col-xs-12">
                        <label for="email" class="sr-only">Post Title</label>
                        <span class="text-danger"><?php echo form_error('title'); ?></span>
                        <input id="email" class="form-control input-group-lg" type="text" name="title" title="Post Title" placeholder="Post Title" value="<?php echo set_value('title'); ?>" required="" />
                      </div> <br>
                      <div class="small-space"></div>
                   
                     <div class="form-group col-xs-12">
                      <span class="text-danger"><?php echo form_error('body'); ?></span>
                      <textarea id="form-message" name="body" class="form-control" placeholder="Content *" rows="4" required="required" ><?php echo set_value('body'); ?></textarea>
                      <script type="text/javascript">  
       CKEDITOR.replace( 'body' );  
    </script>  

                    </div>
                  
                     <div class="small-space"></div>

                  <button class="btn-primary">Publish</button>

              </form>
                </div>
            </div><!-- Post Create Box End-->

           
          </div>

      