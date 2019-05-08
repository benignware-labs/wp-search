(function( $ ) {
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
		const url = SearchXtSuggestions.url + '?action=my_search';

		$('input[name="s"]').each(function() {
      const $container = $(this).parents('form').next('*[data-suggestions]');

			const data = $container.data('suggestions');

			console.log('data', data);

			const options = data ? { ...JSON.parse(decodeURIComponent(data)) } : {};

			console.log('options', options);

			// Fix twenty seventeen menu leaking styles
			const $m = $(this).parents('.main-navigation');

			if ($m.length) {
				$m.before($container, $m);
			}

      $container.addClass('search-suggestions-container');

      const $instance = $(this).catcomplete({
        appendTo: $container,
  			source: url,
  			delay: 500,
  			minLength: 1,
				select: function(event, { item }) {
					if (item.href) {
						window.location.href = item.href;
					}
        },
				...options
  		});

      return $instance;
	  });
  });

})( jQuery );
