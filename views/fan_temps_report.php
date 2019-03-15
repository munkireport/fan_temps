<?php $this->view('partials/head', array(
	"scripts" => array(
		"clients/client_list.js"
	)
)); ?>

<div class="container">
    
  <div class="row">
    <?php $widget->view($this, 'fan_temps_cpu_hot'); ?>
    <?php $widget->view($this, 'fan_temps_gpu_overtemp'); ?>
    <?php $widget->view($this, 'fan_temps_odd_inserted'); ?>
  </div> <!-- /row -->
      
  <div class="row">
    <?php $widget->view($this, 'fan_temps_bad_fans'); ?>
    <?php $widget->view($this, 'fan_temps_fans_set'); ?>
  </div> <!-- /row -->
    
</div>  <!-- /container -->

<script src="<?php echo conf('subdirectory'); ?>assets/js/munkireport.autoupdate.js"></script>

<?php $this->view('partials/foot'); ?>
