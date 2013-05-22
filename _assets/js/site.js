$(document).ready(function() {
  $('#loading').delay(400).fadeOut(1000);
  $('#navigation').show().delay(600).animate({top: '0px'}, 500);
  $('#footer').show().delay(600).animate({bottom: '0px'}, 500);
//  $('#container').show().delay(1000).animate({left: '0px'}, 500);
  $('#container').delay(1000).fadeIn(1000);
});
$('#itlogo').hover(function() {
  $(this).addClass('rotateAnti');
  $(this).attr('style', "margin-left:50%; margin-top:-40px;");
  $('#maindrop').fadeIn(1000).delay(00).animate({'margin-top': '100px'}, 1000);
});
$('#card').click(function() {
  $('#desc').fadeIn(1000);
});