<div class="s-bk-lf">
	<div class="acc-title3">���������� �������</div>
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
    <td><b>���������������� �������������:</b></td>
	<td width="100" align="center"><?=$data_stats["all_users"]; ?> ���.</td>
  </tr>
  
  <tr> <td colspan="2" align="center"><b>- - - - -</b></td> </tr>
  
  <tr class="htt">
    <td><b>������� �� ������ (��� �������):</b></td>
	<td width="100" align="center"><?=sprintf("%.0f",$data_stats["money_b"]); ?></td>
  </tr>
  
  <tr class="htt">
    <td><b>������ �� ������ (�� �����):</b></td>
	<td width="100" align="center"><?=sprintf("%.0f",$data_stats["money_p"]); ?></td>
  </tr>
  
  <tr> <td colspan="2" align="center"><b>- - - - -</b></td> </tr>
  
  <tr class="htt">
    <td><b>�������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["a_t"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>��������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["b_t"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>���������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["c_t"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>��������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["d_t"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>�������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["e_t"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>����������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["f_t"]); ?> ��.</td>
  </tr>

 

  

 <tr> <td colspan="2" align="center"><b>- - - - -</b></td> </tr>
  
  <tr class="htt">
    <td><b>��������� �������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["k_t"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>��������� �������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["l_t"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>��������� ������.�������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["m_t"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>��������� �������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["n_t"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>��������� �������� �������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["o_t"]); ?> ��.</td>
  </tr>

<tr class="htt">
    <td><b>��������� ��������� �����:</b></td>
	<td width="100" align="center"><?=intval($data_stats["p_t"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>��������� �������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["q_t"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>��������� ��������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["r_t"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>��������� ����������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["s_t"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>��������� ���������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["t_t"]); ?> ��.</td>
  </tr>

<tr class="htt">
    <td><b>��������� ������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["g_t"]); ?> ��.</td>
  </tr>

 <tr> <td colspan="2" align="center"><b>- - - - -</b></td> </tr>
  
  <tr class="htt">
    <td><b>������� ������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["u_t"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>������� �������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["v_t"]); ?> ��.</td>
  </tr>
  
  

<tr> <td colspan="2" align="center"><b>- - - - -</b></td> </tr>

<tr class="htt">
    <td><b>��������� �� ������� (����):</b></td>
	<td width="150" align="center"><?=intval($data_stats["coctel_a"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>��������� �� ������� (������):</b></td>
	<td width="150" align="center"><?=intval($data_stats["coctel_b"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>��������� �� ������� (�������):</b></td>
	<td width="150" align="center"><?=intval($data_stats["coctel_c"]); ?> ��.</td>
  </tr>

<tr class="htt">
    <td><b>��������� �� ������� (����):</b></td>
	<td width="150" align="center"><?=intval($data_stats["coctel_d"]); ?> ��.</td>
  </tr>

<tr> <td colspan="2" align="center"><b>- - - - -</b></td> </tr>

<tr class="htt">
    <td><b>��� ������������ (����):</b></td>
	<td width="150" align="center"><?=intval($data_stats["coctel_ap"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>��� ������������ (������):</b></td>
	<td width="150" align="center"><?=intval($data_stats["coctel_bp"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>��� ������������ (�������):</b></td>
	<td width="150" align="center"><?=intval($data_stats["coctel_cp"]); ?> ��.</td>
  </tr>

 <tr class="htt">
    <td><b>��� ������������ (����):</b></td>
	<td width="150" align="center"><?=intval($data_stats["coctel_dp"]); ?> ��.</td>
  </tr>

<tr> <td colspan="2" align="center"><b>- - - - -</b></td> </tr>

  <tr class="htt">
    <td><b>������� ��������������:</b></td>
	<td width="100" align="center"><?=sprintf("%.2f",$data_stats["insert_sum"]); ?> <?=$config->VAL; ?></td>
  </tr>
  
  <tr class="htt">
    <td><b>��������� �������������:</b></td>
	<td width="100" align="center"><?=sprintf("%.2f",$data_stats["payment_sum"]); ?> <?=$config->VAL; ?></td>
  </tr>
  
</table>

</div>
<div class="clr"></div>	