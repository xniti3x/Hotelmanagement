<div class="form-group">
    <label for="day">Day</label>
    <input type="date" class="form-control" id="day"  placeholder="day" value="<?php echo $timesheet[0]->day; ?>">
</div>
<div class="form-group">
    <label for="start">Start</label>
    <input type="time" class="form-control" id="start" value="<?php echo $timesheet[0]->start; ?>"  placeholder="start">
</div>
<div class="form-group">
    <label for="end">End</label>
    <input type="time" class="form-control" id="end" value="<?php echo $timesheet[0]->end; ?>"  placeholder="end">
</div>
<div class="form-group">
    <label for="notes">Notes</label>
    <textarea class="form-control" id="notes" placeholder="notes"><?php echo $timesheet[0]->notes; ?></textarea>
</div>