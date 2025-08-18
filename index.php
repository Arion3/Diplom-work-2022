<?php
session_start();
include ("cart/pdo.php");
include ("cart/funcs.php");
$products = get_products_13();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Lada details</title>
  <!-- MDB icon -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Material Design Bootstrap -->
  <link rel="stylesheet" href="css/mdb.min.css">
  <!-- Your custom styles (optional) -->
  <link rel="stylesheet" href="css/style.css">
  <link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
  rel="stylesheet"
/>
<!-- Google Fonts -->
<link
  href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
  rel="stylesheet"
/>
<!-- MDB -->
<link
  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css"
  rel="stylesheet"
/>
</head>
<body>

  <!-- Start your project here-->
     <nav class="navbar navbar-expand-lg navbar-light  white-text scrolling-navbar">
      <div class="container">
        <a href="../index.php" class="navbar-brand">
        <img src="..\img\logo.png" width="60" height="60" alt="logo">
          <h1 class="black-text left">Lada details</h1>
        </a>
          </div> 
        </nav>
        <?php
        error_reporting(0);
	if (($_SESSION['login']) == "admin")
	{
		?>
		    <nav class="navbar navbar-expand-lg navbar-dark unique-color-dark scrolling-navbar">
      <div class="container ">
        <a href="..\catalog.php" class="navbar-brand waves-effect">
         <h2 class="navbar-light">Админ панель</h2>
         </a>
<?php
	}

 ?>          
    <nav class="navbar navbar-expand-lg navbar-dark unique-color-dark scrolling-navbar">
      <div class="container ">
        <a href="..\catalog.php" class="navbar-brand waves-effect">
         <h2 class="navbar-light">Каталог</h2>
         </a>
         <div class="collapse navbar-collapse">
         </div>
              <form method ="post" class="search-form">
                <input type="text" name="search" class="search" placeholder="Искать">
                <button type="submit" name="submit" value="поиск">
                  <i class="fa fa-search"></i>
                </button>
              
              
              </form><!-- Search form -->

          <ul class="navbar-nav nav-flex-icons">
             <form class="form-inline my-2 my-lg-0">
          </form>
             <li class="nav-item">
              <a href="#" class="nav-link waves-effect">
              <i class="fa fa-shopping-cart"></i>
                <span class="text clearfix d-none d-sm-inline-block mr-1" id="get-cart" type="button" data-toggle="modal" data-target="#cart-modal">
                    Корзина <span class="badge badge-light"><?= $_SESSION['cart.qty'] ?? 0 ?></span>
                </span>
              </a>
            </li>

            
            <?php
if (empty(($_SESSION['login'])))
{
?>
             <li class="nav-item">
              <a href="../php/login in.php" class="nav-link waves-effect">
                <span class="text clearfix d-none d-sm-inline-block mr-1" data-toggle="modal" data-target="#exampleModal">Войти</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="../php/registr.php" class="nav-link waves-effect">
                <span class="text clearfix d-none d-sm-inline-block mr-1" >Зарегистрироваться</span>
              </a>
            </li>
                 </ul>
        </div>
      </div>
    </nav>

            <?php
}
else{
?>
            <li class="nav-item">
              <a href="../php/logout.php" class="nav-link waves-effect">
                <span class="text clearfix d-none d-sm-inline-block mr-1" data-toggle="modal" data-target="#exampleModal">Выйти</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <?php
}
?>
<div class="container mt">
    <div class="container">
      <div class="row-cols-md-2">
          
<?php
              include ("php/dbconnect.php");
              if(isset($_POST['submit'])){
              	 if(empty($_POST['search'])){
              	 	
              		echo 'Задан пустой поисковый запрос.';
              	}
              	else{
                $search = explode(" ", $_POST['search']);
                $count = count($search);
                $array = array();
                $i = 0;
                foreach ($search as $key) {
                $i++;
                  if($i < $count) $array[] = "CONCAT (`name`,`description`) LIKE '%".$key."%' OR "; else $array[] = "CONCAT (`name`,`description`) LIKE '%".$key."%'";
                }
                $sql = "SELECT * FROM `catalog` WHERE ".implode("", $array);
                $query = mysqli_query($mysqli, $sql);
                ?>
            
          
      <div class="card">
        <div class="card-body">
          <div class="align-items-center">
        <?php
        $num = mysqli_num_rows($query);
        $row = mysqli_fetch_assoc($query);
        $text = '<p>По запросу <b>'.$_POST['search'].'</b> найдено совпадений: '.$num.'</p>';
                if(empty($row)){
              	echo '<p>По запросу <b>'.$_POST['search'].'</b> ничего не найдено!</p>';
                } 
                else{
                echo $text;
                do{
                	echo "<h3><img src='img/tovary/".$row['img']."' class='img-fluid'>" .$row['name']."</h3><p>".$row['description']."<p>".$row['price']."</p><br> 
                <a href='?cart=add&id=".$row['id']."' float-right><span class='btn btn-info float-right  add-to-cart' onClick='window.location.reload( true )' data-id='".$row['id']."'><i class='fas fa-cart-arrow-down'></i> Купить</a>";
                }
                while ($row = mysqli_fetch_assoc($query));
                }
                
              }
          }

              ?>
              </div>
            </div>
         </div>
            </div>
          </div>
        </div>


