<?php if(isset($_SESSION['alert_error'])) {echo("<div style='color:red;'>".$_SESSION['alert_error']."</div>");} ?>
<?php if(isset($_SESSION['alert_success'])) {echo("<div style='color:green;'>".$_SESSION['alert_success']."</div>");} ?>

<br>
<div class="panel panel-default">
  <div class="panel-heading">
    
  <div class="headerbar-item pull-right">
        <div class="btn-group btn-group-sm index-options">
          
          <a class="btn btn-default btn-xs" href="<?php echo site_url("banking/save/").$transaction["transactionId"]; ?>"> add to filter </a>
        
        </div>
  </div> 
  <div class="headerbar-item pull-left">
        <div class="btn-group btn-group-sm index-options">
          <a class="btn btn-default btn-xs" href="<?php echo site_url("banking/index/all"); ?>"> zurück </a>
        </div>
  </div>
    
  <div align="center"><?php echo "<b>".$transaction["title"]."</b>"; ?></div>
  </div>
  <div class="panel-body">
  <table class="table table-hover">
    <?php  
    $color= $transaction["transactionAmount"] <0?"red":"green";
    echo 
    "<tr><td>".$transaction["bookingDate"]."</td></tr>".
    "<tr><td>".$transaction["valueDate"]."</td></tr>".
    "<tr><td style='color:".$color.";'><b>".$transaction["transactionAmount"]."€</b></td></tr>".
    "<tr><td>".$transaction["iban"]."</td></tr>".
    "<tr><td>".$transaction["remittanceInformationStructured"]."</td></tr>".
    "<tr><td>".$transaction["additionalInformation"]."</td></tr>";
    ?>   
    <tr><td>
      
    <form method="post" name="myform" action="<?php echo site_url("banking/view/".$transaction["transactionId"]); ?>" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
      <select name="correspondent_id" id="correspondent"  onchange="this.form.submit()">
        <option value="">--Please choose an correspondent--</option>
        <?php
        
        foreach($correspondents as $c){
        if($c->id==$selected_correspondent['correspondent_id']){
          echo "<option selected value='".$c->id."'>".$c->name."</option>";
        }else{
          echo "<option value='".$c->id."'>".$c->name."</option>";
        }
          
        } 
        ?>
      </select>
      </form>

    </td></tr>
    <tr><td>
      <form method="post" name="f_search" action="<?php echo site_url("banking/view/".$transaction["transactionId"]); ?>" enctype="multipart/form-data">
       <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
       <input type="text" name="search" id="search" /> <input type="submit" value="suchen" />
      </form>
    </td></tr>
    <?php 
    foreach($documentsNoTransaction as $doc){
      echo "<tr><td><a target='_blank' href='".base_url()."uploads/paperless/".substr($doc->filename, 16)."'>".substr($doc->filename, 16)."</a> - - - - - <a href='".site_url("banking/addDocument/".$doc->id."/".$transaction['transactionId'])."'>ADD</a></td></tr>";
    }
    
    foreach($found_documents as $doc){
      echo "<tr><td>Vorschlag: <a style='font-size:11pt;color:green;' target='_blank' href='".base_url()."uploads/paperless/".substr($doc->filename, 16)."'>".substr($doc->filename, 16)."</a> - - - - - <a href='".site_url("banking/addDocument/".$doc->id."/".$transaction['transactionId'])."'>ADD</a></td></tr>";
    }
    ?> 
  </table>
  </div>
</div>
<br>
<div class="panel panel-default">
  <div class="panel-heading">
    <div class="row" >
    <?php  echo form_open_multipart('banking/do_upload/'.$id); ?>
    <div class="col-lg-6">
      <div class="input-group">
        <span class="input-group-btn">
          <button class="btn btn-primary" type="submit">upload</button>
        </span>
        <input type="file" name="userfile" class="form-control" placeholder="Search for...">
      </div>
    </div>
    </form>
    </div>
  </div>

<div class="panel-body">
  <div class="table-responsive">
    <table class="table table-hover table-striped">
  <tbody>
  <?php
  foreach($transfiles as $tran){
    echo "<form method='post' action='".site_url("banking/delete/".$tran->id."/".$id)."'>";
    $str=$tran->full_path;
    echo "<tr><td><a target='_blank' href='".base_url().substr($str,strpos($str, 'uploads/'))."'>".$tran->file_name."</a></td>
    <td><input type='submit' value='delete'></td>
    </tr></form>";
  }
  ?>
  </tbody>
  </table>
  </div>
  </div>
</div>




