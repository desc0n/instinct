<?php
/** @var $noticeModel Model_Notice */
$noticeModel = Model::factory('Notice');

$i = 0;
foreach ($notices as $notice) {
    if ($i >= $noticeModel::NOTICES_MARKET_LIMIT * ($page - 1) && $i < $noticeModel::NOTICES_MARKET_LIMIT * $page) {
        ?>
        <?=View::factory('item_thumb')->set('itemData', $notice);?>
        <?
    }

    $i++;
}
?>

