<?
session_start();
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {return;}
session_start();
function __autoload($name){ include("../classes/_class.".$name.".php");}
$config = new config;
$func = new func;
$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);

set_error_handler('err_handler');
function err_handler($errno, $errmsg, $filename, $linenum)
{
	$date = date('Y-m-d H:i:s (T)');
	$f = fopen('errors.txt', 'a');
	if (!empty($f))
	{
		$filename  =str_replace($_SERVER['DOCUMENT_ROOT'],'',$filename);
		$err  = "$date = $errmsg = $filename = $linenum\r\n";
		fwrite($f, $err);
		fclose($f);
	}
}

function cod_filtra($text)
{
	$quotes = array ("\x27", "\x22", "\x60", "\t", "\n", "\r", "*", "%", "<", ">", "?", "!" ,"AND","UNION","SELECT","WHERE","INSERT","UPDATE","DELETE","OUTFILE","FROM","OR","SHUTDOWN","CHANGE","MODIFY","RENAME","RELOAD","ALTER","GRANT","DROP","CONCAT","cmd","exec","<script>","</script>");
	$goodquotes = array ("-", "+", "#" );
	$repquotes = array ("\-", "\+", "\#" );
	$text = trim( strip_tags( $text ) );
	$text = str_replace( $quotes, '', $text );
	$text = str_replace( $goodquotes, $repquotes, $text );
	$pattern = "( +)";
	$replacement = " ";
	$text = preg_replace($pattern, $replacement, $text);
	return $text;
}

if(isset($_SESSION['user'])){$USER = cod_filtra($_SESSION['user']);}else{$USER = '';}

if(isset($_POST['start']))
{
	$NUM = $db->Query("SELECT COUNT(*) as count FROM `m_lotery` where `user`='".$USER."'");
	$NUM_ROW = $db->FetchRow($NUM);
	if($NUM_ROW['count']>0)
	{
		echo "error";return;
	}

	$keys = range(1, 5);
	shuffle($keys);
	$i=0;
	foreach($keys as $key)
	{
		$numbers = array(1,2,3,4,5);
		shuffle($numbers);
 		$NUMB = implode(',',$numbers);
		$new[$i] = $NUMB;
		$i++;
	}

	// Указываем числа
	function generatePassword($length)
	{
		$chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
		$numChars = strlen($chars);
		$string = '';
		for ($i = 0; $i < $length; $i++) {
		$string .= substr($chars, rand(1, $numChars) - 1, 1);
		}
		return $string;
	}

	$pass = generatePassword(32);
	$RES = $new[0]." / ".$new[1]." / ".$new[2]." / ".$new[3]." / ".$new[4]." / Случайный мусор : ".$pass;
	$RES_MD5 = md5($RES);
	$RES2 = iconv('utf-8', 'windows-1251', $RES);

	$data=array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'l', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
	$length_pass=rand(1,3);
	for($i=0;$i<=$length_pass;$i++)
	{
		$rand_sim=rand(0,(count($data)-1));
		$password=$data[$rand_sim];
	}
	$ord_id = rand (1000000000,9999999999);
	$chec = $password.'_'.$ord_id;
	$NUMB_LOTORY = $chec;

	$DATE = time();

	$SES_RAND = rand(0000000000,9999999999);
	$SESSION = md5(time().$USER.'='.time().$SES_RAND);
	$_SESSION['kto'] = $SESSION;

	$TORP = $db->Query("INSERT INTO `m_lotery` (`user`,`num_lotery`,`nomd5`,`md5`,`a_1`,`a_2`,`a_3`,`a_4`,`a_5`,`status`,`date`,`setoc`)VALUES('".$USER."','".$NUMB_LOTORY."','".$RES2."','".$RES_MD5."','".$new[0]."','".$new[1]."','".$new[2]."','".$new[3]."','".$new[4]."','0','".$DATE."','".$SESSION."')");
	if($TORP==true)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}
