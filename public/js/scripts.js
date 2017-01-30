$(document).ready(function() {
    $('.position-num').on('input', function() {
        var cartId = $(this).parent().parent().data('cart-id');
        var value = $(this).val();

        $.post("/ajax/set_cart_num", {cartId: cartId, value: value}, function (data) {
            $('.table-row-' + cartId + ' .position-num').val(data);
            $('.table-row-' + cartId + ' .position-sum').html(data * $('.table-row-' + cartId + ' .position-price').val());

            rewriteAllPrice();
            getCartNum();
        });
    });

    $('.remove-position').click(function() {
        var cartId = $(this).parent().parent().data('cart-id');

        $.post("/ajax/remove_from_cart", {cartId: cartId}, function (data) {
            $('.table-row-' + cartId).remove();

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

    $('.add-cart-btn-minus').on('click', function () {minusCartQuantity();});
    $('.add-cart-btn-plus').on('click', function () {plusCartQuantity();});

    $('#regBtn').click(function () {
        var username = $('#regForm #username').val();
        var email = $('#regForm #email').val();
        var password = $('#regForm #password').val();
        var rePassword = $('#regForm #rePassword').val();

        if (username == '') {
            alert('Не указан логин!');

            return false;
        }

        if (!isValidEmailAddress(email)) {
            alert('Некорректный адрес электронной почты!');

            return false;
        }

        if (password != rePassword) {
            alert('Пароли не совпадают!');

            return false;
        }

        if (checkIssetUsername(username) == 1) {
            alert('Такой логин существует!');

            return false;
        }

        if (checkIssetEmail(email) == 1) {
            alert('Такая почта существует!');

            return false;
        }

        $.post(
            '/ajax/registration',
            {username: username, email: email, password: password},
            function () {
                location.reload();
            }
        );
    });

    getCartNum();
});

function rewriteAllPrice(){
    $.ajax({type: 'POST', url: '/ajax/get_cart_all_price', async: true, data:{}})
        .done(function(allPrice){
            $('.all-price').html(allPrice);
        });
}
function addToCart(noticeId, quantity) {
    $.ajax({url:"/ajax/add_to_cart", data: {noticeId: noticeId, quantity: quantity}, type: 'POST', async: true}).done(function () {getCartNum();if ($('#order-form').length) {location.reload();}});
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
function getNoticeId() {return $('#noticeId').length ? $('#noticeId').val() : null;}
function getCartQuantity() {return $('#cartQuantity').val() * 1;}
function getRootItemQuantity() {return $('#rootItemQuantity').val() * 1;}
function minusCartQuantity() {setCartQuantity(getCartQuantity() - 1);}
function plusCartQuantity() {setCartQuantity(getCartQuantity() + 1);}
function setCartQuantity(quantity) {
    if (changeBtnMinusQuantityDisabledAttribute(quantity) && changeBtnPlusQuantityDisabledAttribute(quantity)) {
        $('#cartQuantity').val(quantity);
    }
}
function changeBtnMinusQuantityDisabledAttribute(quantity) {
    var $btn = $('.add-cart-btn-minus');

    if (quantity <= 0) {
        $btn.attr('disabled', 'disabled');

        return false;
    }

    $btn.removeAttr('disabled');

    return true;
}
function changeBtnPlusQuantityDisabledAttribute(quantity) {
    var $btn = $('.add-cart-btn-plus');

    if (quantity > getRootItemQuantity()) {
        $btn.attr('disabled', 'disabled');

        return false;
    }

    $btn.removeAttr('disabled');

    return true;
}

function isValidEmailAddress(email) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(email);
}

function isValidPhone(phone) {
    var pattern = new RegExp(/^[+7]{2}\d{10}$/i);
    return pattern.test(phone);
}

function checkIssetUsername(username) {
    return $.ajax({url: '/ajax/check_isset_username', data: {username: username}, type: 'POST', async: false}).responseText;
}

function checkIssetEmail(email) {
    return $.ajax({url: '/ajax/check_isset_email', data: {email: email}, type: 'POST', async: false}).responseText;
}