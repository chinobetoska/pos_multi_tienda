<?php
    require_once 'includes/header.php';
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script>
	$(function() {
		$("#startDate").datepicker({
			format: "<?php echo $dateformat; ?>",
			autoclose: true
		});
		
		$("#endDate").datepicker({
			format: "<?php echo $dateformat; ?>",
			autoclose: true
		});
	});
</script>

<?php
    $url_start 		= "";
    $url_end 		= "";
    if(isset($_GET["report"])) {
	    $url_start 	= strip_tags($_GET["start_date"]);
	    $url_end	= strip_tags($_GET["end_date"]);
    }
?>

<script type="text/javascript" src="<?=base_url()?>assets/js/datatables/jquery-1.12.3.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/datatables/jquery.dataTables.min.js"></script>
<link href="<?=base_url()?>assets/js/datatables/jquery.dataTables.min.css" rel="stylesheet">
<script type="text/javascript">
	$(document).ready(function() {
	    $('#example').DataTable();
	});
</script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo $this->lang->line("sold_by_product_report_title"); ?></h1>
		</div>
	</div><!--/.row-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<form action="<?=base_url()?>reports/sold_by_products" method="get">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label><?php echo $lang_start_date; ?></label>
									<input type="text" name="start_date" class="form-control" id="startDate" required autocomplete="off" value="<?php echo $url_start; ?>" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label><?php echo $lang_end_date; ?></label>
									<input type="text" name="end_date" class="form-control" id="endDate" required autocomplete="off" value="<?php echo $url_end; ?>" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>&nbsp;</label><br />
									<input type="hidden" name="report" value="1" />
									<input type="submit" class="btn btn-primary" value="<?php echo $lang_get_report; ?>" />
								</div>
							</div>
						</div>
					</form>

