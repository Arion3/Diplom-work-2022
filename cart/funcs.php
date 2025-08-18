<?php

function debug(array $data): void
{
    echo '<pre>' . print_r($data, 1) . '</pre>';
}

function get_products_1(): array
{
    global $pdo;
    $res = $pdo->query("SELECT * FROM catalog WHERE id >=1 AND id <=6");
    return $res->fetchAll();
}

function get_products_2(): array
{
    global $pdo;
    $res = $pdo->query("SELECT * FROM catalog WHERE id >=7 AND id <=12");
    return $res->fetchAll();
}
function get_products_3(): array
{
    global $pdo;
    $res = $pdo->query("SELECT * FROM catalog WHERE id >=13 AND id <=18");
    return $res->fetchAll();
}
function get_products_4(): array
{
    global $pdo;
    $res = $pdo->query("SELECT * FROM catalog WHERE id >=19 AND id <=24");
    return $res->fetchAll();
}
function get_products_5(): array
{
    global $pdo;
    $res = $pdo->query("SELECT * FROM catalog WHERE id >=25 AND id <=30");
    return $res->fetchAll();
}
function get_products_6(): array
{
    global $pdo;
    $res = $pdo->query("SELECT * FROM catalog WHERE id >=31 AND id <=36");
    return $res->fetchAll();
}
function get_products_7(): array
{
    global $pdo;
    $res = $pdo->query("SELECT * FROM catalog WHERE id >=37 AND id <=42");
    return $res->fetchAll();
}
function get_products_8(): array
{
    global $pdo;
    $res = $pdo->query("SELECT * FROM catalog WHERE id >=43 AND id <=48");
    return $res->fetchAll();
}
function get_products_9(): array
{
    global $pdo;
    $res = $pdo->query("SELECT * FROM catalog WHERE id >=49 AND id <=54");
    return $res->fetchAll();
}
function get_products_10(): array
{
    global $pdo;
    $res = $pdo->query("SELECT * FROM catalog WHERE id >=55 AND id <=60");
    return $res->fetchAll();
}
function get_products_11(): array
{
    global $pdo;
    $res = $pdo->query("SELECT * FROM catalog WHERE id >=61 AND id <=66");
    return $res->fetchAll();
}
function get_products_12(): array
{
    global $pdo;
    $res = $pdo->query("SELECT * FROM catalog WHERE id >=67 AND id <=72");
    return $res->fetchAll();
}

function get_products_13(): array
{
    global $pdo;
    $res = $pdo->query("SELECT * FROM catalog WHERE id >=73 AND id <=76");
    return $res->fetchAll();
}

function get_product(int $id): array
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM catalog WHERE id =?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function add_to_cart($product): void{
    if(isset($_SESSION['cart'][$product['id']])){
        $_SESSION['cart'][$product['id']]['qty'] +=1;
    }else{
        $_SESSION['cart'][$product['id']] = [
            'name' =>$product['name'],
            'description'=>$product['description'],
            'price'=>$product['price'],
            'qty'=>1,
            'img'=>$product['img'],
        ];
    }
    $_SESSION['cart.qty']=!empty($_SESSION['cart.qty']) ? ++$_SESSION['cart.qty'] : 1;
    $_SESSION['cart.sum']=!empty($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + $product['price'] : $product['price'];
}
