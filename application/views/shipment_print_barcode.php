<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <style type="text/css">
    </style>
    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
</head>
<body>  
  
  <form style="width:100%;" method="post" 
                                action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>./doPrint">
    <div class="container-fluid" style="margin-left: -18px;padding-left: 19px;" >
        <div role="tabpanel" class="row tab-product-list tabpanel" >
            <div class="col-md-12">
                <!-- Nav tabs -->
                <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
                <!-- Tab panes -->
                <div class="tab-content">
                     <label for="receive_name" class="col-sm-2 control-label">扫描商品条码：</label>
                     <div class="col-md-2">
						<input type="text" name="product_code" id="product_code" class="form-control">
					</div>
                     
                </div>
            </div>
        </div>
    </div>
   </form>
   

<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
	
    $('#product_code').bind('keyup', listen_product_code).focus();
    var error_info = "<?php echo isset($error_info) ? $error_info:"";?>";
    if(error_info!=""){
    	alert(error_info);
    }
});

var KEY = {
//    RETURN: 13,  // 回车
    CTRL: 17,    // CTRL
    TAB: 9
};

function listen_product_code(event) {
//	alert(event.keyCode);
    switch (event.keyCode) {
        case KEY.RETURN:
        case KEY.CTRL:
            load_product_code();
            event.preventDefault();
            break;
    }
}

function load_product_code() {
	alert('test');
    var product_code = $.trim($('#product_code').val());
    if (product_code == '') {
        alert('快递面单号为空！');
        return; 
    }
//    $('#product_code').val('');
     $("form").submit();
}

</script>
</body>
</html>
