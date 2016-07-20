$(document).ready(function() {
    $('.to-cart').click(function() {
        var item = $(this).val();
        $.post("/ajax/add_to_cart", {item: item}, function (data) {
            getCartNum();
        });
    });

    $('.position-num-plus').click(function() {
        var cartId = $(this).val();
        $.post("/ajax/plus_cart_num", {id: cartId}, function (data) {console.log(data);
            $('#positionNum_' + cartId).val(data);
            $('#positionSum_' + cartId).html(data * $('#positionPrice_' + cartId).val());
            rewriteAllPrice();
            getCartNum();
        });
    });

    $('.position-num-minus').click(function() {
        var cartId = $(this).val();
        $.post("/ajax/minus_cart_num", {id: cartId}, function (data) {
            $('#positionNum_' + cartId).val(data);
            $('#positionSum_' + cartId).html(data * $('#positionPrice_' + cartId).val());
            rewriteAllPrice();
            getCartNum();
        });
    });

    $('.remove-position').click(function() {
        var cartId = $(this).val();
        $.post("/ajax/remove_from_cart", {id: cartId}, function (data) {
            $('#tableRow_' + cartId).remove();
            rewriteAllPrice();
            getCartNum();
        });
    });

    $('.remove-all-positions').click(function() {
        $.post("/ajax/remove_all_cart", {}, function (data) {
            $('.cart-table tbody').html('<tr><td class="item-name"></td><td class="item-price"></td><td class="item-num"></td><td class="item-price"></td><td class="item-actions"></td></tr>');
            rewriteAllPrice();
            getCartNum();
        });
    });

    $('.submit-order-btn').click(function(){
        if ($('#name').val() == '') {
            alert('Укажите свое имя!');

            return false;
        }
        if ($('#phone').val() == '') {
            alert('Укажите свой телефон!');

            return false;
        }
        if ($('#address').val() == '') {
            alert('Укажите свой адрес!');

            return false;
        }

        $('#order-form').submit();
    });

    $('#sendReview').click(function(){
        if ($('#author').val() == '') {
            alert('Укажите свое имя!');

            return false;
        }
        if ($('#review').val() == '') {
            alert('Введите текст отзыва!');

            return false;
        }
        if ($('#city').val() == '') {
            alert('Укажите свой адрес!');

            return false;
        }
        $.ajax({type: 'POST', url: '/ajax/add_review', async: true, data:{
            author: $('#author').val(),
            city: $('#city').val(),
            review: $('#review').val(),
        }})
        .done(function(data){
            $('#sendReview').remove();
            $('#reviewModal .modal-body').html('<div class="alert alert-success"><strong>Отзыв успешно отправлен!</strong><br /> Ваш отзыв появится на сайте после проверки модератором. Спасибо!.</div>');
        });

    });

    getCartNum();
});

function rewriteAllPrice(){
    var positionsPrices = $('.position-price');
    var positionsNum = $('.position-num');
    var allPrice = 0;

    if(positionsPrices.length > 0) {
        for (i=0;i<positionsPrices.length;i++){
            allPrice += positionsPrices[i].value * positionsNum[i].value;
        }
    }

    $('#allPrice').html(allPrice);
}

function getCartNum(){
    $.ajax({type: 'POST', url: '/ajax/get_cart_num', async: true, data:{}})
    .done(function(data){
        if ($(window).width() <= 375) {
            var fontSize = '7px';
            var marginTop = '22px';
        } else {
            var fontSize = '18px';
            var marginTop = '44px';
        }
        if (data == 0) {
            data = 'корзина';
            if ($(window).width() <= 375) {
                fontSize = '6px';
                marginTop = '24px';
            } else {
                fontSize = '14px';
                marginTop = '46px';
            }
        }

        $('.cart-num')
            .css('font-size', fontSize)
            .css('margin-top', marginTop)
            .html(data);
    });
}