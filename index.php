<?php include("includes/header.php");?>
<?php
    include("includes/classes/Item.php");
    include("includes/classes/Constants.php");?>
<head>
  <title>Home</title>
</head>
<section class="carousel slide cid-rilrHid3MC" data-interval="false" id="slider1-3">
    <div class="full-screen">
        <div class="mbr-slider slide carousel" data-pause="true" data-keyboard="false" data-ride="carousel" data-interval="3000">
            <ol class="carousel-indicators">
                <li data-app-prevent-settings="" data-target="#slider1-3" data-slide-to="0"></li>
                <li data-app-prevent-settings="" data-target="#slider1-3" data-slide-to="1"></li>
                <li data-app-prevent-settings="" data-target="#slider1-3" data-slide-to="2"></li>
                <li data-app-prevent-settings="" data-target="#slider1-3" class=" active" data-slide-to="3"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item slider-fullscreen-image" data-bg-video-slide="false" style="background-image: url(assets/images/mbr-1920x1080.jpg);">
                <div class="container container-slide">
                    <div class="image_wrapper">
                        <div class="mbr-overlay"></div>
                        <div class="carousel-caption justify-content-center">
                            <div class="col-10 align-center">
                                <h2 class="mbr-fonts-style display-1">Men's Shoes</h2>
                                <div class="mbr-section-btn" buttons="0">
                                    <a class="btn display-4 btn-black" href="clothing.php?type=shoes&s=men">SHOES FOR MEN</a> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item slider-fullscreen-image" data-bg-video-slide="false" style="background-image: url(assets/images/womens-shoes.jpg);">
                <div class="container container-slide">
                    <div class="image_wrapper">
                        <div class="mbr-overlay"></div>
                        <div class="carousel-caption justify-content-center">
                            <div class="col-10 align-center">
                                <h2 class="mbr-fonts-style display-1"> Women's Shoes</h2>
                                <div class="mbr-section-btn" buttons="0">
                                    <a class="btn display-4 btn-black" href="clothing.php?type=shoes&s=women">SHOES FOR WOMEN</a> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item slider-fullscreen-image" data-bg-video-slide="false" style="background-image: url(assets/images/mbr-1920x1271.jpg);">
                <div class="container container-slide">
                    <div class="image_wrapper">
                        <div class="mbr-overlay"></div>
                        <div class="carousel-caption justify-content-center">
                            <div class="col-10 align-center">
                                <h2 class="mbr-fonts-style display-1">Shop for Men</h2>
                                <div class="mbr-section-btn" buttons="0">
                                    <a class="btn display-4 btn-black" href="clothing.php?type=clothing&s=men">SHOP FOR MEN</a> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item slider-fullscreen-image active" data-bg-video-slide="false" style="background-image: url(assets/images/mbr-2-1920x1440.jpg);">
                <div class="container container-slide">
                    <div class="image_wrapper">
                        <div class="mbr-overlay"></div>
                        <div class="carousel-caption justify-content-center">
                            <div class="col-10 align-center">
                                <h2 class="mbr-fonts-style display-1">Shop for Women</h2>
                                <div class="mbr-section-btn" buttons="0">
                                    <a class="btn display-4 btn-black" href="clothing.php?type=clothing&s=women">SHOP FOR WOMEN</a> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <a data-app-prevent-settings="" class="carousel-control carousel-control-prev" role="button" data-slide="prev" href="#slider1-3">
        <span aria-hidden="true" class="mbri-left mbr-iconfont"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a data-app-prevent-settings="" class="carousel-control carousel-control-next" role="button" data-slide="next" href="#slider1-3">
        <span aria-hidden="true" class="mbri-right mbr-iconfont"></span>
        <span class="sr-only">Next</span>
    </a>
    </div>
</div>
</section>

<section class="mbr-section content4 cid-riDo1i5eiF" id="content4-y" style="padding-top: 32px; background-color: #fff !important;">
    <div class="container">
        <div class="media-container-row">
            <div class="title col-12 col-md-8">
                <h2 class="align-center pb-3 mbr-fonts-style display-2">
                    Our Latest Products</h2>
            </div>
        </div>
    </div>
</section>

