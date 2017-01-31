<div class="item-thumb-parent col-lg-3 col-md-4 col-xs-6 col-sm-3">
    <div class="item-thumb">
        <div class="like">
            <img src="/public/i/heart.png">
            Нравится
        </div>
        <div class="item-thumb-img">
            <a href="/item/show/<?=Arr::get($itemData, 'id');?>">
                <img src="/public/img/thumb/<?=(isset($itemData['imgs'][0]) ? $itemData['imgs'][0]['src'] : 'nopic.jpg');?>">
            </a>
        </div>
    </div>
    <div class="item-buttons">
        <button class="btn btn-danger btn-sale" value="<?=Arr::get($itemData, 'id');?>" onclick="addToCart(<?=Arr::get($itemData, 'id');?>, 1);">Купить <img src="/public/i/cart-icon.png"></button>
    </div>
</div>