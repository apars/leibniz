<div class="col-md-12">
  <audio autoplay>
    <source src="<?php echo base_url().$this->config->item('thanks_path'); ?>" type="audio/mpeg">
  </audio>
  <h2 class="introtext" style="text-align: center"><br>All Done! <br><br>
    Thank you for completing the survey.<br><br>
  </h2>
  <?php header("Refresh: 2; url=".base_url()); ?>
</div>
