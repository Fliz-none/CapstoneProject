import header from './components/header.js';
import home from './components/home.js';
import qa from './components/q&a.js';
import searchpage from './components/searchpage.js';
import recipe from './components/recipe.js';
import factory from './components/factory.js';
import about from './components/about.js';
import tuyendung from './components/tuyendung.js';

window.getDirection = function () {
	var windowWidth = window.innerWidth;
	var direction = windowWidth > 1200 ? 'vertical' : 'horizontal';

	return direction;
};

$(document).ready(function () {
	// header
	header.init();

	// home
	home.init();
	qa.init();
	searchpage.init();
	recipe.init();
	factory.init();
	about.init();
	tuyendung.init();
});

$(window).bind('load', function () {
	// if ($(window).width() < 1200) {
	//     masterWrapper();
	// }
	// active wow
	// var wow = new WOW(
	//     {
	//         boxClass: 'wow',      // default
	//         animateClass: 'animated', // default
	//         offset: 0,          // default
	//         mobile: true,       // default
	//         live: true        // default
	//     }
	// )
	// wow.init();
});
