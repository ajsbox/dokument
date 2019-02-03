<div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span4 home-box" style="padding: 25px;">
		<h3>Admin Notes History</h3>
		<?php foreach($this->admin_model->get_admin_notes() as $n): ?>
			<p><strong>Note By:</strong> <?php echo $n['owner']; ?><br />
				<strong>Note:</strong> <?php echo $n['notes']; ?><br />
				<strong>Date:</strong> <?php echo date("M j Y g:i A", $n['date']); ?>.</p>
		<?php endforeach; ?>
	</div>
</div>