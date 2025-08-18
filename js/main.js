    $(function() {

        function showCart(cart) {
            $('#cart-modal .modal-cart-content').html(cart);
            $('#cart-modal').modal();

            let cartQty = $('#modal-cart-qty').text() ? $('#modal-cart-qty').text() : 0;
            $('.mini-cart-qty').text(cartQty);
        }

        $('.add-to-cart').on('click', function (e) {
            e.preventDefault();
            let id = $(this).data('id');

            $.ajax({
                url: '../cart/cart.php',
                type: 'GET',
                data: {cart: 'add', id: id},
                dataType: 'json',
                success: function (res) {
                    if (res.code == 'ok') {
                        showCart(res.answer);
                    } else {
                        alert(res.answer);
                    }
                },
                error: function () {
                    alert('Error');
                }
            });
        });

        $('#get-cart').on('click', function (e) {
            e.preventDefault();

            $.ajax({
                url: '../cart/cart.php',
                type: 'GET',
                data: {cart: 'show'},
                success: function (res) {
                    showCart(res);
                },
                error: function () {
                    alert('Error');
                }
            });
        });

    $('#cart-modal .modal-cart-content').on('click', '#clear-cart', function () {
        $.ajax({
            url: '../cart/cart.php',
            type: 'GET',
            data: {cart: 'clear'},
            success: function (res) {
                showCart(res);
            },
            error: function () {
                alert('Error');
            }
        });
    });

});
