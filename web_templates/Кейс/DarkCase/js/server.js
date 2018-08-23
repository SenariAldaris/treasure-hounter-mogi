
$(function() {
	var shopScript = '/ajax/';
	var openingCase = false;
	var winnersInterval = 30*1000;
	var paySum;
	
	$('.item-wrapper:gt('+($('.item-wrapper').length - 6)+')').addClass('small')
	
	$('[data-modal]').click(function() {
		$($(this).data('modal')).arcticmodal();
		return false;
	})
	
	$('[data-bonus]').click(function() {
		paySum = $(this).data('sum');
		var bonus = $(this).data('bonus');
		$('#paySum').text(paySum + n2w(paySum, [' рубль', ' рубля', ' рублей']))
		$('#payBonus').text('+ '+bonus+' бонус')
		return false;
	})
	
	$(document).on('click', '.btn-repeat', function(e) {
		var that = $(this);
		var prev = that.text()
		that.text('Подождите...').attr('disabled', 'disabled');
		$.ajax({
			url: shopScript,
			type: 'POST',
			dataType: 'json',
			data: { action: 'orderRepeat', order_id: that.data('order') },
			success: function(data) {
				if (data.status == 'success') {
				}
				else {
				}
				that.text('Готово').attr('disabled', 'disabled');
			},
			error: function() {
				alert('Произошла ошибка. Попробуйте еще раз')
				that.text(prev).attr('disabled', null)
			}
		})
	})
	var orderHistory = $('#orderHistory')
	$('.orderhistory').click(function() {
		orderHistory.arcticmodal()
		var first = orderHistory.find('tbody>tr').first()
		first.find('td').html('Подождите...')
		first.show()
		orderHistory.find("tbody>tr:gt(0)").remove()
		
		$.ajax({
			url: shopScript,
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'orderHistory'
			},
			success: function(data) {
				if (data.status == 'success') {
					if (data.list.length) {
						first.hide()
						data.list.forEach(function(item) {
							var tr = $(
								'<tr>'+
									'<td style="vertical-align: middle; text-align: center; width: 80px; font-size: 14px;">'+item.id+'</td>'+
									'<td style="vertical-align: middle; text-align: center; width: 110px; font-size: 14px;">'+item.date+'</td>'+
									'<td style="vertical-align: middle; text-align: center; width: 105px">'+
										item.case.name+
										//'<img title="'+item.case.name+'" class="historyCase" src="images/items/'+item.case.img+'" style="width: 80px;" />'+
									'</td>'+
									'<td style="vertical-align: middle; text-align: center; width: 105px">'+
										item.weapon.name+
										'<div class="itempick1" style="height: 78px; margin-top: -17px;"><center><img src="'+getImage(item.weapon.image, 96, 96)+'"></center></div>'+
									'</td>'+
									'<td style="vertical-align: middle; width: 97px; position: relative;">'+item.status+
									'<span class="glyphicon glyphicon-question-sign" style="display: none; font-size: 16px;color: red;position: absolute;right: 3px;top: 5px;"></span>'+
									'</td>'+
								'</tr>'
							)
							
							if (item.log) {
								var icon = tr.find('.glyphicon')
								icon.attr('title', item.log)
								icon.show()
								icon.tooltip({
									html: true,
									container: 'body'
								})
							}
							orderHistory.find('tbody').append(tr)
						})
						$('.historyCase').tooltip()
					}
					else {
						first.find('td').html('Вы не сделали ни одной покупки')
					}
				}
				else {
					first.find('td').html(data.msg)
				}
			},
			error: function() {
				first.find('td').html('Произошла ошибка! Попробуйте еще раз')
			}
		})
	})
	
	$('form').submit(function() {
		return false;
	})
	
	$(document).on('keypress', '.balanceInput', function(e) {
		if (!(e.which >= 48 && e.which <=57)) {
			e.preventDefault();
		}
		if (e.which == 13) $(this).next().click()
	})
	
	var paySystems = $('#paySystems')

	
$(document).on('click', '.paytype', function(e) {
		$.ajax({
			url: shopScript,
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'addbalance',
				data: paySum,
				system: $(this).data('system'),
			},
			success: function(data) {
				if (data.status == 'success') {
					document.location = data.url;
				}
			},
			error: function() {
				alert('Произошла ошибка! Попробуйте еще раз')
			}
		})
	})
	
	$(document).on('click', '.paymentcode', function(e) {
		var that = $(this);
		var prevHtml = that.html();
		
		that.text('Подождите...')
		var paymentError = $('.paymentError')
		paymentError.text('')
		
		$.ajax({
			url: shopScript,
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'paymentcode',
				data: that.prev().val()
			},
			success: function(data) {
				if (data.status == 'success') {
					location.reload();
				}
				else {
					paymentError.text(data.msg)
					that.html(prevHtml)
				}
			},
			error: function() {
				paymentError.text('Произошла ошибка! Попробуйте еще раз')
				that.html(prevHtml)
			}
		})
	})
	
	
	$(document).on('click', '.utlink', function(e) {
		var that = $(this);
		var prevHtml = that.html();
		
		that.text('Подождите...')
		var userPanelError = $('.userPanelError')
		userPanelError.text('')
		
		$.ajax({
			url: shopScript,
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'saveLink',
				data: that.prev().val()
			},
			success: function(data) {
				if (data.status == 'success') {
					that.html(prevHtml)
					$('#linkError').hide()
				}
				else {
					userPanelError.text(data.msg)
					that.html(prevHtml)
				}
			},
			error: function() {
				userPanelError.text('Произошла ошибка! Попробуйте еще раз')
				that.html(prevHtml)
			}
		})
	})  
	
	var lastWinners = $('#lastWinners')
	function loadLastWinners() {
		if (openingCase) return;
		$.ajax({
				url: '/ajax/ajax_lastorders.php',
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'lastWinners'
			},
			success: function(data) {
				var nickname;
				try {
					data.reverse().forEach(function(item) {
						if (lastWinners.find('.item' + item.id).length == 0) {
							
							if ( item.fake_nickname == '')
								nickname = item.v_nickname;
							else
								nickname = item.fake_nickname;
							var el = $(
								'<div title="'+item.firstName+'" class="oflo '+item.type+'">'+
									'<img src="'+getImage(item.image,125,125)+'" />'+ 
									'<div class="ofloname">'+nickname+'</div>'+
								'</div>'
							)
							el.hide().addClass('item'+item.id);
							lastWinners.prepend(el)
							el.fadeIn(1000)
						}
					})
					lastWinners.find(".oflo:gt(9)").remove()
					$('.oflo').tooltip()
				}
				catch(e) {
				}
			},
			error: function() {
			}
		})		
	}
		function bagSS() {

		if( $('#lastWinners')[0].innerHTML == ""){
		//alert( $('#lastWinners').innerHTML)
		loadLastWinners();
	    }
	}
	
    setInterval(bagSS,1000)
	setInterval(loadLastWinners, winnersInterval)
	//setTimeout(loadLastWinners, 1000)
	var caseItems = $('#caseItems')
	var casesCarusel = $('#casesCarusel')
	var itemmodal = $('#itemmodal')
	var currentCase;
	var currentCasePrice;
	var upchancePrice = 0;
	$('.item').click(function(e) {
		currentCase = $(this).data('key')
		currentCasePrice = $(this).data('price')
		upchancePrice = 0
		$('.upchance').removeClass('active')
		$('#currentCaseprice').text(currentCasePrice)
		$('#upchancePrice').text('')
		$('#curCaseName').text($(this).find('.name span').text())
		
		$('.syserrbox').hide()
		itemmodal.arcticmodal({
			closeOnOverlayClick: false,
			openEffect: {type: 'fade', speed: 400},
			closeEffect: {type: 'fade', speed: 5},
			beforeClose: function() {
				return !openingCase;
			},
			beforeOpen: function() {
				//caseItems.html('')
			},
			beforeOpen: function() {
				var el = ''
				cases[currentCase].forEach(function(item, index) {
					el += '<li class="weaponblock weaponblock1 '+item[2]+'">'+
									'<img src="'+getImage(item[3], 125, 125)+'" />'+
									'<div class="weaponblockinfo"><span>'+getName(item[0])+'<br/>'+getName(item[1])+'</span></div>'+
								'</li>'
				})
				caseItems.html(el)
				fillCarusel()
			}
		})
	})
	
	function fillCarusel() {
		var a1 = cases[currentCase].filter(function(weapon) { return weapon[2] == 'milspec' }).slice(0).mul(5).shuffle()
		var a2 = cases[currentCase].filter(function(weapon) { return weapon[2] == 'restricted' }).slice(0).mul(5).shuffle()
		var a3 = cases[currentCase].filter(function(weapon) { return weapon[2] == 'classified' }).slice(0).mul(4).shuffle()
		var a4 = cases[currentCase].filter(function(weapon) { return weapon[2] == 'covert' }).slice(0).mul(4).shuffle()
		var a5 = cases[currentCase].filter(function(weapon) { return weapon[2] == 'rare' }).slice(0).mul(2).shuffle()
		
		var arr = a1.concat(a2, a3, a4, a5).shuffle().shuffle().shuffle()
		var el = ''
		arr.forEach(function(item, index) {
			el += '<div class="weaponblock weaponblock2 '+item[2]+'">'+
						'<img src="'+getImage(item[3], 125, 125)+'" />'+
						'<div class="weaponblockinfo"><span>'+getName(item[0])+'<br/>'+getName(item[1])+'</span></div>'+
					'</div>'
		})
		casesCarusel.css("margin-left", "0px")
		casesCarusel.html(el)
	}

	function updateBalance(data) {
		if (data.balance) $('.userBalance').text(data.balance)
	}
	
	var caseOpenAudio = new Audio();
	//caseOpenAudio.src = "/audio/open.wav";
	caseOpenAudio.src = "/audio/test1.wav";
	caseOpenAudio.volume = 0.5;
	
	var caseCloseAudio = new Audio();
	caseCloseAudio.src = "/audio/close.wav";
	caseCloseAudio.volume = 0.2;

	var caseScrollAudio = new Audio();
	caseScrollAudio.src = "/audio/scroll.wav";
	caseScrollAudio.volume = 0.2;
	
	$('.upchance').click(function() {
		var that = $(this)
		upchancePrice = that.data('price')
		document.getElementById("upchanceprice").innerHTML = ''
		
		if (that.is('.active')) {
			that.removeClass('active')
		}
		else {
			$('.upchance').removeClass('active')
			that.addClass('active')
			document.getElementById("upchanceprice").innerHTML = ' + ' + upchancePrice
		}
	})
	$('#openCase').click(function() {
		var that = $(this)
		
		var prevHtml = that.html()
		that.text('Открываем...').attr('disabled', 'disabled')
		$('.syserrbox').hide()
		openingCase = true
		
		$.ajax({
			url: shopScript,
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'openCase',
				'case': currentCase,
				'upchancePrice': upchancePrice
			},
			success: function(data) {
				if (data.status == 'success') {
					updateBalance(data)
					var weapon = data.weapon
					
					var weaponName = weapon.firstName + ' | ' + weapon.secondName
					
					$('#casesCarusel > div:nth-child(30), #weaponBlock .recweap').removeClass('milspec restricted classified covert rare').addClass(weapon.type)
					
					$('#casesCarusel > div:nth-child(30) .weaponblockinfo span').html((weapon.stattrack ? 'StatTrak™ ' : '') + weaponName.replace(' | ', '<br/>'))
					$('#casesCarusel > div:nth-child(30)').find('img').attr('src', getImage(weapon.image, 100, 100))					
					
					$('#weaponBlock .recweaptitle').toggleClass('stattrack', !!weapon.stattrack)
					$('#weaponBlock .recweaptitle .name').text(weaponName)
					$('#weaponBlock .recweap img').attr('src', getImage(weapon.image, 384, 384))
										
					var vkTitle = encodeURI('Кейсы CS:GO - Открывай с выгодой')
					var vkText = (weapon.stattrack ? 'StatTrak™ ' : '') + weaponName
					vkText = encodeURI('Я выиграл ' + vkText)
					var vkImage = getImage(weapon.image, 360, 360)
					vkImage = vkImage.replace("//", 'http://')
					var a = 1431 + 16*124;
					$('#casesCarusel').animate({ marginLeft: -1 * Math.rand(a, a+59) }, {
						duration: 10000,
						easing: 'swing',
						//easing: 'easeInSine',
						start: function() {
							caseOpenAudio.play()
							loadLastWinners()
						},
						complete: function() {
							
							setTimeout(loadLastWinners, 1)
							openingCase = false;
							caseCloseAudio.play()
							
							
							$('.shareBtn').html(VK.Share.button({
								url: 'http://'+document.domain+'/?utm_source=vkshare&title='+vkTitle+'/&description='+vkText+'/&image='+vkImage+'/&noparse=true',
							}, {
								type: 'custom',
								text: '<img src="/css/vk_icon.png" /><span>Поделиться результатом</span>'
							}))
								
							
							$("#sellBlock").hide()
							$("#aftersellBlock1").hide()
							$("#aftersellBlock2").hide()
							$("#aftersellBlock3").hide()
							
							if (weapon.type == 'milspec') {
								$("#sellBlock").show()
								
								$("#sellBlock .sellBtn .sellPrice").text(weapon.price)
								$("#aftersellBlock1 .sellPrice").text(weapon.price + n2w(weapon.price, [' рубль', ' рубля', ' рублей']))
								$("#sellBlock .sellBtn").data('order', weapon.id)
								$("#sellBlock .waitBtn").data('order', weapon.id)
							}
							else {
								$("#aftersellBlock3").show()
							}
							
							setTimeout(function() {
								$('#weaponBlock').arcticmodal({
									closeOnOverlayClick: false,
									openEffect: {type: 'none', speed: 400},
									beforeClose: function() {
										that.text(prevHtml).attr('disabled', null)
										fillCarusel()
									}
								})
							}, 100)
						}
					})
				}
				else {
					updateBalance(data)
					$('#' + data.msg).fadeIn(500)
					that.text(prevHtml).attr('disabled', null)
					openingCase = false;
				}
			},
			error: function() {
				alert('Произошла ошибка! Попробуйте еще раз');
				that.text(prevHtml).attr('disabled', null)
				openingCase = false;
			}
		})
	})
	
	$(document).on('click', ".sellBtn, .waitBtn", function(e) {
		var that = $(this)
		var type = that.is(".sellBtn") ? 'sell' : 'wait'
		$.ajax({
			url: shopScript,
			type: 'POST',
			dataType: 'json',
			data: { action: 'sellORwait', type: type, order_id: that.data('order') },
			success: function(data) {
				if (data.status == 'success') {
					updateBalance(data)
					if (that.is('.Hist')) {
						that.parents('td').first().html('')
					}
					else {
						$("#sellBlock").hide()
						type == 'sell' ? $("#aftersellBlock1").show() : $("#aftersellBlock2").show()
					}
				}
				else {
				}
			},
			error: function() {
				alert('Произошла ошибка. Попробуйте еще раз')
			}
		})
	})
	/*
	$.each(cases, function(key, box) {
		box.forEach(function(weapon) {
			var img = new Image()
			img.src = getImage(weapon[3]);
		})
	})
	*/
})



