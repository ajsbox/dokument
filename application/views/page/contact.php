<div class="row-fluid" style="margin: 15px 0 25px 0;">
 <div class="span6 offset3 gallery">
  <h3 style="margin-left: 25px;">Contact Us</h3>
  <div class="alert alert-success contact_send" style="display: none;"><strong>Success</strong> The email has been sent!</div>
  <form action="send_contact" method="post" class="form-horizontal well form-search" id="contact_form">
   <div class="control-group">
             <label class="control-label" for="contact_name">Your Name </label>
             <div class="controls">
              <div class="input-prepend">
                  <span class="add-on"><i class="icon icon-user"></i></span>
                 <input type="text" name="contact_name" class="input-large">
               </div>
             </div>
         </div>
         <div class="control-group">
             <label class="control-label" for="contact_email">Your Email </label>
             <div class="controls">
              <div class="input-prepend">
                  <span class="add-on">@</span>
                 <input type="text" name="contact_email" class="input-large">
               </div>
             </div>
         </div>
         <div class="control-group">
             <label class="control-label" for="contact_subject">Subject </label>
             <div class="controls">
              <div class="input-prepend">
                  <span class="add-on"><i class="icon icon-inbox"></i></span>
                 <input type="text" name="contact_subject" class="input-large">
               </div>
             </div>
         </div>
         <div class="control-group">
             <label class="control-label" for="contact_body">Message </label>
             <div class="controls">
              <div class="input-prepend">
                  <span class="add-on"><i class="icon icon-comment"></i></span>
                 <textarea name="contact_body" rows="5"></textarea>
               </div>
             </div>
         </div>
   <div class="form-actions">
    <input type="submit" name="send_contact" class="btn btn-large btn-primary" value="Send">
   </div>
  </form>
 </div>
</div>