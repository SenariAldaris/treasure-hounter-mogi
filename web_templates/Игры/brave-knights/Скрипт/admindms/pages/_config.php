<div class="s-bk-lf">
	<div class="acc-title3">���������</div>
</div>
<div class="silver-bk"><div class="clr"></div>	
<?PHP
$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1'");
$data_c = $db->FetchArray();

# ����������
if(isset($_POST["save"])){


	
	$reg_key = intval($_POST['reg_key']);
	$auto = intval($_POST['auto']);
	$ser_per_wmr = intval($_POST["ser_per_wmr"]);
	$ser_per_wmz = intval($_POST["ser_per_wmz"]);
	$ser_per_wme = intval($_POST["ser_per_wme"]);
        $ser_per_btc = intval($_POST["ser_per_btc"]);
	$percent_swap = intval($_POST["percent_swap"]);
	$percent_sell = intval($_POST["percent_sell"]);
        $percent_sell2 = intval($_POST["percent_sell2"]);
	$percent_sell3 = intval($_POST["percent_sell3"]);
	$percent_sell4 = intval($_POST["percent_sell4"]);
	$percent_sell5 = intval($_POST["percent_sell5"]);
        $percent_sell6 = intval($_POST["percent_sell6"]);
	$items_per_coin = intval($_POST["items_per_coin"]);
	$items_per_coin2 = intval($_POST["items_per_coin2"]);
	$items_per_coin3 = intval($_POST["items_per_coin3"]);
	$items_per_coin4 = intval($_POST["items_per_coin4"]);
	$items_per_coin5 = intval($_POST["items_per_coin5"]);
        $items_per_coin6 = intval($_POST["items_per_coin6"]);

	$tomat_in_h = intval($_POST["a_in_h"]);
	$straw_in_h = intval($_POST["b_in_h"]);
	$pump_in_h = intval($_POST["c_in_h"]);
	$peas_in_h = intval($_POST["d_in_h"]);
	$pean_in_h = intval($_POST["e_in_h"]);
        
        $tomat_in_h2 = intval($_POST["f_in_h"]);
	$straw_in_h2 = intval($_POST["g_in_h"]);
	$pump_in_h2 = intval($_POST["h_in_h"]);
	$peas_in_h2 = intval($_POST["i_in_h"]);
	$pean_in_h2 = intval($_POST["j_in_h"]);
        $tomat_in_h7 = intval($_POST["f_in_h"]);
        $tomat_in_h3 = intval($_POST["k_in_h"]);
	$straw_in_h3 = intval($_POST["l_in_h"]);
	$pump_in_h3 = intval($_POST["m_in_h"]);
	$peas_in_h3 = intval($_POST["n_in_h"]);
	$pean_in_h3 = intval($_POST["o_in_h"]);
	
	$tomat_in_h4 = intval($_POST["p_in_h"]);
	$straw_in_h4 = intval($_POST["q_in_h"]);
	$pump_in_h4 = intval($_POST["r_in_h"]);
	$peas_in_h4 = intval($_POST["s_in_h"]);
	$pean_in_h4 = intval($_POST["t_in_h"]);
	
	$tomat_in_h5 = intval($_POST["u_in_h"]);
	$straw_in_h5 = intval($_POST["v_in_h"]);
	$pump_in_h5 = intval($_POST["w_in_h"]);
	$peas_in_h5 = intval($_POST["x_in_h"]);
	$pean_in_h5 = intval($_POST["y_in_h"]);
        
        $tomat_in_h6 = intval($_POST["a1_in_h"]);
	$straw_in_h6 = intval($_POST["b1_in_h"]);
	$pump_in_h6 = intval($_POST["c1_in_h"]);
	$peas_in_h6 = intval($_POST["d1_in_h"]);
	$pean_in_h6 = intval($_POST["e1_in_h"]);
        
	
	$amount_tomat_t = intval($_POST["amount_a_t"]);
	$amount_straw_t = intval($_POST["amount_b_t"]);
	$amount_pump_t = intval($_POST["amount_c_t"]);
	$amount_peas_t = intval($_POST["amount_d_t"]);
	$amount_pean_t = intval($_POST["amount_e_t"]);

        $amount_tomat_t2 = intval($_POST["amount_f_t"]);
	$amount_straw_t2 = intval($_POST["amount_g_t"]);
	$amount_pump_t2 = intval($_POST["amount_h_t"]);
	$amount_peas_t2 = intval($_POST["amount_i_t"]);
	$amount_pean_t2 = intval($_POST["amount_j_t"]);
	
	$amount_tomat_t3 = intval($_POST["amount_k_t"]);
	$amount_straw_t3 = intval($_POST["amount_l_t"]);
	$amount_pump_t3 = intval($_POST["amount_m_t"]);
	$amount_peas_t3 = intval($_POST["amount_n_t"]);
	$amount_pean_t3 = intval($_POST["amount_o_t"]);
	
	$amount_tomat_t4 = intval($_POST["amount_p_t"]);
	$amount_straw_t4 = intval($_POST["amount_q_t"]);
	$amount_pump_t4 = intval($_POST["amount_r_t"]);
	$amount_peas_t4 = intval($_POST["amount_s_t"]);
	$amount_pean_t4 = intval($_POST["amount_t_t"]);
	
	$amount_tomat_t5 = intval($_POST["amount_u_t"]);
	$amount_straw_t5 = intval($_POST["amount_v_t"]);
	$amount_pump_t5 = intval($_POST["amount_w_t"]);
	$amount_peas_t5 = intval($_POST["amount_x_t"]);
	$amount_pean_t5 = intval($_POST["amount_y_t"]);

        $amount_area1 = ($_POST["amount_area1"]);
	$amount_area2 = ($_POST["amount_area2"]);
	$amount_area3 = ($_POST["amount_area3"]);
	
	$amount_bar1 = ($_POST["amount_bar1"]);
	$amount_bar2 = ($_POST["amount_bar2"]);
	$amount_bar3 = ($_POST["amount_bar3"]);

        $buy_coctel_ap = ($_POST["buy_coctel_ap"]);
	$buy_coctel_bp = ($_POST["buy_coctel_bp"]);
	$buy_coctel_cp = ($_POST["buy_coctel_cp"]);
        $buy_coctel_dp = ($_POST["buy_coctel_dp"]);
	
	$sell_coctel_a = ($_POST["sell_coctel_a"]);
	$sell_coctel_b = ($_POST["sell_coctel_b"]);
	$sell_coctel_c = ($_POST["sell_coctel_c"]);
        $sell_coctel_d = ($_POST["sell_coctel_d"]);

        $buy_a_b = ($_POST["buy_a_b"]);
	$buy_b_b = ($_POST["buy_b_b"]);
	$buy_c_b = ($_POST["buy_c_b"]);
	$buy_d_b = ($_POST["buy_d_b"]);
	$buy_f_b = ($_POST["buy_f_b"]);
	$buy_l_b = ($_POST["buy_l_b"]);
        $buy_h_b = ($_POST["buy_h_b"]);
	$buy_i_b = ($_POST["buy_i_b"]);
        $buy_u_b = ($_POST["buy_u_b"]);
	$buy_v_b = ($_POST["buy_v_b"]);

	$sell_a_b = ($_POST["sell_a_b"]);
	$sell_b_b = ($_POST["sell_b_b"]);
	$sell_c_b = ($_POST["sell_c_b"]);
	$sell_d_b = ($_POST["sell_d_b"]);
	$sell_f_b = ($_POST["sell_f_b"]);
	$sell_l_b = ($_POST["sell_l_b"]);
	$sell_h_b = ($_POST["sell_h_b"]);
	$sell_i_b = ($_POST["sell_i_b"]);
	$sell_u_b = ($_POST["sell_u_b"]);
	$sell_v_b = ($_POST["sell_v_b"]);

        $amount_tomat_t6 = intval($_POST["amount_a1_t"]);
	$amount_straw_t6 = intval($_POST["amount_b1_t"]);
	$amount_pump_t6 = intval($_POST["amount_c1_t"]);
	$amount_peas_t6 = intval($_POST["amount_d1_t"]);
	$amount_pean_t6 = intval($_POST["amount_e1_t"]);
	$amount_tomat_t7 = intval($_POST["amount_f_b"]);
	# �������� �� ������
	$errors = true;
	

	
	if($percent_swap < 1 OR $percent_swap > 99){
		$errors = false; echo "<center><font color = 'red'><b>������������ ������� ��� ������ ������ ���� �� 1 �� 99</b></font></center><BR />"; 
	}
	
        if($percent_sell < 1 OR $percent_sell > 99){
		$errors = false; echo "<center><font color = 'red'><b>% ������� �� ����� ��� ������� ������ ���� �� 1 �� 99</b></font></center><BR />"; 
	}

	
if($items_per_coin < 1 OR $items_per_coin > 50000){
		$errors = false; echo "<center><font color = 'red'><b>������� ������� = 1 �������, ������ ���� �� 1 �� 50000</b></font></center><BR />"; 
	}


	
	if($tomat_in_h < 1 OR $straw_in_h < 1 OR $pump_in_h < 1 OR $peas_in_h < 1 OR $pean_in_h < 1){
		$errors = false; echo "<center><font color = 'red'><b>�������� ��������� �������� � ���! ������� 6</b></font></center><BR />"; 
	}
	
 
	
	if($amount_tomat_t < 1 OR $amount_straw_t < 1 OR $amount_pump_t < 1 OR $amount_peas_t < 1 OR $amount_pean_t < 1){
		$errors = false; echo "<center><font color = 'red'><b>����������� ��������� ������ �� ������ ���� ����� 1�� �������</b></font></center><BR />"; 
	}

         if($amount_tomat_t2 < 1 OR $amount_tomat_t5 < 1 OR $amount_straw_t5 < 1 OR $amount_straw_t2 < 1){
		$errors = false; echo "<center><font color = 'red'><b>2 ����������� ��������� ������ �� ������ ���� ����� 1�� �������</b></font></center><BR />"; 
	}
	
	if($tomat_in_h5 < 1 OR $straw_in_h5 < 1){
		$errors = false; echo "<center><font color = 'red'><b>�������� ��������� �������� � ���! ������� 1</b></font></center><BR />"; 
	}

  if($buy_a_b < 0.01 OR $buy_b_b < 0.01 OR $buy_c_b < 0.01 OR $buy_d_b < 0.01 OR $buy_f_b < 0.01 OR $buy_l_b < 0.01 OR $buy_h_b < 0.01 OR $buy_i_b < 0.01 OR $buy_u_b < 0.01 OR $buy_v_b < 0.01){
		$errors = false; echo "<center><font color = 'red'><b>8 ����������� ��������� ������� ����� �� ������ ���� ����� 0.01 ���</b></font></center><BR />"; 
	}

        if($sell_a_b < 0.01 OR $sell_b_b < 0.01 OR $sell_c_b < 0.01 OR $sell_d_b < 0.01 OR $sell_f_b < 0.01 OR $sell_l_b < 0.01 OR $sell_h_b < 0.01 OR $sell_i_b < 0.01 OR $sell_u_b < 0.01 OR $sell_v_b < 0.01){
		$errors = false; echo "<center><font color = 'red'><b>9 ����������� ��������� ������� ����� �� ������ ���� ����� 0.01 ���</b></font></center><BR />"; 
	}


	if($buy_coctel_ap < 0.01 OR $buy_coctel_bp < 0.01 OR $buy_coctel_cp < 0.01 OR $buy_coctel_dp < 0.01){
		$errors = false; echo "<center><font color = 'red'><b>����������� ��������� ������� �������� �� ������ ���� ����� 0.01 ���</b></font></center><BR />"; 
	}
	
	if($sell_coctel_a < 0.01 OR $sell_coctel_b < 0.01 OR $sell_coctel_c < 0.01 OR $sell_coctel_d < 0.01){
		$errors = false; echo "<center><font color = 'red'><b>����������� ��������� ������� �������� �� ������ ���� ����� 0.01 ���</b></font></center><BR />"; 
	}



	# ����������
	if($errors){
	
		$db->Query("UPDATE ".$pref."_config SET 
		
		
		ser_per_wmr = '$ser_per_wmr',
		ser_per_wmz = '$ser_per_wmz',
		ser_per_wme = '$ser_per_wme',
                ser_per_btc = '$ser_per_btc',
		percent_swap = '$percent_swap',
		percent_sell = '$percent_sell',
                percent_sell2 = '$percent_sell2',
		percent_sell3 = '$percent_sell3',
		percent_sell4 = '$percent_sell4',
		percent_sell5 = '$percent_sell5',
                percent_sell6 = '$percent_sell6',
		items_per_coin = '$items_per_coin',
                items_per_coin2 = '$items_per_coin2',
		items_per_coin3 = '$items_per_coin3',
		items_per_coin4 = '$items_per_coin4',
		items_per_coin5 = '$items_per_coin5',
                items_per_coin6 = '$items_per_coin6',
		a_in_h = '$tomat_in_h',
		b_in_h = '$straw_in_h',
		c_in_h = '$pump_in_h',
		d_in_h = '$peas_in_h',
		e_in_h = '$pean_in_h',
                f_in_h = '$tomat_in_h2',
		g_in_h = '$straw_in_h2',
		h_in_h = '$pump_in_h2',
		i_in_h = '$peas_in_h2',
		j_in_h = '$pean_in_h2',
		k_in_h = '$tomat_in_h3',
		l_in_h = '$straw_in_h3',
		m_in_h = '$pump_in_h3',
		n_in_h = '$peas_in_h3',
		o_in_h = '$pean_in_h3',
		p_in_h = '$tomat_in_h4',
		q_in_h = '$straw_in_h4',
		r_in_h = '$pump_in_h4',
		s_in_h = '$peas_in_h4',
		t_in_h = '$pean_in_h4',
		u_in_h = '$tomat_in_h5',
		v_in_h = '$straw_in_h5',
		w_in_h = '$pump_in_h5',
		x_in_h = '$peas_in_h5',
		y_in_h = '$pean_in_h5',
	        
                f_in_h = '$tomat_in_h7',

		amount_a_t = '$amount_tomat_t',
		amount_b_t = '$amount_straw_t',
		amount_c_t = '$amount_pump_t',
		amount_d_t = '$amount_peas_t',
		amount_e_t = '$amount_pean_t',

                amount_f_t = '$amount_tomat_t2',
		amount_g_t = '$amount_straw_t2',
		amount_h_t = '$amount_pump_t2',
		amount_i_t = '$amount_peas_t2',
		amount_j_t = '$amount_pean_t2',
		
		amount_k_t = '$amount_tomat_t3',
		amount_l_t = '$amount_straw_t3',
		amount_m_t = '$amount_pump_t3',
		amount_n_t = '$amount_peas_t3',
		amount_o_t = '$amount_pean_t3',
		
		amount_p_t = '$amount_tomat_t4',
		amount_q_t = '$amount_straw_t4',
		amount_r_t = '$amount_pump_t4',
		amount_s_t = '$amount_peas_t4',
		amount_t_t = '$amount_pean_t4',
		
		amount_u_t = '$amount_tomat_t5',
		amount_v_t = '$amount_straw_t5',
		amount_w_t = '$amount_pump_t5',
		amount_x_t = '$amount_peas_t5',
		amount_y_t = '$amount_pean_t5',


                
	        amount_area1 = '$amount_area1',
		amount_area2 = '$amount_area2',
		amount_area3 = '$amount_area3',
		
		amount_bar1 = '$amount_bar1',
		amount_bar2 = '$amount_bar2',
		amount_bar3 = '$amount_bar3',
		
                buy_a_b = '$buy_a_b',
	        buy_b_b = '$buy_b_b',
	        buy_c_b = '$buy_c_b',
                buy_d_b = '$buy_d_b',
	        buy_f_b = '$buy_f_b',
	        buy_l_b = '$buy_l_b',
                buy_h_b = '$buy_h_b',
	        buy_i_b = '$buy_i_b',
	        buy_u_b = '$buy_u_b',
	        buy_v_b = '$buy_v_b',

	        sell_a_b = '$sell_a_b',
	        sell_b_b = '$sell_b_b',
	        sell_c_b = '$sell_c_b',
                sell_d_b = '$sell_d_b',
	        sell_f_b = '$sell_f_b',
	        sell_l_b = '$sell_l_b',
                sell_h_b = '$sell_h_b',
	        sell_i_b = '$sell_i_b',
	        sell_u_b = '$sell_u_b',
                sell_v_b = '$sell_v_b',

		buy_coctel_ap = '$buy_coctel_ap',
		buy_coctel_bp = '$buy_coctel_bp',
		buy_coctel_cp = '$buy_coctel_cp',
                buy_coctel_dp = '$buy_coctel_dp',
		
		sell_coctel_a = '$sell_coctel_a',
		sell_coctel_b = '$sell_coctel_b',
		sell_coctel_c = '$sell_coctel_c',
                sell_coctel_d = '$sell_coctel_d',
                  
		reg_key = '$reg_key',
		auto = '$auto'
		
		WHERE id = '1'");
		
		echo "<center><font color = '#914A1F'><b>���������</b></font></center><BR />";
		$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1'");
		$data_c = $db->FetchArray();
	}
	
}

?>
<form action="" method="post">
<table width="100%" border="0">
<input type="hidden" name="save">
  
<tr bgcolor="#B9AF95">
    <td><b>��������� 1 BTC (��������):</b></td>
	<td width="150" align="center"><input type="text" name="ser_per_btc" value="<?=$data_c["ser_per_btc"]; ?>" /></td>
  </tr>

  <tr>
    <td><b>��������� 1 RUB (��������):</b></td>
	<td width="150" align="center"><input type="text" name="ser_per_wmr" value="<?=$data_c["ser_per_wmr"]; ?>" /></td>
  </tr>
  
  <tr bgcolor="#B9AF95">
    <td><b>��������� 1 USD (��������):</b></td>
	<td width="150" align="center"><input type="text" name="ser_per_wmz" value="<?=$data_c["ser_per_wmz"]; ?>" /></td>
  </tr>
  
  <tr>
    <td><b>��������� 1 EUR (��������):</b></td>
	<td width="150" align="center"><input type="text" name="ser_per_wme" value="<?=$data_c["ser_per_wme"]; ?>" /></td>
  </tr>
  


  <tr bgcolor="#B9AF95">
    <td><b>���������� % ��� ������ (�� 1 �� 99):</b></td>
	<td width="150" align="center"><input type="text" name="percent_swap" value="<?=$data_c["percent_swap"]; ?>" /></td>
  </tr>
  
   <tr>
    <td><b>% ������� �� ����� ��� ������� (�� 1 �� 99):</b><BR /></td>
	<td width="150" align="center"><input type="text" name="percent_sell" value="<?=$data_c["percent_sell"]; ?>" /></td>
  </tr>

 
  
  
 
       <tr>
  <td>
      <hr color= "red">
	  </td>
  </tr>

  
 <tr bgcolor="#B9AF95">
    <td><b>������� ������� �� ������ = 1 �������:</b></td>
	<td width="150" align="center"><input type="text" name="items_per_coin" value="<?=$data_c["items_per_coin"]; ?>" /></td>
  </tr>

  
  
      <tr>
  <td>
      <hr color= "red">
	  </td>
  </tr>


  <tr>
    <td><b>�������� � ��� �������:</b></td>
	<td width="150" align="center"><input type="text" name="a_in_h" value="<?=$data_c["a_in_h"]; ?>" /></td>
  </tr>
  
  <tr bgcolor="#B9AF95">
    <td><b>�������� � ��� ��������:</b></td>
	<td width="150" align="center"><input type="text" name="b_in_h" value="<?=$data_c["b_in_h"]; ?>" /></td>
  </tr>
  
  <tr>
    <td><b>�������� � ��� �������:</b></td>
	<td width="150" align="center"><input type="text" name="c_in_h" value="<?=$data_c["c_in_h"]; ?>" /></td>
  </tr>
  
  <tr bgcolor="#B9AF95">
    <td><b>�������� � ��� ������:</b></td>
	<td width="150" align="center"><input type="text" name="d_in_h" value="<?=$data_c["d_in_h"]; ?>" /></td>
  </tr>
  
  <tr>
    <td><b>�������� � ��� ������:</b></td>
	<td width="150" align="center"><input type="text" name="e_in_h" value="<?=$data_c["e_in_h"]; ?>" /></td>
  </tr>
  
  
      <tr>
  <td>
      <hr color= "red">
	  </td>
  </tr>

  
  <tr>
    <td><b>��������� �������� (�������):</b></td>
	<td width="150" align="center"><input type="text" name="amount_a_t" value="<?=$data_c["amount_a_t"]; ?>" /></td>
  </tr>
  
  <tr bgcolor="#B9AF95">
    <td><b>��������� �������� (��������):</b></td>
	<td width="150" align="center"><input type="text" name="amount_b_t" value="<?=$data_c["amount_b_t"]; ?>" /></td>
  </tr>
  
  <tr>
    <td><b>���������  �������� (�������):</b></td>
	<td width="150" align="center"><input type="text" name="amount_c_t" value="<?=$data_c["amount_c_t"]; ?>" /></td>
  </tr>
  
  <tr bgcolor="#B9AF95">
    <td><b>��������� �������� (������):</b></td>
	<td width="150" align="center"><input type="text" name="amount_d_t" value="<?=$data_c["amount_d_t"]; ?>" /></td>
  </tr>
  
  <tr>
    <td><b>��������� �������� (������):</b></td>
	<td width="150" align="center"><input type="text" name="amount_e_t" value="<?=$data_c["amount_e_t"]; ?>" /></td>
  </tr>

 <tr bgcolor="#B9AF95">
    <td><b>��������� �������� (��������):</b></td>
	<td width="150" align="center"><input type="text" name="amount_f_t" value="<?=$data_c["amount_f_t"]; ?>" /></td>
  </tr>

<tr>
  <td>
      <hr color= "red">
	  </td>
  </tr>
  

  
 <tr bgcolor="#B9AF95">
    <td><b>��������� ���������� �������:</b></td>
	<td width="150" align="center"><input type="text" name="amount_g_t" value="<?=$data_c["amount_g_t"]; ?>" /></td>
  </tr>
  
  <tr>
    <td><b>��������� ��������� (����):</b></td>
	<td width="150" align="center"><input type="text" name="amount_u_t" value="<?=$data_c["amount_u_t"]; ?>" /></td>
  </tr>
  
  <tr bgcolor="#B9AF95">
    <td><b>��������� ��������� (������):</b></td>
	<td width="150" align="center"><input type="text" name="amount_v_t" value="<?=$data_c["amount_v_t"]; ?>" /></td>
  </tr>

  <tr>
    <td><b>������� � ��� ����:</b></td>
	<td width="150" align="center"><input type="text" name="u_in_h" value="<?=$data_c["u_in_h"]; ?>" /></td>
  </tr>
  
  <tr bgcolor="#B9AF95">
    <td><b>������� � ��� ������:</b></td>
	<td width="150" align="center"><input type="text" name="v_in_h" value="<?=$data_c["v_in_h"]; ?>" /></td>
  </tr>

<tr>
  <td>
      <hr color= "red">
	  </td>
  </tr>
 

  <tr bgcolor="#B9AF95">
    <td><b>���� ����� � �����:</b></td>
	<td width="150" align="center"><input type="text" name="buy_a_b" value="<?=$data_c["buy_a_b"]; ?>" /></td>
  </tr>
  
  <tr>
    <td><b>���� ������� � �����:</b></td>
	<td width="150" align="center"><input type="text" name="buy_b_b" value="<?=$data_c["buy_b_b"]; ?>" /></td>
  </tr>
  
  <tr bgcolor="#B9AF95">
    <td><b>���� ������ � �����:</b></td>
	<td width="150" align="center"><input type="text" name="buy_c_b" value="<?=$data_c["buy_c_b"]; ?>" /></td>
  </tr>
  
  <tr>
    <td><b>���� ���� � �����:</b></td>
	<td width="150" align="center"><input type="text" name="buy_d_b" value="<?=$data_c["buy_d_b"]; ?>" /></td>
  </tr>
  
 <tr bgcolor="#B9AF95">
    <td><b>���� �������� � �����:</b></td>
	<td width="150" align="center"><input type="text" name="buy_f_b" value="<?=$data_c["buy_f_b"]; ?>" /></td>
  </tr>

<tr>
    <td><b>���� ���� � �����:</b></td>
	<td width="150" align="center"><input type="text" name="buy_l_b" value="<?=$data_c["buy_l_b"]; ?>" /></td>
  </tr>

  <tr bgcolor="#B9AF95">
    <td><b>���� ����� � �����:</b></td>
	<td width="150" align="center"><input type="text" name="buy_h_b" value="<?=$data_c["buy_h_b"]; ?>" /></td>
  </tr>
  
  <tr>
    <td><b>���� ����� � �����:</b></td>
	<td width="150" align="center"><input type="text" name="buy_i_b" value="<?=$data_c["buy_i_b"]; ?>" /></td>
  </tr>
  
 <tr bgcolor="#B9AF95">
    <td><b>���� �������� � �����:</b></td>
	<td width="150" align="center"><input type="text" name="buy_u_b" value="<?=$data_c["buy_u_b"]; ?>" /></td>
  </tr>

<tr>
    <td><b>���� ������ � �����:</b></td>
	<td width="150" align="center"><input type="text" name="buy_v_b" value="<?=$data_c["buy_v_b"]; ?>" /></td>
  </tr>


    <tr>
  <td>
      <hr color= "red">
	  </td>
  </tr>

  
 <tr bgcolor="#B9AF95">
    <td><b>������� ����� � �����:</b></td>
	<td width="150" align="center"><input type="text" name="sell_a_b" value="<?=$data_c["sell_a_b"]; ?>" /></td>
  </tr>
  
  <tr>
    <td><b>������� ������� � �����:</b></td>
	<td width="150" align="center"><input type="text" name="sell_b_b" value="<?=$data_c["sell_b_b"]; ?>" /></td>
  </tr>
  
  <tr bgcolor="#B9AF95">
    <td><b>������� ������ � �����:</b></td>
	<td width="150" align="center"><input type="text" name="sell_c_b" value="<?=$data_c["sell_c_b"]; ?>" /></td>
  </tr>
  
  <tr>
    <td><b>������� ���� � �����:</b></td>
	<td width="150" align="center"><input type="text" name="sell_d_b" value="<?=$data_c["sell_d_b"]; ?>" /></td>
  </tr>
  
 <tr bgcolor="#B9AF95">
    <td><b>������� �������� � �����:</b></td>
	<td width="150" align="center"><input type="text" name="sell_f_b" value="<?=$data_c["sell_f_b"]; ?>" /></td>
  </tr>

<tr>
    <td><b>������� ���� � �����:</b></td>
	<td width="150" align="center"><input type="text" name="sell_l_b" value="<?=$data_c["sell_l_b"]; ?>" /></td>
  </tr>

  <tr bgcolor="#B9AF95">
    <td><b>������� ����� � �����:</b></td>
	<td width="150" align="center"><input type="text" name="sell_h_b" value="<?=$data_c["sell_h_b"]; ?>" /></td>
  </tr>
  
  <tr>
    <td><b>������� ����� � �����:</b></td>
	<td width="150" align="center"><input type="text" name="sell_i_b" value="<?=$data_c["sell_i_b"]; ?>" /></td>
  </tr>
  
 <tr bgcolor="#B9AF95">
    <td><b>������� �������� � �����:</b></td>
	<td width="150" align="center"><input type="text" name="sell_u_b" value="<?=$data_c["sell_u_b"]; ?>" /></td>
  </tr>

<tr>
    <td><b>������� ������ � �����:</b></td>
	<td width="150" align="center"><input type="text" name="sell_v_b" value="<?=$data_c["sell_v_b"]; ?>" /></td>
  </tr>

    <tr>
  <td>
      <hr color= "red">
	  </td>
  </tr>


<tr bgcolor="#B9AF95">
    <td><b>��������� ������� �����:</b></td>
	<td width="150" align="center"><input type="text" name="sell_coctel_a" value="<?=$data_c["sell_coctel_a"]; ?>" /></td>
  </tr>
  
  <tr>
    <td><b>��������� ������� ��������:</b></td>
	<td width="150" align="center"><input type="text" name="sell_coctel_b" value="<?=$data_c["sell_coctel_b"]; ?>" /></td>
  </tr>
  
  <tr bgcolor="#B9AF95">
    <td><b>��������� ������� �������:</b></td>
	<td width="150" align="center"><input type="text" name="sell_coctel_c" value="<?=$data_c["sell_coctel_c"]; ?>" /></td>
  </tr>
  <tr>
    <td><b>��������� ������� ����:</b></td>
	<td width="150" align="center"><input type="text" name="sell_coctel_d" value="<?=$data_c["sell_coctel_d"]; ?>" /></td>
  </tr>

<tr>
  <td>
      <hr color= "red">
	  </td>
  </tr>  
  <tr bgcolor="#B9AF95">
    <td><b>��������� ������� �����:</b></td>
	<td width="150" align="center"><input type="text" name="buy_coctel_ap" value="<?=$data_c["buy_coctel_ap"]; ?>" /></td>
  </tr>
  
  <tr>
    <td><b>��������� ������� ��������:</b></td>
	<td width="150" align="center"><input type="text" name="buy_coctel_bp" value="<?=$data_c["buy_coctel_bp"]; ?>" /></td>
  </tr>
  
  <tr bgcolor="#B9AF95">
    <td><b>��������� ������� �������:</b></td>
	<td width="150" align="center"><input type="text" name="buy_coctel_cp" value="<?=$data_c["buy_coctel_cp"]; ?>" /></td>
  </tr>
 
 <tr>
    <td><b>��������� ������� ����:</b></td>
	<td width="150" align="center"><input type="text" name="buy_coctel_dp" value="<?=$data_c["buy_coctel_dp"]; ?>" /></td>
  </tr>

<tr>
  <td>
      <hr color= "red">
	  </td>
  </tr>


  <?
  if ($data_c["reg_key"] == 1) { $sel = 'selected'; } else { $sel = ''; }
  if ($data_c["reg_key"] == 0) { $sel = 'selected'; } else { $sel = ''; }
  ?>
    <tr>
    <td><b>����������� �� ������ � E-Mail:</b></td>
	<td width="150" align="center"><select name="reg_key" width="150">
	<option value="1" <?=$sel; ?>>��
	<option value="0" <?=$sel; ?>>���
	
	</select></td>
  </tr>
  
  
    <?
  if ($data_c["auto"] == 1) { $sell = 'selected'; } else { $sell = ''; }
  if ($data_c["auto"] == 0) { $sell = 'selected'; } else { $sell = ''; }
  ?>
    <tr bgcolor="#B9AF95">
    <td><b>�����������:</b></td>
	<td width="150" align="center"><select name="auto" width="150">
	<option value="1" <?=$sell; ?>>��
	<option value="0" <?=$sell; ?>>���
	
	</select></td>
  </tr>
  
  <tr> <td colspan="2" align="center"><input type="submit" value="���������" class="btn_8"/></td> </tr>
</table>
</form>
</div>
<div class="clr"></div>	