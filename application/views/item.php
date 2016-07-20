<!-- Begin page content -->
<div class="container">
    <div class="row afterf">
        <div class="col-md-6 col-xs-12 col-sm-6">
            <?
            $imgs = Arr::get($notice_info,'imgs',[]);
            $firstImg = reset($imgs);
            if (!empty($firstImg)) {?><img src="/public/img/original/<?=$firstImg['src'];?>" class="item-lage" id="big-img"><?}?>
            <?foreach($imgs as $img){?>
            <div class="item-small">
                <img src="/public/img/original/<?=$img['src'];?>" onclick="$('#big-img').attr('src', $(this).attr('src'));">
            </div>
            <?}?>
        </div>
        <div class="col-md-6 col-xs-12 col-sm-6 item-description-body">
            <div class="col-md-12  col-sm-12 col-xs-12">
                <div class="item-title"><?=Arr::get($notice_info, 'name');?></div>
                <div class="description">
                    <?=Arr::get($notice_info, 'description');?>
                </div>
                <?foreach($noticeParams as $paramsData){?>
                <div><?=$paramsData['name'];?><span class="pull-right"><?=$paramsData['value'];?></span></div>
                <?}?>
                <div class="row">
                    <button class="btn btn-default pull-right to-cart" type="button" value="<?=Arr::get($notice_info, 'id');?>">
                        <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true">
                        </span>
                    </button>
                    <div class="item-price pull-right"><?=Arr::get($notice_info, 'price');?> руб.</div>
                </div>
            </div>
        </div>
    </div>
</div>