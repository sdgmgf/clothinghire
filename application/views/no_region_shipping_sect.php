<table id="list" class="table table-striped table-bordered ">
	<tr>
		<td width="10%">仓库名称</td>
		<td width="10%">PRODUCT_ID</td>
		<td width="40%">商品名称</td>
		<td width="20%">市</td>
		<td width="20%">区</td>
	</tr>
		<?php
		if (isset( $list ) && $list != null) {
			foreach ( $list as $record ) {
				echo "<tr>";
				echo "<td>" . $record ['facility_name'] . "</td>";
				echo "<td>" . $record ['product_id'] . "</td>";
				echo "<td>" . $record ['product_name'] . "</td>";
				echo "<td>" . $record ['city_name'] . "</td>";
				echo "<td>" . $record ['district_name'] . "</td>";
				echo "</tr>";
			}
		}
		?>
	</table>