<section class="items-container cid-riDn13Ln0F" id="services1-x">
    <div class="container">
        <div class="row justify-content-center">
            <?php
                $queryString = "SELECT id FROM items ORDER BY timeAdded DESC LIMIT 8";
                $itemQuery = mysqli_query($sqlConnection, $queryString);

                while($row = mysqli_fetch_array($itemQuery)){
                    $id = $row['id'];
                    $item = new Item($sqlConnection, $id);
                    $title = $item->getName();
                    $itemBrand = $item->getBrand();
                    $description = $item->getDescription();
                    $itemPrice = $item->getPrice();
                    $image = json_decode($item->getImagesJSON(), true)[0];
                    echo "
                    <div class='item-card col-12 col-md-4 col-lg-2 col-sm-4'>
                        <div class='card-wrapper'>
                            <a  href='item.php?id=$id'>
                                <div class='card-img'>
                                    <img src='$image' alt='$title'>
                                </div>
                            </a>
                            <div class='card-box pb-md-5'>
                                <h4 class='item-card-title mbr-fonts-style display-7'>
                                    $itemBrand
                                </h4>
                                <span class='item-card-text mbr-text mbr-fonts-style display-7'>
                                    $title
                                </span>
                                <div class='mbr-section-btn align-center' >
                                    <a href='item.php?id=$id' class='btn btn-warning-outline display-4'>
                                        R $itemPrice
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>";
                }
            ?>
        </div>
    </div>
</section>


<!--<section class="cid-rilxrY0od0" id="content15-6">
    <div class="container">
            <div class="media-container-row">
                
            <div class="img-item col-sm-6 col-lg-3 item1">
                    <a href="clothing.php?type=men&category=clothes">
                        <div class="img-cont">
                            <div class="img-overlay"></div>
                            <img src="assets/images/background9.jpg">
                            <div class="img-caption">
                                <p class="mbr-fonts-style align-left mbr-white display-5">
                                    Clothing for Men</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="img-item col-sm-6 col-lg-3 item1">
                    <a href="clothing.php?type=men&category=shoes">
                        <div class="img-cont">
                            <div class="img-overlay"></div>
                            <img src="assets/images/focus-footwear.jpg">
                            <div class="img-caption">
                                <p class="mbr-fonts-style align-left mbr-white display-5">
                                    Shoes for Men</p>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="img-item col-sm-6 col-lg-3 item1">
                    <a href="clothing.php?type=women&category=clothes">
                        <div class="img-cont">
                            <div class="img-overlay"></div>
                            <img src="assets/images/background9.jpg">
                            <div class="img-caption">
                                <p class="mbr-fonts-style align-left mbr-white display-5">
                                    Clothes for Women</p>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="img-item col-sm-6 col-lg-3 item1">
                    <a href="clothing.php?type=women&category=shoes">
                        <div class="img-cont">
                            <div class="img-overlay" style=""></div>
                            <img src="assets/images/adult-ankle-boots.jpg">
                            <div class="img-caption">
                                <p class="mbr-fonts-style align-left mbr-white display-5">
                                    Shoes for Women</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
    </div>
</section>-->

<section class="mbr-section article content9 cid-rilyHW2XhU" id="content9-9">
    <div class="container">
        <div class="inner-container" style="width: 100%;">
            <hr class="line" style="width: 25%;">
            <div class="section-text align-center mbr-fonts-style display-5">
                    We provide you with the latest in fashion trends. We offer a variety of clothes, shoes and accessories to match anyone's personal style.</div>
            <hr class="line" style="width: 25%;">
        </div>
        </div>
</section>

<section class="cid-rilC2gbIh8" id="social-buttons3-g">
    <div class="container">
        <div class="media-container-row">
            <div class="col-md-8 align-center">
                <h2 class="pb-3 mbr-section-title mbr-fonts-style display-2">
                    SHARE THIS PAGE!
                </h2>
                <div>
                    <div class="mbr-social-likes">
                        <a href="https://www.facebook.com" target="_blank" class="btn btn-social socicon-bg-facebook facebook mx-2" title="Share link on Facebook">
                            <i class="socicon socicon-facebook"></i>
                        </a>
                        <a href="https://www.twitter.com" target="_blank" class="btn btn-social twitter socicon-bg-twitter mx-2" title="Share link on Twitter">
                            <i class="socicon socicon-twitter"></i>
                        </a>
                        <a href="https://www.instagram.com" target="_blank" class="btn btn-social instagram socicon-bg-facebook mx-2" title="Share link on Instagram">
                            <i class="socicon socicon-instagram"></i>
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include("includes/footer.php");?>