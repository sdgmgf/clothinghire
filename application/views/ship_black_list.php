<!doctype html>
<html>
<head>
<title></title>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-store">
<meta http-equiv="Expires" content="0">
<link rel="stylesheet"
	href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
<link rel="stylesheet"
	href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
<link rel="stylesheet"
	href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet"
	href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
<!-- <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/js/calendar/GooCalendar.css"/> -->
</head>
<body id="main">
	<div class="container">
		<section class="main">
			<form style="width: 60%; text-align: center" method="get" 
				action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>shippingBlackList/queryList">
				 
				<label>快递:</label>
				<select id="shipping_id" name="shipping_id" style="width: 40%">
				<?php if (isset($shipping_list)) foreach($shipping_list as $shipping){
					if(isset($shipping_id) && $shipping['shipping_id'] == $shipping_id)
						echo "<option value=".$shipping["shipping_id"]." selected='selected'>".$shipping['shipping_name']."</option>";
					else
						echo "<option value=".$shipping["shipping_id"].">".$shipping['shipping_name']."</option>";
				}?>
				</select>
				<button class="btn btn-primary " id="query" name="query">
					展示
				</button>
				<button class="btn btn-primary " id="addRecord" name="addRecord">
					添加
				</button>
				
				<input type="hidden"  id="page_current" name="page_current"  
                    <?php if(isset($page_current)) echo "value={$page_current}"; ?> /> 
                <input type="hidden"  id="page_count" name="page_count"   
                    <?php if(isset($page_count)) echo "value={$page_count}"; ?> />
                <input type="hidden"  id="page_limit" name="page_limit" 
                    <?php if(isset($page_limit)) echo "value={$page_limit}"; ?> /> 
			</form>
			<!-- product list start -->
			<div class="row  col-sm-7 " style="margin-top: 10px;">
				<table class="table table-striped table-bordered ">
					<thead>
						<tr>
							<th style="width: 30%;">省份</th>
							<th style="width: 30%;">市</th>
							<th style="width: 30%;">区县</th>
							<th style="width: 10%;">操作</th>
						</tr>
					</thead>
					<tbody>
						<?php if(isset($black_list)) {foreach($black_list as $record){?>
						<tr>
							<td><?php echo $record['province_name'];?></td>
							<td><?php echo $record['city_name'];?></td>
							<td><?php echo $record['district_name'];?></td>
							<td><a class="delete" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>shippingBlackList/deleteRecord?shipping_id=<?php echo $shipping_id;?>&district_id=<?php echo $record['district_id'];?>">删除</a></td>
						</tr>
						<?php }}?>
					</tbody>
				</table>
				<div class="row">
					<nav style="float: right; margin-top: -7px;">
						<ul class="pagination">
							<li><a href="#" id="page_prev"> <span aria-hidden="true">&laquo;</span>
							</a></li><?php if(isset($page)) echo $page; ?><li><a href="#"
								id="page_next"> <span aria-hidden="true">&raquo;</span>
							</a></li>
							<li><a href='#'>
							<?php if (isset( $page_count )) echo "共{$page_count}页 &nbsp;"; 
							if (isset( $record_total )) echo "共{$record_total}条记录";?>
                            </a></li>
						</ul>
					</nav>
				</div>
			</div>
		</section>
	</div>
	
<div class="modal fade" id="region-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">新增黑名单地址</h4>
      </div>
      
      <div class="modal-body">
        <div class="container">
            
            <div class="row col-md-10">
                <div class="col-md-2">
                   <h5>  快递方式: </h5>
                </div>
                <div class="col-md-4">
                   <input type="text"  class="form-control" id="cur_shipping_id" style="display: none;">
                   <input type="text"  class="form-control" id="shipping_name" readonly="readonly">
                </div>
                <div class="col-md-6"></div>
            </div>
            
            <div class="row col-md-10">
                <div class="col-md-2">
                   <h5>  省: </h5>
                </div>
                <div class="col-md-4" >
                    <select  style="width: 30%;"  name="province_id" id="provinceSel">
                        <?php
                            if ($province_list && isset($province_list['result']) && $province_list['result'] == 'ok' && $province_list['regions']) {
                                foreach($province_list['regions'] as $region) {
                                    echo "<option value=\"{$region['region_id']}\" " . (isset($order['province_id']) && $order['province_id'] == $region['region_id'] ? " selected='true'" : ""). ">{$region['region_name']}</option>";
                                }
                            }
                         ?>
                    </select>
                    <select  style="width: 30%;"  name="city_id" id="citySel">
                        <?php
                            if ($city_list && isset($city_list['result']) && $city_list['result'] == 'ok' && $city_list['regions']) {
                                foreach($city_list['regions'] as $region) {
                                    echo "<option value=\"{$region['region_id']}\" " . (isset($order['city_id']) && $order['city_id'] == $region['region_id'] ? " selected='true'" : ""). ">{$region['region_name']}</option>";
                                }
                            }
                         ?>
                    </select>
                    <select  style="width: 30%;"  name="district_id" id="districtSel">
                        <?php
                            if ($district_list && isset($district_list['result']) && $district_list['result'] == 'ok' && $district_list['regions']) {
                                foreach($district_list['regions'] as $region) {
                                    echo "<option value=\"{$region['region_id']}\" " . (isset($order['district_id']) && $order['district_id'] == $region['region_id'] ? " selected='true'" : ""). ">{$region['region_name']}</option>";
                                }
                            }
                         ?>
                    </select>
                </div>
                <div class="col-md-6"></div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="add_bl_region" data-dismiss="modal">确定</button>
      </div>
    </div>
  </div>
