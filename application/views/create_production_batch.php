<!doctype html>
<html>

<head>
    <title>Production Batch</title>
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
        label {
            text-align: left;
            display:inline;
        }
        .all-title {
            font-size: 16px;
            position: relative;
        }
        .red {
            color:red;
        }
        .green {
            color:green;
        }
        .blue {
            color:blue;
        }
        .grey {
            color:grey;
        }
        .top-title label {
            font-size: 16px;
            font-weight: bold;
        }
        tr a {
            font-size: 14px;
            font-weight: bolder;
        }
        
    </style>
</head>
<body>
<div id="loadding" class="loadding"><img src="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/img/loadding.gif"></div>
<div class="container-fluid" style="margin-left: -18px;padding-left: 19px;" >
    <div role="tabpanel" class="row tab-product-list tabpanel" >
        <div class="col-md-10">
            <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
            <form style="width:100%;" method="post" >
            <label for="facility_id">仓库：</label>
            <select id="facility_id" name="facility_id">
            </select>
            <button type="button" class="btn btn-primary btn-sm" id="query" style="margin-left:20%">搜索 </button>
            </form>
            
             <p>提醒：1.点击每个商品，波次类型对应的数字可进行相应的省市区的操作</p>
             <p>提醒：2.点击每个商品，波次类型对应的数字前的选择框表示全选</p>
             <table class="table table-striped table-bordered main-table">
                <thead>
                    
                </thead>
                <tbody></tbody>
            </table>
            <input id="sub" type="button" class="btn btn-primary" style="text-align: right;float:right;display:none;" value="提交" onclick="onSubmit()">
        </div>
    </div>
</div>

    <!-- Modal -->
<div>
    <div class="modal fade ui-draggable" id="region_modal" role="dialog"  >
      <div class="modal-dialog" style="width: 700px">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="region_title" name="region_title"></h4>
          </div>
          <input type="hidden" id="production_batch_type" name="production_batch_type">
          <input type="hidden" id="product_id" name="product_id">
          <input type="hidden" id="product_name" name="product_name">
          <input type="hidden" id="production_batch_type_name" name="production_batch_type_name">

          <div class="modal-body ">
                <table id="district_info_table" name="district_info_table" border=3 width="100%">
                    
                </table>
          </div>
        <div class="modal-footer">
            <input id="package_sub" type="button" class="btn btn-primary" style="text-align: right;" value="保存" onclick="onSave()">
          </div>
        </div>
      </div>
    </div>
