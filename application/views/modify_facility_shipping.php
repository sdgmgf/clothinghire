<!doctype html>
<html>
<head>
	<title>拼好货WMS</title>
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <style>
    input[type=time]{
        height: 28px;
    }
    .main-table button {
        margin-right: 10px;
    }
    .fgfw{
        float: right;
    }
    </style>
</head>
<body>
<div style="width: 1000px;margin: 0 auto;">
    <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
    <label for="facility_id">仓库：</label>
    <select id="facility_id" name="facility_id">
        <option value="">请选择仓库</option>
    </select>
    <input type="button" id="addShipping" class="btn btn-primary btn-sm add" style="float:right" value="添加快递"/>
	<table	class="table table-striped table-bordered main-table">

		<thead>
            <tr>
                <th>快递名</th>
                <th>状态</th>
                <th>覆盖范围</th>
                <th>起止时间</th>
                <th>最大单量</th>
                <th>操作</th>
            </tr>
        </thead>

        <tbody>
            
        </tbody>
	</table>
</div>


<!-- modal begin  -->
<div class="modal fade" id="add-shipping-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">增加快递方式</h4>
      </div>
      
      <div class="modal-body">
        <div class="container">
            <div class="row col-md-12">
                <div>
                   <h5>  选择快递方式: </h5>
                </div>
                <div >
                    <select   name="shipping_id" id="shippingSel" >
                        
                    </select><br/>
                </div>
                <div>
                   <h5>  选择大区: </h5>
                </div>
                <div class="areaSel">
                <?php 
                    foreach ($area_list as $area) {
                        echo '<label style="min-width:auto;">'.$area['area_name'].'</label> <input type="checkbox" value="'.$area['area_name'].'" style="margin-right:20px;" data-areaId = '.$area["area_id"].' >';
                    }
                ?>
                </div>
                <div class="col">
                    <div>账号：</div>
                    <input  type="text" id="user" name="user" >
                    <div>密码：</div>
                    <input  type="password" id="password" name="password" >
                    <div>月结账号(仅顺丰必填)：</div>
                    <input  type="text" id="account" name="account" >
                </div> 
                <div class="col">
                    <div></div>
                    <input type="checkbox" onclick="if(this.checked) $('#password').attr('type','text'); else $('#password').attr('type','password');">显示密码
                    <div></div>
                    <input type="button" id="checkUser" name="checkUser" value="检验账号">
                </div>
            </div>
            
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="add_facility_shipping" data-dismiss="modal">确定</button>
      </div>
    </div>
  </div>
</div>
<!-- modal end  -->

<!-- modal begin  -->
<div class="modal fade" id="modify-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">修改</h4>
      </div>
      
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="modify-button" onclick="onSave()">确定</button>
      </div>
    </div>
  </div>
</div>
<!-- modal end  -->

<!-- 修改覆盖范围modal begin  -->
<div class="modal fade" id="fgfw-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">修改</h4>
      </div>
      <div class="modal-body">
        <div class="row" style="width:80%;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="fgfw-button">确定</button>
      </div>
    </div>
  </div>
</div>
<!-- modal end  -->