<br>
<br>
    <div id="carousel" class="carousel slide carousel-fade d-inline-block" data-ride="carousel">
        <!-- Индикаторы -->
        <ol class="carousel-indicators">
            <li data-target="#carousel" data-slide-to="0" class="active"></li>
            <li data-target="#carousel" data-slide-to="1"></li>
            <li data-target="#carousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="img-fluid" src="..\img\slides\3.jpg" alt="...">
            </div>
            <div class="carousel-item">
                <img class="img-fluid" src="..\img\slides\2.jpg" alt="...">
            </div>
            <div class="carousel-item">
                <img class="img-fluid" src="..\img\slides\1.jpg" alt="...">
            </div>
        </div>
        <!-- Элементы управления -->
        <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>

            <span class="sr-only">Предыдущий</span>
        </a>
        <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Следующий</span>
        </a>
    </div>

<div class="container mt-5">

  
  <!--Section: Content-->
  <section class="dark-grey-text text-center">
    
    <!-- Section heading -->
    <h3 class="font-weight-bold mb-4 pb-2">Специальное предложение</h3>
    <!-- Section description -->
  

    <div class="container">
  <div class="row row-cols-2 row-cols-md-4 g-4">
    <?php if (!empty($products)): ?>
      <?php foreach ($products as $product): ?>
      <div class="card">
        <div class="card-body">
          <div class="row align-items-center">
                  <a> <img src="\img\tovary\<?= $product['img'] ?>" height="180" width="180" alt="<?= $product['name'] ?>"></a>
                  <?= $product['description'] ?>
                <br>
                <br>
                <h6 class="h6-responsive font-weight-bold dark-grey-text">
                  <strong><?= $product['price'] ?>р</strong>
                </h6>
              
              <a href="?cart=add&id=<?= $product['id'] ?> float-right"> <span class="btn btn-info float-right  add-to-cart" onClick="window.location.reload( true )"   data-id="<?= $product['id'] ?>"> 
                                    <i class="fas fa-cart-arrow-down"></i> Купить
                                </a>
                              </span>
                                <div class="item-status"><i class="fas fa-check text-success"></i> В наличии</div> 
            
        </div>
      </div>
    </div>

      <?php endforeach; ?>
    <?php endif; ?>

</div>
</div>

  </section>
  <!--Section: Content-->
  <br>
</div>
<div class="modal fade cart-modal" id="cart-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Корзина</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-cart-content">

            </div>

        </div>
    </div>
</div>




<!-- Footer -->
<footer class="page-footer font-small  unique-color-dark pt-4">
  <!-- Footer Elements -->
      

  <!-- Footer Links -->
  <div class="container text-center text-md-left mt-5">

    <!-- Grid row -->
    <div class="row mt-3">

      <!-- Grid column -->
      <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">

        <!-- Content -->
        <h6 class="text-uppercase font-weight-bold">LADA Details</h6>
        <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">

        <!-- Links -->
        <h6 class="text-uppercase font-weight-bold">Наши товары</h6>
        <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
        <p>
     <a href="catalog/filtry.php">Фильтры</a>
        </p>
        <p>
          <a href="catalog/tormoz.php">Тормозная система</a>
        </p>
        <p>
          <a href="catalog/ohlozh.php">Система охлаждения</a>
        </p>
        <p>
          <a href="catalog/elec.php">Электрооборудование</a>
        </p>


      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      

      <!-- Grid column -->
      <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">

        <!-- Links -->
        <h6 class="text-uppercase font-weight-bold">Контакты</h6>
        <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
        <p>
          <i class="fas fa-home mr-3"></i> Москвоская область, г. Лобня, Краснополянский проезд, д 2</p>
        <p>
          <i class="fas fa-envelope mr-3"></i> devyatka@example.com</p>
        <p>
          <i class="fas fa-phone mr-3"></i> +7 800 550 35 50</p>
      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

  </div>
  <!-- Footer Elements -->

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© 2022 Copyright:
    <a href="https://mdbootstrap.com/"> LADA Details</a>
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->

     
  <!-- End your project here-->



  <!-- jQuery -->
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="js/mdb.min.js"></script>
  <!-- Your custom scripts (optional) -->
  <script type="text/javascript"></script>
  <script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"
></script>
<script src="js/main.js"></script>
</body>

</html>

