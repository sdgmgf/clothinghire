<!doctype html>
<html>
<head>
	<meta charset="UTF-8"/>
	<title>拼好货WMS</title>
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>
	<div style="width: 100px;margin:0 auto;height: 50px;">
		<a href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>addFacility" class="btn btn-primary btn-sm" name="addFacility" id="addFacility">添加新仓库</a>
	</div>
	<div style="width: 1000px;margin: 0 auto;">
		<table class="table table-striped table-bordered ">
			<thead>
				<th width="10%">仓库名</th>
				<th width="5%">仓库类型</th>
				<th width="5%">是否可用</th>
				<th width="15%">面单方式</th>
				<th width="15%">仓库地址</th>
				<th width="10%">省</th>
				<th width="10%">市</th>
				<th width="10%">区</th>
				<th width="10%">配发方式</th>
				<th width="10%">操作</th>
			</thead>
			<tbody>
				<?php foreach($facility_info_list as $key => $row){?>
					<tr>
						<td><?php echo $row['facility_name']?></td>
						<td><?php if($row['facility_type'] === '1'){ echo "生产仓";}else if($row['facility_type'] === '2'){echo "生产仓";}else if($row['facility_type'] === '3'){echo "市场虚拟仓";}else if($row['facility_type'] === '4'){echo "产地虚拟仓";}else if($row['facility_type'] === '5'){echo "供应商虚拟仓";}else {echo "中转仓";}?></td>
						<td><?php if($row['enabled'] === '1'){echo "可用";}else{echo "不可用";}?></td>
						<td><?php if($row['is_self_template'] === '1'){echo "自定义面单";}else{echo "快递公司面单";}?></td>
						<td><?php echo $row['facility_address']?></td>
						<td><?php echo $row['province_name']?></td>
						<td><?php echo $row['city_name']?></td>
						<td><?php echo $row['district_name']?></td>
						<td><?php echo $row['schedule_mode_desc'];?></td>
						<td>
							<a style="float: left;" class="btn btn-primary btn-sm" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>facilityList/detail?facility_id=<?php echo $row['facility_id']; ?>"> 详情 </a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</body>
</html>