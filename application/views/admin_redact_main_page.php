<?
/** @var $contentModel Model_Content */
$contentModel = Model::factory('Content');
?>
<div class="row">
    <h2 class="sub-header col-sm-12">Популярные товары</h2>
    <div class="col-sm-11 redact-form">
        <table class="table table-bordered">
            <tr>
                <th class="text-left col-md-11">Товар</th>
                <th class="text-center col-md-1">Действия</th>
            </tr>
            <?foreach($hitsData as $hit){?>
            <tr>
                <td class="">
                    <?=$hit['name'];?>
                </td>
                <td class="text-center">
                    <button class="btn btn-danger">
                        <span class="pull-right glyphicon glyphicon-remove" title="удалить" onclick="$('#remove_hit > #removehit').val(<?=$hit['id'];?>);$('#remove_hit').submit();"></span>
                    </button>
                </td>
            </tr>
            <?}?>
            <?if (count($hitsData) < 4) {?>
            <tr>
                <td colspan="2">
                    <button class="btn btn-primary" onclick="$('#searchModal').modal('toggle');">
                        <span class="glyphicon glyphicon-plus"></span> Добавить популярный товар
                    </button>
                </td>
            </tr>
            <?}?>
        </table>
    </div>
</div>
<form id="add_hit" method="post">
    <input type="hidden" id="addhit" name="addhit" value="0">
</form>
<form id="remove_hit" method="post">
    <input type="hidden" id="removehit" name="removehit" value="0">
</form>
<form class="form-horizontal row" style="display:inline-block;margin-left:40px;" method="post">
    <p>
    <div class="row">
        <h3>Редактируем текст главной страницы</h3>
    </div>
    </p>
    <p>
    <div class="form-group span12">
        <label for="redact_content_text">Текст страницы</label>
        <textarea id="redact_content_text" name="text" class="ckeditor"><?=Arr::get($pageData, 'content', '');?></textarea>
    </div>
    </p>
    <p>
    <div class="row">
        <button type="submit" class="btn btn-primary" name="redactpage" value="3">Сохранить</button>
    </div>
    </p>
</form>
<div class="modal fade" id="searchModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Поиск товара</h4>
            </div>
            <div class="modal-body">
                <div class="col-sm-4 left-nav">
                    <div class="">
                        <?foreach($contentModel->getCategory() as $group_1_data){?>
                            <div class="slide-trigger">
                                <div class="catalog-link">
                                    <div class="panel-heading collapsed">
                                        <h4 class="panel-title">
                                            <?=$group_1_data['name'];?> <span class="glyphicon glyphicon-chevron-right pull-right"></span>
                                        </h4>
                                    </div>
                                </div>
                                <div class="panel-collapse collapse slidepnl">
                                    <ul class="list-group">
                                        <?foreach(Model::factory('Notice')->getNotice(['category_id' => $group_1_data['id']]) as $product_1_data){?>
                                            <li class="list-group-item"><div class="list-product-item" onclick="javascript: $('#add_hit > #addhit').val(<?=$product_1_data['id'];?>);$('#add_hit').submit();"> <?=$product_1_data['name'];?> (<?=$product_1_data['price'];?> руб.)</div></li>
                                        <?}?>
                                    </ul>
                                </div>
                            </div>
                        <?}?>
                    </div>
                </div>
                <input type="hidden" id="searchModalRow" value="-1">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>