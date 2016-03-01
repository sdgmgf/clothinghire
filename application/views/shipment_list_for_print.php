<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/data_item.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
    
    <style type="text/css">
        tr td.product_cell{
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }
       .data_item{
            bdata_item: 1px solid gray;
            margin-top:2px;
            margin-bottom: 2px;
       }

       .data_item_head{
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
            <div class="col-md-12">
                <!-- Nav tabs -->
                <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
                <!-- Tab panes -->
                        <form style="width:100%;" method="post"   action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>shipmentList">
                         <div style="width:30%;float: left;padding: 0px;">
                           
                           <div style="width: 100%;">
                                 <label for="facility_id"  style="width: 40%;">仓库：</label>
                                <select  style="width: 50%;"   name="facility_id" id="facility_id">
                                <?php foreach ($facility_list as $facility) {
                            			if(isset($facility_id) && $facility['facility_id'] ==$facility_id) {
                                			echo "<option value=\"{$facility['facility_id']}\" selected='true'>{$facility['facility_name']}</option>";
                            			} else {
                            				echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
                            			}
                            		}?>
                                </select>
                            </div>
                         </div>
                        
                         <div style="width: 100%;float:left;">
                                <div style="width:66%;float:left;text-align: center;">
                                	<input type="hidden" name="act" id="act">
                                    <button type="button" class="btn btn-primary btn-sm"  id="query"  >搜索 </button> 
                                    &nbsp;&nbsp;<button type="button" class="btn btn-primary btn-sm"  id="download"  >导出 </button> 
                                </div>
                                <!-- 隐藏的 input  start  -->
                                <input type="hidden"  id="page_current" name="page_current"   <?php if(isset($page_current)) echo "value={$page_current}"; ?> /> 
                                <input type="hidden"  id="page_count" name="page_count"   <?php if(isset($page_count)) echo "value={$page_count}"; ?> />
                                <input type="hidden"  id="page_limit" name="page_limit" <?php if(isset($page_limit)) echo "value={$page_limit}"; ?> /> 
                         </div>
                        </form>

                        <div class="row  col-sm-5 " style="margin-top: 10px;">
                            <table class="table table-striped table-bdata_itemed ">
                                <thead>
                                    <tr>
                                        <th style="width:20%;">快递</th>
                                        <th style="width:20%;" >快递单号</th>
                                        <th style="width:10%;">仓库</th>
                                        <th style="width:15%;">打印时间</th>
                                        <th style="width:15%;">打印人 </th>
                                    </tr>
                                </thead>
                                                            
                                <?php if( isset($data_list) && is_array($data_list))  foreach ($data_list as $key => $data_item) { ?> 
                                <tbody >
                                    <tr>
                                        <td class="product_cell">
                                            <?php echo $data_item['shipping_name'] ?>
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $data_item['tracking_number'] ?>  
                                        </td>
                                         <td class="product_cell">
                                             <?php echo $data_item['facility_name'] ?>  
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $data_item['print_time'] ?>  
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $data_item['user_name'] ?>
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
        config['format'] = 'yyyy-MM-dd HH:mm:ss';
    })($.calendar.setting);

    $("#start_time").calendar({btnBar:true,
                   minDate:'2015-05-01', 
                   maxDate:'2022-05-01'});
    $("#end_time").calendar({btnBar:true,
                   minDate:'2015-05-01', 
                   maxDate:'2022-05-01'});
});
  // 是查询 还是 下载 excel 
      // 
     $("#query").click(function(){
         $("#page_current").val("1");
         $("form").submit();
     }); 
     
      // 点击下载 excel 按钮 
     $('#download').click(function(){
        $("#act").val("download");
        $("form").submit();
        $("#act").val("query");
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
</script>
</body>
</html>