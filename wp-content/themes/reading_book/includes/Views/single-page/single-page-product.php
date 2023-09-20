<?php

add_action('product_detail', 'product_detail', 10, 1);
function product_detail($idProduct)
{
    global $hosting;
    include_once THEME_DIR . '/includes/Model/sanPhamYeuThichModel.php';
    include_once THEME_DIR . '/includes/Model/theLoaiModel.php';
    include_once THEME_DIR . '/includes/Model/NSXModel.php';
    include_once THEME_DIR . '/includes/Model/sanPhamModel.php';
    include_once THEME_DIR . '/includes/Model/danhGiaSanPhamModel.php';
    include_once THEME_DIR . '/includes/Model/khachHangModel.php';
    // khách hàng
    $thisCustomer = $_SESSION['isLogin'];
    $maKH = $thisCustomer[0];
    //sản phẩm
    $sanpham = new sanPhamModel($idProduct, '', '', '', '', '', '', '', '', '', '');
    $dataSanPham = $sanpham->getDatabyID();
    // lấy tên thể loại
    $theloai = new theLoaiModel($dataSanPham[0]->maTheLoai, '');
    $dataTheLoai = $theloai->getDatabyID();
    $tenTheLoai = $dataTheLoai[0]->tenTheLoai;
    // lấy tên nsx
    $nsx = new NSXModel($dataSanPham[0]->maNSX, '');
    $dataNSX = $nsx->getDatabyID();

    // đánh giá sp
    $danhGia = new danhGiaSanPhamModel(0, "", "", "", "", $idProduct, $maKH, 0);
    $average = $danhGia->calculate_average(); // lấy trung bình điểm đánh giá
    $commentOfProduct = $danhGia->getDatabyIDProduct();

    $comment_Customer = $danhGia->getDataByIdCustomer();
    $_SESSION['datacmtOfPro'] = $commentOfProduct;
    // yêu  thích
    $yeuthich = new sanPhamYeuThichModel(0, "", $idProduct, $maKH);

?>

    <div class="row row-pb-lg product-detail-wrap">
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-6">
                    <div class="item">
                        <div class="product-entry">
                            <a href="#" class="col-sm-4" class="prod-img">
                                <img src="<?php echo PLUGIN_QUANLYSACH_IMG . '/' . $tenTheLoai . '/' . $dataSanPham[0]->anhDaiDien ?>" class="img-fluid" alt="Free html5 bootstrap 4 template">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="product-desc">
                        <h3><?php echo  $dataSanPham[0]->tenSanPham  ?></h3>
                        <!-- rating -->
                        <p class="price">
                            <span class="rate">
                                <?php
                                //var_dump($average);
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $average) {
                                        $color = '#ffcc00';
                                        $class = 'icon-star-full';
                                    } else if ($i > $average && $average > $i - 1) {
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

                            <span id="heart_respone" class="rate">
                                <?php

                                if ($yeuthich->favourite_exists() != null) {
                                    echo '<i id="icon_heart" style="color:red" class="icon-heart"></i>';
                                } else {
                                    echo '<i id="icon_heart" style="" class="icon-heart"></i>';
                                }
                                ?>

                            </span>
                        </p>
                        <!--end rating -->
                        <div class="size-wrap">
                            <div class="block-26 mb-2">
                                <h4>Thể loại: <a style="color: blue;" href=""><?php echo $tenTheLoai ?></a></h4>
                            </div>
                            <div class="block-26 mb-2">
                                <h4>Nhà xuất bản: <a style="color: blue;" href=""><?php echo $dataNSX[0]->tenNXB ?></a></h4>
                            </div>
                            <div class="block-26 mb-4">
                                <h4>Lượt đọc: <a style="color: blue;" href=""><?php echo $dataSanPham[0]->luotDoc ?></a></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <?php
                                $typeFile = substr($dataSanPham[0]->tenFile, -1);
                                // pdf
                                if ($typeFile == 'f') {
                                ?>
                                    <a target="_blank" href="<?= $hosting . 'doc-Sach?maSanPham=' . $dataSanPham[0]->maSanPham ?>">
                                        <button onclick="themLuotDoc(<?php echo $dataSanPham[0]->maSanPham  ?>)" type="button" class="btn btn-success">Đọc</button>
                                    </a>
                                <?php
                                }
                                //epub
                                else {
                                ?>
                                    <a target="_blank" href="<?= $hosting . 'epub?maSanPham=' . $dataSanPham[0]->maSanPham ?>">
                                        <button onclick="themLuotDoc(<?php echo $dataSanPham[0]->maSanPham  ?>)" type="button" class="btn btn-success">Đọc</button>
                                    </a>
                                <?php
                                }
                                ?>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="pt-4">
                    <h4>Giới thiệu</h4>
                    <?php echo wpautop($dataSanPham[0]->gioiThieu) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div>
                <?php do_action('getAllCategory') ?>
            </div>
            <h3>Tương tự </h3>
            <?php do_action('single_sidebar',  $dataTheLoai[0]->maTheLoai, $tenTheLoai) ?>

        </div>
    </div>

    <!-- Comment -->
    <div class="row ">
        <div class="col-sm-9 border">
            <div class="row">
                <div class="col-md-12 pills">
                    <div class="bd-example bd-example-tabs">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link">Đánh giá</a>
                            </li>
                        </ul>
                        <!--write comment  -->
                        <div class="col-md-12 rating">
                            Rating:
                            <?php
                            if (isset($_SESSION['isLogin'])) {
                                $placeholder = 'Comment here...';
                            } else {
                                $placeholder = 'Please login...';
                            }
                            for ($i = 1; $i <= 5; $i++) {
                            ?>
                                <i style="color: #ccc;" id=<?php echo $idProduct . '-' . $i ?> data-index=<?php echo $i ?> data-product_id=<?php echo $idProduct ?> class="icon-star-full rating"></i>
                            <?php
                            }
                            ?>
                            <div class="input-group ">
                                <input type="hidden" name="value_rating" id="value_rating" value="0" />
                                <input placeholder="<?php echo $placeholder ?>" type="text" name="value_comment" id="value_comment" class="form-control col-md-11">
                                <span class="input-group-btn">
                                    <button style="border-radius: 0; height: 100%;" id="submit_comment" class="btn btn-success" type="submit"><i class="icon-send "></i></button>
                                </span>
                            </div>
                        </div>
                        <!-- end write comment  -->

                        <div id="respone_cmt" class="tab-pane ">

                            <!--Hiển thị bình luận của tài khoản-->
                            <?php
                            if ($comment_Customer != null && ($_GET['c_page'] == 1 || $_GET['c_page'] == '')) {
                                // var_dump($comment_Customer);
                            ?>
                                <div class="col-md-12">

                                    <div class="review">
                                        <div class="user-img" style="background-image: url(<?php echo THEME_URL . '/images/icon.jpg' ?>); width: 50px;height: 50px;"></div>
                                        <div class="desc">
                                            <?php
                                            if ($comment_Customer[0]->trangThai == 0) echo ' ( Chưa duyệt ) ';  ?>
                                            <h4>
                                                <span style="color: blue;" class="text-left"><?php echo $thisCustomer[3] ?></span>
                                                <span class="text-right"><?php echo $comment_Customer[0]->ngaybl ?></span>
                                            </h4>
                                            <h4>
                                                <?php
                                                for ($i = 0; $i < 5; $i++) {
                                                    if ($comment_Customer[0]->diemDanhGia == 0) {
                                                        echo '<p style="font-family: Arial, sans-serif;font-size: 14px;text-transform: lowercase;">unknown</p>';
                                                        break;
                                                    } else if ($i < $comment_Customer[0]->diemDanhGia) {
                                                        echo '<i style="color: #ffcc00;font-size: 15px;" class="icon-star-full"></i>';
                                                    } else {
                                                        echo '<i style="font-size: 15px;color: #ccc;" class="icon-star-full"></i>';
                                                    }
                                                }
                                                ?>

                                            </h4>
                                            <h4 id="respone_edit">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div hidden class="row" id="value_edit">
                                                            <div class="col-md-11">
                                                                <input placeholder="<?php echo $placeholder ?>" value="<?php echo $comment_Customer[0]->noiDung ?>" class="form-control " type="text" id="value_edit_cmt">
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button style="border-radius: 0; height: 100%;" id="submit_edit" class="btn btn-success " type="submit"><i class="icon-send "></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div>
                                                                    <p id="cmt_content" style="font-family: Arial, sans-serif;font-size: 14px;text-transform: lowercase;"><?php echo $comment_Customer[0]->noiDung ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <span class="text-right">
                                                            <i id="edit_cmt" data-id_cmt="<?php echo $comment_Customer[0]->id ?>" style="color: #008000;" class="icon-edit"></i>
                                                            <i id="delete_cmt" data-id_cmt='<?php echo $comment_Customer[0]->id ?>' style="color:red" class="icon-trash"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </h4>

                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <!--Hết bình luận của tài khoản-->
                            <?php
                            // hiển thị tất cả đánh giá 
                            do_action('pagination_cmt');
                            ?>
                            <!-- end comment product -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end Comment -->
    <script>
        function themLuotDoc(id) {
            jQuery.ajax({
                url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>', // URL Ajax
                type: 'POST',
                data: {
                    action: 'themLuotDoc',
                    product_id: <?php echo $idProduct ?>,
                },
                success: function(response) {
                    console.log(response); // Xử lý kết quả thành công
                },
                error: function(xhr, status, error) {
                    console.log(error); // Xử lý lỗi
                }
            });
        }
        <?php
        if (isset($_SESSION['isLogin'])) {
        ?>
            // xóa  màu vàng cho những phần tử k dc hover
            function rm_background(productId) {
                for (let index = 1; index <= 5; index++) {
                    jQuery('#' + productId + '-' + index).css('color', '#ccc');
                }
            }
            // hover chuột đánh giá sao
            jQuery(document).on('mouseenter', '.rating', function() {
                var index = jQuery(this).data('index');
                var product_id = jQuery(this).data('product_id');
                rm_background(product_id);
                for (let i = 1; i <= index; i++) {
                    jQuery('#' + product_id + '-' + i).css('color', '#ffcc00');
                    jQuery('#value_rating').val(i); // đặt giá trị cho value_rating
                }
                jQuery(this).css('cursor', 'pointer');
                // Hủy function khi bấm ra ngoài
                jQuery(document).on('click', function(event) {
                    if (!jQuery(event.target).closest('.rating').length) {
                        jQuery('.rating').css('color', '#ccc');
                        jQuery('#value_rating').val(0);
                    }
                });
            });
            // click đánh giá
            jQuery(document).on('click', '#submit_comment', function() {
                var value_rating = jQuery('#value_rating').val();
                var comment = jQuery('#value_comment').val();
                if (value_rating == '' && comment == '') {
                    return;
                }
                if (value_rating < 0 || value_rating > 5) {
                    return;
                }
                jQuery.ajax({
                    url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>', // URL Ajax
                    dataType: 'html',
                    type: 'POST',
                    data: {
                        action: 'insertNewComment',
                        value_rating: value_rating,
                        comment: comment,
                        product_id: <?php echo $idProduct ?>,
                        idCustomer: <?php echo $_SESSION['isLogin'][0] ?>
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.trim() == 'da_bl') {
                            alert("Bạn đã đánh giá sản phẩm trước đó");
                        } else if (response.trim() == 'fail') {
                            alert("fail");
                        } else {
                            jQuery('#respone_cmt').html(response);
                            alert("Bạn đã đánh giá sản phẩm");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error); // Xử lý lỗi
                    }
                });
            });

            // click xóa
            jQuery(document).on('mouseenter', '#delete_cmt', function() {
                jQuery(this).css('cursor', 'pointer');
            });
            jQuery(document).on('click', '#delete_cmt', function() {
                var idCmt = jQuery(this).data('id_cmt');
                jQuery.ajax({
                    url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>', // URL Ajax
                    dataType: 'html',
                    type: 'POST',
                    data: {
                        action: 'deleteComment',
                        idCmt: idCmt,
                        product_id: <?php echo $idProduct ?>,
                        idCustomer: <?php echo $_SESSION['isLogin'][0] ?>
                    },
                    success: function(response) {
                        console.log(response); // Xử lý kết quả thành công
                        // response trả về là true0: k biết tại sao không phải là true
                        if (response.trim() == 'fail') {
                            alert("fail");
                        } else {
                            jQuery('#respone_cmt').html(response);
                            alert("Bạn đã xóa đánh giá");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error); // Xử lý lỗi
                    }
                });
            })
            // sửa
            jQuery(document).on('mouseenter', '#edit_cmt', function() {
                jQuery(this).css('cursor', 'pointer');
            });
            jQuery(document).on('click', '#edit_cmt', function() {
                jQuery('#cmt_content').hide();
                jQuery('#value_edit').removeAttr('hidden');
                // Hủy function khi bấm ra ngoài
                jQuery(document).on('click', function(event) {
                    if (!jQuery(event.target).closest('#respone_cmt').length) {
                        jQuery('#cmt_content').show();
                        jQuery('#value_edit').attr('hidden', 'hidden');
                    }
                });
            })
            jQuery(document).on('click', '#submit_edit', function() {
                var idCmt = jQuery('#edit_cmt').data('id_cmt');
                var value_edit_cmt = jQuery('#value_edit_cmt').val();
                jQuery.ajax({
                    url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>', // URL Ajax
                    dataType: 'html',
                    type: 'POST',
                    data: {
                        action: 'editCmt',
                        idCmt: idCmt,
                        value_edit_cmt: value_edit_cmt,
                        product_id: <?php echo $idProduct ?>,
                        idCustomer: <?php echo $_SESSION['isLogin'][0] ?>
                    },
                    success: function(response) {
                        console.log(response); // Xử lý kết quả thành công
                        if (response.trim() === 'false') {
                            alert("Sửa bình luận thất bại");
                        } else {
                            jQuery('#respone_edit').html(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error); // Xử lý lỗi
                    }
                });
            })
            // hover thả tim
            jQuery(document).on('mouseenter', '#icon_heart', function() {
                jQuery(this).css('cursor', 'pointer');
            });
            jQuery(document).on('click', '#icon_heart', function() {
                var idCmt = jQuery(this).data('id_cmt');
                jQuery.ajax({
                    url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>', // URL Ajax
                    dataType: 'html',
                    type: 'POST',
                    data: {
                        action: 'addFavourite',
                        product_id: <?php echo $idProduct ?>,
                        idCustomer: <?php echo $_SESSION['isLogin'][0] ?>
                    },
                    success: function(response) {
                        console.log(response); // Xử lý kết quả thành công
                        // response trả về là true0: k biết tại sao không phải là true
                        if (response.trim() == 'fail') {
                            alert("fail");
                        } else {
                            jQuery('#heart_respone').html(response);
                            alert("ok");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error); // Xử lý lỗi
                    }
                });
            });
        <?php
        }
        ?>
    </script>

<?php

}
