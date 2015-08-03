function createPopup(elem, captionText, color) {
	if(!color) {
		var color = "white";
	}
	
	var $ = jQuery;
	var overlay = $('<div>').addClass('video-overlay');
	var popup = $('<div>').addClass('video-popup');
	var iframe = '<iframe src="' + elem.attr('href') + '?autoplay=true" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
	var iframeWrapper = $('<div>').addClass('iframeWrapper');
	popup.css({
		'max-width': elem.data('video-width'),
		'height': (elem.data('video-height') / elem.data('video-width') * 90) + 'vw'
	});
	iframeWrapper.html(iframe);
	popup.html(iframeWrapper);
	overlay.html(popup);

	popup.addClass(color);

	var caption = $('<div>').addClass('caption');
	caption.html(captionText);

	var closeButton = $('<div>').addClass('close-button').html('close');
	
	closeButton.on('click', function() {
		closePopup(overlay);
	});

	overlay.not('.video-popup').on('click', function() {
		closePopup(overlay);
	});

	caption.append(closeButton);

	popup.append(caption);

	$('body').append(overlay);

	setTimeout(function() {
		overlay.addClass('visible');
	},0);
}

function closePopup(elem) {
	elem.remove();
}