<div class="item-content">
    <div class="row">
        <div class="col-lg-5">
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
        <div class="col-lg-7 item-description-body">
            <div class="col-lg-12">
                <div class="row item-title"><?=Arr::get($itemData, 'name');?></div>
                <div class="row description">
                    <?=Arr::get($itemData, 'description');?>
                </div>
                <div class="row">
                    <div class="item-price pull-right"><strong><?=Arr::get($itemData, 'price');?> руб.</strong></div>
                </div>
                <div class="row">
                    <button class="btn btn-danger btn-sale">Купить <img src="/public/i/cart-icon.png"></button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pagination-row"></div>