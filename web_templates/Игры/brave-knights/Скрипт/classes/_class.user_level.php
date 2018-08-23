<?php

// ���������� ��� ����� ���������:
/*
	1) �������� ���� ���� � ����� "classes", � ����� ���� _class.db2.php;
	2) � ������� db_users_a �������� ��������(INTEGER) ���� � ������� "balls".
	3) ������������ ����� �������� �������� ���:
	3.1) user_level::getInstance()->add_ball(1); // ������� ������ 1 ������� ����.
	3.2) user_level::getInstance()->get_level(); // ������� ������� ������� ������.
	3.3) user_level::getInstance()->get_user_level(��_������) - �������� ������� ���������� ���� ������
	3.4) ��������� ������� � ���� ����.
*/

class user_level
{
	private static $instance;
	private $levels;
	private $uid;

	public static function getInstance()
	{
		if (is_null(self::$instance))
		{
			self::$instance = new self($_SESSION["user_id"]);
		}
		return self::$instance;
	}


	public function get_user_level($uid)
	{
		$last = $this->uid;
		$this->uid = $uid;
		$l = $this->get_level();
		$this->uid = $last;
		return $l;
	}

	private function __construct($uid)
	{
		$this->init_levels();
		$this->uid = $uid;
	}

	private function __clone(){}
	private function __wakeup(){}


	// ********************************************************************************************
	// ��� ����� � ��������� ���-�� =)
	// ********************************************************************************************

	private function init_levels()
	{
		$arr = array();
		$arr[] = 0;
		// 1 �� �������
		$arr[] = 100;
		// 2 �� �������
		$arr[] = 200;
		// 3 �� �������
		$arr[] = 300;
		// 4 �� ������� � �.�.
		$arr[] = 400;
                // 5 �� �������
		$arr[] = 500;
                // 6 �� �������
		$arr[] = 600;
                // 7 �� �������
		$arr[] = 700;
                // 8 �� �������
                $arr[] = 800;
                // 9 �� �������
		$arr[] = 900;
                // 10 �� �������
		$arr[] = 1000;
                // 11 �� �������
                $arr[] = 1100;
		$arr[] = 1200;
                $arr[] = 1300;
		$arr[] = 1400;
		$arr[] = 1500;
                $arr[] = 1600;
		$arr[] = 1700;
                $arr[] = 1800;
		$arr[] = 1900;
		$arr[] = 2000;
                // 21 �� �������
                $arr[] = 2100;
		$arr[] = 2200;
                $arr[] = 2300;
		$arr[] = 2400;
		$arr[] = 2500;
                $arr[] = 2600;
		$arr[] = 2700;
                $arr[] = 2800;
		$arr[] = 2900;
		$arr[] = 3000;
                // 31 �� �������
                $arr[] = 3100;
		$arr[] = 3200;
                $arr[] = 3300;
		$arr[] = 3400;
		$arr[] = 3500;
                $arr[] = 3600;
		$arr[] = 3700;
                $arr[] = 3800;
		$arr[] = 3900;
		$arr[] = 4000;
                // 41 �� �������
                $arr[] = 4100;
		$arr[] = 4200;
                $arr[] = 4300;
		$arr[] = 4400;
		$arr[] = 4500;
                $arr[] = 4600;
		$arr[] = 4700;
                $arr[] = 4800;
		$arr[] = 4900;
		$arr[] = 5000;
                // 51 �� �������
                $arr[] = 5100;
		$arr[] = 5200;
                $arr[] = 5300;
		$arr[] = 5400;
		$arr[] = 5500;
                $arr[] = 5600;
		$arr[] = 5700;
                $arr[] = 5800;
		$arr[] = 5900;
		$arr[] = 6000;
                // 61 �� �������
                $arr[] = 6100;
		$arr[] = 6200;
                $arr[] = 6300;
		$arr[] = 6400;
		$arr[] = 6500;
                $arr[] = 6600;
		$arr[] = 6700;
                $arr[] = 6800;
		$arr[] = 6900;
		$arr[] = 7000;
                // 71 �� �������
                $arr[] = 7100;
		$arr[] = 7200;
                $arr[] = 7300;
		$arr[] = 7400;
		$arr[] = 7500;
                $arr[] = 7600;
		$arr[] = 7700;
                $arr[] = 7800;
		$arr[] = 7900;
		$arr[] = 8000;
                // 81 �� �������
                $arr[] = 8100;
		$arr[] = 8200;
                $arr[] = 8300;
		$arr[] = 8400;
		$arr[] = 8500;
                $arr[] = 8600;
		$arr[] = 8700;
                $arr[] = 8800;
		$arr[] = 8900;
		$arr[] = 8000;
                // 91 �� �������
                $arr[] = 9100;
		$arr[] = 9200;
                $arr[] = 9300;
		$arr[] = 9400;
		$arr[] = 9500;
                $arr[] = 9600;
		$arr[] = 9700;
                $arr[] = 9800;
		$arr[] = 9900;
		$arr[] = 10000;
                // 100 �� �������
                $arr[] = 5000;
		$this->levels = $arr;
	}


	// ********************************************************************************************
	// ���� ��� �� ����� �����...
	// ********************************************************************************************
	private function f_get_level($bal)
	{
		$levels = $this->levels;
		$cnt = count($levels)-1;
		for ($i=$cnt; $i >= 0 ; $i--)
		{
			if ($bal>=$levels[$i])
			{
				return $i+1;
			}
		}
		return 0;
	}
	// ********************************************************************************************
	// ��� ��� ������� ����� ������������ � ����� ����, �� ��� �� ������� !
	// ********************************************************************************************

	// ���������� ������� ������ � ������
	public function get_balls()
	{
		$db = db2::getInstance();
		return $db->getOne("select `balls` from `db_users_a` where `id`=?i", $this->uid);
	}

	// ���������� ������� ������ ��������� �������
	public function get_next_level()
	{
		$lev = $this->get_level();
		$lev2 = $lev+1;
		$max_lev = count($this->levels);
		if ($lev2<=$max_lev)
		{
			return $this->levels[$lev2-1];
		}
		return $this->levels[$lev-1];
	}


	// ���������� ����� ������� ������ �����
	public function get_level()
	{
		return $this->f_get_level($this->get_balls());
	}

	// ���������� ����� �� 0 �� 100%, ������������ ������� ����� ������
	// �� ���������� ������ � ���������� �����������.
	public function get_percent()
	{
		$lev = $this->get_level();
		$lev2 = $lev+1;
		$max_lev = count($this->levels);
		if ($lev2<=$max_lev)
		{
			$bal = $this->get_balls();
			$delta = $bal - $this->levels[$lev-1];
			$delta_lev = $this->levels[$lev2-1] - $this->levels[$lev-1];
			$delta = round($delta / $delta_lev * 100);
			return $delta;
		}
		return 100;
	}

	// ��������� ���� ������
	public function add_ball($val)
	{
		$db = db2::getInstance();
		$db->query("update `db_users_a` set `balls`=`balls`+ ?i  where `id`=?i", $val, $this->uid);
	}

	public function test()
	{
		return "UID:".$this->uid." balls:".$this->get_balls()." next: ".$this->get_next_level()." level:".$this->get_level()." perc: ".$this->get_percent();
	}
}