<?
/**
 * @var $adminModel Model_Admin
 */
$adminModel = Model::factory('Admin');
?>
<!-- Begin page content -->
<div class="container">
    <div class="row afterf">
        <div class="col-md-1 col-xs-1 col-sm-1"></div>
        <div class="col-sm-10 col-xs-10 col-sm-10 category-container">
            <div class="xs-category-list">
                <div class="top-border"></div>
                <?foreach($adminModel->getCategory() as $group_1_data){
                    $group2 = $adminModel->getCategory($group_1_data['id']);
                    $groupsIn = [];

                    foreach ($group2 as $group_2_data) {
                        $groupsIn[] = $group_2_data['id'];
                    }
                    ?>
                    <div class="row-accordion">
                        <div class="" id="accordion1<?=$group_1_data['id'];?>">
                            <div class="">
                                <div class="">
                                    <h4 class="panel-title">
                                        <?if ($group_1_data['id'] == Arr::get($get, 'id')) {?>
                                            <span class="glyphicon glyphicon-ok pull-left"></span>
                                        <?}?>
                                        <a class="link" href="/category/list/?id=<?=$group_1_data['id'];?>"><?=$group_1_data['name'];?></a>
                                        <?if (!empty($group2)) {?>
                                            <a data-toggle="collapse" data-parent="#accordion1<?=$group_1_data['id'];?>" href="#collapse1<?=$group_1_data['id'];?>">
                                                <span class="glyphicon glyphicon-list pull-right"></span>
                                            </a>
                                        <?}?>
                                    </h4>
                                </div>
                                <div id="collapse1<?=$group_1_data['id'];?>" class="panel-collapse collapse <?=(in_array(Arr::get($get, 'id'), $groupsIn) ? 'in' : '');?>">
                                    <div class="panel-body product-group-panel-body">
                                        <?foreach ($group2 as $group_2_data){?>
                                            <div class="row-accordion">
                                                <div class="" id="accordion2<?=$group_2_data['id'];?>">
                                                    <div class="">
                                                        <div class="">
                                                            <h4 class="panel-title">
                                                                <?if ($group_2_data['id'] == Arr::get($get, 'id')) {?>
                                                                    <span class="glyphicon glyphicon-ok pull-left"></span>
                                                                <?}?>
                                                                <a class="link" href="/category/list/?id=<?=$group_2_data['id'];?>"><?=$group_2_data['name'];?></a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?}?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?}?>
                <div class="bottom-border"></div>
            </div>
            <div class="col-md-2 col-xs-2 col-sm-2 category-list">
                <div class="top-border"></div>
                <?foreach($adminModel->getCategory() as $group_1_data){
                    $group2 = $adminModel->getCategory($group_1_data['id']);?>
                    <div class="slide-trigger">
                        <div class="catalog-link">
                            <div class="panel-heading collapsed">
                                <h4 class="panel-title">
                                    <?if ($group_1_data['id'] == Arr::get($get, 'id')) {?>
                                    <span class="glyphicon glyphicon-ok pull-left"></span>
                                    <?}?>
                                    <a class="link" href="/category/list/?id=<?=$group_1_data['id'];?>"><?=$group_1_data['name'];?></a>
                                    <?if (!empty($group2)) {?>
                                    <span class="glyphicon glyphicon-chevron-right pull-right"></span>
                                    <?}?>
                                </h4>
                            </div>
                        </div>
                        <?if (!empty($group2)) {?>
                        <div class="panel-collapse collapse slidepnl">
                            <div class="top-border"></div>
                            <ul class="list-group">
                                <?foreach ($group2 as $group_2_data){?>
                                    <div class="sub-trigger">
                                        <li class="list-group-item">
                                            <h4 class="panel-title">
                                                <?if ($group_2_data['id'] == Arr::get($get, 'id')) {?>
                                                    <span class="glyphicon glyphicon-ok pull-left"></span>
                                                <?}?>
                                                <a class="link" href="/category/list/?id=<?=$group_2_data['id'];?>"><?=$group_2_data['name'];?></a>
                                            </h4>
                                        </li>
                                    </div>
                                <?}?>
                            </ul>
                            <div class="bottom-border"></div>
                        </div>
                        <?}?>
                    </div>
                <?}?>
                <div class="bottom-border"></div>
            </div>
            <div class="col-md-10 col-sm-10 col-xs-10 category-body">
                <div class="top-border"></div>
                <?
                $i = 1;
                foreach($notices as $notice) {
                    $diff = $i % 2;
                    $imgs = Arr::get(Arr::get($notice,'imgs',[]), 0, []);?>
                <div class="col-md-5 col-sm-12 col-xs-12 list-item <?=$diff == 1 ? 'first' : '';?>">
                    <div class="col-md-5 col-sm-5 col-xs-5 img-field">
                        <a href="/item/show/<?=$notice['id'];?>">
                            <img class="category-img" src="/public/img/thumb/<?=Arr::get($imgs, 'src', 'nopic.jpg');?>">
                        </a>
                    </div>
                    <div class="col-md-7  col-sm-7 col-xs-7 description-field">
                        <div class="row">
                            <div class="col-sm-12 col-sm-12 col-xs-12">
                                <a href="/item/show/<?=$notice['id'];?>" class="item-link">
                                    <div class="item-title"><?=$notice['name'];?>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-sm-12 col-xs-12">
                                <div class="item-price pull-right">
                                    <?=$notice['price'];?> руб.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?$i++;}?>
                <div class="bottom-border"></div>
            </div>
        </div>
        <div class="col-md-1 col-xs-1 col-sm-1"></div>
    </div>
</div>