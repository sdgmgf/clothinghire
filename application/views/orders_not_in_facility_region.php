<!doctype html>
<html>

<head>
    <title>拼好货WMS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="Pragma" content="no-cache">   
    <meta http-equiv="Cache-Control" content="no-store">
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
    <!--[if lt IE 9]>
            <script src="http://assets.yqphh.com/assets/js/html5shiv.min-3.7.2.js"></script>
        <![endif]-->
    <style type="text/css">
        .main {
            width: 100%;
            max-width: 640px;
            margin: 0 auto;
        }

        .date {
        	font-size:15pt;
            float: left;
            color: red;
        }
        table {
            text-align: left;
            border: 1px;
            border-spacing: 0;
        }

        .text span {
            float: right;
        }
        
        .cyan {
        	background: cyan;
        }
        .green {
        	background: rgb(56, 231, 151);
        }
        .red {
        	background: red;
        }
    </style>
</head>
<body>
<div class="container-fluid" style="margin-left: -18px;padding-left: 19px;" >
	<div role="tabpanel" class="row tab-product-list tabpanel" >
		<div class="col-md-12">
		<input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
		<input type="hidden" id="asn_id"  <?php if(isset($asn_id)) echo "value={$asn_id}"; ?> >
			<div class="tab-content">
				<div class="row col-sm-10 col-sm-offset-0" style="margin-top: 10px;">
					<form style="width:100%;" method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>ordersNotInFacilityRegion">
					<div class="row">
					<label for="facility_id">仓库：</label>
					<select style="width:12%; height: 30px" id="facility_id" name="facility_id" >
                                <?php foreach ( $facility_list as $facility ) {
									if (isset( $facility_id ) && $facility ['facility_id'] == $facility_id) {
										echo "<option value=\"{$facility['facility_id']}\" selected='true'>{$facility['facility_name']}</option>";
									} else {
										echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
									}
								} ?>
                    </select>
					</div>
					</form>
					<div id="myPrintArea">
					<table name="bol_item" id="bol_item" class="table table-striped table-bordered "  style="width:100%" >
						<tr>
			            	<th>PRODUCT_ID</th>
			                <th width="60%">商品</th>
			                <th width="40">外围件数量</th>
						</tr>
						<?php if( isset($order_list) && is_array($order_list))  foreach ($order_list as $key => $order) { ?> 
			            <tr class="content">
			                <td><?php echo $order['product_id']?></td>
			                <td><?php echo !empty($order['product_name'])?$order['product_name']:'' ?></td>
			                <td><?php echo !empty($order['quantity'])?$order['quantity']:'' ?></td>
						</tr>
	      				<?php }?>
      				</table>
    				
    			</div>
    		</div>
    	</div>
    </div>
    
</div>

    <script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
	<script type="text/javascript">
	$('#facility_id').change(function(){
		$('form').submit();
	});
</script>
</body>
</html>