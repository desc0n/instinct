<?
/** @var $contentModel Model_Content */
$contentModel = Model::factory('Content');

/** @var Model_Notice $noticeModel */
$noticeModel = Model::factory('Notice');
?>
<div class="row">
    <h2 class="sub-header col-sm-12">Редактирование товаров:</h2>
    <h4 class="sub-header col-sm-12">Группа: <?=Arr::get($notice_info,'category_name');?></h4>
    <h2 class="sub-header col-sm-12">Карточка товара:</h2>
    <span class="col-sm-11 redact-form">
        <table class="table">
            <form id="redactproduct_form" role="form" method="post">
<!--                <tr>-->
<!--                    <th class="text-left">Сортировка</th>-->
<!--                    <td><input type="text" name="sort" class="order-select form-control" value="--><?//=Arr::get($notice_info,'sort');?><!--"></td>-->
<!--                </tr>-->
                <tr>
                    <th class="text-left hidden-xs hidden-sm">Артикул</th>
                    <td>
                        <p class="hidden-lg hidden-md">Артикул</p>
                        <input type="text" name="article" class="order-select form-control" value="<?=Arr::get($notice_info,'article');?>">
                    </td>
                </tr>
                <tr>
                    <th class="text-left hidden-xs hidden-sm">Наименование</th>
                    <td>
                        <p class="hidden-lg hidden-md">Наименование</p>
                        <textarea name="name" class="form-control"><?=Arr::get($notice_info,'name','');?></textarea>
                    </td>
                </tr>
                <tr>
                    <th class="text-left hidden-xs hidden-sm">Описание</th>
                    <td>
                        <p class="hidden-lg hidden-md">Описание</p>
                        <textarea name="description" class="form-control ckeditor"><?=Arr::get($notice_info,'description','');?></textarea>
                    </td>
                </tr>
                <tr>
                    <th class="text-left hidden-xs hidden-sm">Цена</th>
                    <td>
                        <p class="hidden-lg hidden-md">Цена</p>
                        <input type="text" name="price" class="price-form form-control" value="<?=Arr::get($notice_info,'price',0);?>">
                    </td>
                </tr>
                <tr>
                    <th class="text-left hidden-xs hidden-sm">Количество</th>
                    <td>
                        <p class="hidden-lg hidden-md">Количество</p>
                        <input type="text" name="quantity" class="form-control" value="<?=Arr::get($notice_info,'quantity',0);?>">
                    </td>
                </tr>
                <input type="hidden" name="redactnotice" value="<?=$notice_id;?>">
            </form>
            <tr>
                <th class="text-left hidden-xs hidden-sm">Фото</th>
                <td class="imgs-form">
                    <?foreach(Arr::get($notice_info,'imgs',[]) as $img){?>
                        <div class="img-link">
                            <img src="/public/img/thumb/<?=$img['src'];?>">
                            <span class="pull-right glyphicon glyphicon-remove" title="удалить" onclick="$('#remove_img > #removeimg').val(<?=$img['id'];?>);$('#remove_img').submit();"></span>
                        </div>
                    <?}?>
                    <button class="btn btn-primary" onclick="$('#loadimg_modal').modal('toggle');"><span class="pull-right glyphicon glyphicon-plus"></span></button>
                </td>
            </tr>
        </table>
        <div class="col-md-12 form-group">
            <button class="btn btn-success" onclick="$('#redactproduct_form').submit();">Сохранить изменения</button>
        </div>
        <div class="col-md-12 form-group">
            <form method="post" class="form-horizontal" action="/admin/control_panel/add_notice">
                <button class="btn btn-default" type="submit" name="addnotice" value="3">Добавить в ту же категорию <span class="glyphicon glyphicon-plus"></span></button>
                <input type="hidden" class="form-control" name="name">
                <input type="hidden" name="category" value="<?=Arr::get($notice_info,'category');?>">
            </form>
        </div>
        <div class="col-md-12 form-group">
            <button class="btn btn-primary"  onclick="$('#addCustomCategoryNotice').modal('toggle');">Добавить в другую категорию <span class="glyphicon glyphicon-plus"></span> </button>
        </div>
    </div>
