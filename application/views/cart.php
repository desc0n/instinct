<div class="cart-content">
    <div class="cart-title">Корзина</div>
    <table class="table table-bordered cart-table">
        <thead>
        <tr>
            <td></td>
            <td>Товар</td>
            <td>Цена</td>
            <td>Количество</td>
            <td>Сумма</td>
        </tr>
        </thead>
        <tbody>

        <?
        $allPrice = 0;

        foreach($cart as $cartData) {
            $allPrice += $cartData['price'] * $cartData['num'];
            ?>
            <tr id="tableRow_<?=$cartData['id'];?>" data-cart-id="<?=$cartData['id'];?>">
                <td class="text-center">
                    <button class="btn btn-danger btn-xs remove-position">x</button>
                </td>
                <td class="text-left item-name">
                    <a href="/item/show/<?=$cartData['notice_id'];?>"><?=$cartData['name'];?></a>
                </td>
                <td class="item-price">
                    <span><?=$cartData['price'];?></span>
                    <input type="hidden" class="position-price" id="positionPrice_<?=$cartData['id'];?>" value="<?=$cartData['price'];?>">
                </td>
                <td class="item-num">
                    <input class="form-control position-num" id="positionNum_<?=$cartData['id'];?>" type="text" value="<?=$cartData['num'];?>">
                </td>
                <td class="item-price">
                    <span  id="positionSum_<?=$cartData['id'];?>"><?=$cartData['price']*$cartData['num'];?></span>
                </td>
            </tr>
        <?}?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="4" class="text-right">
                Товаров в корзине на сумму:
            </td>
            <td class="item-price">
                <span id="allPrice"><?=$allPrice;?></span>
            </td>
        </tr>
        </tfoot>
    </table>
    <div class="cart-order">
        <div class="cart-order-title">
            В приведенной ниже форме оставьте, пожалуйста, Ваше имя и телефон (или e-mail),
            по которым наш менеджер сможет связаться с вами для уточнения условий заказа
        </div>
        <div id="order-form" class="row">
            <div class="delivery-type-form col-lg-12 col-md-12 col-sm-12 col-xs-12" id="deliveryTypeForm">
                <div class="quest-client-order-form">
                    <label class="pull-left">Ваше имя <span>*</span> :</label>
                    <input class="form-control cart-customer-field" id="name" name="name" type="text" placeholder="Ваше имя" value="">
                </div>
                <div class="quest-client-order-form">
                    <label class="pull-left">Телефон <span>*</span> :</label>
                    <input class="form-control cart-customer-field" id="phone" name="phone" type="text" placeholder="Телефон" value="">
                </div>
                <div class="quest-client-order-form">
                    <label class="pull-left">Адрес :</label>
                    <input class="form-control cart-customer-field" id="address" name="address" type="text" placeholder="Адрес" value="">
                </div>
                <div class="quest-client-order-form">
                    <label class="pull-left">E-mail :</label>
                    <input class="form-control cart-customer-field" id="email" name="email" type="text" placeholder="E-mail" value="">
                </div>
            </div>
            <input type="hidden" name="newOrder" value="1">
        </div>
        <div class="agreement">
            <div class="agreement-title">Соглашение</div>
            <div class="agreement-content">
<!--                Lorem ipsum dolor sit amet, consectetur adipiscing elit,-->
<!--                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.-->
<!--                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip-->
<!--                ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate-->
<!--                velit esse cillum dolore eu fugiat nulla pariatur.-->
<!--                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt-->
<!--                mollit anim id est laborum.-->
            </div>
            <div class="agreement-checkout">
                <input type="checkbox"> Согласен
            </div>
        </div>
        <?if (!empty($cart)) {?>
            <div class="submit-order-btn-field">
                <button class="btn btn-danger submit-order-btn" type="button" disabled>Оформить заказ</button>
            </div>
        <?}?>
    </div>
</div>
<div class="modal fade" id="modalAlert">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="alert alert-success">
                    <strong>Заказ успешно отправлен!</strong> Мы свяжемся с вами в ближайшее время.
                </div>
            </div>
        </div>
    </div>
</div>