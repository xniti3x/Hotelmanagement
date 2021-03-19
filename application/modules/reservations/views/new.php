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


<form class="mb-6" id="f" action="<?php echo site_url("reservations/ajax/new"); ?>">

  <div class="card">
  <div class="card-header"><h5 class="card-title">Reservierung erstellen</h5></div>
  <div class="card-body">

<div class="mb-3 row">
    <label for="name" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="name" placeholder="name">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="start" class="col-sm-2 col-form-label">Start</label>
    <div class="col-sm-10">
      <input type="date" class="form-control" id="start" placeholder="start">
    </div>
  </div>
   <div class="mb-3 row">
    <label for="end" class="col-sm-2 col-form-label">End</label>
    <div class="col-sm-10">
      <input type="date" class="form-control" id="end" placeholder="end">
    </div>
  </div>
     <div class="mb-3 row">
    <label for="end" class="col-sm-2 col-form-label">Room</label>
    <div class="col-sm-10">
     <select name="room" id="room" class="form-select" aria-label="Default select example">
    <option selected>Room 1</option>
    <option value="1">One</option>
    <option value="2">Two</option>
    <option value="3">Three</option>
    </select>

    </div>
  </div>
    <div class="space" align="right">

    <a class="btn btn-success" id="btnSave" href="javascript:close()">Save</a>
    <a class="btn btn-danger" href="javascript:close()">Cancel</a>
    </div>
    <div class="space">&nbsp;</div>

</div>
</div>

</form>
<script type="text/javascript">

        $("#btnSave").click(function() {
            $.post("<?php echo site_url("reservations/ajax/new"); ?>",{
                name:$("name").val(),
                start:$("start").val(),
                end:$("end").val(),
                room:$("room").val()



            },function(data){

            });


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
