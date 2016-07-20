<!-- Begin page content -->
<div class="container">
    <div class="row afterf">
        <div class="col-md-1 col-xs-1 col-sm-1"></div>
        <div class="col-sm-10 col-xs-10 col-sm-10">
            <button class="btn btn-default" data-toggle="modal" data-target="#reviewModal">Оставить отзыв</button>
            <div class="row">
                <?
                $i = 1;
                foreach ($reviewsData as $review) {
                    $ch = $i % 2;
                    ?>
                <?=($ch == 1 ? '</div><div class="row">' : '');?>
                <div class="col-md-6 col-xs-12 col-sm-6 review">
                    <div class="review-desc">
                        <h3><?=$review['author'];?></h3>
                        <span class="review-city">
                        <?=$review['city'];?>
                        </span>
                        <div class="review-quote">“</div>
                        <div class="review-quote-text">
                            <?=$review['content'];?>
                        </div>
                    </div>
                </div>
                    <?
                    $i++;
                }
                ?>
            </div>
        </div>
        <div class="col-md-1 col-xs-1 col-sm-1"></div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p class="review-form">
                    <label for="author">Имя</label><br />
                    <input class="form-control" id="author" type="text" aria-required='true' />
                </p>
                <p class="review-form">
                    <label for="city">Город</label><br />
                    <input class="form-control" id="city" type="text" aria-required='true' />
                </p>
                <p class="review-form">
                    <label for="review">Отзыв</label><br />
                    <textarea class="form-control" id="review" aria-required="true"  cols="50" rows="5"></textarea>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" id="sendReview">Отправить</button>
            </div>
        </div>
    </div>
</div>