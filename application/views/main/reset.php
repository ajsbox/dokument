<div class="span4 offset3">
<h3>Password Reset:</h3>
<?php if($error == '1') { ?>
<div class="alert alert-error"><strong>Error!</strong> <?=$this->lang->line("there");?></div>
<?php } else { ?>
<div class="alert alert-success"><strong>Success!</strong> <?=$this->lang-line("yn");?></div>
<?php } ?>
</div>