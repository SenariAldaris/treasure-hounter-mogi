<?php
/*========================================= 
	Appointment: Парсинг данных
	File: parse.php 
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
==========================================*/

class parse{

	function BBparse($source, $preview = false){
		global $config;

		$source = preg_replace("#<iframe#i", "&lt;iframe", $source);
		$source = preg_replace("#<script#i", "&lt;script", $source);
		
		$source = str_ireplace("{", "&#123;", $source);
		$source = str_ireplace("`", "&#96;", $source);
		$source = str_ireplace("{theme}", "&#123;theme}", $source);
		
		$source = str_ireplace("[b]", "<b>", str_ireplace("[/b]", "</b>", $source));
		$source = str_ireplace("[i]", "<i>", str_ireplace("[/i]", "</i>", $source));
		$source = str_ireplace("[u]", "<u>", str_ireplace("[/u]", "</u>", $source));
		
		$source = preg_replace("#\[(left|right|center)\](.+?)\[/\\1\]#is", "<div align=\"\\1\">\\2</div>", $source);
		
		$source = preg_replace( "#\[quote\](.+?)\[/quote\]#is", "<blockquote>\\1</blockquote>", $source );
		
		if(stripos($source, "[video]") !== false || stripos($source, "[photo]") !== false || stripos($source, "[link]") !== false){
			$source = preg_replace("#\\[video\\](.*?)\\[/video\\]#ies", "\$this->BBvideo('\\1', '{$preview}')", $source);
			$source = preg_replace("#\\[photo\\](.*?)\\[/photo\\]#ies", "\$this->BBphoto('\\1', '{$preview}')", $source);
			$source = preg_replace("#\\[link\\](.*?)\\[/link\\]#ies", "\$this->BBlink('\\1')", $source);
		}
		
		return $source;
		
	}
	
	function BBvideo($source, $preview = false){
		global $config;
		
		$exp = explode('|', $source);
		$home_url = $config['home_url'];

		if(stripos($source, "{$exp[0]}|{$exp[1]}|{$home_url}") !== false){
			
			if($exp[3])
				if($exp[3] > 175)
					$width = "width=\'175\'";
				else
					$width = "width=\'{$exp[3]}\'";
					
			if($exp[4])
				if($exp[4] > 131)
					$height = "height=\'131\'";
				else
					$height = "height=\'{$exp[4]}\'";
			
			if($exp[5])
				$border = 'notes_videoborder';
				
			if($exp[6])
				$blank = 'target="_blank"';
			else
				$blank = "onClick=\"videos.show({$exp[1]}, this.href, \'/notes/view/{note-id}\'); return false\"";
			
			if($exp[7] == 1)
				$pos = "align=\"left\"";
			elseif($exp[7] == 2)
				$pos = "align=\"right\"";
			else
				$pos = "";
			
			if(!$preview){
				$link = "<a href=\"/video{$exp[0]}_{$exp[1]}_sec=notes/id={note-id}\" {$blank}>";
				$slink = "</a>";
			}

			$source = "<!--video:{$source}-->{$link}<img src=\"{$exp[2]}\" {$width} {$height} {$pos} class=\"notes_videopad {$border}\" />{$slink}<!--/video-->";
		}
		
		return $source;
	}
	