</div>
<!-- modal end  -->
    <script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
    <script type="text/javascript">
    //返回的结果，全局
    var list = [];
    //检测是否是周末
    var is_weekend = '0';
    $.ajax({
        url: $('#WEB_ROOT').val() + 'Commons/getWeekend',
        type: "get",
        dataType: "json",
        success: function(data){
            if (!data.error_info) {
                is_weekend = data.is_weekend;
            }else{
                console.log(data.error_info);
            }
        }
    })
    //获得仓库

    function getFacility() {
        postFacility = $('#WEB_ROOT').val() + 'Commons/getFacilityList';
        $.ajax({
            type: "post",
            url: postFacility,
            data: {}, // 传入获取到的大区id
            dataType: "json",
            success: function(data) {
                
                if (data.result == "ok") {
                    for (var n in data.data) {
                        if (data.data[n].facility_id) {
                            $("#facility_id").append("<option value='" + data.data[n].facility_id + "'>" + data.data[n].facility_name + "</option>");
                        }
                    }
                    $("#query").trigger('click');
                } else {
                    alert(data.error_info);

                }
            },
            error: function() {
                alert('参数错误');
            }
        });
    }
    //初始化，根据仓库获得波次信息
    $(function() {
        getFacility();
        $("#query").on("click", function() {
            $(this).attr("disabled",true);
            list = [];
            $("#sub").hide();
            var url = $('#WEB_ROOT').val() + 'CreateProductionBatch/getPickUpProductList';

            $(".main-table tbody").empty();
            $(".main-table thead").empty();
            $(".main-table thead").append('<tr><th>PRODUCT_ID</th><th class="all-title">商品</th></tr>');

            $.ajax({
                type: "post",
                url: url,
                data: {
                    "facility_id": $("#facility_id").val()
                },
                dataType: "json",
                success: function(data) {
                    $("#loadding").hide();
                    $("#query").attr("disabled",false);
                    console.log(data);
                    //生成第一个表格（main）
                    if (data.result == "ok") {
                        if (data.type_list.length == 0) {
                            alert("该仓库无要创建波次");
                            return false;
                        }
                        initMainTable(data);
                        allSelectMain();
                        cellOperation();
                    } else {
                        alert("出错啦。" + data.error_info);
                    }
                }
            })
        });
    });
    //详细省市区操作

    function onEdit(facility_id, product_id, production_batch_type, getUrl, product_name, production_batch_type_name) {
        $('#district_info_table tr.content').remove();
        var submit_data = {
            "facility_id": facility_id,
            "product_id": product_id,
            "production_batch_type": production_batch_type
        };
        var district_ids = [];
        $("#product_id").val(product_id);
        $("#product_name").val(product_name);
        $("#production_batch_type").val(production_batch_type);
        $("#production_batch_type_name").val(production_batch_type_name);
        $("#region_title").text(product_name + production_batch_type_name + '区域选择');
        $("#district_info_table").empty();
        $("#district_info_table").append("<tr><th id='province_title' style='width: 20%'>省</th><th id='city_title' style='width: 30%'>市</th><th id='district_title' style='width: 50%'>区（数量）</th></tr>");
        $.each(list, function() {
            if ($(this)[0].product_id == product_id && $(this)[0].production_batch_type == production_batch_type) {
                district_ids = $(this)[0].district_ids;
            }
        });

        var postUrl = $("#WEB_ROOT").val() + getUrl;
        $.ajax({
            url: postUrl,
            type: 'POST',
            data: submit_data,
            dataType: "json",
            xhrFields: {
                withCredentials: true
            }
        }).done(function(data) {

            if (data.result == 'ok') {
                data = data.list.provinces;


                if (data.length == 0) {
                    $('#region_modal').modal('hide');
                    return false;
                }
                $('#region_modal').modal('show');
                console.log(data);
                for (var province_id in data) {
                    var is_first = 1;
                    var province_name = data[province_id].province_name;
                    var tr = $("<tr>");
                    var td = $("<td>");
                    td.attr('rowspan', data[province_id].length);

                    var label = $("<label>");
                    label.css('min-width', '15.7%');
                    var input = $("<input>");
                    input.attr('type', 'checkbox');
                    input.attr('value', province_id);
                    input.attr('class', 'province');
                    label.append(input);
                    label.append(province_name);
                    td.append(label);
                    tr.append(td);
                    for (var city_id in data[province_id].citys) {
                        var city_name = data[province_id].citys[city_id].city_name;
                        if (!is_first) {
                            var tr = $("<tr>");
                        }
                        var td = $("<td>");
                        var label = $("<label>");
                        label.css('min-width', '15.7%');
                        var input = $("<input>");
                        input.attr('type', 'checkbox');
                        input.attr('value', city_id);
                        input.attr('class', 'city');
                        input.attr('data-parentID', province_id);
                        input.attr('data-rootID', province_id);
                        label.append(input);
                        label.append(city_name);
                        td.append(label);
                        tr.append(td);

                        var td = $("<td>");
                        for (var district_id in data[province_id].citys[city_id].districts) {
                            var district_name = data[province_id].citys[city_id].districts[district_id].district_name;
                            var num = '(' + '<span>' + data[province_id].citys[city_id].districts[district_id].num + '</span>' + ')';
                            var is_already_set = data[province_id].citys[city_id].districts[district_id].is_already_set;
                            var label = $("<label>");
                            label.css('min-width', '15.7%');
                            label.css('text-align', 'left');
                            var input = $("<input>");
                            input.attr('type', 'checkbox');
                            input.attr('value', district_id);
                            input.attr('class', 'district');
                            input.attr('data-parentID', city_id);
                            input.attr('data-rootID', province_id);
                            if (district_ids.indexOf(input.val()) != -1) {
                                input.attr('checked', 'checked');
                            }
                            label.append(input);
                            label.append(district_name);
                            label.append(num);
                            td.append(label);
                        }
                        tr.append(td);

                        $("#district_info_table").append(tr);
                        is_first = 0;
                    }
                }
                // 
                allSelectModel();

                function allSelectModel() {
                    //所有全选效果
                    $("input.city").each(function() {
                        var length = $(this).parents(td).next('td').find("input.district:checked").length;
                        if ($(this).parents(td).next('td').find("input.district").length == length) {
                            $(this).prop("checked", true);
                        }
                    });
                    $("input.province").each(function() {
                        var val = $(this).attr("value");
                        var length = $(this).parents("tbody").find("input.city[data-parentID=" + val + "]:checked").length;
                        if ($(this).parents("tbody").find("input.city[data-parentID=" + val + "]").length == length) {
                            $(this).prop("checked", true);
                        }
                    });
                    $("#region_modal").modal("show");
                    $("input.province").each(function() {
                        $(this).on('change', function() {
                            if ($(this).prop("checked") == true) {
                                var parentID = $(this).val();
                                $("input[data-rootID=" + parentID + "]").each(function() {
                                    $(this).prop("checked", true);
                                });
                            } else {
                                var parentID = $(this).val();
                                $("input[data-rootID=" + parentID + "]").each(function() {
                                    $(this).prop("checked", false);
                                });
                            }
                        });
                    });
                    $("input.city").each(function() {
                        $(this).on('change', function() {
                            var dataP = $(this).attr("data-parentID");
                            if ($(this).parents("tbody").find("input.city[data-parentID=" + dataP + "]").length == $(this).parents("tbody").find("input.city[data-parentID=" + dataP + "]:checked").length) {
                                $("input.province[value=" + $(this).attr('data-parentID') + "]").prop("checked", true);
                            } else {
                                $("input.province[value=" + $(this).attr('data-parentID') + "]").prop("checked", false);
                            }
                            if ($(this).prop("checked") == true) {
                                var parentID = $(this).val();
                                $("input.district[data-parentID=" + parentID + "]").each(function() {
                                    $(this).prop("checked", true);
                                });
                            } else {
                                var parentID = $(this).val();
                                $("input.district[data-parentID=" + parentID + "]").each(function() {
                                    $(this).prop("checked", false);
                                });
                            }
                        });
                    });

                    $("input.district").on("change", function() {
                        if ($(this).parents("td").find("input.district").length == $(this).parents("td").find("input.district:checked").length) {
                            $("input.city[value=" + $(this).attr('data-parentID') + "]").prop("checked", true);
                        } else {
                            $("input.city[value=" + $(this).attr('data-parentID') + "]").prop("checked", false);
                        }
                        var dataP = $(this).attr("data-rootID");
                        if ($(this).parents("tbody").find("input.city[data-parentID=" + dataP + "]").length == $(this).parents("tbody").find("input.city[data-parentID=" + dataP + "]:checked").length) {
                            $("input.province[value=" + dataP + "]").prop("checked", true);
                        } else {
                            $("input.province[value=" + dataP + "]").prop("checked", false);
                        }
                    });
                }
            } else {
                alert("错误" + data.error_info);
            }

        });
    }
    //保存省市区操作，返回result

    function onSave() {
        var district_ids = [];
        var result = {};
        var num = 0;
        $('.district:checked').each(function(index, elem) {
            district_ids.push($(this).val());
            num += parseInt($(this).siblings('span').html());
        });

        var product_id = $('#product_id').val();
        var production_batch_type = $('#production_batch_type').val();
        var production_batch_type_name = $('#production_batch_type_name').val();
        var product_name = $('#product_name').val();


        result.product_name = product_name;
        result.district_ids = district_ids;
        result.product_id = product_id;
        result.production_batch_type = production_batch_type;
        result.production_batch_type_name = production_batch_type_name;
        result.num = num;
        result.is_all = 0;
        var flag = false;
        $.each(list, function(index, elem) {
            if ($(this)[0].product_id == result.product_id && $(this)[0].production_batch_type == result.production_batch_type) {
                $(this)[0].num = result.num;
                $(this)[0].district_ids = result.district_ids;
                flag = true;
            }
        });
        if (!flag) {
            list.push(result);
        }

        $('#region_modal').modal('hide');
        $('.product').each(function() {
            if ($(this).val() == product_id) {
                $(this).parents('td').siblings('.' + production_batch_type).find("input").prop("checked", false);

            }
        });
        redrawMainTable();
    }
    //展示选择结果的表格

    function redrawMainTable() {
        $(".main-table .num").each(function(index,elem){
            var $this = $(this);
            var flag = false;
            var product_id = $(this).parents('tr').find('input').eq(0).val();
            var production_batch_type = $(this).parents('td').get(0).className;
            $.each(list, function(index, elem) {
                if ($(this)[0].product_id == product_id && $(this)[0].production_batch_type == production_batch_type) {                      
                       $this.html($(this)[0].num);
                       flag = true;
                       return false;
                }
            });
            if(!flag){
                $this.html("0");
            }
        });

        $(".main-table .rowTotal").each(function(index,elem){
            var num = 0 ;
            $(this).parents('tr').find(".num").each(function(index,elem){
                num += parseInt($(this).html());
            });
            $(this).html(num);
        });
        countSum();
    }
    //提交
    function onSubmit() {
        $("#sub").attr("disabled", true);
        var result = {};
        result.list = [];
        result.facility_id = $("#facility_id").val();
        $.each(list, function(index, elem) {
            var temp = {};
            temp.product_id = $(this)[0].product_id;
            temp.production_batch_type = $(this)[0].production_batch_type;
            temp.district_ids = $(this)[0].district_ids;
            temp.is_all = $(this)[0].is_all;
            result.list.push(temp);
        });
        console.log(result);
        $.ajax({
            type: "post",
            url: $('#WEB_ROOT').val() + 'CreateProductionBatch/create',
            data: result,
            dataType: "json",
            success: function(data) {
                $("#sub").attr("disabled", false);
                if (data.result == 'ok') {
                    alert("创建成功");
                    window.location.reload();
                } else {
                    alert(data.error_info);
                }
            }
        }).fail(function(data) {
            console.log(data)
        });
    }

    Array.prototype.remove = function(val) {
        var index = this.indexOf(val);
        if (index > -1) {
            this.splice(index, 1);
        }
    };
    //生成main-table
    function initMainTable(data) {
        var html = "";
        $.each(data.type_list, function(index, elem) {
            if (index == "WEEKEDN_WORK") {
                if (is_weekend == 0) {
                    html += "<th class='top-title blue'><label><input type='checkbox' class='title' value=" + index + " />" + elem + "</label></th>";
                } else {
                    html += "<th class='top-title grey'><label><input type='checkbox' class='title' disabled value=" + index + " />" + elem + "</label></th>";
                }
            } else if (index.indexOf("HISTORY")!=-1) {
                html += "<th class='top-title red'><label><input type='checkbox' class='title' value=" + index + " />" + elem + "</label></th>";
            } else if (index.indexOf("TODAY")!=-1){
                html += "<th class='top-title green'><label><input type='checkbox' class='title' value=" + index + " />" + elem + "</label></th>";
            } else if(index.indexOf("TOMORROW")!=-1){
                html += "<th class='top-title blue'><label><input type='checkbox' class='title' value=" + index + " />" + elem + "</label></th>";
            }
        });
        html += "<th>汇总</th>";
        $(".main-table .all-title").after(html);
        html = '';
        
        for (var y in data.list) {
            var rowTotal = 0;
            html += "<tr><td>" + data.list[y].product_id + "</td><td><label><input type='checkbox' class='product' value=" + y + ">" + data.list[y].product_name + "</label></td>";
            
            $.each( data.list[y].type,function(index,elem){
                rowTotal += parseInt(elem);
            });
            for (var x in data.type_list) {
                html += "<td class=" + x + "><input type='checkbox' class='content'><a href='javascript:void(0);'></a></td>";
            }
            html += "<td class='lastRow'>"+"<span class='rowTotal'>0</span>/<span class='all'>"+rowTotal+"</span></td>"
            html += "</tr>";
        }
        html += "<tr><td colspan='2'>汇总</td>";
        for (var y in data.type_list) {
            html += "<td class='last'><span class='colTotal'></span>/<span class='colTotalAll'></span></td>";
        }
        html += "<td class='last'>"+"<span class='rowTotal'>0</span>/<span class='all'>"+rowTotal+"</span></td>"
        html += "</tr>";
        $(".main-table tbody").append(html);
        var index = 0;
        for (var y in data.list) {
            for (var z in data.list[y].type) {

                if (z == "WEEKEDN_WORK") {
                    if (is_weekend == 1) {
                        $("td." + z).eq(index).find("input").attr("disabled", true);
                        $("td." + z).eq(index).find("a").addClass('disabled');
                         $("td." + z).eq(index).find("a").addClass('grey');
                    }else{
                         $("td." + z).eq(index).find("a").addClass('blue');
                    }
                   

                } else if (z.indexOf("HISTORY")!=-1 ) {
                    $("td." + z).eq(index).find("a").addClass('red');
                } else if(z.indexOf("TODAY")!=-1 ){
                    $("td." + z).eq(index).find("a").addClass('green');
                } else if(z.indexOf("TOMORROW")!=-1 ){
                    $("td." + z).eq(index).find("a").addClass('blue');
                }
                $("td." + z).eq(index).find("a").html("<span class='num'>0</span>" + "/" +"<span class='all'>" +data.list[y].type[z]+"</span>");
                $("td." + z).eq(index).find("input").val(data.list[y].type[z]);
            }
            index++;
        }
        $('.content').each(function() {
            if ($(this).next('a').html() == '') {
                $(this).remove();
            }
        });
        countSum();
    }
    //全选
    function allSelectMain() {
        $('.main-table .product').on('change', function() {
            if ($(this).prop('checked') == true) {
                $(this).parents('td').siblings(':not(.WEEKEDN_WORK)').find('input').prop('checked', true);
            } else {
                $(this).parents('td').siblings(':not(.WEEKEDN_WORK)').find('input').prop('checked', false);
            }
        });
        $('.main-table .title').on('change', function() {
            var select = '.' + $(this).val();
            if ($(this).prop('checked') == true) {

                $(select).find('input').prop('checked', true);
            } else {
                $(select).find('input').prop('checked', false);
            }
        });
        $(".content").on('change', function() {
            if ($(this).parents('tr').find(".content").length == $(this).parents('tr').find(".content:checked").length) {
                $(this).parents('tr').find(".product").prop("checked", true);
            } else {
                $(this).parents('tr').find(".product").prop("checked", false);
            }
            var className = $(this).parents("td").get(0).className;
            if ($("." + className).find('input').length == $("." + className).find('input:checked').length) {
                $("input[value=" + className + "]").prop("checked", true);
            } else {
                $("input[value=" + className + "]").prop("checked", false);
            }
        });
    }
    //每个单元格的操作
    function cellOperation() {
        //进入省市区
        $('.main-table a:not(".disabled")').on('click', function(event) {
            event.preventDefault();
            var $this = $(this);
            var facility_id = $('#facility_id').val();
            var product_id = $this.parents('tr').find('input').eq(0).val();
            var production_batch_type = $(this).parents('td').get(0).className;
            var getUrl = 'CreateProductionBatch/getPickUpProductDetail';
            var product_name = $this.parents('tr').find('label').eq(0).text();
            var production_batch_type_name = $this.parents('table').find('th').eq($this.parents('td').index()).find('label').text();
            onEdit(facility_id, product_id, production_batch_type, getUrl, product_name, production_batch_type_name);
            return false;
        });
        $('.main-table :checkbox').on("change", function() {
            $.each($(".content:not(:checked)"), function() {
                var product_id = $(this).parents('tr').find('input').eq(0).val();
                var production_batch_type = $(this).parents('td').get(0).className;
                $.each(list, function(index, elem) {
                    if ($(this)[0].product_id == product_id && $(this)[0].production_batch_type == production_batch_type && $(this)[0].is_all == 1) {
                        list.remove($(this)[0]);
                    }
                });
            });
            $.each($(".content:checked"), function() {
                var result = {};
                var product_name = $(this).parents('tr').find('label').eq(0).text();
                var district_ids = [];
                var product_id = $(this).parents('tr').find('input').eq(0).val();
                var production_batch_type = $(this).parents('td').get(0).className;
                var production_batch_type_name = $(this).parents('table').find('th').eq($(this).parents('td').index()).find('label').text();
                var num = $(this).val();
                var is_all = 1;

                result.product_name = product_name;
                result.district_ids = district_ids;
                result.product_id = product_id;
                result.production_batch_type = production_batch_type;
                result.production_batch_type_name = production_batch_type_name;
                result.num = num;
                result.is_all = is_all;
                var flag = false;
                $.each(list, function(index, elem) {
                    if ($(this)[0].product_id == result.product_id && $(this)[0].production_batch_type == result.production_batch_type) {
                        $(this)[0].num = result.num;
                        $(this)[0].district_ids = result.district_ids;
                        $(this)[0].is_all = result.is_all;
                        flag = true;
                    }
                });
                if (!flag) {
                    list.push(result);
                }
            });
            redrawMainTable();
        });
    }
    //计算总和
    function countSum() {
        $('.last').each(function(index,elem){
            $(this).attr("data-type",$('.main-table tr td').get(index+2).className);
        })
        $('.last').each(function(index,elem){
            var num = 0;
            var all = 0;
            if($(this).attr("data-type")!=''){
                $('.'+$(this).attr("data-type")+' .num').each(function(){
                    
                    num +=  parseInt( $(this).html());
               
                });
                $('.'+$(this).attr("data-type")+' .all').each(function(){
                    
                    all +=  parseInt( $(this).html());
               
                });
                $(this).find('.colTotal').html(num);  
                $(this).find('.colTotalAll').html(all);  
            }
            
        });
        var num = 0;
        var all = 0;
        $('[data-type=lastRow]').siblings('.last').each(function(index,elem){
            console.log(parseInt( $(this).find('.colTotalAll').html()));
            num += parseInt( $(this).find('.colTotal').html() );
            all += parseInt( $(this).find('.colTotalAll').html() );
        });

        $('[data-type=lastRow]').find('.rowTotal').html(num);
        $('[data-type=lastRow]').find('.all').html(all);
        
        $("#sub").show();
    }
    
    </script>
</body>
</html>
