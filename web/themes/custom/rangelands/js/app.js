'use strict';

jQuery(document).ready( function($) {

	let pizzettaApp = {
		settings: {
			minCoverImageWidth: 200,
		},
		selectors: {
			menuSwitch: $('.primary-menu h2'),
			pageHeader: $('.page-header')
		}
	};

	pizzettaApp.processExternalLinks = function() {
		
		$('.article--body a[href*="http"], .component-type--text a[href*="http"]').each(function(e) {
			let $this = $(this);
			if(!$this.attr('href').includes('gender.cgiar.org') &&
			!$this.attr('href').includes('cgiargender.fabiofidanza.com')) {
				$this.attr('target','_blank').addClass('link-external')
			} 
		}
		);

	}

	pizzettaApp.hideSmallCoverImages = function() {
	
		$('.article--cover img').each( function() {

			let image = $(this)[0];

			if(image.naturalWidth < pizzettaApp.settings.minCoverImageWidth) {
				$(this).parents('.article--cover').addClass('visually-hidden');
			}

		})

		$('.card img').each( function() {

			let image = $(this)[0];

			if(image.naturalWidth < pizzettaApp.settings.minCoverImageWidth) {
				$(this).addClass('visually-hidden');
			}

		})

	}

	pizzettaApp.createCaptionsFromAlts = function() {

		$('.component-type--landing-page--header').each( function() {

			let $this = $(this);

			let $caption = $this.find('.credits');
			let $image = $this.find('img');
			let $figure = $this.find('figure');


			if($caption.length == 0) {
				if($image.attr('alt').trim() != "") {

					let $credits = $('<span class="credits" />');
					$credits.text($image.attr('alt'));
					$figure.append($credits);

				}
			}

		});
		
	}

	pizzettaApp.createCardCoverLinks = function() {

		$('.card').each( function() {

			let $this = $(this);
			let $anchors = $this.find('a');

			if($anchors.length == 1) {
		
				let url = $anchors.eq(0).attr('href');
				let $coverAnchor = $('<a />');
				$coverAnchor.attr('href',url).addClass('cover-link');
				$this.append($coverAnchor);
			}

		})

	}

	pizzettaApp.automateMobileMenu = function() {

		pizzettaApp.selectors.menuSwitch.on('click', function() {

			pizzettaApp.selectors.pageHeader.toggleClass('open');
			
		})

	}

	pizzettaApp.onLoad = function() {
		pizzettaApp.hideSmallCoverImages();
	}

	pizzettaApp.variolada = function() {

		window.bodyVariation = 0;

		$(".component-type--landing-page--header,.component-type--sub-page--header").on('click', function() {

			window.bodyVariation = (window.bodyVariation+1) % 3;
			let bodyClass = "var-" + (window.bodyVariation);

			$('body').attr('class',bodyClass);

		})

	}

	pizzettaApp.automateMaps = function() {

		let $maps = $('.map--container');

		$maps.each( function() {

			let $map_container = $(this);

			let map = $map_container.find('.map').get(0);

			let panzoom = Panzoom(map, { contain: 'outside', startScale: 1,  maxScale: 3 });

			var parent = map.parentElement.parentElement;

			parent.addEventListener('wheel', function(event) {
				event.stopPropagation();
				return panzoom.zoomWithWheel(event);

			})

			let $zoomInButton = $map_container.find('.map--action-zoom-in');
			$zoomInButton.on('click', function() {

				panzoom.zoomIn();
				return false;

			})

			let $zoomOutButton = $map_container.find('.map--action-zoom-out');
			$zoomOutButton.on('click', function() {

				panzoom.zoomOut();
				return false;

			})

			let $legend = $map_container.find('.map--legend');

			let $collapseLegendButton = $map_container.find('.map--legend--action--collapse');
			let $expandLegendButton = $map_container.find('.map--legend--action--expand');

			$collapseLegendButton.on('click', function() {

				$collapseLegendButton.hide();
				$expandLegendButton.show();
				$legend.addClass('collapsed');
				
				return false;

			})

			
			$expandLegendButton.on('click', function() {

				$expandLegendButton.hide();
				$collapseLegendButton.show();
				$legend.removeClass('collapsed');
				return false;

			})

			$expandLegendButton.hide();

			let $fullScreenButton = $map_container.find('.map--action-full-screen');
			let $exitFullScreenButton = $map_container.find('.map--action-exit-full-screen');

			if (parent.requestFullscreen) {
				
	
				$exitFullScreenButton.hide();
	
				$fullScreenButton.on('click', function() {
					
					parent.requestFullscreen().then( () => {
						panzoom.zoom(1);
						$exitFullScreenButton.show();
						$fullScreenButton.hide();
					}
						
					)
	
					return false;
	
				})
	
				$exitFullScreenButton.on('click', function() {
					
					document.exitFullscreen().then( () => {
						panzoom.zoom(1);
						$exitFullScreenButton.hide();
						$fullScreenButton.show();
					}
						
					)
	
					return false;
	
				})
	
			} else {

				$fullScreenButton.hide();
				$exitFullScreenButton.hide();

			}

						
			panzoom.zoom(1);
			
			

		})

		

	}

	pizzettaApp.init = function() {

		if ( document.readyState === 'complete'  ) {
			pizzettaApp.automateMaps();
		} else {
			$(window).on('load',pizzettaApp.automateMaps);
		}
		
		
		
		
	}


	pizzettaApp.init();

	window.pizzettaApp = pizzettaApp;

})


