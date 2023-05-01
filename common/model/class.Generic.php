<?php

class Generic {

	public function __construct ($iditem = '') {

		if (Auth::is_logged()) {
			
			if ($iditem) {
				
				$query = "SELECT * FROM ".$this->table." WHERE id = '".$iditem."' AND status != 'D'";
				
				$result = ejecuta($query);
				
				if ($row = mysqli_fetch_array($result)) {
					
					foreach ($row as $a => $b) {
						$this->$a = $b;
					}
				}
				
				$result->free ();
			}
		}
	}

	public function getList ($order = '1', $sort = 'ASC') {
		
		$query = "SELECT * FROM ".$this->table." WHERE status != 'D' ORDER BY ".$order." ".$sort;
		$result = ejecuta($query);
		
		$items = array();
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($items, $row);
		}
		return $items;
	}

	public function Count () {

		$query = "SELECT count(id) num FROM ".$this->table." WHERE status != 'D'";
		$result = ejecuta($query);
		
		if ($row = mysqli_fetch_assoc($result)) {
			return $row['num'];
		}
	}

	public function getCombo ($name, $value, $visiblefield = 'name') {

		$out .= '<select class="form-control" name="'.$name.'" id="'.$name.'" >';
		
		$out .= '<option value=""> -- Seleccione una opción </option>';
		
		$query = "SELECT id, ".$visiblefield." FROM ".$this->table." WHERE status != 'D' ORDER BY ".$visiblefield;
		$result = ejecuta($query);
		
		while ($row = mysqli_fetch_array($result)) {
			
			$out .= '<option value="'.$row['id'].'" '.($value == $row['id'] ? ' selected ' : '').'>'.$row[$visiblefield].'</option>';
		}
		
		$out .= '</select>';
		
		return $out;
	}

	public function getValue ($value, $visiblefield = 'name') {

		$query = "SELECT id, ".$visiblefield." FROM ".$this->table." WHERE id = '".$value."' AND status != 'D'";
		$result = ejecuta($query);
		
		if ($row = mysqli_fetch_array($result)) {
			
			$out .= $row[$visiblefield];
		}
		
		return $out;
	}		
	
	public function Delete ($iditem){
		
		delete($this->table, array('id'=>$iditem));
		
		echo '<script type="text/javascript"> jQuery(document).ready(function() { deleted(); });</script>';
	}
}