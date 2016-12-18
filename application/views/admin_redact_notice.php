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
            <button class="btn btn-success" onclick="$('#redactproduct_form').submit();">Сохранить</button>
        </div>
        <div class="col-md-12 form-group">
            <form method="post" class="form-horizontal" action="/admin/control_panel/add_notice">
                <button class="btn btn-default" type="submit" name="addnotice" value="3">Добавить в ту же категорию <span class="glyphicon glyphicon-plus"></span></button>
                <input type="hidden" class="form-control" name="name">
                <input type="hidden" name="category" value="<?=Arr::get($notice_info,'category');?>">
            </form>
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