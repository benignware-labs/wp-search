(function( $ ) {
	console.log('INIT WIDGET');

	$.widget("custom.catcomplete", $.ui.autocomplete, {
		_create: function() {
			this._super();
			this.widget().menu( 'option', 'items', '> :not(.ui-widget-header)' );
		},
    _renderMenu: function(ul, items) {
      const self = this;
      let currentCategory = '';

      $.each(items, function(index, item) {
        if (item.category != currentCategory) {
					const $header = $(`<li class="ui-widget-header">${item.category}</li>`);

          ul.append($header);
          currentCategory = item.category;
        }

        self._renderItemData(ul, item);
      });
    },
		_renderItem: function( ul, item ) {
		  return $( '<li>' )
		    .append( item.label )
		    .appendTo( ul );
		}
	});

	$(function() {
		const options = { ...JSON.parse(decodeURIComponent(SearchXtSuggestions.options)) };

		console.log('options', options, $.ui.version);

		$('input[data-search-input]').each(function() {
      const $instance = $(this).catcomplete({
        appendTo: $('<div></div>').insertAfter(this.form),
  			source: SearchXtSuggestions.url,
  			delay: 500,
  			minLength: 1,
				select: function(event, { item }) {
					if (item.href) {
						window.location.href = item.href;
					}
        },
				...options.autocomplete,
				classes: {
					'ui-catcomplete': 'highlight',
					'ui-autocomplete': 'highlight'
				}
  		});

      return $instance;
	  });
  });

})( jQuery );
