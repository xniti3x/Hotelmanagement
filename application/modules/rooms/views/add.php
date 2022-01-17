<?php echo form_open('rooms/add'); ?>

	<div>
		Active : 
		<input type="checkbox" name="active" value="1" />
	</div>
	<div>
		Name : 
		<input type="text" name="name" value="<?php echo $this->input->post('name'); ?>" />
	</div>
	
	<button type="submit">Save</button>

<?php echo form_close(); ?>