<div class="span4 offset4">
<?php if($error == '1'){ ?>
<div class="alert alert-error"><strong>Error!</strong> <?=$this->lang->line("wc");?></div>
<?php } else { ?>
<div class="alert alert-success"><strong>Success!</strong> <?=$this->lang->line("ya");?></div>
<?php } ?>
</div>