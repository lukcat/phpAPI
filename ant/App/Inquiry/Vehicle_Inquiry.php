<?php

namespace App\Inquiry;

use Common\Response as Response;

class Vehicle_Inquiry {
	function getVehicleInfo($vehicle_id, $connect) {
		$table = 'vehicle';
		$field = "'vehicle_type', 'owner_id', 'owner', 'owner_phone', 'start_year'";
		$condition = "where vehicle_id = {$vehicle_id}";
		$sql = "select {$field} from {$table} {$condition}";
		
		if (!$result = mysql_query($sql, $connect)) {
			Response::show(801,'Vehicle_Inquiry: query database error');
		}

		if ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$data = array(
				'vehicle_type' => $row['vehicle_type'],
				'owner_id' => $row['owner_id'],
				'owner' => $row['owner_phone'],
				'owner_phone' => $row['owner_phone'],
				'start_year' => $row['start_year']
			);
			
			Response::show(800, 'query data exist', $data);
		} else {
			Response::show(802, 'query data do not exist');
		}
	}
}

