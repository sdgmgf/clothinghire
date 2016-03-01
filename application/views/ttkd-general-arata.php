<!doctype html>
<html>
<head>
    <title>天天快递</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <style type="text/css">
        *{
            margin: 0;
            padding: 0;
            font-family: "microsoft yahei","sans-sarif";
            list-style: none;
        }
        .bold{
            font-weight: bold;
        }
        .temp{
            width: 98mm;
            height: 178mm;
            border: 1mm solid #000;
        }
        .logo{
            display: inline-block;
            width: 26mm;
            height: 6mm;
            margin: 1mm 2mm;
        }
        .logoName{
            float: right;
            font-size: 12pt;
            line-height: 9mm;
            width: 24mm;
        }
        .datoubi{
            height: 13mm;
            line-height: 13mm;
            font-size: 32pt;
        }
        .packPlace{
            width: 73.6mm;
            height: 10mm;
            line-height: 10mm;
            font-size: 16pt;
            display: inline-block;
            border-right:1px solid #000;
        }
        .packnoPlace{
            width: 22mm;
            height: 10mm;
            line-height: 10mm;
            font-size: 16pt;
            display: inline-block;
        }
        .qr_s{
            width: 22mm;
            height: 5mm;
            margin: 2.5mm 1mm;
            float: right;
        }
        td{
            border: 1px solid #000;
        }
        .tdReceive{
            width: 5mm;
            height: 18mm;
            font-size: 8pt;
            text-align: center;
        }
        .tdPalce{
            width: 69mm;
            font-size: 8pt;
            padding-left: 2px;
        }
        .serviveDtl{
            font-size: 5pt;
            width: 24mm;
        }
        .serviveDtl h6{
            text-align: center;
            background: #eee;
            font-size: 6pt;
            line-height: 5mm;
            border-bottom: 1px solid #000;

        }
        .serviveDtl li{
            width: 24mm;
        }
        .tdPost{
            width: 5mm;
            height: 12mm;
            font-size: 8pt;
            text-align: center;
        }
        .qr_b{
            display: block;
            width: 70mm;
            height: 25mm;
            margin: 0 auto;
        }
        .signInfo{
            width: 98mm;
            height: 19mm;
        }
        .pInfo{
            width: 44mm;
            height: 19mm;
            font-size: 6pt;
        }
        .sign{
            width: 35mm;
            font-size: 8pt;
            padding-left:4px;
        }
        .sign label{
            display: block;
        }
        .qr_m{
            width: 16mm;
            height: 16mm;
        }
        .logo2{
            display: inline-block;
            width: 25mm;
            height: 6mm;
        }
        .qr_xm{
            width: 40mm;
            height: 11mm;
            margin: 0 14mm -2mm;
        }
        .custom{
            height: 28mm;
            position: relative;
        }
        .custom span{
            position: absolute;
            right: 1mm;
            bottom: 1mm;
            font-size: 8pt;
        }
        .border-bottom{
            border-bottom: 1px solid #000;
        }
    </style>
</head>
<body>
<div class="temp">
    <span class="logo"></span>
    <h4 class="logoName">天天快递</h4>
    <div class="border-bottom"></div>
    <h1 class="datoubi bold"><?php  echo $order['station_no']; ?></h1>
    <div class="border-bottom"></div>
    <h2 class="packPlace"><?php  echo $order['package']; ?></h2>
    <h2 class="packnoPlace"><?php  echo $order['package_no']; ?></h2>
    <table border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="tdReceive">收件</td>
            <td class="tdPalce bold"><?php  echo $order['consignee'];?>   <?php echo $order['mobile']; echo $order['tel']; ?><br><?php if($order['province']) echo "[{$order['province']}]";if($order['city']) echo "[{$order['city']}]";if($order['district']) echo "[{$order['district']}]";echo $order['address'];?></td>
            <td class="serviveDtl" rowspan="2" style="vertical-align: top;"><h6>服务</h6>
                <ul>

                </ul>
            </td>
        </tr>
        <tr>
            <td class="tdPost">寄件</td>
            <td class="tdPalce"><?php echo $arata['ztoSender']; ?>    <?php echo $order['c_tel']; ?><br><?php echo $order['company_address']; ?></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center">
                <img src="<?php echo $codeImg;?>" alt="" style="width:70mm; height:18mm;  margin: 0.5mm 0 -1.5mm 0;" >
                <span style="width:70mm; text-align: center; letter-spacing:10px;"><?php echo $arata['tracking_number']; ?></span>
            </td>
        </tr>
    </table>
    <table class="signInfo" border="0" cellspacing="0" cellpadding="0">

        <tr>
            <td class="pInfo">快件送达收件人地址，经收件人货收件人（寄件人）允许的代收人签字，视为送达。您的签字代表您已验收包裹，并确认商品信息无误，包装完好、没有划痕、破损等表面质量问题。</td>
            <td class="sign">
                <label for="receiver">签收人： <span></span></label>
                <label for="time">时间： <span></span></label>
            </td>
            <td style="text-align:center;">
            <?php  if($arata['ztoSender'] == '拼好货商城') { ?>
		    <img src="assets/img/Shop2DBarcodes/1953.png" style="margin-top:2px;" width="70px" height="70px">
		    <?php  } else { ?>
		    <span style="display:inline-block; margin-top:2px;" width="70px" height="70px"></span>
		    <?php } ?>
            </td>
        </tr>
        </talbe>
        <table style="height:14mm;">
            <tr style="height:14mm;">
                <td style="border:0px;"><span class="logo2"></span></td>
                <td style="border:0px; text-align: center;"><img src="<?php echo $codeImg2; ?>" alt="" class="qr_xm">
                    <span style="text-align: center; letter-spacing:1px; font-size:8pt"><?php echo $arata['tracking_number']; ?></span></td>
            </tr>
        </table>

        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td class="tdPost">收件</td>
                <td class="tdPalce"><?php  echo $order['consignee'];   echo $order['mobile']; echo $order['tel']; ?><br><?php if($order['province']) echo "[{$order['province']}]";if($order['city']) echo "[{$order['city']}]";if($order['district']) echo "[{$order['district']}]";echo $order['address'];?></td>
                <td class="serviveDtl" rowspan="2">
                </td>
            </tr>
            <tr>
                <td class="tdPost">寄件</td>
                <td class="tdPalce"><?php echo $arata['ztoSender']; ?>    <?php echo $order['c_tel']; ?><br><?php echo $order['company_address']; ?></td>
            </tr>
            <tr>
                <td colspan="3" class="custom">
                    <span class="bold">已验视</span>
                </td>
            </tr>
        </table>
</div>
</body>
</html>