</div>
	<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
	<script
		src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		
	<script type="text/javascript">
	$("#add_bl_region").click(function(){
	      var shipping_id = $("#cur_shipping_id").val();
	      var shipping_name =  $("#shipping_name").val();
	      var province_id = $("#provinceSel option:selected").val();
	      var city_id = $("#citySel option:selected").val();
	      var district_id = $("#districtSel option:selected").val();
	      var district_name = $("#districtSel option:selected").text();
	      
	      if (shipping_id == null || shipping_id == "") {
	      		alert("快递方式不存在"); return false;
	      }
	      if (province_id == null || province_id == "") {
		      	alert("未指定省份"); return false;
		      }
	      if (city_id == null || city_id == "") {
		      	alert("未指定市"); return false;
		      }
	      if (district_id == null || district_id == "") {
		      	alert("未指定区县"); return false;
		      }

	      if(!confirm('确定新增区域 ： '+district_name+' 到快递：'+shipping_name+' 的黑名单中?\r\n')){
	          return false;
	      }
	      add_region(shipping_id,district_id);
   	});	

   	function add_region(shipping_id,district_id){
   		var myurl = "<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>shippingBlackList/addRecord";
        var mydata = {
                    "shipping_id":shipping_id, 
                    "district_id":district_id
                    }; 
        $.ajax({
                url: myurl,
                type: 'POST',
                data:mydata, 
                dataType: "json", 
                xhrFields: {
                     withCredentials: true
                }
        }).done(function(data){
              if(data.success == "true"){
	              alert("添加成功");
	              window.location.reload();
              }else{
                alert(data.error_info);
              }
        });
    }
	</script>
	<script type="text/javascript">
	$(".delete").on("click",function(event){
		event.preventDefault();
		var res = confirm("确实要从当前快递的黑名单中删除 区县 ： "+$(this).parent().parent().children().eq(2).text()+" ? ");
		if(res == true){
			var url = $(this).attr("href");
			$.ajax({
		         url: url,
		         type: 'GET',
		         dataType : 'json',
		         xhrFields: {
		           withCredentials: true
		         }
			  }).done(function(data){
			      if(data.success == "true"){
				  	  alert("删除成功。");
				  	  window.location.reload();
			      }else{
				  	  alert("删除失败. "+data.error_info);
		        }
		    });  
		}
	});

	$("#addRecord").on("click",function(event){
        event.preventDefault();
        var cur_shipping = $("#shipping_id option:selected").val();
        var cur_name = $("#shipping_id option:selected").text();
        $("#cur_shipping_id").val(cur_shipping);
        $("#shipping_name").val(cur_name);
        $("#region-modal").modal("show");
    });
	
	$("#query").click(function(){
        $("#page_current").val("1");
        $("form").submit();
    }); 
	
	// 分页 
    $('a.page').click(function(){
        var page =$(this).attr('p');
        $("#page_current").val(page); 
        $("form").submit();
    }); 

 // 上一页
    $('a#page_prev').click(function(){
        var page = $("#page_current").val();
        if(page != parseInt(page) ) {
            $('#page_current').val(1);
            page = 1; 
        }else{
            page = parseInt(page); 
            if(page > 1 ){
                page = page - 1; 
               $('#page_current').val(page);
               $("form").submit();  
            }
        }
    }); 

    // 下一页
    $('a#page_next').click(function(){
        var page = $("#page_current").val();
        page = parseInt(page);
        var page_count = $("#page_count").val(); 
        page_count = parseInt(page_count);
        if(page < page_count ){
            page = page + 1; 
            $("#page_current").val(page);
            $("form").submit(); 
        }
    });

    $('#provinceSel').change(function () {
   	 	province_id = $("#provinceSel").val();
   	 	changeRegion(province_id, $("#citySel"), 2);
   	});
   
   	$('#citySel').change(function () {
   	 	city_id = $("#citySel").val();
   	 	changeRegion(city_id, $("#districtSel"), 3);
   	});

    function changeRegion(parent_id, sel, region_type) {
		var WEB_ROOT = "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>";
		var myurl = WEB_ROOT+"region/cityList?parent_id="+parent_id;
     	$.ajax({
                url: myurl,
                type: 'get',
                dataType: "json", 
                xhrFields: {
                     withCredentials: true
                }
        }).done(function(data){
          	if (data != null && data.data != null) {
          		$(sel).empty();
          		$(sel).append(option);
          		for (var i =0; i < data.data.length; i++) {
          			var region = data.data[i];
          			var option = $("<option>").val(region.region_id).text(region.region_name);
          			$(sel).append(option);
          		}
          		
          		if (region_type == 2) {
	          		city_id = $("#citySel").val();
	    	        changeRegion(city_id, $("#districtSel"));
          		}
          	} else {
          		$(sel).empty();
          		if (region_type == 2) {
	          		$("#districtSel").empty();
          		}
          	}
        });
	}
	$(document).ready(function(){
		
	});
</script>
</body>
</html>
