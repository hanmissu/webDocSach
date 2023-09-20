<?php
add_action('wp_ajax_insertNewComment', 'insertNewComment');
add_action('wp_ajax_nopriv_insertNewComment', 'insertNewComment');

add_action('wp_ajax_deleteComment', 'deleteComment');
add_action('wp_ajax_nopriv_deleteComment', 'deleteComment');

add_action('wp_ajax_editCmt', 'editCmt');
add_action('wp_ajax_nopriv_editCmt', 'editCmt');

function insertNewComment()
{
    include_once THEME_DIR . '/includes/Model/theLoaiModel.php';
    include_once THEME_DIR . '/includes/Model/danhGiaSanPhamModel.php';
    include_once THEME_DIR . '/includes/Model/khachHangModel.php';
    // khách hàng
    $thisCustomer =  $_SESSION['isLogin'];
    $dateComment = current_time('d/m/Y');
    $danhgia = new danhGiaSanPhamModel(0, sanitize_text_field($_POST['value_rating']), sanitize_text_field($_POST['comment']), $dateComment, "", sanitize_text_field($_POST['product_id']), sanitize_text_field($_POST['idCustomer']), 0);
    $data = $danhgia->getDataByIdCustomer(sanitize_text_field($_POST['idCustomer']));
    if (empty($data)) {
        $result = $danhgia->insert();
        if ($result == true) {
            // đánh giá sp

            $comment_Customer = $danhgia->getDataByIdCustomer();
            if ($comment_Customer != null && (sanitize_text_field($_GET['c_page']) == 1 || sanitize_text_field($_GET['c_page']) == '')) {
                //html
?>
                <div class="col-md-12">
                    <div class="review">
                        <div class="user-img" style="background-image: url(<?php echo THEME_URL . '/images/icon.jpg' ?>); width: 50px;height: 50px;"></div>
                        <div class="desc">
                            ( Chưa duyệt )
                            <h4>
                                <span style="color: blue;" class="text-left"><?php echo $thisCustomer[3] ?></span>
                                <span class="text-right"><?php echo $comment_Customer[0]->ngaybl ?></span>
                            </h4>
                            <h4>
                                <?php
                                for ($i = 0; $i < 5; $i++) {
                                    if ($comment_Customer[0]->diemDanhGia == 0 || $comment_Customer[0]->diemDanhGia == null) {
                                        echo '<p style="font-family: Arial, sans-serif;font-size: 14px;text-transform: lowercase;">unknown</p>';
                                        break;
                                    }
                                    if ($i < $comment_Customer[0]->diemDanhGia) {
                                        echo '<i style="color: #ffcc00;font-size: 15px;" class="icon-star-full"></i>';
                                    } else {
                                        echo '<i style="font-size: 15px;" class="icon-star-full"></i>';
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

        <?php // end html
            exit;
        } else {
            echo "false";
            exit;
        }
    } else {
        // đã bình luận
        echo "da_bl";
        exit;
    }
}


function deleteComment()
{
    include_once THEME_DIR . '/includes/Model/theLoaiModel.php';
    include_once THEME_DIR . '/includes/Model/danhGiaSanPhamModel.php';
    include_once THEME_DIR . '/includes/Model/khachHangModel.php';
    // khách hàng
    $thisCustomer = $_SESSION['isLogin'];
    $maKH = $thisCustomer[0];

    $danhgia = new danhGiaSanPhamModel(sanitize_text_field($_POST['idCmt']), "", "", "", "", "", "", 0);
    $result = $danhgia->delete();
    if ($result == true) {
        // hiển thị tất cả đánh giá 
        do_action('pagination_cmt');
        exit;
    } else {
        echo "false";
        exit;
    }
}
function editCmt()
{
    include_once THEME_DIR . '/includes/Model/theLoaiModel.php';
    include_once THEME_DIR . '/includes/Model/danhGiaSanPhamModel.php';
    include_once THEME_DIR . '/includes/Model/khachHangModel.php';
    $dateEdit = current_time('d/m/Y');
    $danhgia = new danhGiaSanPhamModel(sanitize_text_field($_POST['idCmt']), "", sanitize_text_field($_POST['value_edit_cmt']), "", $dateEdit, sanitize_text_field($_POST['product_id']), sanitize_text_field($_POST['idCustomer']), "");
    if ($danhgia->updateCmt()) {
        $data = $danhgia->getDataByIdCustomer();
        ?>
        <div class="row">
            <div class="col-md-10">
                <div hidden class="row" id="value_edit">
                    <div class="col-md-11">
                        <input placeholder="<?php echo $placeholder ?>" value="<?php echo $data[0]->noiDung ?>" class="form-control " type="text" id="value_edit_cmt">
                    </div>
                    <div class="col-md-1">
                        <button style="border-radius: 0; height: 100%;" id="submit_edit" class="btn btn-success " type="submit"><i class="icon-send "></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <p id="cmt_content" style="font-family: Arial, sans-serif;font-size: 14px;text-transform: lowercase;"><?php echo $data[0]->noiDung ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <span class="text-right">
                    <i id="edit_cmt" data-id_cmt="<?php echo $data[0]->id ?>" style="color: #008000;" class="icon-edit"></i>
                    <i id="delete_cmt" data-id_cmt='<?php echo $data[0]->id ?>' style="color:red" class="icon-trash"></i>
                </span>
            </div>
        </div>
<?php
        exit;
    } else {
        echo 'false';
        exit;
    }
}
