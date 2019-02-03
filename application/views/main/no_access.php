<div class="row-fluid" style="margin-bottom:300px;">
	<div class="span6 offset3" style="text-align: center;">
		<h1><?=$this->lang->line('access_not_allow');?></h1>
		<p class="lead"><?=$this->lang->line('access_denied');?></p>
		<a href="<?php echo $this->logik->setting('default_url'); ?>" class="btn btn-large btn-primary"><?=$this->lang->line('access_thanks');?></a>
	</div>
</div>