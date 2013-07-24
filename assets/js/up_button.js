$(document).ready(function() {
	$('<div id="arrow"><i class="icon-arrow-up"> <strong>Наверх</strong></i></div>').insertAfter('#content');
	$(window).scroll(function() {
   	if ($(this).scrollTop() >= 400) {
   		$('#arrow').fadeIn();
   	}
		else {
       $('#arrow').fadeOut();
   	};
	});
  $('#arrow').click(function() {
  	$('html, body').animate( {
  		scrollTop: 0
  	}, 'slow')
  })

});