Array.prototype.shuffle = function() {
	var o = this;
	for(var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
	return o;
}
Array.prototype.mul = function(k) {
	var res = []
	for (var i = 0; i < k; ++i) res = res.concat(this.slice(0))
	return res
}
Math.rand = function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
function n2w(n, w) {
	n %= 100;
	if (n > 19) n %= 10;
	
	switch (n) {
	case 1:
		return w[0];
	case 2:
	case 3: 
	case 4:
		return w[1];
	default:
		return w[2];
	}
}
function getName(name) {
	var arr = name.split('|')
	return (arr.length == 1) ? name : arr[1]
}
function getImage(str, w, h) {
	w = w || 384
	h = h || 384
	str = str.replace(prefix, '')
	return '//steamcommunity-a.akamaihd.net/economy/image/'+ prefix + str + '/'+w+'fx'+h
} 

function addWinner(item) {
	var lastWinners = $('#lastWinners')
	var el = $(
		'<div title="'+item.weapon.name+'" class="oflo '+item.type+'">'+
			'<img src="'+getImage(item.weapon.image,125,125)+'" />'+
			'<div class="ofloname">'+item.userName+'</div>'+
		'</div>'
	)
	el.hide()
	lastWinners.prepend(el)
	el.fadeIn(1000)
	
	lastWinners.find(".oflo:gt(9)").remove()
	$('.oflo').tooltip()
}

