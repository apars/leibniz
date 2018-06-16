<div class="container imageloc">
    <div class="row">
      <div class="col-md-12">
        <!--<img class="d-block img-responsive imagecenter w-100" src="<?php echo base_url().$this->config->item('main_back'); ?>" alt="Main_Back">-->
        <?php if(isset($active_surveys) && $active_surveys != null): ?>
          <div class="floatdiv" style="width: 95%;left: 2.5%; transform: translateY(5%)">
          <h2 class="introtext">The results of this survey will teach us insights on how we can serve you better. <br><br>
Yes, we realize how precious your time is. That's why we made sure this survey will
only take 30 seconds or less.<br><br>
(really, we timed it!)<br><br>
Rate us: 1 BAD to 5 BEST<br><br></h2>
          <div style="width: 30%;margin: 0 auto;">
            <?php foreach($active_surveys as $survey): ?>
<!--              <a href="<?php echo base_url() . "questions/" . $survey->slug; ?>" class="list-group-item" style="text-align: center">
                <?php echo $survey->title; ?>
                <span class="glyphicon glyphicon-chevron-right pull-center"></span>
              </a>-->
              
              <button id="demo" type="submit" class="btn btn-lg btn-success pull-center" 
                      onclick="redirectOnClick('<?php echo base_url() . "questions/" . $survey->slug; ?>')" 
                      style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 25px;">
                          Begin
              </button>
              
              
            <?php endforeach; ?>
          </div>
        <?php else: ?>
        <div class="alert alert-danger text-center" role="alert">
            <strong>
                ACHTUNG! <br>MAINTENANCE MODE<br>
            </strong>
              Proceed with extreme caution.
          </div>
              <div id="theloaddbbuttons">
                  <!--800x480 = 3vw 1280x800 = 5vw -->
                  <div><br><br></div>
                  <button type="button" class="btn btn-info btn-sm btn btn-lg btn-danger" data-toggle="modal" data-target="#loadDB" style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 25px;">Load Database...</button>
                  <div><br><br></div>
                  <button type="button" class="btn btn-info btn-sm btn btn-lg" onclick="redirectOnClick('<?php echo base_url(); ?>')" style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 25px;">Return</button>
                  <!-- Modal -->
                    <div id="loadDB" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                              <h4 class="modal-title">Load Database</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                          </div>
                          <div class="modal-body">
                            <p>Please insert USB stick and hit OK button.</p>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-default" onclick="redirect2importDB('<?php echo base_url().'importdb'; ?>')" data-dismiss="modal">OK</button>
                          </div>
                        </div>

                      </div>
                    </div>
              </div>
              <div class="loader" id="theloader" style="display: none"></div>
        <?php endif; ?>
          </div>
     </div>
    </div>
    
  </div>
