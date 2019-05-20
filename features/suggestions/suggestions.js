(function( $ ) {
	const version = parseFloat($.ui.version.match(/^\d+\.\d+/)[0]);
	const options = { ...JSON.parse(decodeURIComponent(SearchXtSuggestions.options)) };
	const support = {
		classes: version >= 1.12
	};

	const classes = options.ui.classes || [];

	$.widget("custom.searchcomplete", $.ui.autocomplete, {
		_create: function() {
			this._super();
			this.widget().menu( 'option', 'items', '> :not(.ui-widget-header)' );
			this.widget().menu( 'option', 'classes', classes );
			this.widget( 'option', 'classes', classes );

			this._invalid = false;
		},
    _renderMenu: function(ul, items) {
      const self = this;
      let currentCategory = '';

      $.each(items, function(index, item) {
        if (item.category != currentCategory) {
					const className = classes['ui-widget-header'];
					const $header = $(`<li class="ui-widget-header search-suggestions-category ${className}">${item.category}</li>`);

          ul.append($header);
          currentCategory = item.category;
        }

        self._renderItemData(ul, item);
      });

			this._invalid = true;
    },
		_renderItem: function( ul, item ) {
		  return $( '<li class="search-suggestions-item">' )
		    .append( item.label )
		    .appendTo( ul );
		},
		_resizeMenu: function() {
			if (this._invalid) {
				const ul = this.menu.element;

				if (!support.classes) {
					for (const [ className, customClass ] of Object.entries(classes)) {
						if (ul.hasClass(className)) {
							ul.addClass(customClass);
						} else {
							ul.find(`.${className}`).addClass(customClass);
						}
					}
				}

				ul.addClass('search-suggestions');
			}

			window.requestAnimationFrame(() => {
				const w = $(window).width() - this.menu.element.offset().left - parseFloat(this.menu.element.css('marginRight'));

				this.menu.element.outerWidth(w);
			});
		}
	});

	$(function() {
		const $input = $('input[data-search-input]');

		$input.each(function() {
			const $this = $(this);

			if (!support.classes) {
				$this.addClass(classes['ui-autocomplete-input']);
				// TODO: Apply `ui-autocomplete-loading`
			}

      const $instance = $this.searchcomplete({
        appendTo: $('<div class="search-suggestions-container"></div>').insertAfter(this.form),
  			source: SearchXtSuggestions.url,
  			delay: 500,
  			minLength: 1,
				select: function(event, { item }) {
					if (item.href) {
						window.location.href = item.href;
					}
        },
				...options.suggestions.autocomplete
  		});

      return $instance;
	  });
  });

})( jQuery );
