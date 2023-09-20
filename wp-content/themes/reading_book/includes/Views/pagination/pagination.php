<?php

add_action('pagination', 'Pagination', 10, 1);
function Pagination($idCategory = null)
{
    global $pagination_limit, $pagination_page;
    include_once THEME_DIR . '/includes/Model/sanPhamModel.php';
    include_once THEME_DIR . '/includes/Model/theLoaiModel.php';
    $sanpham = new sanPhamModel(0, '', '', '', '', '', '', '',$idCategory,'','');
    //var_dump($sanpham);
   
    // Hiển thị tất cả sản phẩm
    if ($idCategory == null) {
        $page = !empty($_GET['page']) ? $_GET['page'] : $pagination_page;
        $dataSanPham = $sanpham->getAll();
        $totalRecords = count($dataSanPham);
        $totalPage = ceil($totalRecords / $pagination_limit);
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
                                <a href="?page=<?php echo $firts_page ?>">
                                    <?php echo $firts_page ?>
                                </a>
                            </li>
                            <li>...</li>

                            <?php

                        }
                        // tại nút chuyển trang
                        for ($i = 1; $i <= $totalPage; $i++) {
                            if ($i != $page) {
                                // hiển thị các nút liền kề
                                if ($i > $page - 4 && $i < $page + 4) {
                            ?>
                                    <li>
                                        <a href="?page=<?php echo $i ?>">
                                            <?php echo $i ?>
                                        </a>
                                    </li>
                                <?php
                                }
                            } else {
                                ?>
                                <li class="active">
                                    <a href="?page=<?php echo $i ?>">
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
                                <a href="?page=<?php echo $end_page ?>">
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
    // Hiển thị các sản phẩm thuộc $idCategory
    else {
        $page = !empty($_GET['page_category']) ? $_GET['page_category'] : $pagination_page;
        $dataSanPham = $sanpham->getDatabyIDCategory();
        $totalRecords = count($dataSanPham);
        $totalPage = ceil($totalRecords / $pagination_limit);
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
                                <a href="<?php echo "?page_category=" .$firts_page ."&id=" . $idCategory  ?>">
                                    <?php echo $firts_page ?>
                                </a>
                            </li>
                            <li>...</li>
                            <?php


                        }

                        // Tạo các nút chuyển trang
                        for ($i = 1; $i <= $totalPage; $i++) {
                            if ($i != $page) {
                                // hiển thị 3 nút liền kề
                                if ($i > $page - 4 && $i < $page + 4) {
                            ?>
                                    <li>
                                        <a href="<?php echo '?page_category=' .$i .'&id=' . $idCategory  ?>">
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
                                    <a href="<?php echo "?page_category=" .$i."&id=" . $idCategory ?>">
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
                                <a href="<?php echo '?page_category='.$end_page .'&id=' . $idCategory ?>">
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
}
