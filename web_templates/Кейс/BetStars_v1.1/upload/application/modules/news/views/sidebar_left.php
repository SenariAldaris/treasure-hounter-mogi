<?php   


$feed = $html->find('#feed', 0);
$items = $html->find('.feed-item');

//////////////////////////////////////////
// Removing The Non blog Articles from feeds
//////////////////////////////////////////
foreach($items as $item)
{
	foreach($item->find('.feed-score') as $score) 
	{
		if($score)
		{
			foreach ($score as $m)
			{
				$m->outertext = '';
			}
		}
	}
	foreach($item->find('.feed-article .media-media') as $media) 
	{
		if($media)
		{
			foreach ($media as $m)
			{
				$m->outertext = '';
			}
		}
	}	
}
//////////////////////////////////////////
//     Retrieving Only Blog Articles
//////////////////////////////////////////

$articles = $html->find('.blog-blog, .story-news');
	   
//////////////////////////////////////////
//      Hidding Elements We Dont Want
/////////////////////////////////////////	   
$util = $html->find('.article-util', 0);
$tags = $html->find('.tags', 0);
$share = $html->find('.sharetools', 0);
$mod = $html->find('.matchhq-module');
$comp_mod = $html->find('.competition-module',0);
$poll = $html->find('.poll-module',0);


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
if($poll){
	$poll->outertext = '';
}
/////////////////////////////////////////
//        Url cleaning function
/////////////////////////////////////////
function toAscii($str, $replace=array(), $delimiter='-') {
	if( !empty($replace) ) {
		$str = str_replace((array)$replace, ' ', $str);
	}

	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

	return $clean;
	
/////////////////////////////////////////
/////////////////////////////////////////	
}?>

<div class="box">
	<div class="box-body">
		<h4 class="head fs14"><?php echo lang('news_related_news');?></h4>	
		
		<ul class="list-group list-group-unbordered">
			<?php foreach ($articles as $item) :

		  
				$h2 = $item->find('.text-content h2',0);		 
				
				$a = $item->find('.text-content a',0);
				$age = $item->find('.text-content .age',0);
				$author = $item->find('.text-content .author',0);
				 
				if($a){
				$h3 = $a->innertext;
				}
				if($a){
				$link = $a->href;
				}
								
				$thumb = $item->find('img',0);
				$text = $item->find('.text .info',0);
				
				if($text){
					$text_link = $item->find('.text a',0);
					$text_clean = $text_link->innertext;
				}?>
			 

				<li class="list-group-item">

					<?php if(($a) && ($link)) {
							$str = explode("http://www.espnfc.com/", $link ,2);
							$data = $str[1];
							$post = toAscii($data); 
					}?>

					<?php echo form_open(base_url('news/article') . '/' .$post, 'id="form" class="form-horisontal"'); ?>
					
						<h2><?php if(($a) && ($h3)) { echo substr($h3, 0, 40); }?>...</h2>
						<?php echo $thumb;?>
						<p><?php if($text) { echo $text_clean; }?>...</p>
						<p class="text-red"><?php echo $age; ?></p>

						<input type="hidden" id="data" name="data" value="<?php echo $data;?>">
						<input type="hidden" id="link" name="link" value="<?php echo $link;?>">	
						<input type="submit" name="save" class="btn btn-clean btn-block" value="Read more" />
						
					<?php echo form_close(); ?>
					
				</li>	
				<div class="clearfix"></div>
				<div class="divider-4 mbn mtn"></div>

			<?php endforeach;?>	
				
		</ul>	

	</div>	
</div>

