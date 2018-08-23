<?PHP

class wmset{


	var $sets = array( array() );

	public function __construct(){
	
		# ��� 1
		$this->sets[1]["min_sum"] = 100;
		$this->sets[1]["desc"] = "�� 100 �� 499 RUB";
		$this->sets[1]["t_a"] = 0;
		$this->sets[1]["t_b"] = 0;
		$this->sets[1]["t_c"] = 0;
		$this->sets[1]["t_d"] = 0;
		$this->sets[1]["t_e"] = 0;
		
		# ��� 2
		$this->sets[2]["min_sum"] = 500;
		$this->sets[2]["desc"] = "�� 500 �� 999 RUB";
		$this->sets[2]["t_a"] = 0;
		$this->sets[2]["t_b"] = 0;
		$this->sets[2]["t_c"] = 0;
		$this->sets[2]["t_d"] = 0;
		$this->sets[2]["t_e"] = 0;
		
		# ��� 3
		$this->sets[3]["min_sum"] = 1000;
		$this->sets[3]["desc"] = "�� 1000 �� 1999 RUB";
		$this->sets[3]["t_a"] = 0;
		$this->sets[3]["t_b"] = 0;
		$this->sets[3]["t_c"] = 0;
		$this->sets[3]["t_d"] = 0;
		$this->sets[3]["t_e"] = 0;
		
		# ��� 4
		$this->sets[4]["min_sum"] = 2000;
		$this->sets[4]["desc"] = "�� 2000 �� 3999 RUB";
		$this->sets[4]["t_a"] = 0;
		$this->sets[4]["t_b"] = 0;
		$this->sets[4]["t_c"] = 0;
		$this->sets[4]["t_d"] = 0;
		$this->sets[4]["t_e"] = 0;
		
		# ��� 5
		$this->sets[5]["min_sum"] = 4000;
		$this->sets[5]["desc"] = "�� 4000 �� 7999 RUB";
		$this->sets[5]["t_a"] = 0;
		$this->sets[5]["t_b"] = 0;
		$this->sets[5]["t_c"] = 0;
		$this->sets[5]["t_d"] = 0;
		$this->sets[5]["t_e"] = 0;
		
		# ��� 6
		$this->sets[6]["min_sum"] = 8000;
		$this->sets[6]["desc"] = "�� 8000 RUB";
		$this->sets[6]["t_a"] = 0;
		$this->sets[6]["t_b"] = 0;
		$this->sets[6]["t_c"] = 0;
		$this->sets[6]["t_d"] = 0;
		$this->sets[6]["t_e"] = 0;
	
	}
	
	
	function SetsList(){
		
		unset($this->sets[0]);
		return $this->sets;
	
	}
	
	
	function GetSet($sum){
		$sum = $sum +1;
		$my_array = array_reverse( $this->SetsList() );
		
		foreach($my_array as $key => $value){
		
			if($sum >= $value["min_sum"]) return $value;
		
		}
		
	}
	
}


?>