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
		<th>Active</th>
		<th>Name</th>
		<th>Actions</th>
    </tr>
	<?php foreach($ip_rooms as $i){ ?>
    <tr>
		<td><?php echo $i['id']; ?></td>
		<td><?php echo $i['active']; ?></td>
		<td><?php echo $i['name']; ?></td>
		<td>
            <a href="<?php echo site_url('rooms/edit/'.$i['id']); ?>">Edit</a> | 
            <a href="<?php echo site_url('rooms/remove/'.$i['id']); ?>">Delete</a>
        </td>
        </tr>
	<?php } ?>
</table>
</div>