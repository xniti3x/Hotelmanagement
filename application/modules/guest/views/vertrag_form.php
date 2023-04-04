<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Vertrag erstellen</title>
  </head>
  <body>
  <form method="post" action="<?php echo site_url("guest/vertrag/vertrag"); ?>">
<input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"value="<?php echo $this->security->get_csrf_hash() ?>">
<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('Vertrag erstellen'); ?></h1>
    <?php print_r ($vermieter); ?>
</div>
<div id="content">
    <?php $this->layout->load_view('layout/alerts'); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading form-inline clearfix">
                    <?php _trans('Vertragsinformationen'); ?>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="vermieter"><?php _trans('Vermieter'); ?></label>
                        <div class="controls">
                        <select name="vermieter" id="Vermieter" class="form-control simple-select">
                        <?php $pieces = explode(";", $vermieter); foreach($pieces as $p){ ?>
                            <option value="<?php echo $p; ?>"><?php echo $p; ?></option>
                            <?php } ?>
                        </select>
                            <input type="text" name="mieter" id="mieter" class="form-control" placeholder="mieter name | adresse | ...">
                            <input type="text" name="wohnfleche" id="wohnfleche" class="form-control" placeholder="wohnfläche"> 
                        <select name="adresse" id="adresse" class="form-control simple-select">
                        <?php $pieces = explode(";", $adresse); foreach($pieces as $p){ ?>
                            <option value="<?php echo $p; ?>"><?php echo $p; ?></option>
                            <?php } ?>
                        </select>
                        <input type="text" name="raumlichkeiten" id="raumlichkeiten" class="form-control"placeholder="1 Zimmer, 1 Kellerraum, Bad, Küche, Garage, Stellplatz"> 
                        <input type="number" name="kaltmiete" id="kaltmiete" class="form-control" placeholder="kaltmiete" value=""> 
                        <input type="number" name="nebenkosten" id="nebenkosten" class="form-control" placeholder="nebenkosten" value="">
                        <input type="text" name="iban" id="iban" class="form-control" placeholder="iban bankkonto" value="">  
                        <input type="number" name="kaution" id="kaution" class="form-control" placeholder="kaution" value=""> 
                        <select name="kautionsart" id="kautionsart" class="form-control simple-select">
                        <?php $pieces = explode(";", $kautionart); foreach($pieces as $p){ ?>
                            <option value="<?php echo $p; ?>"><?php echo $p; ?></option>
                            <?php } ?>
                        </select> 
                        <input type="text" name="begin" id="begin" class="form-control" placeholder="vertragsbegin datum bsp 13-01-2101" value="">
                        <input type="text" name="ende" id="ende" class="form-control" placeholder="vertragsende datum" value="">
                        <input type="number" name="selbstbeteiligung" id="selbstbeteiligung" class="form-control" placeholder="Selbstbeteiligung betrag" value="150">
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->layout->load_view('layout/header_buttons'); ?>
</form>
  </body>
</html>