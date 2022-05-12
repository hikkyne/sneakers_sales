<?php
require_once '../admin/db.php';
?>

<?php

session_start();
$id = $_POST['id'];
if (empty($_SESSION['cart'][$id])) {
    $query = "SELECT product.*, product_img.img AS image FROM product
     INNER JOIN product_img ON product.id = product_img.product_id WHERE product.id = $id LIMIT 1";

    $result = get_list($query);
    $_SESSION['cart'][$id]['id'] = $id;
    $_SESSION['cart'][$id]['quantity'] = 1;
    $_SESSION['cart'][$id]['image'] = $result[0]['image'];
    $_SESSION['cart'][$id]['name'] = $result[0]['name'];
    $_SESSION['cart'][$id]['cost'] = $result[0]['cost'];
    $_SESSION['cart'][$id]['sale'] = $result[0]['sale'];
} else {
    $_SESSION['cart'][$id]['quantity']++;
}

?>
<div class="site-cart">
    <div class="cart-view">
        <table id="cart-view">
            <?php
            if (isset($_SESSION['cart'])) {
                $cart = $_SESSION['cart'];
                foreach ($cart as $value) {

            ?>
                    <tr class="item_2 " >
                        <td class="img" style="width:120px" >
                            <a href="/products/quan-gau-swag-tokago-new-2022">
                                <img style="width:110px" src="../admin/photos/<?= $value['image'] ?>" alt="dsd">
                            </a>
                        </td>
                       
                        <td>
                            <p class="pro-title">
                                <a class="pro-title-view" href="">SP: <?= $value['name'] ?></a>
                                <br>
                                <span class="variant">
                                   Size: 43
                                </span>
                            </p>
                            <div class="mini-cart_quantity">
                                <div class="pro-quantity-view">
                                    <span class="qty-value">Số lượng: <?= $value['quantity'] ?></span>
                                </div>
                                <div class="pro-price-view">Giá :<?= number_format($value['cost'] *(1-(int)$value['sale']/100), 0, '', ','); ?>₫</div>
                            </div>
                        </td>
                        <td class="">X</td>
                    </tr>
            <?php }
            } else {
            }

            ?>
        </table>
    </div>

</div>