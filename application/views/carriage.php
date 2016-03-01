<!doctype html>
<html>
<head>
<meta charset="UTF-8" />
<title>拼好货WMS</title>
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
<style type="text/css">
.table_wrap { max-height: 450px; border: 1px solid #ddd; margin-top: 10px; overflow: auto; }
.table_wrap .operate { font-family: 'MicroSoft YaHei'; }
#list_table { width: 100%; border: none; }
#list_table tr td { border: none; }
#list_table td * { vertical-align: middle; }
#list_table td input[type="checkbox"] { margin-top: 0px; }
#list_table td input[type="radio"] { margin-top: -2px; }
#list_table .line { display: inline-block; height: 18px; width: 2px; background: #999; }
#list_table tfoot input[type="text"] { width: 60px; line-height: 12px; }
#list_table tfoot label { text-align: left; }
.form_wrap { min-width: 1300px; }
.form_wrap .form_item{ width: 24%; box-sizing: bordre-box; }
.form_wrap .form_item input[type="text"] { width: 60px; line-height: 12px; }
</style>
</head>
<body>
	<h3 style="text-align:center;">快递费用</h3>
    <form action="javascript:;" class="form-inline">
		<div class="form-group">
			<label class="control-label">仓库：
				<select name="facility" id="facility" class="form-control input-sm">
                    <option value="">请选择仓库</option>
                    <?php
                        if(isset($facility_list)){
                            foreach ($facility_list as $v) {
                                if(isset($v['facility_id'])) {
                                    if(isset($facility_id) && $v['facility_id']==$facility_id){
                                        echo "<option data-from='".$v['district_id']."' value='".$v['facility_id']."' selected='selected'>".$v['facility_name']."</option>";
                                    }else{
                                        echo "<option data-from='".$v['district_id']."' value='".$v['facility_id']."' >".$v['facility_name']."</option>";
                                    }             
                                } 
                            } 
                        }
                       ?>
				</select>
			</label>
		</div>
		<div class="form-group">
			<label class="control-label">快递：
				<select name="shipping" id="shipping" class="form-control input-sm">
                    <option value="">选择快递方式</option>
				</select>
			</label>
		</div>
        <div class="table_wrap">
            <div class="operate">
                <input type="button" name="all_check" class="btn btn-primary all_check" value="全选" />
                <input type="button" name="reverse_check" class="btn btn-primary reverse_check" value="反选" />
            </div>
            <table class="table table-bordered" id="list_table">
                <tbody>        
                     <?php
                        if(!isset($parent_id)){
                            $flag = true; 
                            foreach ($area_list as $key => $v) {
                                if($flag){
                                    ?>
                                    <input type="hidden" value="<?php if(isset($v[0]['region_type'])) echo $v[0]['region_type'];?>" name="region_type" id="region_type" />
                                    <?php 
                                    $flag = false;
                                }
                                echo '<tr><td>' . $key . '</td></tr>';
                                foreach ($v as $kk => $val) {
                                    if ($kk % 4 == 0) {
                                        echo '<tr>';
                                    }?>
                                <td>
                                    <input type="checkbox" class="list_item" name="region_ids" class="region_ids" value="<?php echo $val['region_id']; ?>">
                                    <span><?php echo $val['region_name'] ?></span> 
                                    <?php if($this->helper->chechActionList(array('editCarriageFreight'))){ ?>
                                    <a href="javascript:;" data-parent_id='<?php echo $val['region_id']; ?>' class="manage">管理</a>
                                    <?php } if($this->helper->chechActionList(array('readCarriageFreight'))){ ?>
                                    <a href="javascript:;" data-region_name='<?php echo $val['region_name']; ?>'data-region_id='<?php echo $val['region_id'] ?>' class="price">运费</a>
                                    <?php }?>
                                </td>
                                <?php
                                if ($kk % 4 == 3)
                                    echo '</tr>';
                            }
                    }
                }else{
                    ?>
                    <input type="hidden" value="<?php if(isset($regions[0]['region_type']))  echo $regions[0]['region_type']; ?>" name="region_type" id="region_type" />
                    <?php 
                    foreach ($regions as $kk => $val) {
                        if ($kk % 4 == 0) {
                            echo '<tr>';
                        }   
                    ?>
                            <td>
                                <input type="checkbox" class="list_item" name="region_ids" class="region_ids" value="<?php echo $val['region_id']; ?>">
                                <span><?php echo $val['region_name'] ?></span> 
                                <a href="javascript:;" data-parent_id='<?php echo $val['region_id'] ?>' class="manage">管理</a>
                                <?php if($this->helper->chechActionList(array('readCarriageFreight'))){ ?>
                                <a href="javascript:;" data-region_name='<?php echo $val['region_name']; ?>'data-region_id='<?php echo $val['region_id'] ?>' class="price">运费</a>
                                <?php }?>
                            </td>
                <?php
                        }
                     }

                ?>
                </tbody>
            </table>
        </div>
        <ul class="form_wrap clearfix list-inline">
            <li class="form_item">
                <label>首重：
                    <input type="text" class="" name="first_weight" id="first_weight" >kg
                </label>
            </li>
            <li class="form_item">
                <label>首重快递费：
                    <input type="text" class="" name="first_fee" id="first_fee" >元
                </label>
            </li>
            <li class="form_item">
                <label>续重快递费：
                    <input type="text" class="" name="continued_fee" id="continued_fee" >元/KG 
                </label>
            </li>
            <li class="form_item">
                <label>续重计算规则：
                    <select name="rule_id" id="rule_id">
                        <?php 
                            foreach($carriage_rule['data'] as $key=>$v){
                                if(empty($v['rule_id']))continue;
                        ?>
                        <option value="<?php echo $v['rule_id']; ?>"><?php echo $v['rule_name'] ?></option>
                        <?php } ?>
                        
                    </select>
                </label>
            </li>
        </ul>
        <div class="text-center">
            <?php if($this->helper->chechActionList(array('editCarriageFreight'))){  ?>
            <input type="submit" value="提交" class="btn btn-primary submit">
            <?php } ?>
            <?php if(isset($parent_id)) { ?>
            <a href="javascript:;" class="btn btn-primary back" style="margin-left: 10px; ">返回上一级</a>
            <?php } ?>
        </div>
    </form>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="http://cdn.bootcss.com/jquery.form/3.51/jquery.form.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script>
$(function(){
    var $table_wrap = $('.table_wrap'),
        $all_check = $('.all_check'),
        $reverse_check = $('.reverse_check'),
        $facility = $('#facility'),
        $shipping = $('#shipping'),
        g_parent_id = "<?php echo !empty($parent_id) ? $parent_id : '' ?>"
        g_facility_id = "<?php echo !empty($facility_id) ? $facility_id : '' ?>"
        g_shipping_id = "<?php echo !empty($shipping_id) ? $shipping_id : '' ?>"

    function getShippingList(facility_id,shipping_id){//初始化快递下拉列表
        if(facility_id==''){
            $shipping.html('<option value="">选择快递方式</option>');
            return;
        }
        $.ajax({
            url:'<?php echo $WEB_ROOT.'addCarriage/getShippings'?>',
            type:'GET',
            data: {
                'facility_id' : facility_id
            },
            xhrFields: {
                withCredentials: true
            },
            dataType:'json',
            success: function(data){
                if(data['error_info']) {
                    alert(data['error_info']);
                    return;
                }
                var data = data.data.facility_shipping_list,
                    str = '<option value="">选择快递方式</option>';

                $.each(data,function(){
                    if(this.shipping_id==shipping_id){
                        str+= '<option value="'+this.shipping_id+'" selected="selected">'+this.shipping_name+'</option>';
                    }else{
                        str+= '<option value="'+this.shipping_id+'">'+this.shipping_name+'</option>';
                    }
                });
                $shipping.html(str);
            },
            error: function(){
                alert('获取快递列表失败');
                return false;
            }
        });
    }

    getShippingList($facility.val(),g_shipping_id);

    $all_check.on('click',function(){//全选
        var $this = $(this);
        $('#list_table').find('.list_item').prop('checked',true);
    });

    $reverse_check.on('click',function(){//反选
        var $this = $(this),
            $checkItem = $('#list_table').find('.list_item').filter(':checked'),
            $notCheckItem = $('#list_table').find('.list_item').not(':checked');
            $notCheckItem.prop('checked',true);
            $checkItem.prop('checked',false);
    });

    $facility.on('change',function(){
        var $this = $(this),
            facility_id = $this.val();
        $shipping.html("<option value=''>选择快递方式</option>");
        getShippingList(facility_id,'');
    });

    $('form').on('click','.submit',function(){
        var facility_id = $.trim($facility.val()),
            shipping_id = $.trim($shipping.val()),
            first_weight = $.trim( $('#first_weight').val() ),
            first_fee = $.trim( $('#first_fee').val() ),            
            continued_fee = $.trim( $('#continued_fee').val() ),
            $facility_id_selected = $facility.find('option:selected'), 
            from_region_id = $facility_id_selected.data('from'), 
            $region_ids = $('#list_table').find('.list_item:checked'),
            region_ids_arr = [],
            region_ids = '',
            rule_id = $.trim($('#rule_id').val()),
            region_type = $('#region_type').val();
           
            data = {};
            
        $region_ids.each(function(){
            region_ids_arr.push($(this).val());
        });   
        region_ids = region_ids_arr.join(',');
        data = {
            'facility_id' : facility_id,
            'shipping_id' : shipping_id,
            'first_fee' : first_fee,
            'first_weight' : first_weight,
            'continued_fee' : continued_fee,
            'from_region_id' : from_region_id,
            'region_ids' : region_ids,
            'rule_id' : rule_id,
            'region_type': region_type
        };
        $.ajax({
            url : '<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>addCarriage/addNewCarriage',
            type : 'POST',
            data : data,
            dataType : 'json',
            xhrFields : {
                withCredentials: true
            },
            success : function(data){
                if(data["error_info"]){
                    alert(data["error_info"]);
                }else{
                    alert("添加成功");
                }
                //window.location.reload();
            },
            error : function(){
                alert('失败');
            }　
        });
    });
    $table_wrap.on('click','.price',function(){
        var region_name = $(this).data('region_name'),
            region_id = $(this).data('region_id'),
            facility_id = $facility.val(),
            shipping_id = $shipping.val();
        if('' == facility_id){
            alert("请选择仓库");
            return ;
        }else if('' == shipping_id){
            alert("请选择快递");
            return ;
        }
        window.open("<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>addCarriage/getCarriageFreight?facility_id="+facility_id+"&shipping_id="+shipping_id+"&region_id="+region_id+"&region_name="+region_name);
    });

    $('.manage').on('click',function(){
        var $this = $(this),
            parent_id = $this.data('parent_id'),
            facility_id = $facility.val(),
            shipping_id = $shipping.val(),
            dataArr = [],
            url = '';

        parent_id && dataArr.push('parent_id='+parent_id);
        facility_id && dataArr.push('facility_id='+facility_id);
        shipping_id && dataArr.push('shipping_id='+shipping_id);
        url = "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>addCarriage/?"+dataArr.join('&');
        window.location.href = url;
    });

    $('.back').on('click',function(){
        var url = "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>addCarriage/?",
            dataArr = [];

        g_parent_id && dataArr.push('parent_id='+g_parent_id);
        g_facility_id && dataArr.push('facility_id='+g_facility_id);
        g_shipping_id && dataArr.push('shipping_id='+g_shipping_id);
        window.location.href = url+dataArr.join('&');
    });
});
</script>
</body>
</html>