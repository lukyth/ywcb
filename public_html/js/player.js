(function(){

'use strict';

// i'm in a rush so sloppy coding

var show_data = show_data || false;

$('[data-player]').each(function(){
	var node = $(this);
	var players = [];
	var tracks = node.data('player');

	tracks.forEach(function(v){
		var player = $("<audio>").attr({
			'controls': show_data,
			'preload': true,
			'src': v[0]
		}).appendTo(node).get(0);
		player._shift = v[1];
		players.push(player);
	});

	var play = function(){
		players.forEach(function(item){
			item.pause();
			item.currentTime = Math.max(0, -item._shift);
			if(item._shift > 0){
				item.timeout = setTimeout(function(){
					console.log('play');
					item.play();
				}, item._shift * 1000);
			}else{
				item.play();
			}
		});
	};
	var pause = function(){
		players.forEach(function(item){
			clearTimeout(item.timeout);
			item.pause();
		});
	};
	var isPlaying = false;

	$('<img src="/img/play.svg" style="width:100%;">').css("cursor", "pointer").appendTo(this).click(function(){
		isPlaying = !isPlaying;
		isPlaying ? play() : pause();
	});
});


})();