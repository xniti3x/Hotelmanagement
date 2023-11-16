<?php echo form_open('rooms/edit/'.$ip_room['id']); ?>

<div class="table-responsive">
    <table class="table table-hover table-striped">
	<tr><th>Titel</th><th>Funktion</th></tr>
    <tr><td>show on Diagram </td><td><input type="checkbox" name="active" value="1" <?php echo ($ip_room['active']==1 ? 'checked="checked"' : ''); ?> /></td></tr>	
	<tr><td>show on Webpage </td><td><input type="checkbox" name="show_on_system" value="1" <?php echo ($ip_room['show_on_system']==1 ? 'checked="checked"' : ''); ?> /></td></tr>
	<tr><td>Name</td><td><input type="text" name="name" value="<?php echo ($this->input->post('name') ? $this->input->post('name') : $ip_room['name']); ?>" /></td></tr>
	<tr><td>Kapazität</td><td><input type="text" name="capacity" value="<?php echo ($this->input->post('capacity') ? $this->input->post('capacity') : $ip_room['capacity']); ?>" /></td></tr>
	<tr><td>Kategorie</td><td><input type="text" name="kategorie" value="<?php echo ($this->input->post('kategorie') ? $this->input->post('kategorie') : $ip_room['kategorie']); ?>" /></td></tr>
	<tr><td>Bezeichnung</td><td><textarea type="text" name="beschreibung" rows="5" cols="100"><?php echo ($this->input->post('beschreibung') ? $this->input->post('beschreibung') : $ip_room['beschreibung']); ?></textarea></td></tr>
	<tr><td>Preis 1P</td><td><input type="text" name="preis1" value="<?php echo ($this->input->post('preis1') ? $this->input->post('preis1') : $ip_room['preis1']); ?>" /></td></tr>
	<tr><td>Preis 2P</td><td><input type="text" name="preis2" value="<?php echo ($this->input->post('preis2') ? $this->input->post('preis2') : $ip_room['preis2']); ?>" /></td></tr>
	<tr><td>Preis 3P</td><td><input type="text" name="preis3" value="<?php echo ($this->input->post('preis3') ? $this->input->post('preis3') : $ip_room['preis3']); ?>" /></td></tr>
	<tr><td></td><td><button type="submit">Save</button></td></tr>	
</table>
</div>

	
	
	
<?php echo form_close(); ?>