<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
    
    <style type="text/css">
        tr td.product_cell{
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
    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
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

                        <form style="width:100%;" method="get"  action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>./BatchPrintList/printBatchPickBySN">

                         <div style="width:100%;float: left;padding: 0px;">
                               <div style="width:100%;">
                                         <label for="batch_pick_sn"  style="width: 40%;">批次号：</label>
                                            <input type="text"  id="batch_pick_sn" name="batch_pick_sn" 
                                             <?php if(isset($batch_pick_sn))  echo "value={$batch_pick_sn}"; ?> >
                                             
                                             <button type="button" class="btn btn-primary btn-sm"  id="query"  >打印</button> 
                                </div> 
                         </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>

<script type="text/javascript">
	$("#batch_pick_sn").focus();
      // 
     $("#query").click(function(){
         var batch_pick_sn = $("#batch_pick_sn").val();
         if($.trim(batch_pick_sn) == '' )
         {
             alert("请扫描批次");
             return;
         }
		postBatchPickSN(batch_pick_sn);
     }); 

     // 把数据提交到后台 
     function postBatchPickSN(batch_pick_sn){
            var myurl = $("#WEB_ROOT").val()+"batchPickPrint/queryStatus";
            var mydata = {
                        "batch_pick_sn":batch_pick_sn
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
                if(data['status'] == 'PRINTED'){
               	 	if(confirm("已打印，是否再次打印？")){ $("form").submit(); }else{  }
                } else if(data['status'] == 'INIT') {
                	$("form").submit(); 
                } else if(data['status'] == 'FINISH') {
                    alert('批次已发货');
                } else {
                	alert(data['status']);
                }
            });
     }
</script>
</body>
</html>