<div class="row-fluid">
<?php $this->load->view('user/user_menu'); 
$this->load->view('jqueryform/Zebra_Form');?>
	<div class="span9">
		
          <div class="widget-content">

       <div class="matter">
        <div class="container-fluid">
          <div class="row-fluid">
            <div class="span12">


              <div class="widget">
                <div class="widget-head">
                  <div class="pull-left"> Documentos<small> for <?php echo $this->auth_model->get_user()->username; ?></small></div>
                  <div class="widget-icons pull-right">
                    <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
                    <a href="#" class="wclose"><i class="icon-remove"></i></a>
                  </div>  
                  <div class="clearfix"></div>
                </div>
                <div class="widget-content">
                  <div class="padd">
				
                 <!--   <h6>Input Boxs</h6>
                    <hr />-->
                    <!-- Form starts. Don't forget the class "uni" to add cool styles -->
                 <?php if(!empty($user_update)) { ?>
			<div class="alert alert-success user_update"><strong>Success!</strong> Your Profile has been updated !</div><?php } ?>
            <h1>Documents</h1><br />
	<form class="form-horizontal uni" action="<?php echo $this->logik->setting('default_url'); ?>user/show_table" method="post"  enctype="multipart/form-data">
                      
                  
  					
                     
                      
                    <div class="control-group">
                    <label class="control-label" for="inputPassword">Table name</label>
                    <div class="controls">
                    <input type="text" name="tablename" id="username"  class="password"  >  
                               
                                   
                    </div>
                    </div>
                    
                     
                    
                       
                    
                      <button type="submit" name="submit" class="btn btn-primary" >Show table</button>
                  
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
       </div>
    </div>
    
</div>