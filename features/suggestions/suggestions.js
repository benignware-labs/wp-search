(function( $ ) {
	$(function() {
    const options = {
      linkClass: 'search-suggestions-link'
    };

		const url = SearchXtSuggestions.url + '?action=my_search';

		$('input[name="s"]').each(function() {
      var $container = $(this).parents('form').next('*[data-suggestions]');

      $container.addClass('search-suggestions-container');

      var $instance = $(this).autocomplete({
        appendTo: $container,
  			source: url,
  			delay: 500,
  			minLength: 3
  		});

      $instance.data("ui-autocomplete")._renderItem = function( $ul, item ) {

        let html = `<span>${item.label}</span>`;

        if (item.link) {
          html = `<a class="${options.linkClass}" href="${item.link}">${html}</a>`;
        }

        return $( '<li class="ui-autocomplete-row list-group-item"></li>' )
          .data( "item.autocomplete", item )
          .append( html )
          .appendTo( $ul );
      };

      $instance.data("ui-autocomplete")._renderMenu = function( $ul, items ) {
        var instance = this;
        $.each( items, function( index, item ) {
          instance._renderItemData( $ul, item );
        });

        $ul.addClass('search-suggestions list-group');
      };

      return $instance;
	  });
  });

})( jQuery );
