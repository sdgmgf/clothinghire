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
.panel { min-width: 1300px; }
.list_wrap { }
.list_wrap .list_item { line-height: 28px; }
.list_wrap .list_item table {  width: 1200px; }
.list_wrap .list_item table th { text-align: center;  }
.list_wrap .list_item table td { width: 160px; box-sizing: border-box; overflow: hidden; height: 32px; text-align: center; border:1px solid;}
</style>
</head>
<body>
    <div class="panel panel-primary">
        <div class="panel-heading" style="text-align:center; "><span><?php echo $region_name; ?>地区</span>运费列表</div>
        <div class="panel-body" style="text-align:center;">
            <ul class="list-inline list_wrap">
                <li class="list_item" >
                    <table class="list-inline">
                        <thead>
                            <th>发货仓库</th>
                            <th>快递方式</th>
                            <th>首重</th>
                            <th>首重快递费</th>
                            <th>续重快递费</th>
                            <th>规则</th>
                            <th>到达地址</th>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($data as $v){
                            ?>
                            <tr>
                            <td><span><?php echo $v['facility_name']?></span></td>
                            <td><span><?php echo $v['shipping_name']; ?></span></td>
                            <td><span><?php echo $v['first_weight']; ?></span></td>
                            <td><span><?php echo $v['first_fee']; ?></span></td>
                            <td><span><?php echo $v['continued_fee']; ?></span></td>
                            <td><span><?php echo $v['rule_name']; ?></span></td>
                            <td><span><?php echo $v['region_name']; ?></span></td>
                            </tr>
                           <?php } ?>
                        </tbody>
                    </table>
                </li>
            </ul>
        </div>
    </div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="http://cdn.bootcss.com/jquery.form/3.51/jquery.form.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
</body>
</html>