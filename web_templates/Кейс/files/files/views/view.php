<?php


include('../bitdrop.class.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?=serviceName?> - <?=$_GET['shortURL']?></title>
		
		<link rel="stylesheet" type="text/css" href="css/bitdrop.css" />
		<link rel="stylesheet" type="text/css" href="css/ui.css" />

		<script type="text/javascript" src="js/numericalize.js"></script>
		<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
		
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	</head>
	
	<script type="text/javascript">
	if ( navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|Android)/i) ){ location.replace("m/<?=$_GET['shortURL']?>"); }
	
	//=====
	jQuery.fn.lightbox = function () {
    var close = function () {
        $('.ui-lightbox').fadeOut(500, function () {
            $('.ui-backdrop, .ui-backdrop-light').fadeOut(200, function () {
                $(this).remove();
                $(document).off('keydown');
                $(window).off('resize');
            });
        });
    };

    var resize = function (event) {
        var maxw = ($(window).width() - 75 < 100) ? 100 : $(window).width() - 75,
            maxh = ($(window).height() - 75 < 100) ? 100 : $(window).height() - 75,
            height = event.data.height,
            width = event.data.width,
            ratio = maxh / maxw;

        if (height / width > ratio) {
            if (height > maxh) {
                width = Math.round(width * (maxh / height));
                height = maxh;
            }
        } else {
            if (width > maxw) {
                height = Math.round(height * (maxw / width));
                width = maxw;
            }
        }
        $('.ui-lightbox > img').attr({ width: width, height: height });
        $('.ui-lightbox').css({ 'width': width, 'height': height });
    };


    var open = function(a)
    {
        $('body').prepend('<div class="ui-backdrop"><div class="ui-lightbox"><a class="ui-lightbox-close">&#215;</a>Loading...</div></div>');

        $('.ui-close').click(function (e) {
            e.preventDefault();
            close();
        });

        var img = new Image();
        img.onload = function () {
            $('.ui-lightbox')
                .empty()
                .append('<a class="ui-lightbox-close" href="#">&#215;</a>')
                .append('<img src="' + img.src + '" alt="" width="' + this.width + '" height="' + this.height + '" />');

            $('.ui-lightbox-close').click(function (e) {
                e.preventDefault();
                close();
            });

            $(window).on('resize.cssui', {
                    width: this.width,
                    height: this.height
                }, resize);
            $(window).trigger('resize.cssui');
            
        };
        img.src = $(a).attr('href');
        
        $('.ui-backdrop, .ui-backdrop-light').fadeIn(250, function () {
            $('.ui-lightbox').fadeIn(100);
        });

        $(document).on('keydown', function (e) {
            switch (e.which) {
	            case 37: console.log("left"); break;
	            case 39: console.log("right"); break;
	            case 27: console.log("esc"); close(); break;
            }
            return false;
        });
    };

    $.each($(this), function(a, k)
    {
        $(k).click(function(e){ e.preventDefault(); open(k); });
    });
    return this;
	};
	//=====

	$(function()
	{
		$('.flag').click(function(e)
		{
			e.preventDefault();
			$.ajax({
					type: "POST",
					url: 'controller.php?method=flag',
					data: 'shortURL=' + $(this).attr('data-file'),
					success: function(response){ $('.flag').html(' <span class="flag">File has been flagged.</span>'); }
			});
		});
		$('a.preview').lightbox();
	});
	</script>
	<body>
	
	<div class="header">
		<div class="wrapper">
			<div class="left logo">
				<a href="<?=URLPrefix?>://<?=yourURL?>"><?=serviceName?></a>
			</div>
			<div class="right dash">
				<a href="#"><?=$_GET['shortURL']?></a>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	
	
	<?php if( $bitdrop->view($_GET['shortURL'], $_POST['password'])): ?>
		<div class="wrapper center">
			<a href="<?=$bitdrop->largePreview?>" class="preview">
				<img src="<?=$bitdrop->smallPreview?>" />
			</a>
		</div>
	
	
		<div class="wrapper box">		
			<div class="left halfplus">
				<h3>details</h3>
				<table class="ui-min" style="width: 100%;">
					<tbody>
						<tr>
							<th>Название файла</th>
							<td><?=$bitdrop->filename?> <span class="icon-views"><?=$bitdrop->views?></span></td>
						</tr>
						<tr>
							<th>Size</th>
							<td><span class="data"><?=$bitdrop->size?></span></td>
						</tr>
						<tr>
							<th>Expires</th>
							<td><span class="time"><?=$bitdrop->expireDate?></span></td>
						</tr>
						<tr>
							<th>Доступность</th>
							<td><?=$bitdrop->available?></td>
						</tr>
						<tr>
							<th>Options</th>
							<td>
								<a href="download.php?shortURL=<?=$bitdrop->shortURL?>" class="ui-button-green">Скачать</a>
								<span class="red">&bull;</span><a href="#" class="flag" data-file="<?=$bitdrop->shortURL?>"> Flag</a>
							</td>
						</tr>
					</tbody>
				</table>
				<script> document.title = '<?=$bitdrop->filename?>'; </script>
			</div>
		
			<div class="right halfminus">
				<h3>qr code api</h3>
				<img src="http://chart.apis.google.com/chart?cht=qr&chs=200x200&chl=<?=URLPrefix.'://'.yourURL.'/'.$bitdrop->shortURL?>" />
			</div>
		
			<div class="clear"></div>
		</div>
	<?php elseif($bitdrop->isLocked): ?>
		
		<div class="wrapper box full">
			<form action="views/download.php?shortURL=<?=$bitdrop->shortURL?>" method="post" >
				<p class="ui-message-yellow">The document <?=$bitdrop->filename?> is password protected</p>
				<hr/>
				<input type="password" name="password" placeholder="Password"/>
				<input type="submit" class="ui" value="Разблокировать и скачать" />
			</form>
		</div>
		
	<?php else: ?>
		
		<div class="wrapper box full">
			<p class="ui-message-red"><?=$bitdrop->errorMessage?></p>
		</div>
	
	<?php endif; ?>

	
	<div class="wrapper">
		<div class="footer">wm-scripts.ru</div>
	</div>
	
	</body>
</html>