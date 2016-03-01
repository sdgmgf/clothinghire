<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
    
    <style type="text/css">

      .currentPage{
       font-weight: bold;
       font-size: 120%; 
       }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            font-size: 12px padding:0;
        }
        
        .page {page-break-after:always;}
        /*table{ font-size: 10px;padding:0;}*/
        /*@media print {
            .raw {
                display: none;
            }
        }*/
        @media print {.printNot {display: none;}}
    </style>
    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
</head>
<!-- onload="window.print()" -->
<body >
    <div id="loadding"><img src="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/img/loadding.gif"></div>

	<div class="left-top" style="position:relative;font-size:10pt;top:10px;left:0px;text-align:center;border-right:0px;border-bottom:0px;">
		<h3>生成批次号：<span id='production_batch_sn'></span>仓库：<span id='facility_name'></span></h3>
	</div>

    <!-- <div style="position:absolute;top:160px;left:10px;width:400px;border:0px;" > -->
    <div style="position:relative;left:0px;border:0px;" class='main-div'>   
    </div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/js/initpbtable.js"></script>
<script>
    var WEB_ROOT = "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>";
    var submit_data = {"production_batch_id":"<?php if(isset($production_batch_id)) echo $production_batch_id; ?>"};
    function getData(){
        var postUrl = WEB_ROOT+"ProductionBatchList/getPickUpRawMaterialAndSupplies";
        
        $.ajax({
            url: postUrl,
            type: 'GET',
            data: submit_data,
            dataType: "json",
            xhrFields: {
                withCredentials: true
            }
        }).done(function(data) {

            console.log(data);
            $("#loadding").remove();
            if (data.result == "ok") {
                var html = '';
                var rawHtml = initRawTable(data.raw_material_detail);
                $(".main-div").append(rawHtml);

                var RawTotalHtml = initRawTotalTable(data.raw_material_summary);
                $(".main-div").append(RawTotalHtml);

                $(".main-div").append("<div class='page'></div>");

//                 var ConsumableHtml = initConsumableTable(data.supplies_detail);
//                 $(".main-div").append(ConsumableHtml);
                
                var ConsumableTotalHtml = initConsumableTotalTable(data.supplies_summary);
                $(".main-div").append(ConsumableTotalHtml);

                $("#production_batch_sn").html(data.production_batch_sn);
                $("#facility_name").html(data.facility_name);
                $('td').css({"padding":'0',"word-break":"break-all","word-wrap":"break-word"});

//                $("table:not(.raw)").addClass('printNot');
                window.print();
            } else {
                alert("失败。" + data.error_info);
            }
            
        });
    }
    $(function(){
        getData();
    });
</script>
</body>
</html>
