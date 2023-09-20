<?php
add_action('thongBao', 'thongBao', 10, 1);
function thongBao($transient_name)
{
    if (get_transient($transient_name)) {
?>
        <script>
            var successMessage = '<?php echo get_transient($transient_name); ?>';
            alert(successMessage);
            // Xóa transient để không hiển thị lại lần sau
            <?php delete_transient($transient_name);
            ?>
        </script>
<?php
    }
}
