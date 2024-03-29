<div class="modal fade details-8" id="details-8" tableindex="-1" role="dialog" aria-labelled="details-8" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center">Кроссовки Liu Jo</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="center-block">
                                <img src="images/Liu_Jo.jpg" class="details img-responsive">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <h4>Подробнее</h4>
                            <p>Эти кроссовки удивительные. Вы должны их купить. Купите их пока они есть.</p>
                            <hr>
                            <p>Цена: $5.99</p>
                            <p>Бренд: Liu Jo</p>
                            <form action="add_cart.php" method="post">
                                <div class="form-group">
                                    <div class="col-xs-3">
                                        <label for="quantity" id="quantity-label">Количество:</label>
                                        <input type="text" class="form-control" id="quantity" name="quantity">
                                    </div><br><br><br>
                                    <div class="form-group">
                                        <label for="size">Размер:</label>
                                        <select name="size" id="size" class="form-control">
                                            <option value=""></option>
                                            <option value="28">28</option>
                                            <option value="32">32</option>
                                            <option value="36">36</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button class="btn btn-warning" type="submit"><span class="glyphicon glyphicon-shopping-cart"></span> Добавить в корзину</button>
            </div>
        </div>
    </div>
</div>