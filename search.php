<?php include("includes/header.php");?>
<?php
    include("includes/classes/Constants.php");
    include("includes/classes/Account.php");
    include("includes/classes/Item.php");
    
    $account = new Account($sqlConnection);

    if(isset($_POST['search-button'])){
        $searchInput = $_POST['search-input'];
    
        if($searchInput != ""){
            header("Location: search.php?q=$searchInput");
        }
    }
    $searchTerm = null;
    if(isset($_GET['q'])){
        $searchTerm = $_GET['q'];
    }

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }
    $itemsPerPage = 20;
    $offset = ($page - 1) * $itemsPerPage;

    function getUrlPage($searchTerm, $page){
        $link = "search.php?q=$searchTerm";
        $link .= "&page=$page";
        return $link;
    }
?>
<head>
  <title>Search</title>
</head>
<section class="mbr-section form3" style="background-color: #fff;">
    <div class="container" style="padding: 32px;">
    <form action="search.php" method="POST">
        <div class="row justify-content-center">
            <input class="form-control search-input" type="text" name="search-input" placeholder="Search..." value="<?php if(isset($_GET['q'])) echo $_GET['q'];?>">
            </div>
            <div class="row justify-content-center">
                    <button class="btn btn-sm btn-black display-4" name="search-button" type="submit">
                        <span class="mbrib-search mbr-iconfont mbr-iconfont-btn"></span>Search
                    </button>
            </div>
        </div>
    </form>
</section>
<section class="items-container cid-riDn13Ln0F" id="services1-x">
    <div class="container">
        <div class="row justify-content-center">
            <?php
            $searchResultCount = 0;
            if(!empty($searchTerm)){
                $queryString = "SELECT COUNT(*) FROM items WHERE brand LIKE '%$searchTerm%' OR name LIKE '%$searchTerm%'";
                $query = mysqli_query($sqlConnection, $queryString);

                $total_rows = mysqli_fetch_array($query)[0];
                $total_pages = ceil($total_rows/$itemsPerPage);

                $queryString = "SELECT id FROM items WHERE brand LIKE '%$searchTerm%' OR name LIKE '%$searchTerm%'";
                
                $queryString .= " LIMIT $offset, $itemsPerPage";
                $itemQuery = mysqli_query($sqlConnection, $queryString);

                $searchResultCount = mysqli_num_rows($itemQuery);
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
            }
            ?>
        </div>
    </div>
</section>
<section class="items-container cid-riDn13Ln0F" style="<?php if($searchResultCount == 0) echo "display:none;"?>">
    <div class="container">
        <div class="row justify-content-center">
                <div class="mbr-section-btn align-center col-sm" >
                    <a href="<?php
                        $prevPage = $page - 1;
                        echo getUrlPage($searchTerm, $prevPage);
                    ?>" class="btn btn-page transition-hover display-4" style="<?php if($page == 1) echo "display:none;"?>">
                        < Previous
                    </a>
                </div>
                <div class="mbr-section-btn align-center col-sm" >
                    <a href="<?php
                        $nextPage = $page + 1;
                        echo getUrlPage($searchTerm, $nextPage);
                    ?>" class="btn btn-page transition-hover display-4" style="<?php if($page == $total_pages) echo "display:none;"?>">
                        Next >
                    </a>
                </div>
        </div>
    </div>
</section>
<?php include("includes/footer.php");?>