</div>
<div class="modal fade" id="loadimg_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Загрузка изображения</h4>
            </div>
            <div class="modal-body">
                <form role="form" method="post" enctype='multipart/form-data'>
                    <div class="form-group">
                        <label for="exampleInputFile">Выбор файла</label>
                        <input type="file" name="imgname[]" id="exampleInputFile" multiple>
                    </div>
                    <input type="hidden" name="loadproductimg" value="<?=$notice_id;?>">
                    <button type="submit" class="btn btn-default">Загрузить</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<form id="remove_img" method="post">
    <input type="hidden" id="removeimg" name="removeimg" value="0">
</form>
<div class="modal fade" id="loadfile_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Загрузка документа</h4>
            </div>
            <div class="modal-body">
                <form role="form" method="post" enctype='multipart/form-data'>
                    <div class="form-group">
                        <label for="exampleInputFile">Выбор файла</label>
                        <input type="file" name="filename[]" multiple>
                    </div>
                    <input type="hidden" name="loadproductfile" value="<?=$notice_id;?>">
                    <button type="submit" class="btn btn-default">Загрузить</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<form id="remove_file" method="post">
    <input type="hidden" id="removefile" name="removefile" value="0">
</form>
<div class="modal fade" id="addCustomCategoryNotice">
    <form role="form" method="post" action="/admin/control_panel/add_notice">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Выберите категорию для добавления</h4>
            </div>
            <div class="modal-body">
                <?foreach($contentModel->getCategory() as $group_1_data){?>
                    <div class="row-accordion">
                        <div class="panel-group" id="accordion1<?=$group_1_data['id'];?>">
                            <div class="row">
                                <div class="col-lg-1 col-sm-1 col-md-1 col-xs-1">
                                    <input type="radio" name="category" value="<?=$group_1_data['id'];?>">
                                </div>
                                <a class="col-lg-7 col-sm-7 col-md-7 col-xs-7" data-toggle="collapse" data-parent="#accordion1<?=$group_1_data['id'];?>" href="#collapse1<?=$group_1_data['id'];?>">
                                    <?=$group_1_data['name'];?>
                                </a>
                                <div class="text-left col-lg-4 col-sm-4 col-md-4 col-xs-4">
                                    <span class="glyphicons glyphicons-collapse"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div id="collapse1<?=$group_1_data['id'];?>" class="col-lg-12 col-sm-12 col-md-12 col-xs-12 panel-collapse collapse <?=(Arr::get($get,'group_1','') == $group_1_data['id'] ? 'in' : '');?>">
                                    <?foreach ($contentModel->getCategory($group_1_data['id']) as $group_2_data){?>
                                    <div class="row-accordion">
                                        <div class="row" id="accordion2<?=$group_2_data['id'];?>">
                                            <div class="col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                                            <div class="col-lg-1 col-sm-1 col-md-1 col-xs-1">
                                                <input type="radio" name="category" value="<?=$group_2_data['id'];?>">
                                            </div>
                                            <a class="col-lg-8 col-sm-8 col-md-8 col-xs-8" data-toggle="collapse" data-parent="#accordion2<?=$group_2_data['id'];?>" href="#collapse2<?=$group_2_data['id'];?>">
                                                <?=$group_2_data['name'];?>
                                            </a>
                                        </div>
                                    </div>
                                    <?}?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?}?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
                <button class="btn btn-primary" type="submit" name="addnotice" value="3">Добавить <span class="glyphicon glyphicon-plus"></span></button>
                <input type="hidden" class="form-control" name="name">
            </div>
        </div>
    </div>
    </form>
</div>