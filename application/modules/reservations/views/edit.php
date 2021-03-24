<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-1.12.2.js" type="text/javascript"></script>

    <title>New Reservation</title>
  </head>
  <body>

<form method="post" class="mb-6 needs-validation" novalidate  action="<?php echo site_url("reservations/newPost"); ?>" id="f">

  <div class="card">
  <div class="card-header"><h5 class="card-title">Reservierung erstellen</h5></div>
  <div class="card-body">

    <input type="hidden" id="csrf_token_name" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

<div class="mb-3 row">
    <label for="name" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="<?php echo $reservations->title; ?>" id="name" placeholder="name">
        <p id="error" style="display:none;color:red;">
            Bitte wählen sie einen namen aus.
        </p>
    </div>
  </div>
  <div class="mb-3 row">
    <label for="start" class="col-sm-2 col-form-label">Start</label>
    <div class="col-sm-10">
      <input type="date" class="form-control" value="<?php echo  date_format($reservations->start, 'Y-m-d'); ?>" id="start" placeholder="start">
    </div>
  </div>
   <div class="mb-3 row">
    <label for="end" class="col-sm-2 col-form-label">End</label>
    <div class="col-sm-10">
      <input type="date" class="form-control" id="end" value="<?php echo  date_format($reservations->end, 'Y-m-d'); ?>" placeholder="end">
    </div>
  </div>
     <div class="mb-3 row">
    <label for="end" class="col-sm-2 col-form-label">Room</label>
    <div class="col-sm-10">
     <select name="room" id="room" class="form-select" aria-label="Default select example">
    <?php foreach($rooms as $room){
        $selected="";
        if($room->id==$reservations->room_id){
            $selected="selected";
        }
        echo "<option ".$selected." value=".$room->id.">".$room->name."</option>";


    } ?>
    </select>

    </div>
  </div>
    <div style="display: inline;">
        <div style="display: inline;">
          <a class="btn btn-outline-danger" id="btnDelete">Delete</a>
        </div>
        <div style="display: inline; float:right;">
            <a class="btn btn-success" id="btnSave">Save</a>
            <a class="btn btn-danger" href="javascript:close()">Cancel</a>
        </div>
    </div>
</div>
</div>

</form>
<script type="text/javascript">

        $("#btnDelete").click(function() {

            $.post("<?php echo site_url("reservations/delete/".$reservations->id); ?>",{},
            function(data){
                close();
            });


        });

        $("#btnSave").click(function() {
            if($("#name").val()==""){
                $("#error").css("display","inline");
            }else{
                $.post("<?php echo site_url("reservations/newPost/".$reservations->id); ?>",{
                    name:$("#name").val(),
                    start:$("#start").val(),
                    end:$("#end").val(),
                    room_id:$("#room").val()
                },function(data){
                    close();
                });
            }
        });

        function close(result) {
            if (parent && parent.DayPilot && parent.DayPilot.ModalStatic) {
                parent.DayPilot.ModalStatic.close(result);
            }
        }
    </script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

  </body>
</html>
