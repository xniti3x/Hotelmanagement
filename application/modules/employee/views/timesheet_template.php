<style>
table.minimalistBlack {
  width: 100%;
  text-align: left;
  border-collapse: collapse;
}
table.minimalistBlack td, table.minimalistBlack th {
  border: 1px solid #000000;
  padding: 5px 4px;
}
table.minimalistBlack tbody td {
    font-size: 13px;
}
table.minimalistBlack thead {
  background: #CFCFCF;
  background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
  background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
  background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
  border-bottom: 3px solid #000000;
}
table.minimalistBlack thead th {
  font-size: 15px;
  font-weight: bold;
  color: #000000;
  text-align: left;
}
table.minimalistBlack tfoot {
  font-size: 14px;
  font-weight: bold;
  color: #000000;
  border-top: 3px solid #000000;
}
table.minimalistBlack tfoot td {
  font-size: 14px;
  background:#eee;
}
</style>
<table class="minimalistBlack">
<thead>
<tr>
<th>Tag</th>
<th>Datum</th>
<th>Start</th>
<th>End</th>
<th>Dauer</th>
<th>Bemerkung</th>
</tr>
</thead>
<tfoot>
<tr>
<td></td>
<td></td>
<td></td>
<td>Summe:</td>
<td><?php print_r($total);?></td>
<td></td>
</tr>
</tfoot>
<tbody>
<?php $i=1; foreach($employee as $emp){
            echo ("<tr>
            <td style='width:20px;'>".$i++."</td>
            <td style='width:120px;'>".$tage[date('w',strtotime($emp->day))]." - ".date('d-m-Y', strtotime($emp->day))."</td>
            <td style='width:80px;'>".$emp->start."</td>
            <td style='width:80px;'>".$emp->end."</td>
            <td style='width:80px;'>".$emp->duration."</td>
            <td>".$emp->notes."</td>
            </tr>");
        } 
    ?>    
</tbody>
</table>