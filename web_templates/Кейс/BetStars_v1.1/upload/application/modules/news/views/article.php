<?php   

	//include('simple_html_dom.php');
	

	
//	http://www.espnfc.com/gamecast/432136/gamecast.html
	
	
//$html = new simple_html_dom();
//$html->load($page);
$article = $html->find('article', 0);
$grid_content = $html->find('.grid-item-content', 0);
$util = $html->find('.article-util', 0);
$tags = $html->find('.tags', 0);
$share = $html->find('.sharetools', 0);
$mod = $html->find('.matchhq-module');
$comp_mod = $html->find('.competition-module',0);
$mvwidget = $html->find('.mv-widget',0);


$href = $html->find('article a');
if($share){
	$share->outertext = '';
}
if($util){
	$util->outertext = '';
}
if($tags){
	$tags->outertext = '';
}
if($mod){
	foreach ($mod as $m){
		$m->outertext = '';
	}	
}
if($comp_mod){
	$comp_mod->outertext = '';
}
if($mvwidget){
	$mvwidget->outertext = '';
}
if($href){
	foreach ($href as $m){
		strip_tags($m->class = 'no-link');
	}	
}
?>



	<div class="box">
		<div class="box-body">		
			<div class="box-header bg-white">
				<h3 class="box-title"></h3>
				<div class="box-tools pull-right">
					<img class="img-responsive mb5"src="<?php echo base_url();?>assets/img/espn_dotcom_black.gif">
				</div>
			</div>
			<div class="divider-4"></div>		
		<?php if($article) {
			echo $article;
		}
		?>
        </div>
    </div>
		