	function BBphoto($source, $preview = false){
		global $config;
		
		$exp = explode('|', $source);
		$home_url = $config['home_url'];

		if(stripos($source, "{$exp[0]}|{$exp[1]}|{$home_url}") !== false){
			
			if($exp[3] > 160)
				$exp[2] = str_replace('/c_', '/', $exp[2]);
				
			if($exp[4] > 120)
				$exp[2] = str_replace('/c_', '/', $exp[2]);
				
			if($exp[3])
				if($exp[3] > 740)
					$width = "width=\'740\'";
				else
					$width = "width=\'{$exp[3]}\'";
					
			if($exp[4])
				if($exp[4] > 547)
					$height = "height=\'547\'";
				else
					$height = "height=\'{$exp[4]}\'";
			
			if($exp[5])
				$border = 'notes_videoborder';
				
			if($exp[6])
				$blank = 'target="_blank"';
			else
				$blank = "onClick=\"Photo.Show(this.href); return false\"";
			
			if($exp[7] == 1)
				$pos = "align=\"left\"";
			elseif($exp[7] == 2)
				$pos = "align=\"right\"";
			else
				$pos = "";
				
			if($exp[8] AND !$preview AND $exp[0] AND $exp[1]){
				$link = "<a href=\"/photo{$exp[0]}_{$exp[1]}_sec=notes/id={note-id}\" {$blank}>";
				$elink = "</a>";
			} elseif($exp[8]) {
				$link = "<a href=\"{$exp[2]}\" target=\"_blank\">";
				$elink = "</a>";
			} else {
				$link = '';
				$elink = '';
			}
			
			if($exp[0] AND $exp[1])
				$source = "<!--photo:{$source}-->{$link}<img class=\"notes_videopad {$border}\" src=\"{$exp[2]}\" {$width} {$height} {$pos} />{$elink}<!--/photo-->";
			else
				$source = "<!--photo:{$source}-->{$link}<img class=\"notes_videopad {$border}\" src=\"{$exp[2]}\" {$width} {$height} {$pos} />{$elink}<!--/photo-->";
		}
		
		return $source;
	}
	
	function BBlink($source){
		$exp = explode('|', $source);
		
		if($exp[0]){
			if(!$exp[1])
				$exp[1] = $exp[0];

			$source = "<!--link:{$source}--><a href=\"{$exp[0]}\" target=\"_blank\">{$exp[1]}</a><!--/link-->";
		}
		
		return $source;
	}
	
	function BBdecode($source){
	
		$source = str_ireplace("&#123;", "{", $source);
		$source = str_ireplace("&#96;", "`", $source);
		$source = str_ireplace("&#123;theme}", "{theme}", $source);
		
		$source = str_ireplace("<b>", "[b]", str_ireplace("</b>", "[/b]", $source));
		$source = str_ireplace("<i>", "[i]", str_ireplace("</i>", "[/i]", $source));
		$source = str_ireplace("<u>", "[u]", str_ireplace("</u>", "[/u]", $source));
		
		$source = preg_replace("#<div align=\"(left|right|center)\">(.+?)</div>#is", "[\\1]\\2[/\\1]", $source);
		
		$source = preg_replace( "#\[quote\](.+?)\[/quote\]#is", "<blockquote>\\1</blockquote>", $source );
		
		$source = preg_replace( "#<blockquote>(.+?)</blockquote>#is", "[quote]\\1[/quote]", $source );
		
		if(stripos($source, "<!--photo:") !== false || stripos($source, "<!--video:") !== false || stripos($source, "<!--link:") !== false){
			$source = preg_replace("#\\<!--video:(.*?)\\<!--/video-->#ies", "\$this->BBdecodeVideo('\\1')", $source);
			$source = preg_replace("#\\<!--photo:(.*?)\\<!--/photo-->#ies", "\$this->BBdecodePhoto('\\1')", $source);
			$source = preg_replace("#\\<!--link:(.*?)\\<!--/link-->#ies", "\$this->BBdecodeLink('\\1')", $source);
		}
		
		return $source;
	
	}
	
	function BBdecodePhoto($source){
		$start = explode('-->', $source);
		$source = "[photo]{$start[0]}[/photo]";
		return $source;
	}
	
	function BBdecodeVideo($source){
		$start = explode('-->', $source);
		$source = "[video]{$start[0]}[/video]";
		return $source;
	}
	
	function BBdecodeLink($source){
		$start = explode('-->', $source);
		$source = "[link]{$start[0]}[/link]";
		return $source;
	}