<?php
	if(isset($_GET["report"])) {
		if ($site_dateformat == 'd/m/Y') {
            $startArray 	= explode('/', $url_start);
            $endArray 		= explode('/', $url_end);

            $start_day 		= $startArray[0];
            $start_mon 		= $startArray[1];
            $start_yea 		= $startArray[2];

            $url_start 		= $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day 		= $endArray[0];
            $end_mon 		= $endArray[1];
            $end_yea 		= $endArray[2];

            $url_end 		= $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'd.m.Y') {
            $startArray 	= explode('.', $url_start);
            $endArray 		= explode('.', $url_end);

            $start_day 		= $startArray[0];
            $start_mon 		= $startArray[1];
            $start_yea 		= $startArray[2];

            $url_start 		= $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day 		= $endArray[0];
            $end_mon 		= $endArray[1];
            $end_yea 		= $endArray[2];

            $url_end 		= $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'd-m-Y') {
            $startArray 	= explode('-', $url_start);
            $endArray 		= explode('-', $url_end);

            $start_day 		= $startArray[0];
            $start_mon 		= $startArray[1];
            $start_yea 		= $startArray[2];

            $url_start 		= $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day 		= $endArray[0];
            $end_mon 		= $endArray[1];
            $end_yea 		= $endArray[2];

            $url_end 		= $end_yea.'-'.$end_mon.'-'.$end_day;
        }

        if ($site_dateformat == 'm/d/Y') {
            $startArray 	= explode('/', $url_start);
            $endArray 		= explode('/', $url_end);

            $start_day 		= $startArray[1];
            $start_mon 		= $startArray[0];
            $start_yea 		= $startArray[2];

            $url_start 		= $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day 		= $endArray[1];
            $end_mon 		= $endArray[0];
            $end_yea 		= $endArray[2];

            $url_end 		= $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'm.d.Y') {
            $startArray 	= explode('.', $url_start);
            $endArray	 	= explode('.', $url_end);

            $start_day 		= $startArray[1];
            $start_mon 		= $startArray[0];
            $start_yea 		= $startArray[2];

            $url_start 		= $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day 		= $endArray[1];
            $end_mon 		= $endArray[0];
            $end_yea 		= $endArray[2];

            $url_end 		= $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'm-d-Y') {
            $startArray 	= explode('-', $url_start);
            $endArray 		= explode('-', $url_end);

            $start_day 		= $startArray[1];
            $start_mon 		= $startArray[0];
            $start_yea 		= $startArray[2];

            $url_start 		= $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day 		= $endArray[1];
            $end_mon 		= $endArray[0];
            $end_yea 		= $endArray[2];

            $url_end 		= $end_yea.'-'.$end_mon.'-'.$end_day;
        }

        if ($site_dateformat == 'Y.m.d') {
            $startArray 	= explode('.', $url_start);
            $endArray 		= explode('.', $url_end);

            $start_day 		= $startArray[2];
            $start_mon 		= $startArray[1];
            $start_yea 		= $startArray[0];

            $url_start 		= $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day 		= $endArray[2];
            $end_mon 		= $endArray[1];
            $end_yea 		= $endArray[0];

            $url_end 		= $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'Y/m/d') {
            $startArray 	= explode('/', $url_start);
            $endArray 		= explode('/', $url_end);

            $start_day 		= $startArray[2];
            $start_mon 		= $startArray[1];
            $start_yea 		= $startArray[0];

            $url_start 		= $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day 		= $endArray[2];
            $end_mon 		= $endArray[1];
            $end_yea 		= $endArray[0];

            $url_end 		= $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'Y-m-d') {
            $startArray 	= explode('-', $url_start);
            $endArray 		= explode('-', $url_end);

            $start_day	 	= $startArray[2];
            $start_mon 		= $startArray[1];
            $start_yea 		= $startArray[0];

            $url_start 		= $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day 		= $endArray[2];
            $end_mon 		= $endArray[1];
            $end_yea 		= $endArray[0];

            $url_end 		= $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        
?>
		<div class="row" style="margin-top: 10px;">
			<div class="col-md-12" style="text-align: right;">
				<a href="<?=base_url()?>reports/exportSoldByModelReport?url_start=<?php echo $url_start; ?>&url_end=<?php echo $url_end; ?>" target="_blank">
					<button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;"><?php echo $lang_export_to_excel; ?></button>
				</a>
			</div>
		</div>
		<div class="row" style="margin-top: 10px;">
			<div class="col-md-12">
				<div class="table-responsive">
					<table id="example" class="display" cellspacing="0" width="100%">
					    <thead>
					        <tr>
						        <th width="28%"><?php echo $this->lang->line("product_code"); ?></th>
						        <th width="28%"><?php echo $this->lang->line("product_name"); ?></th>
						        <th width="28%"><?php echo $this->lang->line("product_category"); ?></th>
						        <th width="15%"><?php echo $this->lang->line("sold_by_product_sold_qty"); ?></th>
					        </tr>
					    </thead>
					    <tbody>
<?php
	$pcodeArray 	= array();
	$start_dtm 		= $url_start." 00:00:00";
	$end_dtm 		= $url_end." 23:59:59";
	
	$ordItemResult 	= $this->db->query("SELECT DISTINCT product_code FROM order_items WHERE created_datetime >= '$start_dtm' AND created_datetime <= '$end_dtm' AND status = '1' ORDER BY id DESC ");
	$ordItemData 	= $ordItemResult->result();
	for($oit = 0; $oit < count($ordItemData); $oit++) {
		$ordItem_pcode 		= $ordItemData[$oit]->product_code;
		
		if(in_array("$ordItem_pcode", $pcodeArray)) {
			
		} else {
			array_push($pcodeArray, $ordItem_pcode);
		}
		
		unset($ordItem_pcode);
	}
	unset($ordItemData);
	unset($ordItemResult);
?>

<?php
	if(count($pcodeArray) > 0) {
		for($p = 0; $p < count($pcodeArray); $p++) {
			$pcode 				= $pcodeArray[$p];
			
			$pname 				= "-";
			$pcat_name 			= "-";
			$prodDtaResult		= $this->db->query("SELECT * FROM products WHERE code = '$pcode' ");
			$prodDtaRows 		= $prodDtaResult->num_rows();
			if($prodDtaRows == 1) {
				$prodDtaData	= $prodDtaResult->result();
				$pname 			= $prodDtaData[0]->name;
				$pcat_id 		= $prodDtaData[0]->category;
				unset($prodDtaData);
				
				$catNameResult	= $this->db->query("SELECT name FROM category WHERE id = '$pcat_id' ");
				$catNameRows 	= $catNameResult->num_rows();
				if($catNameRows == 1) {
					$catNameData= $catNameResult->result();
					$pcat_name	= $catNameData[0]->name;
					unset($catNameData);
				}
				unset($catNameRows);
				unset($catNameResult);
			}
			unset($prodDtaRows);
			unset($prodDtaResult);
			
			$total_sold_qty 	= 0;
			$soldItemResult 	= $this->db->query("SELECT qty FROM order_items WHERE product_code = '$pcode' AND created_datetime >= '$start_dtm' AND created_datetime <= '$end_dtm' AND status = '1' ");
			$soldItemData 		= $soldItemResult->result();
			for($s = 0; $s < count($soldItemData); $s++) {
				$soldItem_qty	= $soldItemData[$s]->qty;
				
				$total_sold_qty += $soldItem_qty;
				
				unset($soldItem_qty);
			}
			unset($soldItemData);
			unset($soldItemResult);
?>
			<tr>
				<td><?php echo $pcode; ?></td>
				<td><?php echo $pname; ?></td>
				<td><?php echo $pcat_name; ?></td>
				<td><?php echo $total_sold_qty; ?></td>
			</tr>
<?php
		}
	}
?>					
						</tbody>
					</table>
				</div>
			</div>
		</div>
<?php
	}	
?>

					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	<br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
	
<?php
    require_once 'includes/footer.php';
?>