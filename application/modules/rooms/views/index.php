<div id="headerbar">
    <div class="headerbar-item pull-left">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('rooms/add'); ?>">
            <i class="fa fa-plus"></i> <?php _trans('Room') ?>
        </a>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-hover table-striped">
    <tr>
		<th>ID</th>
		<th>Name</th>
        <th>Kapazität</th>
		<th>Diagramanzeigen</th>
        <th>Webseiteanzeigen</th>
        <th>Kategorie</th>
        <th>Beschreibung</th>
        <th>1P</th>
        <th>2P</th>
        <th>3P</th>
		<th>Actions</th>
    </tr>
	<?php foreach($ip_rooms as $i){ ?>
    <tr>
		<td><?php echo $i['id']; ?></td>
		<td><?php echo $i['name']; ?></td>
        <td><?php echo $i['capacity']; ?></td>
		<td><?php echo $i['active']==1?'ja':'nein'; ?></td>
        <td><?php echo $i['show_on_system']==1?'ja':'nein'; ?></td>
        <td><?php echo $i['kategorie']; ?></td>
        <td><?php echo $i['beschreibung']; ?></td>
        <td><?php echo $i['preis1']; ?>€</td>
        <td><?php echo $i['preis2']; ?>€</td>
        <td><?php echo $i['preis3']; ?>€</td>
        
		<td>
            <a href="<?php echo site_url('rooms/edit/'.$i['id']); ?>">Edit</a> | 
            <a href="<?php echo site_url('rooms/remove/'.$i['id']); ?>">Delete</a>
        </td>
        </tr>
	<?php } ?>
</table>
</div>