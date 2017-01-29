<div class="item-content">
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
            <?
            $imgs = Arr::get($itemData,'imgs',[]);
            $firstImg = reset($imgs);
            if (!empty($firstImg)) {?><img src="/public/img/original/<?=$firstImg['src'];?>" class="item-large" id="big-img"><?}?>
            <?foreach($imgs as $img){?>
                <div class="item-small">
                    <img src="/public/img/original/<?=$img['src'];?>" onclick="$('#big-img').attr('src', $(this).attr('src'));">
                </div>
            <?}?>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 item-description-body">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row item-title"><?=Arr::get($itemData, 'name');?></div>
                <div class="row description">
                    <?=Arr::get($itemData, 'description');?>
                </div>
                <div class="row">
                    <div class="item-price pull-right"><strong><?=Arr::get($itemData, 'price');?> руб.</strong></div>
                </div>
                <div class="row item-buttons">
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                        <?if((int)Arr::get($itemData, 'quantity', 0) === 0) {?>
                        <strong>нет в наличии</strong>
                        <?} else {?>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button class="btn btn-danger add-cart-btn-minus" type="button" disabled>
                                    <span class="glyphicon glyphicon-minus"></span>
                                </button>
                            </span>
                            <input type="text" class="form-control" id="cartQuantity" value="1">
                            <input type="hidden" id="rootItemQuantity" value="<?=Arr::get($itemData, 'quantity');?>">
                            <span class="input-group-btn">
                                <button class="btn btn-danger add-cart-btn-plus" type="button" <?=((int)Arr::get($itemData, 'quantity', 1) === 1 ? 'disabled' : null);?>>
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                            </span>
                        </div>
                        <?}?>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                        <button class="btn btn-danger btn-sale">Купить <img src="/public/i/cart-icon.png"></button>
                    </div>
                </div>
                <input type="hidden" id="noticeId" value="<?=Arr::get($itemData, 'id');?>">
            </div>
        </div>
    </div>
</div>
<div class="pagination-row"></div>