<?php
add_action('search_pagination', 'search_pagination');
function search_pagination()
{
    include_once THEME_DIR . '/includes/Model/sanPhamYeuThichModel.php';
    global  $pagination_limit, $pagination_offset, $hosting;
    $products = $_SESSION['search'];
    $limit = $pagination_limit;
    $totalProducts = count($products);
    $totalPages = ceil($totalProducts / $limit);
    $page = isset($_GET['s_page']) ? $_GET['s_page'] : 1;
    $offset = ($page - 1) * $limit;
    $currentPageProducts = array_slice($products, $offset, $pagination_limit);
    // Hiển thị sản phẩm trên trang hiện tại
?>
    <div class="col-lg-9 col-xl-9">
        <div class="row row-pb-md">
            <!-- -->
            <?php
            foreach ($currentPageProducts as $product) {
                // Hiển thị thông tin sản phẩm
            ?>
                <?php
                $theloai = new theLoaiModel($product->maTheLoai, '');
                // lấy tên thể loại
                $dataTheLoai = $theloai->getDatabyID();
                $tenTheLoai = $dataTheLoai[0]->tenTheLoai;
                //
                $yeuthich = new sanPhamYeuThichModel(0, "", $product->maSanPham, "");
                ?>
                <div class="col-lg-4 mb-4 text-center">
                    <div class="product-entry border">
                        <a href="<?php echo $hosting ?>single-page?id=<?php echo $product->maSanPham ?>" class="prod-img">
                            <div id="review" class="review">
                                <p>
                                    <i class="ion-ios-eye"><?php echo $product->luotDoc ?></i>
                                </p>
                                <p><i class="icon-heart"> <?php echo ($yeuthich->countFavourire()[0]->luotThich) ?> </i></p>
                            </div>
                            <img style="width: 150px;" src="<?php echo PLUGIN_QUANLYSACH_IMG . '/' . $tenTheLoai . '/' . $product->anhDaiDien ?>" class="img-fluid" alt="err">
                        </a>
                        <div class="desc">
                            <h2 ><a href="<?php echo $hosting ?>wordpress/single-page?id=<?php echo $product->maSanPham ?>"><?php echo $product->tenSanPham ?></a></h2>
                        </div>

                    </div>
                </div>
                <?php
                ?>
            <?php
            }
            ?>
        </div>
        <!-- -->


        <!-- -->
        <?php
        // Hiển thị các link phân trang
        for ($i = 1; $i <= $totalPages; $i++) {
            //html
        ?>
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="block-27">
                        <ul>

                            <?php
                            // tạo nút trở về đầu trang
                            if ($page > 4) {
                                $firts_page = 1;
                            ?>
                                <li>
                                    <a href="?s_page=<?php echo $firts_page ?>">
                                        <?php echo $firts_page ?>
                                    </a>
                                </li>
                                <li>...</li>

                                <?php

                            }
                            // tại nút chuyển trang
                            for ($i = 1; $i <= $totalPages; $i++) {
                                if ($i != $page) {
                                    // hiển thị các nút liền kề
                                    if ($i > $page - 4 && $i < $page + 4) {
                                ?>
                                        <li>
                                            <a href="?s_page=<?php echo $i ?>">
                                                <?php echo $i ?>
                                            </a>
                                        </li>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <li class="active">
                                        <a href="?s_page=<?php echo $i ?>">
                                            <?php echo $i ?>
                                        </a>
                                    </li>
                                <?php
                                }
                            }
                            // tạo nút đến cuối trang
                            if ($page < $totalPages - 4) {
                                $end_page = $totalPages;
                                ?>
                                <li>...</li>
                                <li>
                                    <a href="?s_page=<?php echo $end_page ?>">
                                        <?php echo $end_page ?>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>


                        </ul>
                    </div>
                </div>
            </div>
        <?php
            //end html
        }
        ?>
        <!-- -->
    </div>
<?php
}
