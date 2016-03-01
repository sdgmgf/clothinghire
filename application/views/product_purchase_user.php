<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/js/calendar/GooCalendar.css"/> -->
    <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
    
    <style type="text/css">
        tr td.product_cell{
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }
        tr th.product_cell{
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }
        th{
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }
        td{
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }
       .order{
            border: 1px solid gray;
            margin-top:2px;
            margin-bottom: 2px;
       }

       .order_head{
            background-color: #cccccc;
       }

      .currentPage{
           font-weight: bold;
           font-size: 120%; 
       }
    </style>
</head>
<body>  
    <div class="container-fluid" style="margin-left: -18px;padding-left: 19px;" >
        <div role="tabpanel" class="row tab-product-list tabpanel" >
            <div class="col-md-12">
                <!-- Nav tabs -->
                <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="onsale">
                        <!-- product list start -->
                        <div class="row  col-sm-10 ">
                            <div>
                                <h3 style="display:inline-block; margin-right: 40px;"><?php echo $area['area_name']?>商品采购助理</h3>
                                <select name="area" id="area" style="min-width: 100px;">
                                    <option value="">请选择大区</option>
                                </select>
                            </div>
                            <form method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>productPurchaseUser/update">
                            <input type="hidden" id="hidden_product_id" name="hidden_product_id" >
                            <input type="hidden" id="hidden_user_id" name="hidden_user_id" >
                            <input type="hidden" name="hidden_area_id" value="<?php echo $area['area_id']?>" >
                            <table class="table table-striped table-bordered purchase_table">
                                <thead>
                                    <tr>
                                    	<th>RPODUCT_ID</th>
                                        <th>商品</th>
                                        <th width="15%">采购助理</th>
                                        <th width="40%">操作</th>
                                    </tr>
                                </thead>
                                	<?php foreach($product_list as $product){
                                		?>
                            		<tr>
                            			<td><?php echo $product['product_id']?></td>
                            			<td><?php echo $product['product_name']?></td>
                            			<td class="product_cell">
                            				<?php 
                            					if ($product['purchase_user_id']) {
	                            					echo $product['user_name'] . "【{$product['real_name']}】";
                            					} else {
                            						echo "<b style='color:red;'>未设置</b>";
                            					}
                            				?>
                            			</td>
                            			<td>
                            				<select id="product_id<?php echo $product['product_id']?>">
                            					<option value=""></option>
                            					<?php foreach($user_list as $user) {
                            						echo "<option value=\"{$user['user_id']}\" " . ($user['user_id'] == $product['purchase_user_id'] ? " selected=true" : "") .">{$user['user_name']}【{$user['real_name']}】</option>";
                            					}?>
                            				</select>
                            				<button class="btn btn-success" product_id="<?php echo $product['product_id']?>" name="commit" style="margin-left: 50px" >提交</button></td>
                            		</tr>
                                		<?php
                                	}?>
                            </table>
                            </form>
                        </div>
                        <!-- product list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    var current_area_id = '<?php echo $area["area_id"]; ?>';
    console.log(current_area_id);
    getAreaList();
    function getAreaList(){//得到当前用户的area数据
        $('#area').html('');
        $.ajax({
            url : '<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>productPurchaseUser/getAreaList',
            type : 'GET',
            dataType : 'json',
            xhrFields: {
                withCredentials: true
            },
            success : function(data){
                if(data.success == 'success'){
                    var area_list = data.area_list,
                        str = '';
                    $.each(area_list,function(){
                        if(this.area_id == current_area_id){
                            console.log(this.area_id+':'+current_area_id);
                            str += "<option value="+this.area_id+" selected=selected>"+this.area_name+"</option>";
                        }else{
                            str += "<option value="+this.area_id+">"+this.area_name+"</option>";
                        }
                    });
                    $('#area').html(str);
                }else{
                    alert(data['error_info']);
                }
            },
            error : function(){
                //alert('获取大区列表失败');
            }
        });
    }
    $("button[name='commit']").click(function(){
    	var product_id = $(this).attr('product_id');
    	var user_id = $("#product_id" + product_id).val();
    	if (user_id == null || user_id == "") {
    		alert("请选择用户");
    		return false;
    	}
    	$("#hidden_product_id").val(product_id);
    	$("#hidden_user_id").val(user_id);
    	$("#form").submit();
    });

    $('.purchase_table').DataTable({
        language: {
            "url": "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/Chinese.lang"
        },
        paging: false,
        info: false
    });
	
    $('#area').on('change',function(){
        var $this = $(this),
            area_id = $.trim($this.val());
        window.location.href = '<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>productPurchaseUser/?area_id='+area_id;
    });
</script>
</body>
</html>
