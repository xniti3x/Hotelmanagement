<?php echo form_open('rooms/edit/'.$ip_room['id']); ?>

<div>
		Active : 
		<input type="checkbox" name="active" value="1" <?php echo ($ip_room['active']==1 ? 'checked="checked"' : ''); ?> />
	</div>
	<div>
		show_on_system : 
		<input type="checkbox" name="show_on_system" value="1" <?php echo ($ip_room['show_on_system']==1 ? 'checked="checked"' : ''); ?> />
	</div>
	<div>
		Name : 
		<input type="text" name="name" value="<?php echo ($this->input->post('name') ? $this->input->post('name') : $ip_room['name']); ?>" />
	</div>
	
	<button type="submit">Save</button>
	
<?php echo form_close(); ?>