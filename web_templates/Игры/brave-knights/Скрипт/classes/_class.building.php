<?PHP

class building
{


	function __construct($db)
	{
		$this->db = $db;
		$this->CheckTime();
	}

	// описание ошибок
	function GetError($name)
	{
		switch ($name)
		{
			case 'not_resource':
				return "<center><font color = 'red'><b>Недостаточно ресурсов для строительства!</b></font></center><BR />";
			break;

			case 'not_money':
				return "<center><font color = 'red'><b>Недостаточно средств для строительства!</b></font></center><BR />";
			break;

			case 'err_drop':
				return "Ошибка списания средств";
			break;

			case 'not_add':
				return "Ошибка добавления в очередь на строительство";
			break;

			case 'not_exs':
				return "Данной категории не существует";
			break;


			case 'finish':
				return "<center><font color = '#914A1F'><b>Вы успешно оплатили строительство!</b></font></center><BR />";
			break;

			case 'finishb':
				return "<center><font color = '#914A1F'><b>Оплата прошла успешно!</b></font></center><BR />";
			break;

			default:
				# code...
			break;
		}
	}
//*************************************************************************************
//									ТУТ НАСТРОЙКИ ВСЯКИЕ							  *
//*************************************************************************************
	public function getTimeDie()
	{
		return 60*60*24*30*12; // 12 месяцев
	}


	// список ресурсов по категориям
	private function GetResourceList()
	{
		$arr = array();
		$arr["stroy"] = array("money_b","f_b", "h_b", "i_b");
		$arr["smesi"] = array("d_b", "e_b");
		return $arr;
	}

	// список Автомобилей
	private function GetBuildingList()
	{
		$arr = array();
		$arr[] = "k_t";
		$arr[] = "l_t";
                $arr[] = "m_t";
		$arr[] = "n_t";
                $arr[] = "o_t";
		$arr[] = "p_t";
                $arr[] = "q_t";
                $arr[] = "r_t";
		$arr[] = "s_t";
                $arr[] = "t_t";
		return $arr;
	}


	// наименования всего и вся для сборки
	public function GetNames($name)
	{
		switch ($name)
		{

			// деревья
			case 'a_t':
				return "Земля";
			break;

			// материалы


			case 'money_b':
				return "Стоимость";
			break;

                        case 'f_b':
				return "Кирпичи";
			break;

                        case 'h_b':
				return "Доски";
			break;

                        case 'i_b':
				return "Сталь";
			break;


			// здания

                        case 'k_t':
				return "Хранилище";
                        break;

			case 'l_t':
				return "Мельница";
			break;

			case 'm_t':
				return "Кирпичный завод";
                        break;

                        case 'n_t':
				return "Пилорама";
			break;

                        case 'o_t':
				return "Литейный завод";
			break;

			case 'p_t':
				return "Колбасный цех";
			break;

                        case 'q_t':
				return "Загоны";
			break;

			case 'r_t':
				return "Пекарня";
                        break;

                        case 's_t':
				return "Пивоварня";
			break;

			case 't_t':
				return "Шашлычная";
			break;


			// если не задано,
			// возвращает то что передано
			default:
				return $name;
			break;
		}
	}

	// время постройки
	public function GetTimeBuilding($name)
	{
		switch ($name)
		{
			case 'k_t':
				return 60*60*12;
			break;

			case 'l_t':
				return 60*60*24;
			break;

                        case 'm_t':
				return 60*60*24;
			break;

                        case 'n_t':
				return 60*60*24;
			break;

			case 'o_t':
				return 60*60*24;
			break;

                        case 'p_t':
				return 60*60*24;
			break;

                        case 'r_t':
				return 60*60*24;
			break;

                        case 'q_t':
				return 60*60*24;
			break;

			case 's_t':
				return 60*60*24;
			break;

                        case 't_t':
				return 60*60*24;
			break;

                        case 'i_t':
				return 60*60*24;
			break;

			// по умолчанию 24 часа
			// если не задано что-то конкретное
			default:
				return 60*60*24;
			break;
		}
	}

