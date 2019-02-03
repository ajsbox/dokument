<div class="hero-unit">
	<h1><?=$this->lang->line("welcome");?></h1>
	<p><?=$this->lang->line("uts");?></p>
	<p><?=$this->lang->line("you");?> <?php echo $this->auth->user_type(); ?></p>
	<p><?php echo $this->input->cookie('user_login_cookie'); ?></p>
</div>