<div class="s-bk-lf">
	<div class="acc-title3">Статистика проекта</div>
</div>
<div class="silver-bk"><div class="clr"></div>	
<?PHP

$db->Query("SELECT 
	COUNT(id) all_users, 
	SUM(money_b) money_b, 
	SUM(money_p) money_p, 
	
	SUM(a_t) a_t, 
	SUM(b_t) b_t, 
	SUM(c_t) c_t, 
	SUM(d_t) d_t, 
	SUM(e_t) e_t, 
	 
	SUM(all_time_c) all_time_c, 
	SUM(all_time_d) all_time_d, 
	

	SUM(f_t) f_t, 
	SUM(g_t) g_t, 
	SUM(h_t) h_t, 
	SUM(i_t) i_t, 
	SUM(j_t) j_t,  
	
	
        SUM(k_t) k_t, 
	SUM(l_t) l_t, 
	SUM(m_t) m_t, 
	SUM(n_t) n_t, 
	SUM(o_t) o_t,
        SUM(p_t) p_t, 
	SUM(q_t) q_t, 
	SUM(r_t) r_t, 
	SUM(s_t) s_t, 
	SUM(t_t) t_t,

        SUM(bar1) bar1,
	SUM(bar2) bar2,
	SUM(bar3) bar3,

        SUM(coctel_a) coctel_a,
	SUM(coctel_b) coctel_b,
	SUM(coctel_c) coctel_c,
	
	SUM(coctel_ap) coctel_ap,
	SUM(coctel_bp) coctel_bp,
	SUM(coctel_cp) coctel_cp,

        

	SUM(payment_sum) payment_sum, 
	SUM(insert_sum) insert_sum
	
	
	FROM ".$pref."_users_b");
$data_stats = $db->FetchArray();

?>

<table width="450" border="0" align="center">
  <tr class="htt">
    <td><b>Зарегистрировано пользователей:</b></td>
	<td width="100" align="center"><?=$data_stats["all_users"]; ?> чел.</td>
  </tr>
  
  <tr> <td colspan="2" align="center"><b>- - - - -</b></td> </tr>
  
  <tr class="htt">
    <td><b>Серебра на счетах (Для покупок):</b></td>
	<td width="100" align="center"><?=sprintf("%.0f",$data_stats["money_b"]); ?></td>
  </tr>
  
  <tr class="htt">
    <td><b>Золота на счетах (На вывод):</b></td>
	<td width="100" align="center"><?=sprintf("%.0f",$data_stats["money_p"]); ?></td>
  </tr>
  
  <tr> <td colspan="2" align="center"><b>- - - - -</b></td> </tr>
  
  <tr class="htt">
    <td><b>Рабочих:</b></td>
	<td width="100" align="center"><?=intval($data_stats["a_t"]); ?> шт.</td>
  </tr>
  
  <tr class="htt">
    <td><b>Хозяюшек:</b></td>
	<td width="100" align="center"><?=intval($data_stats["b_t"]); ?> шт.</td>
  </tr>
  
  <tr class="htt">
    <td><b>Лесорубов:</b></td>
	<td width="100" align="center"><?=intval($data_stats["c_t"]); ?> шт.</td>
  </tr>
  
  <tr class="htt">
    <td><b>Шахтеров:</b></td>
	<td width="100" align="center"><?=intval($data_stats["d_t"]); ?> шт.</td>
  </tr>
  
  <tr class="htt">
    <td><b>Рыцарей:</b></td>
	<td width="100" align="center"><?=intval($data_stats["e_t"]); ?> шт.</td>
  </tr>
  
  <tr class="htt">
    <td><b>Командиров:</b></td>
	<td width="100" align="center"><?=intval($data_stats["f_t"]); ?> шт.</td>
  </tr>

 

  

 <tr> <td colspan="2" align="center"><b>- - - - -</b></td> </tr>
  
  <tr class="htt">
    <td><b>Построено Складов:</b></td>
	<td width="100" align="center"><?=intval($data_stats["k_t"]); ?> шт.</td>
  </tr>
  
  <tr class="htt">
    <td><b>Построено Мельниц:</b></td>
	<td width="100" align="center"><?=intval($data_stats["l_t"]); ?> шт.</td>
  </tr>
  
  <tr class="htt">
    <td><b>Построено Кирпич.Заводов:</b></td>
	<td width="100" align="center"><?=intval($data_stats["m_t"]); ?> шт.</td>
  </tr>
  
  <tr class="htt">
    <td><b>Построено Пилорам:</b></td>
	<td width="100" align="center"><?=intval($data_stats["n_t"]); ?> шт.</td>
  </tr>
  
  <tr class="htt">
    <td><b>Построено Литейных Заводов:</b></td>
	<td width="100" align="center"><?=intval($data_stats["o_t"]); ?> шт.</td>
  </tr>

<tr class="htt">
    <td><b>Построено Колбасных Цехов:</b></td>
	<td width="100" align="center"><?=intval($data_stats["p_t"]); ?> шт.</td>
  </tr>
  
  <tr class="htt">
    <td><b>Построено Загонов:</b></td>
	<td width="100" align="center"><?=intval($data_stats["q_t"]); ?> шт.</td>
  </tr>
  
  <tr class="htt">
    <td><b>Построено Пекарней:</b></td>
	<td width="100" align="center"><?=intval($data_stats["r_t"]); ?> шт.</td>
  </tr>
  
  <tr class="htt">
    <td><b>Построено Пивоварень:</b></td>
	<td width="100" align="center"><?=intval($data_stats["s_t"]); ?> шт.</td>
  </tr>
  
  <tr class="htt">
    <td><b>Построено Шашлычных:</b></td>
	<td width="100" align="center"><?=intval($data_stats["t_t"]); ?> шт.</td>
  </tr>

<tr class="htt">
    <td><b>Обновлено Казарм:</b></td>
	<td width="100" align="center"><?=intval($data_stats["g_t"]); ?> шт.</td>
  </tr>

 <tr> <td colspan="2" align="center"><b>- - - - -</b></td> </tr>
  
  <tr class="htt">
    <td><b>Куплено Овечек:</b></td>
	<td width="100" align="center"><?=intval($data_stats["u_t"]); ?> шт.</td>
  </tr>
  
  <tr class="htt">
    <td><b>Куплено Лошадей:</b></td>
	<td width="100" align="center"><?=intval($data_stats["v_t"]); ?> шт.</td>
  </tr>
  
  

<tr> <td colspan="2" align="center"><b>- - - - -</b></td> </tr>

<tr class="htt">
    <td><b>Продукции на продажу (Хлеб):</b></td>
	<td width="150" align="center"><?=intval($data_stats["coctel_a"]); ?> шт.</td>
  </tr>
  
  <tr class="htt">
    <td><b>Продукции на продажу (Шашлык):</b></td>
	<td width="150" align="center"><?=intval($data_stats["coctel_b"]); ?> шт.</td>
  </tr>
  
  <tr class="htt">
    <td><b>Продукции на продажу (Колбаса):</b></td>
	<td width="150" align="center"><?=intval($data_stats["coctel_c"]); ?> шт.</td>
  </tr>

<tr class="htt">
    <td><b>Продукции на продажу (Пиво):</b></td>
	<td width="150" align="center"><?=intval($data_stats["coctel_d"]); ?> шт.</td>
  </tr>

<tr> <td colspan="2" align="center"><b>- - - - -</b></td> </tr>

<tr class="htt">
    <td><b>Для употребления (Хлеб):</b></td>
	<td width="150" align="center"><?=intval($data_stats["coctel_ap"]); ?> шт.</td>
  </tr>
  
  <tr class="htt">
    <td><b>Для употребления (Шашлык):</b></td>
	<td width="150" align="center"><?=intval($data_stats["coctel_bp"]); ?> шт.</td>
  </tr>
  
  <tr class="htt">
    <td><b>Для употребления (Колбаса):</b></td>
	<td width="150" align="center"><?=intval($data_stats["coctel_cp"]); ?> шт.</td>
  </tr>

 <tr class="htt">
    <td><b>Для употребления (Пиво):</b></td>
	<td width="150" align="center"><?=intval($data_stats["coctel_dp"]); ?> шт.</td>
  </tr>

<tr> <td colspan="2" align="center"><b>- - - - -</b></td> </tr>

  <tr class="htt">
    <td><b>Введено пользователями:</b></td>
	<td width="100" align="center"><?=sprintf("%.2f",$data_stats["insert_sum"]); ?> <?=$config->VAL; ?></td>
  </tr>
  
  <tr class="htt">
    <td><b>Выплачено пользователям:</b></td>
	<td width="100" align="center"><?=sprintf("%.2f",$data_stats["payment_sum"]); ?> <?=$config->VAL; ?></td>
  </tr>
  
</table>

</div>
<div class="clr"></div>	