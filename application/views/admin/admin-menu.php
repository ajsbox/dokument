<div class="span2">
		<ul class="nav nav-tabs nav-stacked">
			<li><a class="btn-nav" href="<?php echo $this->logik->setting('default_url'); ?>admin/userDocuments"><i class="icon icon-home icon-white"></i>    <?=$this->lang->line("ad1");?><i class="icon  icon-white pull-right"></i></a></li>

			<li><a class="btn-nav" href="<?php echo $this->logik->setting('default_url'); ?>admin/settings"><i class="icon icon-wrench icon-white"></i><?=$this->lang->line("menu_setting");?><i class="icon  icon-white pull-right"></i></a></li>
			
            <!-- dhiru 26-04-14 -->
            <li><a class="btn-nav" href="<?php echo $this->logik->setting('default_url'); ?>group/manage"><i class="icon icon-group icon-white"></i>   <?=$this->lang->line("mg1");?> <i class="icon  icon-white pull-right"></i></a></li>
           <!--<li><a class="btn-nav" href="<?php echo $this->logik->setting('default_url'); ?>roles/manage_roles"><i class="icon icon-book icon-white"></i>   <?=$this->lang->line("mr");?> <i class="icon  icon-white pull-right"></i></a></li>-->
            
            <li><a class="btn-nav" href="<?php echo $this->logik->setting('default_url'); ?>manage_users/manage_user"><i class="icon icon-user icon-white"></i>   <?=$this->lang->line("mu");?> <i class="icon  icon-white pull-right"></i></a></li>
            
             <li><a class="btn-nav" href="<?php echo $this->logik->setting('default_url'); ?>external_users/manage_users"><i class="icon icon-user icon-white"></i>  <?=$this->lang->line("external_user");?> <i class="icon  icon-white pull-right"></i></a></li>
            
            <li><a class="btn-nav" href="<?php echo $this->logik->setting('default_url'); ?>document/manage"><i class="icon icon-file icon-white"></i>    <?=$this->lang->line("md1");?><i class="icon  icon-white pull-right"></i></a></li>
			
			<li><a class="btn-nav" href="<?php echo $this->logik->setting('default_url'); ?>admin/statistics"><i class="icon icon-book icon-white"></i> <?=$this->lang->line("menu_statistics")?><i class="icon  icon-white pull-right"></i></a></li>
			
			<li><a class="btn-nav" href="<?php echo $this->logik->setting('default_url'); ?>admin/graph"><i class="icon icon-book icon-white"></i> <?=$this->lang->line("menu_graph")?><i class="icon  icon-white pull-right"></i></a></li>
			
			<li><a class="btn-nav" href="<?php echo $this->logik->setting('default_url'); ?>admin/log"><i class="icon icon-book icon-white"></i> <?=$this->lang->line("menu_log")?><i class="icon  icon-white pull-right"></i></a></li>
			
			<!--<li><a class="btn-nav" href="<?php echo $this->logik->setting('default_url'); ?>document/dbconnection"><i class="icon icon-book icon-white"></i>  DB Connection<i class="icon  icon-white pull-right"></i></a></li>-->
			<li><a class="btn-nav" href="<?php echo $this->logik->setting('default_url'); ?>document/ldap_auth"><i class="icon icon-book icon-white"></i>  <?=$this->lang->line("admin_menu_ldap_auth")?><i class="icon  icon-white pull-right"></i></a></li>
            <!-- end dhiru 26-04-14 -->
		
            <!--<li><a class="btn-nav" href="<?php //echo $this->logik->setting('default_url'); ?>admin/userDocuments"><i class="icon icon-user icon-white"></i>   Documentos <i class="icon  icon-white pull-right"></i></a></li>-->
            
			<!--<li><a class="btn-nav" href="<?php //echo $this->logik->setting('default_url'); ?>admin/email_users"><i class="icon icon-envelope icon-white"></i>   <?=$this->lang->line("eu");?> <i class="icon  icon-white pull-right"></i></a></li>
			<li><a class="btn-nav" href="<?php //echo $this->logik->setting('default_url'); ?>admin/email_templates"><i class="icon icon-briefcase icon-white"></i>   <?=$this->lang->line("et");?> <i class="icon  icon-white pull-right"></i></a></li>-->
		</ul>
</div>