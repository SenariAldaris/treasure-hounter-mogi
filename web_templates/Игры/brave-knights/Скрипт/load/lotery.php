<?
echo "<meta charset='windows-1251'>";
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {return;} //отвечаем только на AJAX запросы
function cod_filtra($text)
{
	$quotes = array (" ","\x27", "\x22", "\x60", "\t", "\n", "\r", "*", "%", "<", ">", "?", "!" ,"AND","UNION","SELECT","WHERE","INSERT","UPDATE","DELETE","OUTFILE","FROM","OR","SHUTDOWN","CHANGE","MODIFY","RENAME","RELOAD","ALTER","GRANT","DROP","CONCAT","cmd","exec","<script>","</script>");
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
session_start();
function __autoload($name){ include("../classes/_class.".$name.".php");}
$config = new config;
$func = new func;
$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);
if(isset($_SESSION['user'])){$USER = cod_filtra($_SESSION['user']);}else{$USER = '';}

$USER_LOT = $db->Query("SELECT * FROM `m_lotery` where `user`='".$USER."'");
$USER_LOT = $db->FetchArray($USER_LOT);

##############################################
#	проверяем не просраочена ли лотерея
##############################################

$DATYRE = time()-60*60*12;
$db->Query("DELETE FROM `m_lotery` WHERE `date`<'".$DATYRE."' and `status`='0' or `date`<'".$DATYRE."' and `status`='1' or `date`<'".$DATYRE."' and `status`='3'");

##############################################

$OFF_LOTERY = "on";//off отлючена лотерея ---- on включена
if($OFF_LOTERY == "off"){echo '<div class="jackpot" align="center">Технические работы</div>';return;}

