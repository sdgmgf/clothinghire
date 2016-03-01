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
            <input type="hidden" id="WEB_ROOT" name="WEB_ROOT" <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?>>
            <div id="list">
                <table id="list" class="table table-striped table-bordered ">
                    <thead>
                        <tr>
                            <td width="10%">仓库</td>
                            <td width="10%">快递</td>
                            <td width="10%">覆盖省份</td>
                            <td width="30%">覆盖城市</td>
                            <td width="30%">覆盖区县</td>
                            <td width="10%">操作</td>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal -->
        <div>
            <div class="modal fade ui-draggable" id="region_modal" role="dialog">
                <div class="modal-dialog" style="width: 1200px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" id="btnClose" data-dismiss="modal"aria-label="Close">
                                <span aria-hidden="true">
                                    &times;
                                </span>
                            </button>
                            <h4 class="modal-title" id="region_title" name="region_title">
                            </h4>
                        </div>
                        <input type="hidden" id="facility_id" name="facility_id">
                        <input type="hidden" id="shipping_id" name="shipping_id">
                        <div class="modal-body ">
                            <table id="district_info_table" name="district_info_table" border=3>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <input id="package_sub" type="button" class="btn btn-primary" style="text-align: right" value="保存" onclick="onSave()">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal end -->
        <script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js">
        </script>
        <script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js">
        </script>
        <script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js">
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                tableData();
            }); // end document ready function 
            function tableData() {
                var url = $('#WEB_ROOT').val() + 'FacilityInCityCoverage/getFacilityInCityCoverage';
                $.ajax({
                    url: url,
                    type: "post",
                    dataType: "json"
                }).done(function(data) {
                    $('#tableBody').html('');
                    var facilitys = data.list;
                    for (var facility_id in facilitys) { //仓库
                        var tr = $("<tr>");
                        var facilityName = facilitys[facility_id].facility_name;
                        var shippings = facilitys[facility_id].shippings;
                        var facilityLen = facilitys[facility_id].length;
                        var facilityTd = $("<td>");
                        facilityTd.attr('rowspan', facilityLen);
                        facilityTd.html(facilityName);
                        $(tr).append(facilityTd);

                        var is_firstShipping = 1;
                        for (var shipping_id in shippings) { //快递
                            var is_firstProvince = 1;
                            var is_firstProvinceCity = 1;
                            var shippingName = shippings[shipping_id].shipping_name;
                            var shippingLen = shippings[shipping_id].length
                            var provinces = shippings[shipping_id].provinces;
                            if (!is_firstShipping) {
                                var tr = $("<tr class='shipping'>");
                            }
                            is_firstShipping = 0;
                            var shippingTd = $("<td>");
                            var operateTd = $("<td rowspan=" + shippingLen + "><a class='btn btn-primary btn-sm' target='_blank' href='javascript:;' onclick='onEdit(" + facility_id + "," + shipping_id + ",\"" + facilityName + "\")'>修改</a></td>");
                            shippingTd.attr('rowspan', shippings[shipping_id].length);
                            shippingTd.html(shippingName);
                            $(tr).append(shippingTd);
                            if (provinces.length !== 0) {
                                for (var province_id in provinces) { //省份
                                    var provinceName = provinces[province_id].province_name;
                                    var citys = provinces[province_id].citys;
                                    var provinceLen = provinces[province_id].length
                                    if (!is_firstProvince) {
                                        var tr = $("<tr>");
                                    }
                                    var is_firstProvince = 0;
                                    var provinceTd = $("<td>");
                                    provinceTd.attr('rowspan', provinceLen);
                                    provinceTd.html(provinceName);
                                    $(tr).append(provinceTd);
                                    var is_firstCity = 1;

                                    for (var city_id in citys) { //城市
                                        var cityName = citys[city_id].city_name;
                                        var cityLen = citys[city_id].length;
                                        var districts = citys[city_id].districts;
                                        if (!is_firstCity) {
                                            var tr = $("<tr>");
                                        }
                                        is_firstCity = 0;
                                        var cityTd = $("<td>");
                                        cityTd.attr('rowspan', cityLen);
                                        cityTd.html(cityName);
                                        $(tr).append(cityTd);

                                        var districtData = "";
                                        for (var district_id in data.list[facility_id].shippings[shipping_id].provinces[province_id].citys[city_id].districts) { //区县
                                            var districtName = data.list[facility_id].shippings[shipping_id].provinces[province_id].citys[city_id].districts[district_id].district_name;
                                            districtData += districtName + " ";
                                        }
                                        var districtTd = $("<td>");
                                        districtTd.append(districtData);
                                        $(tr).append(districtTd);
                                        if (is_firstProvinceCity) {
                                            $(tr).append(operateTd);
                                        }
                                        is_firstProvinceCity = 0;
                                        $("#tableBody").append(tr);
                                    }
                                }
                            } else {
                                tr.append("<td></td><td></td><td>");
                                tr.append(operateTd);
                                $("#tableBody").append(tr);
                            }
                        }
                    }

                }).fail(function() {
                    console.log("error");
                });
            }
            function onEdit(facility_id, shipping_id, title_name) {
                $('#district_info_table tr.content').remove();
                var submit_data = {
                    "facility_id": facility_id,
                    "shipping_id": shipping_id
                };
                $("#facility_id").val(facility_id);
                $("#shipping_id").val(shipping_id);
                $("#region_title").text(title_name + '覆盖区域设置');
                $("#district_info_table").empty();
                $("#district_info_table").append("<tr><th id='province_title' style='width: 10%'>省</th><th id='city_title' style='width: 10%'>市</th><th id='district_title' style='width: 80%'>区县</th></tr>");

                var postUrl = $("#WEB_ROOT").val() + 'facilityInCityCoverage/availble';
                $.ajax({
                    url: postUrl,
                    type: 'POST',
                    data: submit_data,
                    dataType: "json",
                    xhrFields: {
                        withCredentials: true
                    }
                }).done(function(data) {
                    var shipping_name = data.shipping_name;
                    for (var province_id in data.provinces) {
                        var is_first = 1;
                        var province_name = data.provinces[province_id].province_name;
                        var tr = $("<tr>");
                        var td = $("<td>");
                        td.attr('rowspan', data.provinces[province_id].length);
                        var label = $("<label>");
                        var input = $("<input>");
                        input.attr('type', 'checkbox');
                        input.attr('value', province_id);
                        input.attr('class', 'province');
                        label.append(input);
                        label.append(province_name);
                        td.append(label);
                        tr.append(td);
                        for (var city_id in data.provinces[province_id].citys) {
                            var city_name = data.provinces[province_id].citys[city_id].city_name;
                            if (!is_first) {
                                var tr = $("<tr>");
                            }
                            var td = $("<td>");
                            var label = $("<label>");
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
                            for (var district_id in data.provinces[province_id].citys[city_id].districts) {
                                var district_name = data.provinces[province_id].citys[city_id].districts[district_id].district_name;
                                var is_already_set = data.provinces[province_id].citys[city_id].districts[district_id].is_already_set;
                                var label = $("<label>");
                                var input = $("<input>");
                                input.attr('type', 'checkbox');
                                input.attr('value', district_id);
                                input.attr('class', 'district');
                                input.attr('data-parentID', city_id);
                                input.attr('data-rootID', province_id);
                                if (is_already_set == 1) {
                                    input.attr('checked', 'checked');
                                }
                                label.append(input);
                                label.append(district_name);
                                td.append(label);
                            }
                            tr.append(td);
                            $("#district_info_table").append(tr);
                            is_first = 0;
                        }
                    }
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
                        $(this).on('change',function() {
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
                        $(this).on('change',function() {
                            if ($(this).prop("checked") == true) {
                                var parentID = $(this).val();
                                $("input[data-parentID=" + parentID + "]").each(function() {
                                    $(this).prop("checked", true);
                                });
                            } else {
                                var parentID = $(this).val();
                                $("input[data-parentID=" + parentID + "]").each(function() {
                                    $(this).prop("checked", false);
                                });
                            }
                        });
                    });

                    $("input.district").on("change",function() {
                        if ($(this).parents("td").find("input.district").length == $(this).parents("td").find("input.district:checked").length) {
                            $("input[value=" + $(this).attr('data-parentID') + "]").prop("checked", true);
                        } else {
                            $("input[value=" + $(this).attr('data-parentID') + "]").prop("checked", false);
                        }
                    });

                    $("input.city").on("change",function() {
                        var dataP = $(this).attr("data-parentID");
                        if ($(this).parents("tbody").find("input.city[data-parentID=" + dataP + "]").length == $(this).parents("tbody").find("input.city[data-parentID=" + dataP + "]:checked").length) {
                            $("input[value=" + $(this).attr('data-parentID') + "]").prop("checked", true);
                        } else {
                            $("input[value=" + $(this).attr('data-parentID') + "]").prop("checked", false);
                        }
                    });
                }).error(function() {
                    console.log("error");
                });
            }
            function onSave() {
                var facility_id = $("#facility_id").val();
                var shipping_id = $("#shipping_id").val();
                var districts = [];
                $("input.district").each(function() {
                    if ($(this).prop("checked")) {
                        if (parseInt($(this).val()) > 0) {
                            districts.push($(this).val());
                        }
                    };
                });
                var submit_data = {
                    "facility_id": facility_id,
                    "shipping_id": shipping_id,
                    "district_ids": districts
                };

                var postUrl = $("#WEB_ROOT").val() + 'facilityInCityCoverage/add';
                $.ajax({
                    url: postUrl,
                    type: 'POST',
                    data: submit_data,
                    dataType: "json",
                    xhrFields: {
                        withCredentials: true
                    }
                }).done(function(data) {
                    if (data.result == "ok") {
                        alert("保存成功。");
                        location.reload();
                    } else {
                        alert("保存失败。" + data.error_info);
                    }
                }).fail(function(data) {
                    console.log(data);
                });
            }
        </script>
    </body>

</html>