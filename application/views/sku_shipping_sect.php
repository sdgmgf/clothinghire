<table id="list" class="table table-striped table-bordered ">
	<tr>
		<td width="20%">所属店铺</td>
		<td width="30%">商品名称</td>
		<td width="40%">快递列表</td>
		<td width="10%">操作</td>
	</tr>
		<?php
		if (isset( $sku_shipping ) && $sku_shipping != null) {
			foreach ( $sku_shipping as $record ) {
				echo "<tr>";
				echo "<td>" . $record ['merchant_name'] . "</td>";
				echo "<td>" . $record ['product_name'] . "</td>";
				echo "<td>" . $record ['shippings'] . "</td>";
				echo "<td>";
				echo "<a style='float: left;' class='btn btn-primary btn-sm' target='_blank' href='{$WEB_ROOT}skuShipping/skuShippingDetail?facility_id={$facility['facility_id']}&product_id={$record['product_id']}'>详情</a>";
				echo "</td>";
				echo "</tr>";
			}
		}
		?>
	</table>