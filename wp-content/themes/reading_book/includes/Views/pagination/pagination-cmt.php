<?php
add_action('pagination_cmt', 'pagination_cmt', 10, 1);
function pagination_cmt()
{
    include_once THEME_DIR . '/includes/Model/danhGiaSanPhamModel.php';
    include_once THEME_DIR . '/includes/Model/khachHangModel.php';
    global $pagination_page, $pagination_limit;
    $thisCustomer = $_SESSION['isLogin'];
    $maKH = $thisCustomer[0];

    $cmt =$_SESSION['datacmtOfPro'];
    $page = !empty($_GET['c_page']) ? $_GET['c_page'] : $pagination_page;

    $totalRecords = count($cmt);
    $totalPages = ceil($totalRecords / $pagination_limit);
    $offset = ($page - 1) * $pagination_limit;
    $currentPageCmt = array_slice($cmt, $offset, $pagination_limit);
    //var_dump($cmt);
    $danhGia = new danhGiaSanPhamModel(0, "", "", "", "", $cmt[0]->maSanPham, $maKH, "");
    // var_dump($currentPageCmt);
    // exit;
    foreach ($currentPageCmt as $currentCmt) {
        if ($currentCmt->maKH == $maKH)  continue;
        $khachhang = new khachHangModel($currentCmt->maKH, "", "", "", "", "", "", "", "", "", "", "", "", "", "");
        $allCmtCustomer = $khachhang->getDataByID();
        // lấy ngày bình luận của khách hàng trong bảng danhgiasanpham
        $dateCmt = $danhGia->getDataByIdCustomer($currentCmt->maKH);
        if ($currentCmt->trangThai == '0') continue;
?>

        <div class="review">
            <div class="user-img" style="background-image: url(<?php echo THEME_URL . '/images/icon.jpg' ?>); width: 50px;height: 50px;"></div>
            <div class="desc">
                <h4>
                    <span style="color: blue;" class="text-left"><?php echo $allCmtCustomer[0]->tenDangNhap ?></span>
                    <span class="text-right"><?php echo $dateCmt[0]->ngaybl ?></span>
                </h4>
                <h4>
                    <?php
                    for ($i = 0; $i < 5; $i++) {
                        if ($dateCmt[0]->diemDanhGia == 0) {
                            echo '<p style="font-family: Arial, sans-serif;font-size: 14px;text-transform: lowercase;">unknown</p>';
                            break;
                        }
                        if ($i < $dateCmt[0]->diemDanhGia) {
                            echo '<i style="color: #ffcc00;font-size: 15px;" class="icon-star-full"></i>';
                        } else {
                            echo '<i style="font-size: 15px;" class="icon-star-full"></i>';
                        }
                    }
                    ?>

                </h4>
                <h4>
                    <span class="text-left">
                        <p style="font-family: Arial, sans-serif;font-size: 14px;text-transform: lowercase;"><?php echo $currentCmt->noiDung ?></p>
                    </span>
                    <?php
                    // hiển thị nút sửa cho người dùng đang đăng nhập
                    if ($currentCmt->maKH == $maKH) {
                    ?>
                        <span class="text-right"> <i style="color: #008000;" class="icon-edit"></i> <i style="color:red" class="icon-trash"></i></span>
                    <?php
                    }
                    ?>
                </h4>

            </div>
        </div>

    <?php
    }

    for ($i = 0; $i < count($cmt); $i++) {
    }
    //html
    ?>
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="block-27">
                <ul>
                    <!-- Tạo nút trở về đầu trang -->
                    <?php
                    if ($page > 4) {
                        $firts_page = 1;

                    ?>
                        <li>
                            <a href="<?php echo "?c_page=" . $firts_page  . "&id=" . $cmt[0]->maSanPham ?>">
                                <?php echo $firts_page ?>
                            </a>
                        </li>
                        <li>...</li>
                        <?php


                    }

                    // Tạo các nút chuyển trang
                    for ($i = 1; $i <= $totalPages; $i++) {
                        if ($i != $page) {
                            // hiển thị 3 nút liền kề
                            if ($i > $page - 4 && $i < $page + 4) {
                        ?>
                                <li>
                                    <a href="<?php echo '?c_page=' . $i  . "&id=" . $cmt[0]->maSanPham ?>">
                                        <?php echo $i ?>
                                    </a>
                                </li>
                            <?php
                            }
                        }
                        // 
                        else {
                            ?>
                            <li class="active">
                                <a href="<?php echo "?c_page=" . $i . "&id=" . $cmt[0]->maSanPham ?>">
                                    <?php echo $i ?>
                                </a>
                            </li>
                        <?php
                        }
                    }
                    // tạo nút đến cuối trang
                    if ($page < $totalPage - 4) {
                        $end_page = $totalPage;
                        ?>
                        <li>...</li>
                        <li>
                            <a href="<?php echo '?c_page=' . $end_page . "&id=" . $cmt[0]->maSanPham ?>">
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