<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript">
var WEB_ROOT = "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>";
var Facility_id = "<?php if(isset($facility_id)) echo $facility_id; ?>";
$(document).ready(function(){
    $("#addShipping").click(function(){
    	$("#add-shipping-modal").modal('show');
    });
    $("#checkUser").click(function(){
        var facility_id = "<?php echo $facility_id;?>";
        var shipping_id = $("#shippingSel").val();
        var user = $("#user").val();
        var password = $("#password").val();
        var sf_account = $("#account").val();
        if(isNullOrEmpty(user) || isNullOrEmpty(password)){
            alert("必须输入账号密码");
            return false;
        }
        if(shipping_id == 44  && isNullOrEmpty(sf_account)){
            alert("顺丰快递需要填写月结账号！");
            return false;
        }
        if(shipping_id == 45  && isNullOrEmpty(sf_account)){
            alert("顺丰航运需要填写月结账号！");
            return false;
        }
        if(shipping_id != null){
            $.ajax({
                url: WEB_ROOT+"modifyFacility/checkUser",
                type: 'POST',
                data : {"facility_id":facility_id,"shipping_id":shipping_id,"user":user,"password":password,"account":sf_account}, 
                dataType: "json", 
                xhrFields: {
                     withCredentials: true
                }
            }).done(function(data){
                  if(data.success == "true"){
                    alert("账号正确.快递单号:"+data.tn);
                  }else{
                      if(data.info != undefined && data.info != null)
                          alert("验证有误: "+data.info);
                      else
                        alert("验证有误");
                  }
            });
        }
    });
    $("#add_facility_shipping").click(function(){
        var facility_id = "<?php echo $facility_id;?>";
        var shipping_id = $("#shippingSel").val();
        var user = $("#user").val();
        var password = $("#password").val();
        var sf_account = $("#account").val();
        var area_ids = [];
        $.each($(".areaSel").find('input[type="checkbox"]').filter(':checked'),function(index,item){
            area_ids.push($(item).attr('data-areaId'));
        })
        if(isNullOrEmpty(user) || isNullOrEmpty(password)){
            alert("必须输入账号密码");
            return false;
        }
        if(shipping_id == 44  && isNullOrEmpty(sf_account)){
            alert("顺丰快递需要填写月结账号！");
            return false;
        }
        
        if(shipping_id != null){
            $("#add_facility_shipping").attr("disabled","disabled");
            $.ajax({
                url: WEB_ROOT+"modifyFacility/addFacilityShipping",
                type: 'POST',
                data : {"facility_id":Facility_id,"shipping_id":shipping_id,"user":user,"password":password,"account":sf_account,"area_ids":area_ids}, 
                dataType: "json", 
                xhrFields: {
                     withCredentials: true
                }
            }).done(function(data){
                  if(data.success == "OK"){
                    alert("添加成功！");
                    window.location.reload();
                  }else{
                    alert(data.error_info);
                  }
                  $("#add_facility_shipping").removeAttr("disabled");
            });
        }
    });  
});

