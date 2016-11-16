$(document).ready(function() {
    $('.btn-sale').click(function() {
        var noticeId = $(this).val();
        $.post("/ajax/add_to_cart", {noticeId: noticeId}, function (data) {
            getCartNum();

            if ($('#order-form').length) {
                location.reload();
            }
        });
    });

    $('.position-num').on('input', function() {
        var cartId = $(this).parent().parent().data('cart-id');
        var value = $(this).val();

        $.post("/ajax/set_cart_num", {cartId: cartId, value: value}, function (data) {
            $('#positionNum_' + cartId).val(data);
            $('#positionSum_' + cartId).html(data * $('#positionPrice_' + cartId).val());

            rewriteAllPrice();
            getCartNum();
        });
    });

    $('.remove-position').click(function() {
        var cartId = $(this).parent().parent().data('cart-id');

        $.post("/ajax/remove_from_cart", {cartId: cartId}, function (data) {
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

        sendOrder();
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

    $('.agreement-checkout input[type=checkbox]').on('click', function () {
        if ($(this).prop('checked')) {
            $('.submit-order-btn').removeAttr('disabled');
        } else {
            $('.submit-order-btn').attr('disabled', 'disbled');
        }
    });

    checkItemHeight();
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
        $('#cart-num').html(data);
    });
}

function sendOrder() {
    var name = $('#name').val();
    var phone = $('#phone').val();
    var address = $('#address').val();
    var email = $('#email').val();

    $.ajax({type: 'POST', url: '/ajax/send_order', async: true, data:{name: name, phone: phone, address: address, email: email}})
    .done(function(){
        $('.cart-table tbody tr').remove();

        rewriteAllPrice();
        getCartNum();

        $('#modalAlert').modal('toggle');
    });
}

function checkItemHeight()
{
    var imgs = $('.item-thumb-img img');

    for (i = 0; i < imgs.length; i++) {
        if(imgs[i].height > 105) {
            imgs[i].style.height = '105px';
        }
    }
}