<div class="span2" style="padding-top:21px;">
		<ul class="nav nav-tabs nav-stacked">
		
			<li><a class="btn-nav" href="<?php echo $this->logik->setting('default_url'); ?>user/home"><i class="icon icon-home icon-white"></i> <?=$this->lang->line("home");?> <i class="icon icon-white pull-right"></i></a></li>
            <li><a class="btn-nav" href="<?php echo $this->logik->setting('default_url'); ?>user/settings"><i class="icon icon-wrench icon-white"></i> <?=$this->lang->line("settings");?> <i class="icon  icon-white pull-right"></i></a></li>
            <?php $isValid = $this->user_model->checkValidRoles('Cargar');
			if($isValid) {?>
            <li><a class="btn-nav" href="<?php echo $this->logik->setting('default_url'); ?>user/documents"><i class="icon icon-file icon-white"></i> <?=$this->lang->line("documents_menu");?> <i class="icon icon-white pull-right"></i></a></li>
            <?php }?>
			<!--
			<?php //$isValid = $this->user_model->checkValidRoles('Estadisticas');
			//if($isValid) {?>
            <li><a class="btn-nav" href="<?php //echo $this->logik->setting('default_url'); ?>user/statistics"><i class="icon icon-book icon-white"></i> <?=$this->lang->line("menu_statistics");?> <i class="icon icon-white pull-right"></i></a></li>
            <?php //}?>
			
			<?php //$isValid = $this->user_model->checkValidRoles('Graficos');
			//if($isValid) {?>
            <li><a class="btn-nav" href="<?php //echo $this->logik->setting('default_url'); ?>user/graph"><i class="icon icon-book icon-white"></i> <?=$this->lang->line("menu_graph")?><i class="icon  icon-white pull-right"></i></a></li>
            <?php //}?>
			
			<?php //$isValid = $this->user_model->checkValidRoles('Historial');
			//if($isValid) {?>
            <li><a class="btn-nav" href="<?php //echo $this->logik->setting('default_url'); ?>user/log"><i class="icon icon-book icon-white"></i> <?=$this->lang->line("menu_log")?><i class="icon  icon-white pull-right"></i></a></li>
            <?php //}?>
			-->
            <!--<li><a class="btn-nav" href="<?php //echo $this->logik->setting('default_url'); ?>user/my_documents"><i class="icon icon-question-sign icon-white">
            </i> Mi Cargar Documento <i class="icon icon-white pull-right"></i></a></li>-->
			<?php if($this->logik->module('support') == '1'): ?>
			<li><a class="btn-nav" href="<?php echo $this->logik->setting('default_url'); ?>support/view"><i class="icon icon-question-sign icon-white"></i> <?=$this->lang->line("my_suport_tickets");?> <i class="icon icon-white pull-right"></i></a></li>
			<?php endif; ?>
		</ul>
</div>