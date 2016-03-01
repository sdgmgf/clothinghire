<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    
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
					 <audio id="audio" src="../assets/ao.mp3" ></audio>
                     <label for="receive_name" class="col-sm-2 control-label">扫描快递面单：</label>
                     <div class="col-md-2">
						<input type="text" name="tracking_number" id="tracking_number" class="form-control">
					</div>
                     
                </div>
            </div>
        </div>
    </div>
    <label name="pre_tracking_number" id="pre_tracking_number"  style="color:red"></label>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
	
    $('#tracking_number').bind('keyup', listen_tracking_number).focus();
	var audio = document.getElementById("audio");
	audio.play();
	audio.pause();
});

var KEY = {
    RETURN: 13,  // 回车
    CTRL: 17,    // CTRL
    TAB: 9
};

function listen_tracking_number(event) {
    switch (event.keyCode) {
        case KEY.RETURN:
            load_tracking_number();
            event.preventDefault();
            break;
    }
}

function play_audio_on_wrong_tracking_number() {
	var audio = document.getElementById("audio");
	audio.play();
	window.setTimeout("audio.pause()",1000);
}

function load_tracking_number() {
    var tracking_number = $.trim($('#tracking_number').val());

    if (tracking_number == '') {
	    play_audio_on_wrong_tracking_number();
        alert('快递面单号为空！');
        return; 
    }
    
    $('#tracking_number').attr("readOnly", true);
    addTrackingNumber(tracking_number);
}
function addTrackingNumber(tracking_number) {
	var myurl = $("#WEB_ROOT").val()+"shipmentShipping/validatePrint?tracking_number="+tracking_number;
	var tracking_number = $.trim($('#tracking_number').val()); 
     $.ajax({
                url: myurl,
                type: 'get',
                dataType: "json", 
                xhrFields: {
                     withCredentials: true
                }
          }).done(function(data){
          	if (data != null ) {
          		if(data.result == 'ok'){
          			location.href = $("#WEB_ROOT").val()+"shipmentShipping/doPrint?shipment_id="+data.order.shipment_id;
//          			console.log('ok');
//          			doPrint(tracking_number, data.order.shipment_id);
          		}else{
					play_audio_on_wrong_tracking_number();
          			console.log('error');
          			$('#tracking_number').val('');
          			$('#pre_tracking_number').html("快递面单号:"+tracking_number+data.error_info);
          			alert("快递面单号验证失败:"+tracking_number+data.error_info);
          			$('#tracking_number').removeAttr("readOnly");
          		}
          	} else {
				play_audio_on_wrong_tracking_number();
          		$('#tracking_number').val('');
          		$('#pre_tracking_number').html("快递面单号扫描出库失败"+tracking_number);
          		alert("快递面单号扫描出库失败"+tracking_number);
          		$('#tracking_number').removeAttr("readOnly");
          	}
          });
}

/*
function doPrint(tracking_number, shipment_id) {
	var myurl = $("#WEB_ROOT").val()+"shipmentShipping/doPrint?shipment_id="+shipment_id;
	console.log(myurl);
	  $.ajax({
                url: myurl,
                type: 'get',
                dataType: "json", 
                xhrFields: {
                     withCredentials: true
                }
          }).done(function(data){
          	console.log(data);
          	if (data != null ) {
          		if(data.result == 'ok'){
          			$('#tracking_number').val('');
          			$('#tracking_number').removeAttr("readOnly");
          		}else{
					play_audio_on_wrong_tracking_number();
          			console.log('error');
          			$('#tracking_number').val('');
          			$('#pre_tracking_number').html("快递面单号:"+tracking_number+data.error_info);
          			alert("快递面单号:"+tracking_number+data.error_info);
          			$('#tracking_number').removeAttr("readOnly");
          		}
          	} else {
				play_audio_on_wrong_tracking_number();
          		$('#tracking_number').val('');
          		$('#pre_tracking_number').html("快递面单号扫描出库失败"+tracking_number);
          		alert("快递面单号扫描出库失败"+tracking_number);
          		$('#tracking_number').removeAttr("readOnly");
          	}
          });
}
*/
</script>
</body>
</html>