	// необходимые ресурсы для постройки
	// а также цены на всё, в том числе на ресурсы.
	public function GetPriceAndResource($name)
	{
		$data = array();

		switch ($name)
		{

			case 'b_b':
				$data['price']=10;
			break;


			case 'c_b':
				$data['price']=20;
			break;

			case 'd_b':
				$data['price']=150;
			break;

			case 'e_b':
				$data['price']=120;
			break;

                        case 'f_b':
				$data['price']=120;
			break;

			case 'k_t':
				$data['price'] = 0;

                                
                                $data['h_b'] = 3000;
                                
                                $data['plod'] = 3;
                                $data['level'] = 1;
			break;

			case 'l_t':
				$data['price'] = 0;
				$data['plod'] = 7;

                                $data['f_b'] = 2000;
                                $data['h_b'] = 2000;
                                $data['i_b'] = 1000;
				$data['level'] = 5;
			break;


                        case 'm_t':
				$data['price'] = 0;
				$data['plod'] = 11;

                                $data['f_b'] = 2000;
                                $data['h_b'] = 2000;
                                $data['i_b'] = 1000;
                                $data['level'] = 5;
			break;
                        case 'n_t':
				$data['price'] = 0;
				$data['plod'] = 15;

                                $data['f_b'] = 2000;
                                $data['h_b'] = 2000;
                                $data['i_b'] = 1000;
                                $data['level'] = 10;
			break;

                        case 'o_t':
				$data['price'] = 0;
				$data['plod'] = 19;

                                $data['f_b'] = 2000;
                                $data['h_b'] = 2000;
                                $data['i_b'] = 1000;
                                $data['level'] = 10;
			break;

                        case 'p_t':
				$data['price'] = 0;
				$data['plod'] = 31;

                                $data['f_b'] = 3000;
                                $data['h_b'] = 2000;
                                $data['i_b'] = 2000;
                                $data['level'] = 40;
			break;


                        case 'q_t':
				$data['price'] = 0;
				$data['plod'] = 47;

                                
                                $data['h_b'] = 3000;
                                
                                $data['level'] = 20;
			break;

                        case 'r_t':
				$data['price'] = 0;
				

                                $data['f_b'] = 3000;
                                $data['h_b'] = 2000;
                                $data['i_b'] = 1000;
                                $data['level'] = 20;
			break;

                        case 's_t':
				$data['price'] = 0;
				$data['plod'] = 88;

                                $data['f_b'] = 3000;
                                $data['h_b'] = 2000;
                                $data['i_b'] = 1000;
                                $data['level'] = 20;
			break;

                        case 't_t':
				$data['price'] = 0;
				$data['plod'] = 103;

                                $data['f_b'] = 3000;
                                $data['h_b'] = 2000;
                                $data['i_b'] = 2000;
                                $data['level'] = 30;
			break;

                                
		}
		return $data;
	}

//*************************************************************************************
//								ТУТ НАСТРОЙКИ ЗАКАНЧИВАЮТСЯ							  *
// лучше дальше ничего не крутить ^_^
//*************************************************************************************

	public function IsBuild($user_id, $name)
	{
		$db = $this->db;
		$data = $this->GetPriceAndResource($name);
		foreach ($data as $key => $value)
		{
			if (($key=="price") or ($key=="plod") or ($key=="level")) continue;
			$db->query("select `$key` from `db_users_b` where `id`=$user_id");
			$row = $db->FetchArray();
			if ($row[0]<$value) return 0;
		}
		return $this->IsNotHas($user_id, $name);
		//return 1;
	}

	public function IsBuyResource($user_id, $name, $cnt=1)
	{
		$db = $this->db;
		$data = $this->GetPriceAndResource($name);
		$price = (int)$data['price']*(int)$cnt;
		$db->query("select `money_b` from `db_users_b` where `id`=$user_id");
		$row = $db->FetchArray();
		if ($row[0]<$price) return 0;
		return 1;
	}


	public function IsNotHas($user_id, $name)
	{
		$db = $this->db;
		$db->query("select `$name` from `db_users_b` where `id`=$user_id");
		$row = $db->FetchArray();
		if ($row[0]>0)
			return 0;
		$db->query("select count(`id`) from `db_building` where `status`=0 and `id_user`=$user_id and `name_tree`='$name'");
		$row = $db->FetchArray();
		if ($row[0]>0)
			return 0;
		return 1;
	}

	public function IsBuy($user_id, $name)
	{
		if ($this->IsBuyResource($user_id, $name)==1)
		{
			return $this->IsNotHas($user_id, $name);
		}
		return 0;
	}