	function WIKI_parse($source){
		
		global $db;
		
		if(function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc()) $source = stripslashes($source);  

		$source = str_replace("<>", "&lt;&gt;", str_replace(">>", "&gt;&gt;", str_replace("<<", "&lt;&lt;", $source)));
		$source = str_replace("<!--", "&lt;!--", $source);
			
		$find = array ('/data:/i', '/about:/i', '/vbscript:/i', '/onclick/i', '/onload/i', '/onunload/i', '/onabort/i', '/onerror/i', '/onblur/i', '/onchange/i', '/onfocus/i', '/onreset/i', '/onsubmit/i', '/ondblclick/i', '/onkeydown/i', '/onkeypress/i', '/onkeyup/i', '/onmousedown/i', '/onmouseup/i', '/onmouseover/i', '/onmouseout/i', '/onselect/i', '/javascript/i' );
		
		$replace = array ("d&#097;ta:", "&#097;bout:", "vbscript<b></b>:", "&#111;nclick", "&#111;nload", "&#111;nunload", "&#111;nabort", "&#111;nerror", "&#111;nblur", "&#111;nchange", "&#111;nfocus", "&#111;nreset", "&#111;nsubmit", "&#111;ndblclick", "&#111;nkeydown", "&#111;nkeypress", "&#111;nkeyup", "&#111;nmousedown", "&#111;nmouseup", "&#111;nmouseover", "&#111;nmouseout", "&#111;nselect", "j&#097;vascript" );

		$source = str_replace("\r\n\r\n", "\n", $source);
		
		$source = preg_replace($find, "", $source);
		$source = preg_replace("#\{include#i", "&#123;include", $source);
		$source = preg_replace("#<script#i", "&lt;script", $source);
		$source = preg_replace("#<iframe#i", "&lt;iframe", $source);
		$source = preg_replace("#</iframe>#i", "&lt;/iframe&gt;", $source);
		$source = preg_replace("#<style(.*?)>#i", "", $source);
		$source = preg_replace("#</style(.*?)>#i", "", $source);
		$source = preg_replace("#<(tr|td|table)(.*?)>#i", "", $source);
		$source = preg_replace("#</(tr|td|table)(.*?)>#i", "", $source);
		$source = preg_replace("#<textarea(.*?)>#i", "", $source);
		$source = preg_replace("#<input(.*?)>#i", "", $source);
		$source = preg_replace("#<form(.*?)>#i", "", $source);
		$source = preg_replace("#</form(.*?)>#i", "", $source);
		$source = preg_replace("#<body(.*?)>#i", "", $source);
		$source = preg_replace("#</body(.*?)>#i", "", $source);
		$source = preg_replace("#<html(.*?)>#i", "", $source);
		$source = preg_replace("#</html(.*?)>#i", "", $source);
		$source = preg_replace("#<meta(.*?)>#i", "", $source);
		$source = preg_replace("#</meta(.*?)>#i", "", $source);
		$source = preg_replace("#<audio(.*?)>#i", "", $source);
		$source = preg_replace("#</audio(.*?)>#i", "", $source);
		$source = preg_replace("#<video(.*?)>#i", "", $source);
		$source = preg_replace("#</video(.*?)>#i", "", $source);
		$source = preg_replace("#<noscript(.*?)>#i", "", $source);
		$source = preg_replace("#</noscript(.*?)>#i", "", $source);
		$source = preg_replace("#<head(.*?)>#i", "", $source);
		$source = preg_replace("#</head(.*?)>#i", "", $source);
		$source = preg_replace("#<object(.*?)>#i", "", $source);
		$source = preg_replace("#</object(.*?)>#i", "", $source);
		$source = preg_replace("#<param(.*?)>#i", "", $source);
		$source = preg_replace("#</param(.*?)>#i", "", $source);
		$source = str_replace("<?", "&lt;?", $source);
		$source = str_replace("?>", "?&gt;", $source);
		
		$source = str_replace("`", "&#96;", $source );
		$source = str_ireplace("{theme}", "&#123;THEME}", $source);
		$source = str_ireplace("{comments}", "&#123;comments}", $source);
		$source = str_ireplace("{addcomments}", "&#123;addcomments}", $source);
		
		$source = str_replace("__CODENR__", "\r", $source);
		$source = str_replace("__CODENN__", "\n", $source);	

		$source = addslashes($source);			
		
		$source = $db->safesql($source);
		
		return $source;
		
	}

}
?>