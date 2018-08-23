$(function(){
 if ($(window).scrollTop()>="700") $("#ToTop").fadeIn("fast")
 $(window).scroll(function(){
  if ($(window).scrollTop()<="700") $("#ToTop").fadeOut("fast")
   else $("#ToTop").fadeIn("fast")
 });

 if ($(window).scrollTop()<=$(document).height()-"999") $("#OnBottom").fadeIn("fast")
 $(window).scroll(function(){
  if ($(window).scrollTop()>=$(document).height()-"999") $("#OnBottom").fadeOut("fast")
   else $("#OnBottom").fadeIn("fast")
 });

 $("#ToTop").click(function(){$("html,body").animate({scrollTop:0},"fast")})
 $("#OnBottom").click(function(){$("html,body").animate({scrollTop:$(document).height()},"fast")})
});