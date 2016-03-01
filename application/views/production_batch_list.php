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
        tr {
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }
        tr th{
            text-align: center;
            vertical-align:middle;
            height: 100%;
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
            <div class="col-md-12">
                <!-- Nav tabs -->
                <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
                <!-- Tab panes -->
                <div class="tab-content">
                        <form class="clearfix" style="width:100%;" method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>./productionBatchList">
                         <div style="width:100%;float: left;padding: 0px;">
                               <div style="width:100%;">
                                    <label for="production_batch_date" style=" text-align: right">生产批次日期：</label>
                                    <input style="width:12%" type="text" id="production_batch_date" name="production_batch_date" <?php if(isset($production_batch_date)) echo "value='{$production_batch_date}'"; ?> >
                                    <label for="production_batch_sn" style="width: 10%; text-align: right">生成批次号：</label>
                                    <input type="text" id="production_batch_sn" name="production_batch_sn"  <?php if(isset($production_batch_sn)) echo "value='{$production_batch_sn}'"; ?> >
                                </div> 
                                <div  style="width:100%;">
                    			<label for="status" style="width: 10%; text-align: right">状态：</label>
                    			<select id="status" name="status">
                    				<option value="DOING" <?php if(isset($status) && $status == 'DOING') echo "selected='true'"?>>未完成</option>
                    				<option value="FINISH" <?php if(isset($status) && $status == 'FINISH') echo "selected='true'"?>>完成</option>
                    			</select>
                                <label for="facility_id"  style="width: 10%; text-align: right">仓库：</label>
                                <select id="facility_id" name="facility_id" >
                                <?php foreach ( $facility_list as $facility ) {
                                    if (isset( $facility_id ) && $facility ['facility_id'] == $facility_id) {
                                        echo "<option value=\"{$facility['facility_id']}\" selected='true'>{$facility['facility_name']}</option>";
                                    } else {
                                        echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
                                    }
                                } ?>
                                </select>
                                </div>

                                <div>
                                
                                </div>
                         </div>
                         <div style="width: 100%;float:left;">
                                <div style="width:66%;float:left;text-align: center;">
                                    <button type="button" class="btn btn-primary btn-sm"  id="query"  >搜索 </button> 
                                </div>
                                <!-- 隐藏的 input  start  -->
                                <input type="hidden"  id="page_current" name="page_current" <?php if(isset($page_current)) echo "value={$page_current}"; ?> /> 
                                <input type="hidden"  id="page_count" name="page_count" <?php if(isset($page_count)) echo "value={$page_count}"; ?> />
                                <input type="hidden"  id="page_limit" name="page_limit" <?php if(isset($page_limit)) echo "value={$page_limit}"; ?> /> 
                                <!-- 隐藏的 input  end  -->
                         </div>
                        </form>
                        <!-- list start -->
                        <div class="row col-sm-12 " style="margin-top: 10px;">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                        <th>仓库</th>
                                        <th>生产批次号</th>
                                        <th>生产批次日期</th>
                                        <th>状态</th>
                                        <th>任务单量</th>
                                        <th>已提货单量</th>
                                        <th>状态明细</th>
                                        <th>进度</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                                            
                                <?php if( isset($production_batch_list) && is_array($production_batch_list))  foreach ($production_batch_list as $key => $production_batch) { ?> 
                                <tbody >
                                    <tr>
                                    	<td hidden="true" class="production_batch_id"><?php echo $production_batch['production_batch_id']?></td>
                                        <td><?php echo $production_batch['facility_name'] ?></td>
                                        <td><?php echo $production_batch['production_batch_sn'] ?></td>
                                        <td><?php echo $production_batch['production_batch_date'] ?></td>
                                        <td><?php if($production_batch['status'] == 'DOING') { echo '未完成';} elseif($production_batch['status'] == 'FINISH') { echo '完成';}  ?></td>
                                    	<td><?php echo $production_batch['plan_quantity'] ?></td>
                                        <td><?php echo $production_batch['finish_quantity'] ?></td>
                                        <td>
                                        <?php  if(!empty($production_batch['status_-1'])) echo '待绑定快递:'.$production_batch['status_-1'].'<br>' ?>
                                        <?php  if(!empty($production_batch['status_0'])) echo '待绑定面单:'.$production_batch['status_0'].'<br>' ?>
                                        <?php  if(!empty($production_batch['status_1'])) echo '待产线提货:'.$production_batch['status_1'].'<br>' ?>
                                        <?php  if(!empty($production_batch['status_6'])) echo '待生成批次:'.$production_batch['status_6'].'<br>' ?>
                                        <?php  if(!empty($production_batch['status_4'])) echo '待打印:'.$production_batch['status_4'].'<br>' ?>
                                        <?php  if(!empty($production_batch['status_2'])) echo '待发货:'.$production_batch['status_2'].'<br>' ?>
                                        <?php  if(!empty($production_batch['status_3'])) echo '待生成发运单:'.$production_batch['status_3'].'<br>' ?>
                                        <?php  if(!empty($production_batch['status_5'])) echo '完成:'.$production_batch['status_5'].'<br>' ?>
                                        </td>
                                        <td><a class="btn btn-primary" href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>ProductionBatchProgressDetail?production_batch_id=<?php echo $production_batch['production_batch_id']?>">进度</a></td>
                                    	<td>
                                    	<?php if($production_batch['status'] == 'DOING') {?>
                                    	<a class="btn btn-primary" style="display:none;"  href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>ProductionItemList?production_batch_id=<?php echo $production_batch['production_batch_id']?>">提货</a>
                                    	<a class="btn btn-primary" href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>ProductionBatchList/doPrint2?production_batch_id=<?php echo $production_batch['production_batch_id']?>">打印</a>
                                    	<?php }?>
                                    	</td>
                                    </tr>
                                </tbody>
                                  <tr colspan="7" style="height: 13px;">
                                  </tr>
                                <?php } ?>

                            </table>
                                    <div class="row">
                                            <nav style="float: right;margin-top: -7px;">
                                                <ul class="pagination">
                                                    <li>
                                                        <a href="#"   id="page_prev">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </a>
                                                    </li>
                                                    <?php if(isset($page)) echo $page; ?>
                                                    <li>
                                                        <a href="#" id="page_next" >
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </a>
                                                    </li>
                                                    <li><a href='#'>
                                                     <?php if(isset($page_count)) echo "共{$page_count}页 &nbsp;"; 
                                                          if(isset($record_total))  echo  "共{$record_total}条记录"; 
                                                     ?>
                                                     </a></li>
                                                </ul>
                                            </nav>
                                    </div>
                        </div>
                        <!--  list end -->
                </div>
            </div>
    </div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    (function(config){
        config['extendDrag'] = true; // 注意，此配置参数只能在这里使用全局配置，在调用窗口的传参数使用无效
        config['lock'] = true;
        config['fixed'] = true;
        config['okVal'] = 'Ok';
        config['format'] = 'yyyy-MM-dd';
    })($.calendar.setting);

    $("#production_batch_date").calendar({btnBar:true});
}) ;

 $("#query").click(function(){
     $("#page_current").val("1");
     $("form").submit();
 }); 
 Date.prototype.diff = function(date){
	  return (this.getTime() - date.getTime())/(24 * 60 * 60 * 1000);
	}
	
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

$("button#toggleShow").click(function(){
    $("div#searchDiv").toggle(); 
});

</script>
</body>
</html>