	private function DropResources($user_id, $name)
	{
		$db = $this->db;
		$data = $this->GetPriceAndResource($name);
		foreach ($data as $key => $value)
		{
			if (($key=="price") or ($key=="plod") or ($key=="level")) continue;
			if (!$db->query("update `db_users_b` set `$key`=`$key`-$value where `id`=$user_id"))
				return $this->GetError('err_drop');
		}
		return 1;
	}

	private function DropMoney($user_id, $name, $cnt=1)
	{
		$db = $this->db;
		$data = $this->GetPriceAndResource($name);
		$price = (int)$data['price']*(int)$cnt;
		if ($db->query("update `db_users_b` set `money_b`=`money_b`-$price  where `id`=$user_id")) return 1;
		return 0;
	}

	private function DoBuyResource($user_id, $name, $cnt=1)
	{
		$db = $this->db;
		if ($this->DropMoney($user_id,$name,$cnt))
		{
			$sql = "update `db_users_b` set `$name`=`$name`+$cnt  where `id`=$user_id";
			if ($db->Query($sql)) return $this->GetError('finishb');
			return $this->GetError('not_add');
		}
		return $this->GetError('err_drop');
	}



	private function DoBuy($user_id, $name)
	{
		return $this->DoBuyResource($user_id, $name);
	}

	private function DoBuild($user_id, $name,$time)
	{
		$db = $this->db;
		$drop = $this->DropResources($user_id, $name);
		if ($drop!=1) return $drop;
		if ($drop==1)
		{
			$now = time();
			if ($time==0)
				$add = $now + $this->GetTimeBuilding($name);
			else
				$add = $now + $time;

			$sql = "insert into `db_building`
				(`id_user`, `name_tree`, `build_start`, `build_end`, `status`)
				values
				($user_id, '$name', $now, $add, 0)";
			$db->Query($sql);
			$lid = $db->LastInsert();
			$add = $add + $this->getTimeDie();
			$sql = "insert into `db_building`
				(`id_user`, `name_tree`, `build_start`, `build_end`, `status`)
				values
				($user_id, '$name', $now, $add, 2)";
			$db->Query($sql);
			if ($lid>0)
			{
				return $this->GetError('finish');
			}
			return $this->GetError('not_add');
		}
	}

	private function IsExistProd($name)
	{
		$tree = $this->GetPriceAndResource($name);

		if (count($tree)>0) return 1;
		else return 0;
	}

	// постройка
	public function Build($user_id, $name, $time=0)
	{
		if ($this->IsExistProd($name)!=1)
			return $this->GetError('not_exs');

		if ($this->IsBuild($user_id, $name)==0)
		{
			return $this->GetError('not_resource');
		}
		else
		{
			return $this->DoBuild($user_id, $name, $time=0);
		}
	}

	// покупка стройки
	public function Buy($user_id, $name, $time=0)
	{
		$db = $this->db;
		$name = $db->RealEscape($name);
		$time = (int)$time;
		if ($this->IsExistProd($name)!=1)
			return $this->GetError('not_exs');

		if ($this->IsBuy($user_id, $name)==0)
		{
			return $this->GetError('not_money');
		}
		else
		{
			return $this->DoBuy($user_id, $name);
		}
	}

	// покупка ресурсов
	public function BuyResource($user_id, $name, $count=1)
	{
		$db = $this->db;
		$count = (int)$count;
		$name = $db->RealEscape($name);
		if ($this->IsExistProd($name)!=1)
			return $this->GetError('not_exs');

		if ($this->IsBuyResource($user_id, $name,$count)==0)
		{
			return $this->GetError('not_money');
		}
		else
		{
			return $this->DoBuyResource($user_id, $name, $count);
		}
	}


	public function CheckTime()
	{
		$db = $this->db;
		$now = time();
		$sql = "select * from `db_building` where `status`=0 and `build_end`<=$now";
		$db->Query($sql);
		$arr = array();
		if ($db->NumRows()>0)
		{
			while($row = $db->FetchArray())
			{
				$arr[] = $row;
			}
		}
		if (count($arr)>0)
		{
			foreach ($arr as $row)
			{
				$id = $row['id'];
				$tree = $row['name_tree'];
				$user = $row['id_user'];
				$sql = "update `db_building` set `status`=1 where `id`=$id";
				$db->Query($sql);
				$sql = "update `db_users_b` set `$tree`=`$tree`+1 where `id`=$user";
				$db->Query($sql);
			}
		}
		$this->CheckTimeLife();
	}

