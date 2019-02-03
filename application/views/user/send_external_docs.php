 
<div class="row-fluid" style="background-color:#FFFFFF;">
	<div class="span9">
		<div id="tableMessage"></div>
      &nbsp;<b><?php echo $this->lang->line("send_users")?>:-</b><br>
 <div style="margin:0px 0px 0px 0px; width:28%;">

				<select name="users[]" id="users" multiple style="width:200px;">
               <?php
			   	foreach($Exusers as $user1) {?>
					<option value="<?=$user1['email']?>"><?=ucfirst($user1['name'])?></option>
				<?php }?>
               </select>
          	
                <br><div id="valid_user" style="display:none;color:#FF0000;"><strong>Error ! </strong> <?=$this->lang->line("doc_user_req")?></div>
          	<input type="checkbox" id="selAll">&nbsp;&nbsp;<?=$this->lang->line("select_all")?><br /><br />
			<div style="text-align:right;">
			<input type="hidden" name="id" value="<?=$this->uri->segment(4)?>" id="document_id">
			<input type="hidden" name="table" value="<?=$this->uri->segment(3)?>" id="table">
			<!--<input type="hidden" value="Enviar" name="sendEx" class="btn">-->
			<input type="submit" value="<?=$this->lang->line("document_send")?>" name="sendEx" class="btn" id="sentBtnEt" style="height:31px; width:66px;" onclick="return verifyToSentExDoc();">
			<!--<input type="submit" value="Cancel" name="cancel" class="btn">-->
         
			</div>
 
            <br />  

 		</div>
 </div>
  </div> 
