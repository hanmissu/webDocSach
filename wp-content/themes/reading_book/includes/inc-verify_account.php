<?php
add_action('customer_verify', 'customer_verify', 10, 1);
function customer_verify($code)
{
    include_once THEME_DIR . '/includes/Model/khachHangModel.php';
    $userEmail = get_transient('email_verify');
    $khachhang = new khachHangModel(0, "", "", $userEmail, $code, "", "", "", "", "", "", null, null);
    $data = $khachhang->getDataByEmail();
    if ($data[0]->maXacThucEmail == $code) {
        set_transient('register_success', 'Đăng ký thành công', 30);
        $khachhang->updateStatus();
        delete_transient('email_verify');
        wp_redirect(home_url());
    } else {
        set_transient('code_verify_fail', $code, 30);
        set_transient('verify_fail', 'Mã xác nhận không đúng', 30);
        wp_redirect($hosting . "/xac-nhan");
    }
}