	public function CheckTimeLife()
	{
		$db = $this->db;
		$now = time();
		$sql = "select * from `db_building` where `status`=2 and `build_end`<=$now";
		$db->Query($sql);
		$arr = array();
		if ($db->NumRows()>0)
		{
			while($row = $db->FetchArray())
			{
				$arr[] = $row;
			}
		}
		if (count($arr)>0)
		{
			foreach ($arr as $row)
			{
				$id = $row['id'];
				$tree = $row['name_tree'];
				$user = $row['id_user'];
				$sql = "update `db_building` set `status`=1 where `id`=$id";
				$db->Query($sql);
				$sql = "update `db_users_b` set `$tree`=`$tree`-1 where `id`=$user";
				$db->Query($sql);
			}
		}
	}

	private function ConvertTime($val)
	{
		$time = (int)$val;
		$m = floor($time / 60);
		$h = floor($m / 60);
		$d = floor($h / 24);
		$h = $h - $d*24;
		$m = $m - $h*60 - $d*24*60;
		$s = $time - $m*60 - $h*60*60 - $d*24*60*60;
	   if($d != 0) return "$d дн $h ч $m м $s с";
	   if($h != 0) return "$h ч $m м $s с";
	   if($m != 0) return "$m м $s сек";
	   if($s != 0) return "$s с";
	}


	public function GetBuildingData($user_id,$status=0)
	{
		$db = $this->db;
		$sql = "select * from `db_building` where `status`=$status and `id_user`=$user_id";
		$db->Query($sql);
		$arr = array();
		if ($db->NumRows()>0)
		{
			while($row = $db->FetchArray())
			{
				$row['delta'] = $row['build_end'] - time();
				$row['delta_t'] = $this->ConvertTime($row['delta']);
				$arr[] = $row;
			}
		}
		return $arr;
	}

	private function GetMyCountItem($user_id, $item)
	{
		$db = $this->db;
		$db->query("select `$item` from `db_users_b` where `id`=$user_id");
		$row = $db->FetchArray();
		return $row[0];
	}


	private function GetResourcesCat($cat)
	{
		$data = $this->GetResourceList();
		return $data[$cat];
	}



	public function GetMoney()
	{
		$uid = $_SESSION["user_id"];
		$db = $this->db;
		$db->query("select `money_b` from `db_users_b` where `id`=$uid");
		$row = $db->FetchArray();
		return $row[0];
	}


	public function GetHasResources($user_id)
	{
		$db = $this->db;
		$data = $this->GetResourceList();
		$ret = array();
		foreach ($data as $row)
		{
			foreach ($row as $res)
			{
				$db->query("select `$res` from `db_users_b` where `id`=$user_id");
				$srow = $db->FetchArray();
				$cnt = $srow[0];
				if ($cnt>0) $ret[$res] = $cnt;
			}
		}
		return $ret;
	}
//********************************************************************************************************
// Внешний вид, можно настроить на свой вкус
// тут крутить можно
//********************************************************************************************************


	public function GetBuildProcess($user_id, $tree)
	{
		$style = "<style>.info_block{height: 65px;float: left;margin: 0px 40px 20px 50px;width: 460px;background:rgb(243, 242, 233);border-radius: 20px;} .info_block div{padding: 15px;}</style>";
		$data = $this->GetBuildingData($user_id);
		$ret = $style;
		foreach ($data as $row)
		{
			$time = $row['delta_t'];
			if ($row['name_tree']==$tree)
			{
			$ret .= "<div class='info_block'>";
				$ret .=  "<div>";
				$ret .=  $this->GetNames($row['name_tree'])." - до окончания строительства осталось: <br>".$time;
				$ret .=  "</div>";
			$ret .=  "</div>";
			}
		}
		return $ret;
	}