function closeShipping(btn,id){
    $(btn).attr("disabled","disabled");
	$.ajax({
        url: WEB_ROOT+"modifyFacility/closeFacilityShipping",
        type: 'POST',
        data : {"facility_shipping_id":id}, 
        dataType: "json", 
        xhrFields: {
             withCredentials: true
        }
    }).done(function(data){
        // $(btn).attr("disabled",false);
          if(data.success == "OK"){
            getList();
          }else{
            alert(data.error_info);
          }
    });
}
function enableShipping(btn,id){
    $(btn).attr("disabled","disabled");
	$.ajax({
        url: WEB_ROOT+"modifyFacility/enableFacilityShipping",
        type: 'POST',
        data : {"facility_shipping_id":id}, 
        dataType: "json", 
        xhrFields: {
             withCredentials: true
        }
    }).done(function(data){
        // $(btn).attr("disabled",false);
          if(data.success == "OK"){
            getList();
          }else{
            alert(data.error_info);
          }
    });
}
function checkShippingUser(btn, id){
	$(btn).attr("disabled","disabled");
	$.ajax({
        url: WEB_ROOT+"modifyFacility/checkShippingUser",
        type: 'POST',
        data : {"facility_shipping_id":id}, 
        dataType: "json", 
        xhrFields: {
             withCredentials: true
        }
    }).done(function(data){
        $(btn).removeAttr("disabled");
          if(data.success == "true"){
        	  alert("账号正确.快递单号:"+data.tn);
          }else{
              if(data.info != undefined && data.info != null)
            	  alert("验证有误: "+data.info);
              else
            	alert("验证有误");
          }
    });
}
//修改2015-12-15 mhgu
function getFacility() {
        var post = $('#WEB_ROOT').val() + 'Commons/getFacilityList';
        $("#facility_id").html('<option value="">请选择仓库</option>');
        $.ajax({
            type: "post",
            url: post,
            data: {}, // 传入获取到的大区id
            dataType: "json",
            success: function(data) {
                $("#loadding").hide();
                if (data.result == "ok") {
                    for (var n in data.data) {
                        if(data.data[n].facility_id == Facility_id){
                            $("#facility_id").append("<option selected value='" + data.data[n].facility_id + "'>" + data.data[n].facility_name + "</option>");
                        }else{
                            $("#facility_id").append("<option value='" + data.data[n].facility_id + "'>" + data.data[n].facility_name + "</option>");

                        }
                    }
                } else {
                    alert(data.error_info);

                }
            },
            error: function() {
                alert('参数错误');
            }
        });
}
function initTable(data) {
    console.log(data);
    var html = '';
    $.each(data, function(index, elem) {
        html += "<tr><td>" + elem.shipping_name + "</td><td>" + (elem.enable == '1' ? "开启状态" : "关闭状态") + "</td>" + "<td>" + "<span data-shippingId=" + elem.shipping_id + ">" + elem.area_name + "</span>" + "<button class='btn btn-primary btn-sm fgfw'>修改</button>" + "</td>" + "<td>" + elem.start_pickup_time + "-" + elem.end_pickup_time + "</td><td>" + elem.pickup_upper_limit +
            "</td><td data-id=" + elem.facility_shipping_id +"><button class='btn btn-primary btn-sm enable' data-able=" 
            + elem.enable + ">" + (elem.enable == '1' ? "关闭" : "开启") + "</button><button class='btn btn-primary btn-sm check'>检测账号</button><button class='btn btn-primary btn-sm modify' data-id=" + elem.facility_shipping_id + 
            " data-limit="+elem.pickup_upper_limit+" data-start="+elem.start_pickup_time+" data-end="+elem.end_pickup_time+">修改</button></td></tr>";
    });
    $(".main-table tbody").empty().append(html);
    $(".main-table .enable[data-able='1']").on('click', function() {
        closeShipping(this,$(this).parents('td').attr("data-id"));
    });
    $(".main-table .enable[data-able='0']").on('click', function() {
        enableShipping(this,$(this).parents('td').attr("data-id"));
    });
    $(".main-table .check").on('click', function() {
        checkShippingUser(this, $(this).parents('td').attr("data-id"));
    });
    $(".main-table .modify").on('click', function() {
        var facility_shipping_id = $(this).attr("data-id");
        var start_pickup_time = $(this).attr("data-start");
        var end_pickup_time = $(this).attr("data-end");
        var pickup_upper_limit = $(this).attr("data-limit");
        modify(facility_shipping_id,start_pickup_time,end_pickup_time,pickup_upper_limit);
    });
}
//获得列表数据
function getList() {
    var post = $('#WEB_ROOT').val() + 'ModifyFacility/getShipping';
    $.ajax({
        type: "get",
        url: post,
        data: {
            "facility_id": Facility_id
        }, // 传入获取到的大区id
        dataType: "json",
        success: function(data) {
            if (data.result == "ok") {
                initTable(data.facility_shipping_list);
            } else {
                alert(data.error_info);

            }
        },
        error: function() {
            alert('参数错误');
        }
    });
}
function add() {
    var post = $('#WEB_ROOT').val() + 'ModifyFacility/getShippingList';
    $.ajax({
        type: "get",
        url: post,
        dataType: "json",
        success: function(data) {

            if (data.result == "ok") {
                initSelect(data.shipping);
            } else {
                alert(data.error_info);

            }
        },
        error: function() {
            alert('参数错误');
        }
    });   
}
function initSelect (data){
    var html = '';
    $.each(data,function(index,elem){
        html += "<option value="+elem.shipping_id+">"+elem.shipping_name+"</option>";
    });
    $("#shippingSel").empty().append(html);
}
function modify (id,start,end,limit){
    $("#modify-modal").modal("show");
    html = '<label for="start_time">开始时间:</label>';
    html += '<input type="time" name="start_time" id="start_time" required="required" value='+start+'><br />';
    html += '<label for="end_time">结束时间:</label>';
    html += '<input type="time" name="end_time" id="end_time" required="required" value='+end+'><br />';
    html += '<label for="limit">最大单量:</label>';
    html += '<input type="text" name="limit" id="limit" required="required" value='+limit+'>';
    html += '<input type="hidden" name="f-id" id="f-id" required="required" value='+id+'>';
    $("#modify-modal .modal-body").empty().append(html);
    // $("#modify-button").on("click",function(){
    //     onSave(id);
    //     console.log(id);
    // });
}
//提交修改数据
function onSave(){
    $("#modify-button").attr("disabled",true);
    var post = $('#WEB_ROOT').val() + 'ModifyFacility/modifyFacilityShippingAbility';
    var number = /^[1-9]\d*$/g;
    if(isNullOrEmpty($("#limit").val())){
        alert("最大单量不能为空");
        $("#modify-button").attr("disabled",false);
        return false;
    }
    if(!number.test($("#limit").val())){
        alert("最大单量必须是正整数");
        $("#modify-button").attr("disabled",false);
        return false;
    }
    if(isNullOrEmpty($("#start_time").val())){
        alert("起始时间格式错误");
        $("#modify-button").attr("disabled",false);
        return false;
    }
    if(isNullOrEmpty($("#end_time").val())){
        alert("结束时间格式错误");
        $("#modify-button").attr("disabled",false);
        return false;
    }
    var submit_data = {
        'facility_shipping_id' : $("#f-id").val(),
        'start_pickup_time': $("#start_time").val(),
        'end_pickup_time' :  $("#end_time").val(),
        'pickup_upper_limit' : $("#limit").val()
    };
    $.ajax({
        type: "post",
        url: post,
        data: submit_data,
        dataType: "json",
        success: function(data) {
            $("#modify-button").attr("disabled",false);
            if (data.result == "ok") {
                alert("成功");
                $("#modify-modal").modal("hide");
                getList();
            } else {
                alert(data.error_info);

            }
        },
        error: function() {
            alert('参数错误');
        }
    });
}
function isNullOrEmpty(strVal) {
    if (strVal == '' || strVal == null || strVal == undefined) {
        return true;
    } else {
        return false;
    }
}
function isTime(str) {
    var a = str.match(/^(\d{1,2})(:)?(\d{1,2})\2(\d{1,2})$/);
    if (a == null) {
        return false;
    }
    if (a[1] >= 24 || a[3] >= 60 || a[4] >= 60) {
        return false;
    }
    return true;
}
$(function() {
    getFacility();

    if (Facility_id != '') {
        getList();
    }
    $("#facility_id").on("change", function() {
        Facility_id = $(this).val();
        getList();
    });
    $('.add').on("click",function(){
        add();
    });
});

