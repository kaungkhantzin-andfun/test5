// require('./bootstrap');

import Alpine from 'alpinejs'
import persist from '@alpinejs/persist'
Alpine.plugin(persist)

window.Alpine = Alpine

Alpine.magic('clipboard', () => {
	return subject => navigator.clipboard.writeText(subject)
})

Alpine.start()


/**
 * Important
 * Dont delete this
 * because this is the backup for custom.js which is obfuscated to prevent people from stealing our code
 */
// // to convert ckeditor 5 oembed tag (media embed) to iframe
// var otags = document.querySelectorAll('oembed');

// otags.forEach(item => {
// 	var url = item.getAttribute('url');

// 	// get video id
// 	var YouTube = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
// 	var Vimeo = /^.*(?:http:|https:|)\/\/(?:player.|www.)?vimeo\.com\/(?:video\/|embed\/|watch\?\S*v=|v\/)?(\d*).*/;
// 	var YouTube = url.match(YouTube);
// 	var Vimeo = url.match(Vimeo);
// 	var site;
// 	var videoId;

// 	if (YouTube && YouTube[2].length == 11) {
// 		site = '//www.youtube.com/embed/';
// 		videoId = YouTube[2];
// 	} else if (Vimeo) {
// 		site = '//player.vimeo.com/video/';
// 		videoId = Vimeo[1];
// 	} else {
// 		return 'error';
// 	}
// 	// end of get video id

// 	// iframe markup
// 	if (YouTube || Vimeo) {
// 		var iframeMarkup = '<iframe style="width: 100%; height: 480px;" src="' + site + videoId + '" frameborder="0" allow="autoplay; fullscreen; picture-in-picture"></iframe>';
// 	}

// 	item.parentElement.innerHTML = iframeMarkup;
// });
// // end of to convert ckeditor 5 oembed tag (media embed) to iframe