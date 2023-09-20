<?php
add_action('getAllProduct', 'getAllProduct', 10, 1);
function getAllProduct($idCategory = null)
{
    include_once THEME_DIR . '/includes/Model/theLoaiModel.php';
    include_once THEME_DIR . '/includes/Model/sanPhamModel.php';
    include_once THEME_DIR . '/includes/Model/sanPhamYeuThichModel.php';
    global $pagination_limit, $pagination_page, $hosting;
    $limit =  $pagination_limit;
    $sanpham = new sanPhamModel(0, '', '', '', '', '', '', '', $idCategory, '', '');
    if ($idCategory == null) {
        $page = isset($_GET['page']) ? $_GET['page'] : $pagination_page;
        $offset = ($page - 1) * $limit;
        $dataSanPham = $sanpham->getDataForPagination($limit, $offset);
    } else {
        $page = isset($_GET['page_category']) ? $_GET['page_category'] : $pagination_page;
        $offset = ($page - 1) * $limit;
        $dataSanPham = $sanpham->getProductsByCategory($limit, $offset);
    }
    // var_dump($dataSanPham, $page);
    for ($i = 0; $i < count($dataSanPham); $i++) {
        $theloai = new theLoaiModel($dataSanPham[$i]->maTheLoai, '');
        // lấy tên thể loại
        $dataTheLoai = $theloai->getDatabyID();
        $tenTheLoai = $dataTheLoai[0]->tenTheLoai;
        //
        $yeuthich = new sanPhamYeuThichModel(0, "", $dataSanPham[$i]->maSanPham, "");

?>
        <div class="col-lg-4 mb-4 text-center">
            <div class="product-entry border">
                <a href="<?php echo $hosting ?>single-page?id=<?php echo $dataSanPham[$i]->maSanPham ?>" class="prod-img">
                    <div id="review" class="review">
                        <p>
                            <i class="ion-ios-eye"><?php echo $dataSanPham[$i]->luotDoc ?></i>
                        </p>
                        <p><i class="icon-heart"> <?php echo ($yeuthich->countFavourire()[0]->luotThich) ?> </i></p>
                    </div>
                    <img style="width: 250px;height: 220px;" src="<?php echo PLUGIN_QUANLYSACH_IMG . '/' . $tenTheLoai . '/' . $dataSanPham[$i]->anhDaiDien ?>" class="img-fluid" alt="err">
                </a>
                <div class="desc">
                    <h2 ><a href="<?php echo $hosting ?>/single-page?id=<?php echo $dataSanPham[$i]->maSanPham ?>"><?php echo $dataSanPham[$i]->tenSanPham ?></a></h2>
                </div>

            </div>
        </div>

<?php
    }
}
