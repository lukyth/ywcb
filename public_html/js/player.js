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

	$('<div class="play">Play</div>').click(function(){
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
		return false;
	}).appendTo(node);

	$('<div class="stop">Stop</div>').click(function(){
		players.forEach(function(item){
			clearTimeout(item.timeout);
			item.pause();
		});
		return false;
	}).appendTo(node);
});


})();