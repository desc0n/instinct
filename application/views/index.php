<?php
/** @var $noticeModel Model_Notice */
$noticeModel = Model::factory('Notice');
?>
<div class="market-content row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?=$market_content;?>
    </div>
</div>
<div class="pagination-row">
    Страница
    <?php for ($i = 1; $i <= ceil($noticesCount / $noticeModel::NOTICES_MARKET_LIMIT); $i++) {?>
    <a class="btn btn-default <?=($i == $page ? 'btn-pagination-active' : 'btn-pagination');?>" href="/?page=<?=$i;?>"><?=$i;?></a>
    <?}?>
</div>
