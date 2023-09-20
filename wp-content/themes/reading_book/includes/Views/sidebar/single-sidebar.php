<?php
add_action('single_sidebar', 'single_sidebar', 10, 2);
function single_sidebar($maTheLoai, $tenTheLoai)
{
    global $hosting;
    include_once THEME_DIR . '/includes/Model/sanPhamModel.php';
    include_once THEME_DIR . '/includes/Model/theLoaiModel.php';
    include_once THEME_DIR . '/includes/Model/danhGiaSanPhamModel.php';
    $sanpham = new sanPhamModel(0, '', '', '', '', '', '', '', $maTheLoai, '', '');
    $dataSanPham = $sanpham->getDatabyIDCategory();
    for ($i = 0; $i < 5; $i++) {
        # code...

        if ($dataSanPham[$i] != null) {
            //html
?>
            <div class="product-desc border-bottom">
                <div class="size-wrap">
                    <div class="block-26 mb-2 pt-2">
                        <img style="width: 100px;height: 100px;" src="<?php echo PLUGIN_QUANLYSACH_IMG . '/' . $tenTheLoai . '/' . $dataSanPham[$i]->anhDaiDien ?>" class="img-fluid" alt="Free html5 bootstrap 4 template">

                    </div>
                    <a href="<?php echo $hosting ?>/single-page/?id=<?php echo  $dataSanPham[$i]->maSanPham ?>"><?php echo  $dataSanPham[$i]->tenSanPham ?></a>
                    <p>Rating:
                        <span>
                            <?php
                            $danhGia = new danhGiaSanPhamModel(0, "", "", "", "",  $dataSanPham[$i]->maSanPham, "", "");
                            $average = $danhGia->calculate_average(); // lấy trung bình điểm đánh giá
                            $commentOfProduct = $danhGia->getDatabyIDProduct();
                            for ($rating = 1; $rating <= 5; $rating++) {
                                if ($rating <= $average) {
                                    $color = '#ffcc00';
                                    $class = 'icon-star-full';
                                } else if ($rating > $average && $average > $rating - 1) {
                                    $color = '';
                                    $class = 'icon-star-half';
                                } else {
                                    $color = 'color: #ccc;';
                                    $class = 'icon-star-full';
                                }
                            ?>
                                <a href="#">
                                    <i style="color:  <?php echo $color ?>;" class="<?php echo $class ?>"></i>
                                </a>
                            <?php
                            }
                            ?>
                            (<?php echo count($commentOfProduct) ?> Rating)
                        </span>

                    </p>
                    <p>Thể loại:
                        <span style="color: blue;">
                            <?php
                            $theloai = new theLoaiModel($maTheLoai, "");
                            $dataTheLoai = $theloai->getDatabyID();
                            echo $dataTheLoai[0]->tenTheLoai;
                            ?>
                        </span>
                    </p>
                </div>
            </div>

<?php
            //end html
        }
    }
}
