<?php
add_action('wp_ajax_change_password', 'change_password');
add_action('wp_ajax_nopriv_change_password', 'change_password');
function change_password()
{
    include_once THEME_DIR . '/includes/Model/khachHangModel.php';
    $khachhang = new khachHangModel($_SESSION['isLogin'][0], "", "", "", "", "", wp_hash_password($_POST['newPassword']), 1, "", "", "", "", "");
    $dataCheck = $khachhang->getDataByID();
    $newpass = "newpass:" . $_POST['currentPassword'];
    if (wp_check_password(trim($_POST['currentPassword']), $dataCheck[0]->matKhau) == false || $_POST['newPassword'] == '') {
        echo "false";
        exit;
    } else if ($khachhang->updatePassword()) {
        echo "true";
        exit;
    } else {
        echo "err";
        exit;
    }
}

add_action('wp_ajax_customer_edit', 'customer_edit');
add_action('wp_ajax_nopriv_customer_edit', 'customer_edit');
function customer_edit()
{
    include_once THEME_DIR . '/includes/Model/khachHangModel.php';
    if ($_POST['ngaySinh'] != null) {
        $date = DateTime::createFromFormat('Y-m-d', $_POST['ngaySinh']);
        $birthdayFormat = $date->format('d-m-Y');
    } else {
        $birthdayFormat = $_POST['ngaySinhCu'];
    }

    $phone =  $_POST['phone'] != '' ?  $_POST['phone'] : null;
    $khachhang = new khachHangModel($_SESSION['isLogin'][0], $_POST['fullName'], $phone, "", null, "", "", 1, $_POST['Gender'], $birthdayFormat, "", null, null);
    if ($khachhang->update()) {
        echo 'true';
        exit;
    } else {
        echo 'false';
        exit;
    }
}

add_action('wp_ajax_resetPassword', 'resetPassword');
add_action('wp_ajax_nopriv_resetPassword', 'resetPassword');
function resetPassword()
{
    include_once THEME_DIR . '/includes/Model/khachHangModel.php';
    $mat_khau = wp_generate_password(8, false);
    $khachhang = new khachHangModel(0, "", "", $_POST['email'], "", "", wp_hash_password($mat_khau), "", "", "", "", "", "");
    $subject = "Reset password";
    $message = "Mật khẩu mới của bạn là: $mat_khau";
    do_action('sendMail', $_POST['email'], $subject, $message);
    $khachhang->resetPassword();
}
add_action('wp_ajax_register', 'register');
add_action('wp_ajax_nopriv_register', 'register');
function register()
{
    include_once THEME_DIR . '/includes/Model/khachHangModel.php';
    $date = current_time('d/m/Y');
    $hashedPassword = wp_hash_password(sanitize_text_field($_POST['password']));
    $code = wp_rand(100000, 999999);
    $khachhang = new khachHangModel(
        0,
        sanitize_text_field($_POST['fullName']),
        sanitize_text_field($_POST['phoneNumber']),
        sanitize_text_field($_POST['userEmail']),
        $code,
        sanitize_text_field($_POST['loginName']),
        $hashedPassword,
        0,
        "",
        "",
        $date,
        null,
        null
    );
    if ($khachhang->getDataByEmail() != null) {
        echo 'existsEmail';
        exit;
    } else if ($khachhang->getDataByLoginName() != null) {
        echo 'existsLoginName';
        exit;
    } else {
        if ($khachhang->insert()) {
            $subject = "Xác thực email đăng ký";
            $message = "Mã xác thực của bạn là: $code";
            do_action('sendMail', $_POST['userEmail'], $subject, $message);
            $_SESSION['email_verify'] = $_POST['userEmail'];
            echo 'true';
            exit;
        } else {
            echo 'false';
            exit;
        }
    }
}
add_action('wp_ajax_verify_email', 'verify_email');
add_action('wp_ajax_nopriv_verify_email', 'verify_email');
function verify_email()
{
    include_once THEME_DIR . '/includes/Model/khachHangModel.php';
    $userEmail = $_POST['email'];
    $code = $_POST['code'];
    $khachhang = new khachHangModel(0, "", "", $userEmail, $code, "", "", "", "", "", "", null, null);
    $data = $khachhang->getDataByEmail();
    if ($data[0]->maXacThucEmail == $code) {
        $khachhang->updateStatus();
        set_transient('register_success', 'Đăng ký thành công', 30);
        unset($_SESSION['email_verify']);
        echo 'true';
        exit;
    } else {
        echo 'false';
        exit;
    }
}

add_action('wp_ajax_login', 'login');
add_action('wp_ajax_nopriv_login', 'login');
function login()
{
    include_once THEME_DIR . '/includes/Model/khachHangModel.php';
    $khachhang = new khachHangModel(0, "", "", null, "", sanitize_text_field($_POST['loginName']), "", "", "", "", "", null, null);
    $data = $khachhang->getDataByLoginName();
    if ($data == null || !wp_check_password($_POST['password'],  $data[0]->matKhau)) {
        echo 'false';
        exit;
    } else if ($data[0]->trangThai == 0) {
        $_SESSION['email_verify'] = $data[0]->email;
        echo 'verify';
        exit;
    } else {
        set_transient('login_success', 'Chào mừng bạn', 30);
        $_SESSION['isLogin'] = [$data[0]->maKH, $data[0]->hoTenKH, $data[0]->email, $data[0]->tenDangNhap];
        echo 'true';
        exit;
    }
}
add_action('wp_ajax_logout', 'logout');
add_action('wp_ajax_nopriv_logout', 'logout');
function logout()
{
    unset($_SESSION['isLogin']);
    echo 'true';
    exit;
}

add_action('wp_ajax_resend_email', 'resend_email');
add_action('wp_ajax_nopriv_resend_email', 'resend_email');
function resend_email()
{
    include_once THEME_DIR . '/includes/Model/khachHangModel.php';
    $khachhang = new khachHangModel(0, "", null, $_POST['email'], "", "", "", 0, "", "", "", null, null);
    $data = $khachhang->getDataByEmail();
    $subject = "Xác thực email đăng ký";
    $message = "Mã xác thực của bạn là: " .  $data[0]->maXacThucEmail;
    do_action('sendMail', $_POST['email'], $subject, $message);
    echo 'true';
    exit;
}
