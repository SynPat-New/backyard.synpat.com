/**
 * Init playground
 */
var playground = {
  clusterize: null,
  $amountTag: $('#playgroundAmount'),
  initClusterize: function(rows_in_block) {
	var opts = {
	  rows: rows,
	  scrollId: 'playgroundScroll',
	  contentId: 'playgroundContent'
	};
	if(rows_in_block) {
	  opts['rows_in_block'] = rows_in_block;
	}
	console.log(opts);
	playground.clusterize = new Clusterize(opts);
	   
  },
  init: function() {
    playground.initClusterize(50);
  }
}
setTimeout(playground.init, 50);
