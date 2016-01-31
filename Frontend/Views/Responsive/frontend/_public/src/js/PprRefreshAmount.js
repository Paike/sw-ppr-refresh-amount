function cartRefresh() {
	var ajaxCartRefresh = window.controller.ajax_cart_refresh,
		$cartAmount = $('.cart--amount'),
		$cartQuantity = $('.cart--quantity');

	if (!ajaxCartRefresh.length) {
		return;
	}

	$.ajax({
		'url': ajaxCartRefresh,
		'dataType': 'jsonp',
		'success': function (response) {
			var cart = JSON.parse(response);

			if(!cart.amount || !cart.quantity) {
				return;
			}

			$cartAmount.html(cart.amount);
			$cartQuantity.html(cart.quantity).removeClass('is--hidden');

			if(cart.quantity == 0) {
				$cartQuantity.addClass('is--hidden');
			}
		}
	});
}
$(function(){
	var cartAmount = Number($('.cart--amount').text().replace(/[^\d]/g,''));
	if(cartAmount * 1 == 0) cartRefresh();
});