if($USER_LOT['status']==3)
{
	echo '<h1>Оплата ставки мгновенной лотереи</h1>';

	$desc = base64_encode($_SERVER["HTTP_HOST"]." - USER ".$USER_LOT['user']);
	$m_shop = $config->shopIDLoto;
	$m_orderid = $USER_LOT['num_lotery'];//ордер магазина
	$m_amount = number_format($USER_LOT['stavka'], 2, ".", "");
	$m_curr = "RUB";
	$m_desc = $desc;
	$m_key = $config->secretLoto;
	
	$arHash = array(
	 $m_shop,
	 $m_orderid,
	 $m_amount,
	 $m_curr,
	 $m_desc,
	 $m_key
	);
	$sign = strtoupper(hash('sha256', implode(":", $arHash)));
	
	//echo $config->shopID.' = '.$m_key = $config->secretW;
	
	echo '<table align="center">';
		echo '<tr>';
			echo '<td width="50%" align="center">';
				echo '<form method="GET" action="//payeer.com/api/merchant/m.php">';
					echo '<input type="hidden" name="m_shop" value="'.$config->shopIDLoto.'">';
					echo '<input type="hidden" name="m_orderid" value="'.$m_orderid.'">';
					echo '<input type="hidden" name="m_amount" value="'.$m_amount.'">';
					echo '<input type="hidden" name="m_curr" value="RUB">';
					echo '<input type="hidden" name="m_desc" value="'.$desc.'">';
					echo '<input type="hidden" name="m_sign" value="'.$sign.'">';
					echo '<input type="submit" name="m_process" class="butter" value="Оплатить '.$m_amount.' руб. PAYEER" />';
				echo '</form>';
			echo '</td>';
	echo '</table>';
	return;
}
echo '<table  width="400px" border="0" cellspacing="1" cellpadding="1">';
		echo '<tr>';
			echo '<td  width="200px" align="right">';
				$td = 5; // ячейки
				$tr = 5; // строки
				echo '<table class="bor" border="0" cellspacing="2" cellpadding="2">';
					for($x=0; $x<$tr; $x++)
					{
						$x_1 = $x ;
						echo '<tr ';
							
							if($USER_LOT['h5']=="" and $USER_LOT['h4']!="" and $x_1==0 and $USER_LOT['status']==1){echo 'class="tr-m"';}
							if($USER_LOT['h4']=="" and $USER_LOT['h3']!="" and $x_1==1 and $USER_LOT['status']==1){echo 'class="tr-m"';}
							if($USER_LOT['h3']=="" and $USER_LOT['h2']!="" and $x_1==2 and $USER_LOT['status']==1){echo 'class="tr-m"';}
							if($USER_LOT['h2']=="" and $USER_LOT['h1']!="" and $x_1==3 and $USER_LOT['status']==1){echo 'class="tr-m"';}
							if($USER_LOT['h1']=="" and $x_1==4 and $USER_LOT['status']==1){echo 'class="tr-m"';}
						echo '>';
							for($y=0; $y<$td; $y++)
							{
								$y_1 = $y ;
								echo '<td>';
								//$res_xy = $x_1."_".$y_1;
								if($USER_LOT['status']=='')
								{
									echo '<img class="img-m" src="../../img/bg-lot-m.png" width="30" height="30" onclick="javascript:go_n();" alt="" />';
								}
								elseif($USER_LOT['status']==0)
								{
									echo '<img class="img-m" src="../../img/bg-lot-m.png" width="30" height="30" onclick="javascript:go_no_s();" alt="" />';
								}
								elseif($USER_LOT['status']==1 or $USER_LOT['status']==2)
								{
									if($x_1==0)
									{
										if($USER_LOT['h5']=="" and $USER_LOT['h4']!="")
										{
											if($USER_LOT['status']==2)
											{
												$H1 = $USER_LOT['h5'];
												$explode = explode(',', $USER_LOT['a_5']);
												if(isset($explode[$H1])){$RES_H = $explode[$H1];}else{$RES_H = "";}
												$Y_H = $explode[$y_1];
												if($Y_H != $RES_H)
												{
													$IMG = $Y_H;
													echo '<img class="im-op" src="../../img/bg-lot-moneta_'.$IMG.'.png" width="30" height="30" />';
												}
												
											}
											else
											{
												$LOT = $USER_LOT['num_lotery'];
												echo '<img onClick="go_ho('.$x_1.','.$y_1.',\''.$LOT.'\')" class="img-m" src="../../img/bg-lot-m.png" width="30" height="30" alt="'.$x_1.'" />';
											}
										}
										elseif($USER_LOT['h5']!="" and $USER_LOT['h4']!="")
										{
											$H1 = $USER_LOT['h5'];
											$explode = explode(',', $USER_LOT['a_5']);
											if(isset($explode[$H1])){$RES_H = $explode[$H1];}else{$RES_H = "";}
											$Y_H = $explode[$y_1];
											if($Y_H != $RES_H)
											{
												$IMG = $Y_H;
												echo '<img class="im-op" src="../../img/bg-lot-moneta_'.$IMG.'.png" width="30" height="30" />';
											}
											elseif($Y_H == $RES_H)
											{
												$IMG = $RES_H;
												echo '<img class="win" src="../../img/bg-lot-moneta_'.$IMG.'.png" width="30" height="30" />';
											}
										}
										elseif($USER_LOT['h5']=="" and $USER_LOT['h4']=="")
										{
											if($USER_LOT['status']==2)
											{
												$H1 = $USER_LOT['h5'];
												$Y_H = '';
												$explode = explode(',', $USER_LOT['a_5']);
												if(isset($explode[$H1])){$RES_H = $explode[$H1];}else{$RES_H = "";}
												$Y_H = $explode[$y_1];
												
												if($Y_H != $RES_H)
												{
													$IMG = $Y_H;
													echo '<img class="im-op" src="../../img/bg-lot-moneta_'.$IMG.'.png" width="30" height="30" />';
												}
												
											}
											else
											{
												echo '<img src="../../img/bg-lot-m.png" width="30" height="30" alt="'.$x_1.'" />';
											}
										}
										
									}
									elseif($x_1==1)
									{
										if($USER_LOT['h4']=="" and $USER_LOT['h3']!="")
										{
											if($USER_LOT['status']==2)
											{
												$H1 = $USER_LOT['h4'];
												$Y_H = "";
												$explode = explode(',', $USER_LOT['a_4']);
												if(isset($explode[$H1])){$RES_H = $explode[$H1];}else{$RES_H = "";}
												$Y_H = $explode[$y_1];
												
												if($Y_H != $RES_H)
												{
													$IMG = $Y_H;
													echo '<img class="im-op" src="../../img/bg-lot-moneta_'.$IMG.'.png" width="30" height="30" />';
												}
											}
											else
											{
												$LOT = $USER_LOT['num_lotery'];
												echo '<img onClick="go_ho('.$x_1.','.$y_1.',\''.$LOT.'\')" class="img-m" src="../../img/bg-lot-m.png" width="30" height="30" alt="'.$x_1.'" />';
											}
										}
										elseif($USER_LOT['h4']!="" and $USER_LOT['h3']!="")
										{
											$H1 = $USER_LOT['h4'];
											$Y_H = '';
											$explode = explode(',', $USER_LOT['a_4']);
											if(isset($explode[$H1])){$RES_H = $explode[$H1];}else{$RES_H = "";}
											$Y_H = $explode[$y_1];
											
											if($Y_H != $RES_H)
											{
												$IMG = $Y_H;
												echo '<img class="im-op" src="../../img/bg-lot-moneta_'.$IMG.'.png" width="30" height="30" />';
											}
											elseif($Y_H == $RES_H)
											{
												$IMG = $RES_H;
												echo '<img class="win" src="../../img/bg-lot-moneta_'.$IMG.'.png" width="30" height="30" />';
											}
										}
										elseif($USER_LOT['h4']=="" and $USER_LOT['h3']=="")
										{
											if($USER_LOT['status']==2)
											{
												$H1 = $USER_LOT['h4'];
												$Y_H = '';
												$explode = explode(',', $USER_LOT['a_4']);
												if(isset($explode[$H1])){$RES_H = $explode[$H1];}else{$RES_H = "";}
												$Y_H = $explode[$y_1];
												
												if($Y_H != $RES_H)
												{
													$IMG = $Y_H;
													echo '<img class="im-op" src="../../img/bg-lot-moneta_'.$IMG.'.png" width="30" height="30" />';
												}
											}
											else
											{
												echo '<img src="../../img/bg-lot-m.png" width="30" height="30" alt="'.$x_1.'" />';
											}
										}
									}
									elseif($x_1==2)
									{
										if($USER_LOT['h3']=="" and $USER_LOT['h2']!="")
										{
											if($USER_LOT['status']==2)
											{
												$H1 = $USER_LOT['h3'];
												$Y_H ='';
												$explode = explode(',', $USER_LOT['a_3']);
												if(isset($explode[$H1])){$RES_H = $explode[$H1];}else{$RES_H = "";}
												$Y_H = $explode[$y_1];
												
												if($Y_H != $RES_H)
												{
													$IMG = $Y_H;
													echo '<img class="im-op" src="../../img/bg-lot-moneta_'.$IMG.'.png" width="30" height="30" />';
												}
											}
											else
											{
												$LOT = $USER_LOT['num_lotery'];
												echo '<img onClick="go_ho('.$x_1.','.$y_1.',\''.$LOT.'\')" class="img-m" src="../../img/bg-lot-m.png" width="30" height="30" alt="'.$x_1.'" />';
											}
										}
										elseif($USER_LOT['h3']!="" and $USER_LOT['h2']!="")
										{
											$H1 = $USER_LOT['h3'];
											$Y_H ='';
											$explode = explode(',', $USER_LOT['a_3']);
											if(isset($explode[$H1])){$RES_H = $explode[$H1];}else{$RES_H = "";}
											$Y_H = $explode[$y_1];
											
											if($Y_H != $RES_H)
											{
												$IMG = $Y_H;
												echo '<img class="im-op" src="../../img/bg-lot-moneta_'.$IMG.'.png" width="30" height="30" />';
											}
											elseif($Y_H == $RES_H)
											{
												$IMG = $RES_H;
												echo '<img class="win" src="../../img/bg-lot-moneta_'.$IMG.'.png" width="30" height="30" />';
											}
										}
										elseif($USER_LOT['h3']=="" and $USER_LOT['h3']=="")
										{
											echo '<img src="../../img/bg-lot-m.png" width="30" height="30" alt="'.$x_1.'" />';
										}
									}
									elseif($x_1==3)
									{
										if($USER_LOT['h2']=="" and $USER_LOT['h1']!="")
										{
											if($USER_LOT['status']==2)
											{
												$H1 = $USER_LOT['h2'];
												$Y_H = '';
												$explode = explode(',', $USER_LOT['a_2']);
												if(isset($explode[$H1])){$RES_H = $explode[$H1];}else{$RES_H = "";}
												$Y_H = $explode[$y_1];
												
												if($Y_H != $RES_H)
												{
													$IMG = $Y_H;
													echo '<img class="im-op" src="../../img/bg-lot-moneta_'.$IMG.'.png" width="30" height="30" />';
												}
											}
											else
											{
												$LOT = $USER_LOT['num_lotery'];
												echo '<img onClick="go_ho('.$x_1.','.$y_1.',\''.$LOT.'\')" class="img-m" src="../../img/bg-lot-m.png" width="30" height="30" alt="'.$x_1.'" />';
											}
										}
										elseif($USER_LOT['h2']!="" and $USER_LOT['h1']!="")
										{
											$H1 = $USER_LOT['h2'];
											$Y_H = "";
											$explode = explode(',', $USER_LOT['a_2']);
											if(isset($explode[$H1])){$RES_H = $explode[$H1];}else{$RES_H = "";}
											$Y_H = $explode[$y_1];
											
											if($Y_H != $RES_H)
											{
												$IMG = $Y_H;
												echo '<img class="im-op" src="../../img/bg-lot-moneta_'.$IMG.'.png" width="30" height="30" />';
											}
											elseif($Y_H == $RES_H)
											{
												$IMG = $RES_H;
												echo '<img class="win" src="../../img/bg-lot-moneta_'.$IMG.'.png" width="30" height="30" />';
											}
										}
										elseif($USER_LOT['h2']=="" and $USER_LOT['h1']=="")
										{
											echo '<img src="../../img/bg-lot-m.png" width="30" height="30" alt="'.$x_1.'" />';
										}
									}
									elseif($x_1==4)//первый ход
									{
										if($USER_LOT['h1']=="")
										{
											$LOT = $USER_LOT['num_lotery'];
											echo '<img onClick="go_ho('.$x_1.','.$y_1.',\''.$LOT.'\')" class="img-m" src="../../img/bg-lot-m.png" width="30" height="30" alt="'.$x_1.'" />';
										}
										elseif($USER_LOT['h1']!="")
										{
											$H1 = $USER_LOT['h1'];
											$Y_H = '';
											$explode = explode(',', $USER_LOT['a_1']);
											if(isset($explode[$H1])){$RES_H = $explode[$H1];}else{$RES_H = "";}//echo $RES_H;
											$Y_H = $explode[$y_1];
											
											if($Y_H != $RES_H)
											{
												$IMG = $Y_H;
												echo '<img class="im-op" src="../../img/bg-lot-moneta_'.$IMG.'.png" width="30" height="30" />';
											}
											elseif($Y_H == $RES_H)
											{
												$IMG_WIN = $RES_H;
												echo '<img class="win" src="../../img/bg-lot-moneta_'.$IMG_WIN.'.png" width="30" height="30" />';
											}
										}
									}
								}
								echo '</td>';
							}
						echo '</tr>';
					}
				echo '</table>';
			echo '</td>';
			echo '<td  width="200px">';
			
				echo '<center>';
					echo '<img src="../img/jackpot.png" width="150" height="30" alt=""/><br />';
					$jackpot = $db->Query("SELECT * FROM `m_lotery_prise` where `predmet`='jackpot'");
					$jackpot = $db->FetchArray($jackpot);
					echo '<div class="jackpot">'.$jackpot['jackpot'].'</div>';
				echo '</center>';
				
				echo '<center><b class="b-m">Таблица выигрыша</b></center>';
				if($USER_LOT['h1']!="")
				{
					$H1 = $USER_LOT['h1'];
					$H2 = $USER_LOT['h2'];
					$H3 = $USER_LOT['h3'];
					$H4 = $USER_LOT['h4'];
					$H5 = $USER_LOT['h5'];
					
					$explode = explode(',', $USER_LOT['a_1']);
					$RES_H = $explode[$H1];
					$Y_H = $RES_H;
					
					if($H2!="")
					{
						$explode = explode(',', $USER_LOT['a_2']);
						$RES_H = $explode[$H2];
						$Y_H1 = $RES_H;
					}
					
					if($H3!="")
					{
						$explode = explode(',', $USER_LOT['a_3']);
						$RES_H = $explode[$H3];
						$Y_H2 = $RES_H;
					}
					
					if($H4!="")
					{
						$explode = explode(',', $USER_LOT['a_4']);
						$RES_H = $explode[$H4];
						$Y_H3 = $RES_H;
					}
					
					if($H5!="")
					{
						$explode = explode(',', $USER_LOT['a_5']);
						$RES_H = $explode[$H5];
						$Y_H4 = $RES_H;
					}
					
					$PRICE = $db->Query("SELECT * FROM `m_lotery_prise` where `predmet`='".$Y_H."'");
					$PRICE_RES = $db->FetchArray($USER_LOT);
					
					$PORT_S = '';
					$PORT_S1 = '';
					$PORT_S2 = '';
					$PORT_S3 = '';
					$PORT_S4 = '';
					
					if($H1>=0 and $H2=="" or $Y_H!=$Y_H1)
					{
						$PORT_S = ' class="tr-m-1"';
					}
					else
					{
						if($H2>=0 and $Y_H==$Y_H1 and $H3=="" or $Y_H1!=$Y_H2)
						{
							$PORT_S1 = ' class="tr-m-1"';
						}
						else
						{
							
							if($H3>=0 and $Y_H==$Y_H1 and $Y_H1==$Y_H2 and $H4=="" or $Y_H2!=$Y_H3)
							{
								$PORT_S2 = ' class="tr-m-1"';
							}
							else
							{
								if($H4>=0 and $Y_H==$Y_H1 and $Y_H1==$Y_H2 and $Y_H2==$Y_H3 and $H5=="" or $Y_H3!=$Y_H4)
								{
									$PORT_S3 = ' class="tr-m-1"';
								}
								else
								{
									if($H5>=0 and $Y_H==$Y_H1 and $Y_H1==$Y_H2 and $Y_H2==$Y_H3 and $Y_H3==$Y_H4)
									{
										$PORT_S4 = ' class="tr-m-1"';
									}
								}
							}
						}
					}
					
					echo '<table width="200px" border="0" cellspacing="0" cellpadding="0" align="center">';
						echo '<tr '.$PORT_S.'>';
							echo '<td width="130px" class="rhp">';
								echo '<img class="ing-px" src="../../img/bg-lot-moneta_'.$Y_H.'.png" width="20" height="20" alt=""/>';
							echo '</td>';
							echo '<td width="70px" align="center">';
								echo $PRICE_RES['h1'].' Б';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr '.$PORT_S1.'>';
							echo '<td class="rhp">';
								echo '<img class="ing-px" src="../../img/bg-lot-moneta_'.$Y_H.'.png" width="20" height="20" alt=""/>';
								echo '<img class="ing-px" src="../../img/bg-lot-moneta_'.$Y_H.'.png" width="20" height="20" alt=""/>';
							echo '</td>';
							echo '<td align="center">';
								echo 'x '.$PRICE_RES['h2'];
							echo '</td>';
						echo '</tr>';
						
						echo '<tr '.$PORT_S2.'>';
							echo '<td class="rhp">';
								echo '<img class="ing-px" src="../../img/bg-lot-moneta_'.$Y_H.'.png" width="20" height="20" alt=""/>';
								echo '<img class="ing-px" src="../../img/bg-lot-moneta_'.$Y_H.'.png" width="20" height="20" alt=""/>';
								echo '<img class="ing-px" src="../../img/bg-lot-moneta_'.$Y_H.'.png" width="20" height="20" alt=""/>';
							echo '</td>';
							echo '<td align="center">';
								echo 'x '.$PRICE_RES['h3'];
							echo '</td>';
						echo '</tr>';
						
						echo '<tr '.$PORT_S3.'>';
							echo '<td class="rhp">';
								echo '<img class="ing-px" src="../../img/bg-lot-moneta_'.$Y_H.'.png" width="20" height="20" alt=""/>';
								echo '<img class="ing-px" src="../../img/bg-lot-moneta_'.$Y_H.'.png" width="20" height="20" alt=""/>';
								echo '<img class="ing-px" src="../../img/bg-lot-moneta_'.$Y_H.'.png" width="20" height="20" alt=""/>';
								echo '<img class="ing-px" src="../../img/bg-lot-moneta_'.$Y_H.'.png" width="20" height="20" alt=""/>';
							echo '</td>';
							echo '<td align="center">';
								echo 'x '.$PRICE_RES['h4'];
							echo '</td>';
						echo '</tr>';
						
						echo '<tr '.$PORT_S4.'>';
							echo '<td class="rhp">';
								echo '<img class="ing-px" src="../../img/bg-lot-moneta_'.$Y_H.'.png" width="20" height="20" alt=""/>';
								echo '<img class="ing-px" src="../../img/bg-lot-moneta_'.$Y_H.'.png" width="20" height="20" alt=""/>';
								echo '<img class="ing-px" src="../../img/bg-lot-moneta_'.$Y_H.'.png" width="20" height="20" alt=""/>';
								echo '<img class="ing-px" src="../../img/bg-lot-moneta_'.$Y_H.'.png" width="20" height="20" alt=""/>';
								echo '<img class="ing-px" src="../../img/bg-lot-moneta_'.$Y_H.'.png" width="20" height="20" alt=""/>';
							echo '</td>';
							echo '<td align="center">';
								if($PRICE_RES['h5']=='jackpot'){echo $PRICE_RES['h5'];}else{echo 'x '.$PRICE_RES['h5'];}
							echo '</td>';
						echo '</tr>';
					echo '</table>';
				}
				else
				{
					echo '<b class="b-m"> будет доступна после первого хода</b>';
				}
			echo '</td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td colspan="2" align="center">';
				$NUM = $db->Query("SELECT COUNT(*) as count FROM `m_lotery` where `user`='".$USER."'");
				$NUM_ROW = $db->FetchRow($NUM);
				if($NUM_ROW['count']==0)
				{
					echo '<div class="but-m" onClick="add_bilet()">';
						echo 'Играть';
					echo '</div>';
				}
				else
				{
					
					$db->Query("SELECT * FROM `m_lotery_stavka`");
					while($STAVKA = $db->FetchArray())
					{
						if($USER_LOT['status']==1)
						{
							echo '<span class="but-sn" onClick="hod_go()">';
								echo $STAVKA['stavka'].' '.$STAVKA['valuta'];
							echo '</span>';
						}
						elseif($USER_LOT['status']==0)
						{
							echo '<span class="but-s" onClick="PayBilet(\''.$STAVKA['id'].'\',\''.$STAVKA['stavka'].'\',\''.$USER_LOT['num_lotery'].'\')">';
								echo $STAVKA['stavka'].' '.$STAVKA['valuta'];
							echo '</span>';
						}
					}
					
					if($USER_LOT['status']==2)
					{
						echo '<div align="center" style="font-size:14px; color:#999;">';
								echo 'Игра окончена !';
						echo '</div>';
							if($USER_LOT['vid_prise'] == "bilet")
							{
								echo '<span class="but-s" style="text-align:justify;" onClick="PriceBilet()">';
									if($USER_LOT['sum_prise']==1){$BILLET='Билет колесо фортуны';}
									if($USER_LOT['sum_prise']>=2){$BILLET='Билета колесо фортуны';}
									echo 'Получить приз : '.$USER_LOT['sum_prise'].' '.$BILLET; 
							}
							elseif($USER_LOT['vid_prise'] == "money")
							{
								echo '<span class="but-s" style="text-align:justify;" onClick="PriceBilet()">';
								if($USER_LOT['status_prise']==1)
								{
									$JkPoT = 'Джекпот = '.$USER_LOT['sum_prise'];
								}
								else
								{
									$JkPoT = $USER_LOT['stavka'].' x '.$USER_LOT['sum_prise'].' = '. $USER_LOT['stavka']*$USER_LOT['sum_prise'];
								}
									echo 'Получить приз : '.$JkPoT.' руб.'; 
							}
						echo '</span>';
					}
					
					echo '<div class="mder5">';
					echo '<table border="0" width="450px" cellspacing="1" cellpadding="0">';
						echo '<tr>';
    						echo '<td class="md" colspan="2" align="center" width="100px">Контроль честности</td>';
  						echo '</tr>';
						echo '<tr>';
    						echo '<td class="md" align="right">';
								echo 'MD5 :';
							echo '</td>';
    						echo '<td class="md-2">';
								echo $USER_LOT['md5'];
							echo '</td>';
  						echo '</tr>';
						
						echo '<tr>';
    						echo '<td class="md" align="right">';
								echo 'Ваша ставка :';
							echo '</td>';
    						echo '<td class="md-2">';
								if($USER_LOT['stavka']=="" or $USER_LOT['stavka']<0)
								{
									echo '<b>Ставка еще не выбрана (не оплачена)</b>';
								}
								else
								{
									echo '<b>'.$USER_LOT['stavka'].' </b>руб';
								}
							echo '</td>';
  						echo '</tr>';
						
						echo '<tr>';
    						echo '<td class="md" width="110px" align="right">Резултат игры :</td>';
    						echo '<td class="md-2">';
								if($USER_LOT['status']==1 or $USER_LOT['status']==0)
								{
									echo 'по завершению игры';
								}
								elseif($USER_LOT['status']==2)
								{
									echo '<span style="font-size:13px;">'.iconv('windows-1251', 'utf-8', $USER_LOT['nomd5']).'</span>';
								}
							echo '</td>';
  						echo '</tr>';
					echo '</table>';
					echo '</div>';
				}
				$db->Query("SELECT * FROM `m_lotery_history` WHERE `status_prise`='1' ORDER BY `id` DESC limit 1");
				while($HISTORY = $db->FetchArray())
				{
					echo '<table class="b-rad" style="margin-top:35px;" width="100%" border="0" cellspacing="1" cellpadding="1" align="center">';
					echo '<tr bgcolor="#ccc" style="font-size:14px; color:#0E5498">';
						echo '<td width="33%" align="center" style="color:#0E5498;font-size:16px;font-weight:bold;" colspan="3">
							Последний выигранный Джекпот
						</td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td align="center">';
							echo '<span class="gt-rot">'.$HISTORY['user'].'</span>';
						echo '</td>';
						echo '<td align="center">';
							echo '<span class="gt-rot">'. $HISTORY['id_lotety'].'</span>';
						echo '</td>';
						echo '<td align="center">';
							echo '<span class="gt-rot">'. $HISTORY['money'].' руб.</span>';
						echo '</td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td align="center" class="borer-t" colspan="3">';
						echo '</td>';
					echo '</tr>';
					echo '</table>';				//echo '<br />';	
				}
				echo '<br /><br />';
					echo '<input class="toggle-box" id="identifier-2" type="checkbox" >';
					echo '<label for="identifier-2"><span class="but-s">20 Последнних игр</span></label>';
					echo '<div>';
						echo '<br />';
						
							echo '<table class="b-rad" width="100%" border="0" cellspacing="1" cellpadding="1" align="center">';
								echo '<tr bgcolor="#ccc" style="font-size:14px; color:#0E5498">';
									echo '<td width="33%" align="center">Пользователь</td>';
									echo '<td width="33%" align="center">Номер лотереи</td>';
									echo '<td width="33%" align="center">Приз</td>';
								echo '</tr>';
								
								
								$db->Query("SELECT * FROM `m_lotery_history` ORDER BY `id` DESC limit 20");
								while($HISTORY = $db->FetchArray())
								{
									echo '<tr>';
										echo '<td align="center">';
											echo '<span class="gt-rot">'.$HISTORY['user'].'</span>';
										echo '</td>';
										echo '<td align="center">';
											echo '<span class="gt-rot">'.$HISTORY['id_lotety'].'</span>';
										echo '</td>';
										echo '<td align="center">';
											if($HISTORY['money']!= '0.00')
											{
												echo '<span class="gt-rot">'.$HISTORY['money'].' руб.</span>';
											}
											elseif($HISTORY['bilet']>0)
											{
												if($HISTORY['bilet']==1){
													echo '<span class="gt-rot">'.$HISTORY['bilet'].'</span><br />
													<span class="gt-rot2">билет на колесо фортуны</span>';
												}
												elseif($HISTORY['bilet']>1){
													echo '<span class="gt-rot">'.$HISTORY['bilet'].'</span><br />
													<span class="gt-rot2">билета на колесо фортуны</span>';
												}
											}
										echo '</td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td align="center" class="borer-t" colspan="3">';
										echo '</td>';
									echo '</tr>';
								}
							echo '</table>';

					echo '</div>';
				echo '<br /><br />';
			echo '</td>';
		echo '</tr>';
	echo '</table>';
?>