var table_tr_index,shipping_id;
$(".main-table").on('click','.fgfw',function(){
    $("#fgfw-modal .modal-body .row").empty();
    var obj = $(this);
    table_tr_index = obj.parent().parent().index() + 1;
    shipping_id = obj.siblings('span').attr('data-shippingId');
    $.ajax({
        type: "get",
        url: $('#WEB_ROOT').val() + 'ModifyFacility/getFacilityShippingCoverageArea',
        data: {
            "facility_id": Facility_id,
            "shipping_id": shipping_id
        },
        dataType: "json",
        success: function(data) {
            if (data.result == "ok") {
                var html = '';
                var arr_select = [];
                $.each(data.area_list,function(index,item){
                    html += '<label>' + item.area_name + '</label> <input type="checkbox" value=' + item.area_name + ' data-areaId=' + item.area_id + ' />';
                    if (item.is_coverage=='1') {
                        arr_select.push(item.area_name);
                    };
                })
                $("#fgfw-modal .modal-body .row").append(html);
                $("#fgfw-modal").find("input[type='checkbox']").prop('checked',false);
                for (var i = 0; i < arr_select.length; i++) {
                    $("#fgfw-modal").find("input[value=" + arr_select[i] + "]").prop('checked',true);
                };
                $("#fgfw-modal").modal("show");
            } else {
                alert(data.error_info);
            }
        },
        error: function() {
            alert('参数错误');
        }
    });
})

$("#fgfw-button").on('click',function(){
    var checkedInput = $("#fgfw-modal").find("input[type='checkbox']:checked");
    var check_area = '';
    var area_ids = [];
    for (var i = 0; i < checkedInput.length; i++) {
        check_area += $(checkedInput[i]).val() + ',';
        area_ids.push($(checkedInput[i]).attr('data-areaId'));
        
    };
    check_area = check_area.substring(0,check_area.length-1);
    if (!area_ids.length) {
        alert('至少选中一项');
        return false;
    };
    console.log(area_ids);
    $.ajax({
        type: "POST",
        url: $('#WEB_ROOT').val() + 'ModifyFacility/addFacilityShippingCoverageArea',
        data: {
            "facility_id": Facility_id,
            "shipping_id": shipping_id,
            "area_ids": area_ids
        },
        dataType: "json",
        success: function(data) {
            if (data.result == "ok") {
                alert('修改成功');
                $(".main-table").find('tr').eq(table_tr_index).find('td').eq(2).find('span').text(check_area);
                $("#fgfw-modal").modal("hide");
                location.reload();
            } else {
                alert(data.error_info);
            }
        },
        error: function() {
            alert('参数错误');
        }
    });
})
    
</script>
</body>
</html>
