<!doctype html>
<html>
<head>
	<title>拼好货WMS</title>
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>
<div style="width: 1000px;margin: 0 auto;">
	<div style="width: 60%;margin: 0 auto;">
		<table class="table table-striped table-bordered ">
			<tr>
				<td>仓库:</td>
				<td>
					<select style="width: 90%;float: left;" name="facility_list" id="facility_list">
						<?php 
							foreach ($facility_list as $facility) {
								echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>"; 
							}
						?>
					</select>
				</td>
			</tr>
			<tr><td colspan="2">
				<button type="button" style="float: right;" class="btn btn-primary" onclick="javascript:getFacilityList()" >查询</button></td>
			</tr>
		</table>
	</div>
	<div id="list">
	</div>
</div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript">
function isNullOrEmpty(strVal) {
	if (strVal == '' || strVal == null || strVal == undefined) {
		return true;
	} else {
		return false;
	}
}
function getFacilityList(){
	$.ajax({
        url: "<?php echo $WEB_ROOT;?>modifyFacility/getFacilityWithoutRegionShipping?facility_id="+$('#facility_list option:selected').val(),
        type: 'GET',
        dataType: "text", 
        xhrFields: {
             withCredentials: true
        }
    }).done(function(data){
          if(!isNullOrEmpty(data)){
			$("#list").html(data);
          }
    });
}
</script>
</body>
</html>