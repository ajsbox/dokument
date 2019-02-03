<?php if($this->logik->get_level()==3){?>
<div class="admin-form">
  <div class="container-fluid">

    <div class="row-fluid">
      <div class="span12">
        <!-- Widget starts -->
            <div class="widget">
              <!-- Widget head -->
              <div class="widget-head">
                <i class="icon-lock"></i> Inicio de Sesion 
              </div>

              <div class="widget-content">
                <div class="padd">
                  <!-- Login form -->
                    
                  <form class="form-horizontal" method="post" action="<?=$this->logik->setting("default_url");?>login">
                    <!-- Email -->
                    <div class="control-group">
                      <label class="control-label" for="inputEmail">Usuario</label>
                      <div class="controls">
                        <input type="text" id="inputEmail"  name="username">
                      </div>
                    </div>
                    <!-- Password -->
                    <div class="control-group">
                      <label class="control-label" for="inputPassword">Contraseña</label>
                      <div class="controls">
                        <input type="password" id="inputPassword"  name="password">
                      </div>
                    </div>
                    <!-- Remember me checkbox and sign in button -->
                    <div class="control-group">
                      <div class="controls">
                        <label class="checkbox">
                          <input type="checkbox"> Recordarme
                        </label>
                        <br>
                        <input type="submit" class="btn" name="login" value="Login">
                        <input type="reset" class="btn" value="Restablecer">
                      </div>
                    </div>
                  </form>

                </div>
                <div class="widget-foot">
                  <!-- Footer goes here -->
                </div>
              </div>
            </div>  
      </div>
    </div>
  </div> 
</div>
<?php } else {
	if($this->logik->get_level()==1) $page_get="admin/userDocuments"; else $page_get="user/my_documents";
	  ?>
<script type="text/javascript">

window.location.href="<?=$this->logik->setting("default_url")?><?=$page_get?>";
</script>
<?php } ?>
	
