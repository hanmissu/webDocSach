<?php
add_action('sidebar_getAllCategory', 'sidebar_getAllCategory');
function sidebar_getAllCategory()
{
    global $hosting;
    include_once THEME_DIR . '/includes/Model/theLoaiModel.php';
    $theloai = new theLoaiModel(0, '');
    $dataTheLoai = $theloai->getAll();
    //html
?>

    <div class="row">
        <div class="col-sm-12">
            <div class="side border mb-1">
                <h3>Thể loại</h3>
                <ul>
                    <?php for ($i = 0; $i < count($dataTheLoai); $i++) {
                        //html
                    ?>
                        <li><a href="<?php echo $hosting ?>category?id=<?php echo $dataTheLoai[$i]->maTheLoai  ?>"><?php echo $dataTheLoai[$i]->tenTheLoai ?></a></li>

                    <?php
                        //end html
                    } ?>
                </ul>
            </div>
        </div>
    </div>
<?php
    //end html
}
