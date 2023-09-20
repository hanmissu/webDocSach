<?php
add_action('wp_ajax_addFavourite', 'addFavourite'); // Xác thực yêu cầu Ajax cho người dùng đăng nhập
add_action('wp_ajax_nopriv_addFavourite', 'addFavourite'); // Xác thực yêu cầu Ajax cho người dùng không đăng nhập
add_action('getFavourite', 'getFavourite');
function addFavourite()
{
    include_once THEME_DIR . '/includes/Model/sanPhamYeuThichModel.php';
    $yeuthich = new sanPhamYeuThichModel(0, "", sanitize_text_field($_POST['product_id']), sanitize_text_field($_POST['idCustomer']));
    if ($yeuthich->favourite_exists() == null && $yeuthich->insert() == true) {
        echo '<i id="icon_heart" style="color:red" class="icon-heart"></i>';
        exit;
    } else if ($yeuthich->favourite_exists() != null && $yeuthich->deleteByCustomerAndProc() == true) {
        echo '<i id="icon_heart" class="icon-heart"></i>';
        exit;
    } else {
        echo 'false';
    }
}

function getFavourite()
{
    include_once THEME_DIR . '/includes/Model/theLoaiModel.php';
    include_once THEME_DIR . '/includes/Model/sanPhamModel.php';
    include_once THEME_DIR . '/includes/Model/sanPhamYeuThichModel.php';
    $yeuthich = new sanPhamYeuThichModel(0, "", "", $_SESSION['isLogin'][0]);
    $data = $yeuthich->getFavourite();
    // var_dump($yeuthich, $_SESSION['isLogin'], $data);
    // var_dump($dataSanPham, $page);
    for ($i = 0; $i < count($data); $i++) {
        $sanpham = new sanPhamModel($data[$i]->maSanPham, '', '', '', '', '', '', '', '', '','');
        $dataSanPham = $sanpham->getDatabyID();
        $theloai = new theLoaiModel($dataSanPham[0]->maTheLoai, '');
        // lấy tên thể loại
        $dataTheLoai = $theloai->getDatabyID();
        $tenTheLoai = $dataTheLoai[0]->tenTheLoai;
?>
        <div class="col-lg-4 mb-4 text-center">
            <div class="product-entry border">
                <a href="<?php echo $hosting ?>single-page?id=<?php echo $dataSanPham[0]->maSanPham ?>" class="prod-img">
                    <img style="width: 150px;" src="<?php echo PLUGIN_QUANLYSACH_IMG . '/' . $tenTheLoai . '/' . $dataSanPham[0]->anhDaiDien ?>" class="img-fluid" alt="err">
                </a>
                <div class="desc">
                    <h2><a href="<?php echo $hosting ?>wordpress/single-page?id=<?php echo $dataSanPham[0]->maSanPham ?>"><?php echo $dataSanPham[0]->tenSanPham ?></a></h2>

                </div>
            </div>
        </div>

<?php
    }
    exit;
}
