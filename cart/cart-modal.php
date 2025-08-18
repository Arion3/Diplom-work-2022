<div class="modal-body">
    <?php if (!empty($_SESSION['cart'])): ?>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Изображение</th>
                <th scope="col">Наименование</th>
                <th scope="col">Цена</th>
                <th scope="col">Количество</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                <tr>
                    <td><a href="#"><img src="../img/tovary/<?= $item['img'] ?>" width="180" alt="<?= $item['name'] ?>"></a></td>
                    <td><a href="#"><?= $item['name'] ?></a></td>
                    <td><?= $item['price'] ?></td>
                    <td><?= $item['qty'] ?></td>
                </tr>
            <?php endforeach; ?>

            <tr>
                <td colspan="4" align="right">Товаров: <span id="modal-cart-qty"><?= $_SESSION['cart.qty'] ?></span>
                    <br> Сумма: <?= $_SESSION['cart.sum'] ?> р.
                </td>
            </tr>
            </tbody>
        </table>
    <?php else: ?>
        <p>Корзина пуста...</p>
    <?php endif; ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" onClick="window.location.reload( true )" data-dismiss="modal">Закрыть</button>
    <?php if (!empty($_SESSION['cart'])): ?>
        <a href="../catalog/zakaz.php"><button type="button" class="btn btn-primary" >Оформить заказ</button></a>
        <button type="button" class="btn btn-danger" id="clear-cart">Очистить корзину</button>
    <?php endif; ?>
</div>
