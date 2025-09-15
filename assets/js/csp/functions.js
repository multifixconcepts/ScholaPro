/**
 * Functions (global, always loaded) JS
 *
 * @since 12.5
 *
 * @package RosarioSIS
 */

csp.functions.onEvents = function() {
	$('#body,#colorbox').on('focus', '.onclick', csp.functions.inputDivOnclick);

	csp.functions.listOutput.prepare();

	/**
	 * ajaxPrepare #body (or #colorbox) after AJAX call
	 * Use when delegated events are not possible
	 * or not recommended (mouseover fires too frequently)
	 *
	 * @see ajaxPrepare()
	 */
	$('#body,#colorbox').on('ajaxPrepare', csp.functions.listOutput.prepare);
}

$(csp.functions.onEvents);

/**
 * Add input HTML when clicking on <div onclick> (input value & title)
 * Listen to focus event: can be triggered by the Tab key (keyboard navigation)
 *
 * @see InputDivOnclick()
 *
 * @uses addHTML() function
 */
csp.functions.inputDivOnclick = function() {
	var divOnclickId = this.parentNode.id;

	if (! divOnclickId) {
		return;
	}

	var inputId = divOnclickId.substring(3),
		inputHtml = document.getElementById('html' + inputId);

	if (! inputHtml) {
		return;
	}

	addHTML(inputHtml.innerHTML, divOnclickId, true);

	if (typeof inputHtml.remove === 'function') { // Fix for Internet Explorer
		inputHtml.remove();
	}

	$('#' + inputId).focus();
	$('#' + divOnclickId).click();
}

/**
 * ListOutput() function JS
 *
 * @todo Remove onKeyPress & onClick in 13.0
 */
csp.functions.listOutput = {
	onKeyPress: function(e) {
		LOSearch(e, this.value, this.dataset.url);
	},
	onClick: function(e) {
		var input = $(this).prev('#LO_search');

		LOSearch(e, input.val(), input.data('url'));
	},
	verticalTabNavigation: function() {
		/**
		 * Navigate table inputs vertically using tab key.
		 *
		 * @link https://stackoverflow.com/questions/38575817/set-tabindex-in-vertical-order-of-columns
		 */
		var tabindex = 1;

		$('tbody', this).each(function(i, tbl) {
			$(tbl).find('tr').first().find('td').each(function(clmn, el) {
				$(tbl).find('tr td:nth-child(' + (clmn + 1) + ') :input').each(function(j, input) {
					$(input).attr('tabindex', tabindex++);
				});
			});
		});
	},
	prepare: function() {
		$('#' + this.id + ' #LO_search').on('keypress', csp.functions.listOutput.onKeyPress);

		$('#' + this.id + ' #LO_search + .button').on('click', csp.functions.listOutput.onClick);

		$('#' + this.id + ' .list.vertical-tab-navigation').each(csp.functions.listOutput.verticalTabNavigation);
	}
}