	public function GetBuildingTable($money=0, $tree = 0)
 {
  $uid = $_SESSION["user_id"];
  $db = $this->db;
  $arr = $this->GetBuildingList();
  $ret = "<style>";
  $ret .= ".fr-block-my{
    width: 460px;
    float: left;font-size: 11pt;
    margin: 0px 20px 20px 20px;padding: 20px 20px 20px 40px;
    background: rgb(243, 242, 233);
    border-radius: 15px;}";
  $ret .= "</style>";
  $i = 0;
  foreach ($arr as $row)
  {
   $i++;
   $name = $this->GetNames($row);
   $ress = $this->GetPriceAndResource($row);
   $time = $this->GetTimeBuilding($row);
   $time = $this->ConvertTime($time);
   if ($tree==$row)
{
   $ret .=
   "<div class='fr-block-my'>
    <form action='' method='post'>
    <div class='cl-fr-lf'>
     <img src='/img/fruit/$i.png' />
    </div>

    <div class='cl-fr-rg' style='padding-left:20px;'>
     <div class='fr-te-gr-title'><b>$name</b></div>";

   if ($money==0)
   {
    $ret .= "<div class='fr-te-gr'><font color='#000000'>Для строительства: </font></div>";
    foreach ($ress as $res => $cnt )
      {
       if (($res=="price") or ($res=="plod") or ($res=="level")) continue;

       $res_name = $this->GetNames($res);
       $ret .= "<div class='fr-te-gr'>$res_name: <font color='#000000'>$cnt шт.</font></div>";
      }

     $ret .= "<div class='fr-te-gr'>Время стройки: <font color='#000000'> $time </font></div>";
   }
   if ($money==1)
   {
    $ret .= "<div class='fr-te-gr'>Стоимость: $ress[price] серебра </div>";

    $ret .= "<input type='hidden' name='buy' value='1' />";
   }
     $cnt = $this->GetMyCountItem($uid, $row);
     

     $ret .=  "<div class='fr-te-gr'>Построено: <font color='#000000'> $cnt шт.</font></div>";
     $ret .= "<input type='hidden' name='item' value='$row' />";
     if (($ress['level']>user_level::getInstance()->get_level()) and ((int)$ress['level']>0))
     {
     	$ret .=  "<div class='fr-te-gr'>Вам необходим: <font color='#000000'> $ress[level] уровень</font></div>";
     }
     else
     {
     	if ($this->IsNotHas($uid, $row)==1)
     	{
     		$ret .= "<input type='submit' value='Построить' style='height: 30px; margin-top:10px;'class='btn_8' />";
     	}
     }
     	$ret .= "
    </div>
    </form>
   </div>";
}
  }
  return $ret;
 }
	public function GetMyBuilding($user_id)
	{
		$style = "<style>.info_block{height: 65px;float: left;margin: 0px 20px 20px 50px;width: 450px;background: rgba(190, 190, 190, 0.39);border-radius: 20px;} .info_block div{padding: 15px;}</style>";
		$data = $this->GetBuildingData($user_id,1);
		$ret = $style;
		foreach ($data as $row)
		{
			$time = $row['delta_t'];
			$ret .= "<div class='info_block'>";
				$ret .=  "<div>";
				$ret .=  $this->GetNames($row['name_tree']);
				$ret .=  "</div>";
			$ret .=  "</div>";
		}
		return $ret;
	}


	public function GetResourceTable($category)
	{
		$uid = $_SESSION["user_id"];
		$db = $this->db;
		$arr = $this->GetResourcesCat($category);
		$ret = "<style>";
		$ret .= ".fr-block-my{ width: 550px;float: left;margin: 0px 20px 20px 30px;background: rgba(0, 0, 0, 0.09);border-radius: 15px;}";
		$ret .= "</style>";
		foreach ($arr as $row)
		{
			$name = $this->GetNames($row);
			$price = $this->GetPriceAndResource($row);
			$price = $price['price'];

			$ret .=
			"<div class='fr-block'>
				<form action='' method='post'>
				<div class='cl-fr-lf'>
					<img src='/img/fruit/99.png' />
				</div>

				<div class='cl-fr-rg' style='padding-left:20px;'>
					<div class='fr-te-gr-title'><b>$name</b></div>";

				$ret .= "<div class='fr-te-gr'>Стоимость: $price серебра </div>";
				$ret .= "<input type='hidden' name='buy' value='1' />";
					$cnt = $this->GetMyCountItem($uid, $row);
					$ret .=  "<div class='fr-te-gr'>Куплено: <font color='#000000'> $cnt шт.</font></div>";
					$ret .= "<input type='hidden' name='resource' value='$row' />";
					$ret .= "<input type='text' name='count' value='1' />";
					$ret .= "<input type='submit' value='Приобрести' style='height: 30px; margin-top:10px;' />
				</div>
				</form>
			</div>";
		}
		return $ret;
	}


	public function GetMyResources($user_id)
	{
		$data = $this->GetHasResources($user_id);
		foreach ($data as $key => $value )
		{
			$ret .=  $this->GetNames($key).": ".$value." шт. <br>";
		}
		return $ret;
	}


}