//////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////
if(isset($_POST['game']))
{
	$LOT_N = cod_filtra($_POST['l']);
	$HOD_B = $db->Query("SELECT * FROM `m_lotery` where `user`='".$USER."' and `num_lotery`='".$LOT_N."' and `status`='1'");
	$HOD = $db->FetchArray($HOD_B);

	if($HOD==true)
	{
		if(isset($_SESSION['kto'])){$KTO = $_SESSION['kto'];}else{$KTO = '';}
		if($KTO!=$HOD['setoc']){return;}

		if($HOD['h1']=="")//проверяем 1 ход
		{
			$X = (int)cod_filtra($_POST['x']);
			$Y = (int)cod_filtra($_POST['y']);
			if($X==4)
			{
				if($Y > 4){ echo 'error';return;}
				$RES_H = $Y;
				$H1 = $db->Query("UPDATE `m_lotery` SET `h1`='".$RES_H."' WHERE  `user`='".$USER."' and `num_lotery`='".$LOT_N."' and `status`='1'");
				if($H1 == true)
				{
					echo 1;
				}
				else
				{
					echo 'error';
				}
				return;
			}
		}
		else
		{
			if($HOD['h2']=="" and $HOD['h1']!="")//проверяем 2 ход
			{
				$X = (int)cod_filtra($_POST['x']);
				$Y = (int)cod_filtra($_POST['y']);
				if($X==3)
				{
					if($Y > 4){ echo 'error';return;}
					$RES_H = $Y;

					$USER_LOT = $db->Query("SELECT * FROM `m_lotery` where `user`='".$USER."'");
					$USER_LOT = $db->FetchArray($USER_LOT);

					$explode = explode(',', $USER_LOT['a_1']);
					$RES_H1 = $explode[$USER_LOT['h1']];


					$explode = explode(',', $USER_LOT['a_2']);
					$RES_H2 = $explode[$RES_H];

					if($RES_H1 != $RES_H2)
					{
						$PRICE = $db->Query("SELECT * FROM `m_lotery_prise` where `predmet`='".$RES_H1."'");////////
						$PRICE_RES = $db->FetchArray($USER_LOT);

						$UBDATE=",`status`='2',`vid_prise`='bilet',`sum_prise`='".$PRICE_RES['h1']."'";
					}
					else
					{
						$UBDATE="";
					}

					$H1 = $db->Query("UPDATE `m_lotery` SET `h2`='".$RES_H."'".$UBDATE." WHERE  `user`='".$USER."' and `num_lotery`='".$LOT_N."' and `status`='1'");
					if($H1 == true)
					{
						echo 1;
					}
					else
					{
						echo 'error';
					}
					return;
				}
			}
			else
			{
				if($HOD['h3']=="" and $HOD['h2']!="")//проверяем 3 ход
				{
					$X = (int)cod_filtra($_POST['x']);
					$Y = (int)cod_filtra($_POST['y']);
					if($X==2)
					{
						if($Y > 4){ echo 'error';return;}
						$RES_H = $Y;

						$USER_LOT = $db->Query("SELECT * FROM `m_lotery` where `user`='".$USER."'");
						$USER_LOT = $db->FetchArray($USER_LOT);

						$explode = explode(',', $USER_LOT['a_2']);
						$RES_H1 = $explode[$USER_LOT['h2']];


						$explode = explode(',', $USER_LOT['a_3']);
						$RES_H2 = $explode[$RES_H];

						if($RES_H1 != $RES_H2)
						{
							$PRICE = $db->Query("SELECT * FROM `m_lotery_prise` where `predmet`='".$RES_H1."'");////////
							$PRICE_RES = $db->FetchArray($USER_LOT);

							$UBDATE=",`status`='2',`vid_prise`='money',`sum_prise`='".$PRICE_RES['h2']."'";
						}
						else
						{
							$UBDATE="";
						}
						$H1 = $db->Query("UPDATE `m_lotery` SET `h3`='".$RES_H."'".$UBDATE." WHERE  `user`='".$USER."' and `num_lotery`='".$LOT_N."' and `status`='1'");
						if($H1 == true)
						{
							echo 1;
						}
						else
						{
							echo 'error';
						}
						return;
					}
				}
				else
				{
					if($HOD['h4']=="" and $HOD['h3']!="")//проверяем 4 ход
					{
						$X = (int)cod_filtra($_POST['x']);
						$Y = (int)cod_filtra($_POST['y']);
						if($X==1)
						{
							if($Y > 4){ echo 'error';return;}
							$RES_H = $Y;

							$USER_LOT = $db->Query("SELECT * FROM `m_lotery` where `user`='".$USER."'");
							$USER_LOT = $db->FetchArray($USER_LOT);

							$explode = explode(',', $USER_LOT['a_3']);
							$RES_H1 = $explode[$USER_LOT['h3']];


							$explode = explode(',', $USER_LOT['a_4']);
							$RES_H2 = $explode[$RES_H];

							if($RES_H1 != $RES_H2)
							{
								$PRICE = $db->Query("SELECT * FROM `m_lotery_prise` where `predmet`='".$RES_H1."'");////////
								$PRICE_RES = $db->FetchArray($USER_LOT);

								$UBDATE=",`status`='2',`vid_prise`='money',`sum_prise`='".$PRICE_RES['h3']."'";
							}
							else
							{
								$UBDATE="";
							}

							$H1 = $db->Query("UPDATE `m_lotery` SET `h4`='".$RES_H."'".$UBDATE." WHERE  `user`='".$USER."' and `num_lotery`='".$LOT_N."' and `status`='1'");
							if($H1 == true)
							{
								echo 1;
							}
							else
							{
								echo 'error';
							}
							return;
						}
					}
					else
					{
						if($HOD['h5']=="" and $HOD['h4']!=="")//проверяем 5 ход
						{
							$X = (int)cod_filtra($_POST['x']);
							$Y = (int)cod_filtra($_POST['y']);
							if($X==0)
							{
								if($Y > 4){ echo 'error';return;}
								$RES_H = $Y;

								$USER_LOT = $db->Query("SELECT * FROM `m_lotery` where `user`='".$USER."'");
								$USER_LOT = $db->FetchArray($USER_LOT);

								$explode = explode(',', $USER_LOT['a_4']);
								$RES_H1 = $explode[$USER_LOT['h4']];


								$explode = explode(',', $USER_LOT['a_5']);
								$RES_H2 = $explode[$RES_H];

								if($RES_H1 != $RES_H2)
								{
									$PRICE = $db->Query("SELECT * FROM `m_lotery_prise` where `predmet`='".$RES_H1."'");
									$PRICE_RES = $db->FetchArray($USER_LOT);
									$UBDATE=",`status`='2',`vid_prise`='money',`sum_prise`='".$PRICE_RES['h4']."'";
								}
								else
								{
									$PRICE = $db->Query("SELECT * FROM `m_lotery_prise` where `predmet`='".$RES_H2."'");
									$PRICE_RES = $db->FetchArray($USER_LOT);
									$JC = $PRICE_RES['h5'];

									if($PRICE_RES['h5']=='jackpot')
									{
										$PRICE = $db->Query("SELECT * FROM `m_lotery_prise` where `predmet`='".$JC."'");
										$PRICE_RES = $db->FetchArray($USER_LOT);
										$PRICE_JS = $PRICE_RES['jackpot'];
										$UBDATE=",`status`='2',`vid_prise`='money',`sum_prise`='".$PRICE_JS."',`status_prise`='1'";
									}
									else
									{
										$UBDATE=",`status`='2',`vid_prise`='money',`sum_prise`='".$JC."'";
									}
								}

								$H1 = $db->Query("UPDATE `m_lotery` SET `h5`='".$RES_H."'".$UBDATE." WHERE  `user`='".$USER."' and `num_lotery`='".$LOT_N."' and `status`='1'");
								if($H1 == true)
								{
									echo 1;
								}
								else
								{
									echo 'error';
								}
								return;
							}
						}
						else
						{
							echo "error";return;
						}
					}
				}
			}
		}
	}
	else
	{
		echo 'error';
	}
}
/////////////////////////////////////////////////////////////
//
/////////////////////////////////////////////////////////////
if(isset($_POST['priceb']))
{
	$USER_LOT = $db->Query("SELECT * FROM `m_lotery` where `user`='".$USER."'");
	$USER_LOT = $db->FetchArray($USER_LOT);

	if($USER_LOT==true)
	{
		//if($_SESSION['kto']!=$USER_LOT['setoc']){return;}

		if($USER_LOT['vid_prise'] == 'bilet')
		{
			$PRICE = $USER_LOT['sum_prise'];

			if($USER_LOT['h3']!=''){$H3 = cod_filtra($USER_LOT['h3']);}else{$H3='--';}
			if($USER_LOT['h4']!=''){$H4 = cod_filtra($USER_LOT['h4']);}else{$H4='--';}
			if($USER_LOT['h5']!=''){$H5 = cod_filtra($USER_LOT['h5']);}else{$H5='--';}
			$ID  = cod_filtra($USER_LOT['id']);
			$ID_B  = cod_filtra($USER_LOT['num_lotery']);
			$STAVKA = $USER_LOT['stavka'];
			$PREDMET_ALL = cod_filtra($USER_LOT['nomd5']);
			$BILET = cod_filtra($USER_LOT['sum_prise']);
			$HOD = cod_filtra($USER_LOT['h1']).' , '.cod_filtra($USER_LOT['h2']).' , '.$H3.' , '.$H4.' , '.$H5;
			$DATE = time();
			//echo $STAVKA;return;
			$RESS = $db->Query("INSERT INTO `m_lotery_history`(`user`,`hod`,`id_lotety`,`lotery_predmet`,`stavka`,`bilet`,`money`,`data`)VALUES('".$USER."','".$HOD."','".$ID_B."','".$PREDMET_ALL."','".$STAVKA."','".$BILET."','0.00','".$DATE."')");
			if($RESS == true)
			{
				$TORP = $db->Query("UPDATE `wmrush_users_b` SET `billet` = billet+'".$PRICE."' WHERE `user`='".$USER."'");
				if($TORP==true)
				{
					/////////////////////////////////////////////////////////
					$PROCENT = 10;//Настройка процента на зачисление джекпота
					/////////////////////////////////////////////////////////
					$JP = ($STAVKA/100)*$PROCENT;
					//echo $JP;return;
					$JS = round(floatval($JP),2);
					$JP_RES = $db->Query("UPDATE `m_lotery_prise` SET `jackpot` = jackpot + '".$JS."' WHERE `predmet`='jackpot'");

					if($JP_RES==true)
					{
						$ROWSS = $db->Query("DELETE FROM `m_lotery` WHERE `user`='".$USER."' and `id`='".$ID."'");
						if($ROWSS == true)
						{
							echo 1;
							return;
						}
						else
						{
							echo 'error';
							return;
						}
					}
					else
					{
						echo 'error';
						return;
					}
				}
				else
				{
					echo 'error';
					return;
				}
			}
			else
			{
				echo 'error';
				return;
			}
			return;
		}
		if($USER_LOT['vid_prise'] == 'money')
		{
			$usid = $_SESSION["user_id"];
			$db->Query("SELECT * FROM `wmrush_users_a` WHERE `id`='$usid'");
			$user_payeers = $db->FetchArray();

			function ViewPurse($purse)
			{
				if( substr($purse,0,1) != "P" ) return false;
				if( !preg_match("/^[0-9]{7,11}$/", substr($purse,1)) ) return false;
				return $purse;
			}
			if(isset($user_payeers['purse']))
			{
				$SITE = 'basic-industries';//с какого сайта выплата
				$purse = ViewPurse($user_payeers['purse']);

				$sum = cod_filtra($USER_LOT['sum_prise']);

				//если сумма ставки не равна сумме оплаты выплачиваем только 1 рубль
				if($USER_LOT['stavka']!=$USER_LOT['stevka_pay'])
				{
					$JS = "0.01";
				}
				else
				{
					if($USER_LOT['status_prise']==1)
					{
						$JS = $sum;
						$PURSTER = 1;
					}
					else
					{
						$JS = $USER_LOT['stavka']*$sum;
						$PURSTER = 0;
					}
				}
				$JS = round(floatval($JS),2);

				$val = "RUB";
				if($purse !== false)
				{
					### Делаем выплату ###
					$payeer = new rfs_payeer($config->AcNumberL, $config->apiIdL, $config->apiKeyL);
					if ($payeer->isAuth())
					{
						$arBalance = $payeer->getBalance();
						if($arBalance["auth_error"] == 0)
						{
							$sum_pay = round(($JS), 2);
							$balance = $arBalance["balance"]["RUB"]["DOSTUPNO"];
							if( ($balance) >= ($sum_pay))
							{
								$arTransfer = $payeer->transfer(array(
								'curIn' => 'RUB', // счет списания
								'sum' => $sum_pay, // сумма получения
								'curOut' => 'RUB', // валюта получения
								'to' => $purse, // получатель (счет)
								'comment' => "Выплата пользователю {$USER} с проекта {$SITE} мгновенная лотерея"
								));

								if (!empty($arTransfer["historyId"]))
								{
									# Вставляем запись в выплаты
									# заисываем данные в историю
									# удаляем лотереяю из игровой таблицы

									$PRICE = $USER_LOT['sum_prise'];

									if($USER_LOT['h3']!=''){$H3 = cod_filtra($USER_LOT['h3']);}else{$H3='--';}
									if($USER_LOT['h4']!=''){$H4 = cod_filtra($USER_LOT['h4']);}else{$H4='--';}
									if($USER_LOT['h5']!=''){$H5 = cod_filtra($USER_LOT['h5']);}else{$H5='--';}
									$ID  = cod_filtra($USER_LOT['id']);
									$ID_B  = cod_filtra($USER_LOT['num_lotery']);
									$STAVKA = $USER_LOT['stavka'];
									$PREDMET_ALL = cod_filtra($USER_LOT['nomd5']);
									$BILET = cod_filtra($USER_LOT['sum_prise']);
									$HOD = cod_filtra($USER_LOT['h1']).' , '.cod_filtra($USER_LOT['h2']).' , '.$H3.' , '.$H4.' , '.$H5;
									$DATE = time();
									//echo $STAVKA;return;
									$RESS = $db->Query("INSERT INTO `m_lotery_history`(`user`,`hod`,`id_lotety`,`lotery_predmet`,`stavka`,`bilet`,`money`,`data`,`status_prise`)VALUES('".$USER."','".$HOD."','".$ID_B."','".$PREDMET_ALL."','".$STAVKA."','','".$sum_pay."','".$DATE."','".$PURSTER."')");
									if($RESS == true)
									{
										if($PURSTER==1)
										{
											$JPS_RE = $db->Query("UPDATE `m_lotery_prise` SET `jackpot` = '0.00' WHERE `predmet`='jackpot'");
										}

										$ROWSS = $db->Query("DELETE FROM `m_lotery` WHERE `user`='".$USER."' and `id`='".$ID."'");
										if($ROWSS == true)
										{
											echo 2;//выплачено
											return;
										}
										else
										{
											echo 'error';
											return;
										}
									}
								}
								else
								{
									//Шлюз выплат перегружен попробуйте позже!
									echo 3;
								}
							}
							else
							{
								echo 4;//Шлюз выплат перегружен попробуйте позже!
							}
						}
						else
						{
							echo 5;//Не удалось выплатить! Попробуйте позже
						}
					}
					else
					{
						echo 6;//Не удалось выплатить! Попробуйте позже
					}
				}
				else
				{
					echo 7;//Кошелек Payeer указан неверно! Смотрите образец!
				}
			}
		}
	}
	else
	{
		echo 'error';
	}
}
///////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////
if(isset($_POST['paylot']))
{
	if(isset($_POST['id'])) {$ID  = (int)cod_filtra($_POST['id']) ;}else{$ID='';}
	if(isset($_POST['pay'])){$PAY = (int)cod_filtra($_POST['pay']);}else{$PAY='';}
	if(isset($_POST['lot'])){$LOT = cod_filtra($_POST['lot']);}else{$LOT='';}

	$HOD_B = $db->Query("SELECT * FROM `m_lotery` where `user`='".$USER."' and `num_lotery`='".$LOT."' and `status`='0'");
	$HOD = $db->FetchArray($HOD_B);
	if(isset($_SESSION['kto'])){$KTO = cod_filtra($_SESSION['kto']);}else{$KTO = "";}
	if($KTO!=$HOD['setoc'])
	{
		$ROWSS = $db->Query("DELETE FROM `m_lotery` WHERE `user`='".$USER."' and `id`='".$HOD['id']."'");
		if($ROWSS==true)
		{
			echo 'errorlot';
			return;
		}
		else
		{
			echo 'error';
		}
	}

	if($HOD==true)
	{
		if($HOD['status']==3)
		{
			echo 'error';return;
		}
		else
		{
			$ProvStavka = $db->Query("SELECT * FROM `m_lotery_stavka` where `id`='".$ID."'");
			$ProvStavka = $db->FetchArray($ProvStavka);
			if($ProvStavka['stavka']!=$PAY){echo 'error';return;}
			if($ProvStavka==true)
			{
				if($ProvStavka['stavka']==$PAY)
				{
					$STAVKA = (int)cod_filtra($ProvStavka['stavka']);
					//записываем начало платежа статус 3
					$PAY = $db->Query("UPDATE `m_lotery` SET `stavka`='".$STAVKA."',`status`='3' WHERE `user`='".$USER."' and `num_lotery`='".$LOT."' and `status`='0'");
					if($PAY == true)
					{
						echo 1;
						return;
					}
					else
					{
						echo 'error';
					}
					return;
				}
				else
				{
					echo 'error';
				}
			}
			else
			{
				echo 'error';
			}
		}
	}
	else
	{
		echo 'error';
	}
}
?>