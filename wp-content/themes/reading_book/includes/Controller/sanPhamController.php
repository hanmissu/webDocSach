
<?php
include_once '../../../../../wp-load.php';
$key_search= isset($_POST['key_search']) ? $_POST['key_search'] : '';
if($key_search !=''){
    do_action('xuLyTimKiem', sanitize_text_field($key_search));
}

