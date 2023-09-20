<?php
/*
Template Name: ch_login
*/

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    get_header();
    ?>
</head>

<body>
    <?php get_template_part('template-parts/nav/nav'); ?>
    <?php
    do_action('thongBao_theme', 'login_fail');
    ?>

    <div class="container">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5" style="background-color: #eee;">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Đăng nhập</p>
                                <form class="mx-1 mx-md-4">
                                    <div class="d-flex flex-row align-items-center mb-4">

                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example1c">Tên đăng nhập<sup class="sub_requied">*</sup>
                                                <span style="visibility: hidden;color: red;" id="message1">Vui lòng không nhập ký tự đặc biệt</span>
                                            </label>
                                            <input type="text" id="loginName" class="form-control" value="" name="loginName" minlength="3" maxlength="255" required />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">

                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example1c">Mật khẩu<sup class="sub_requied">*</sup></label>
                                            <input type="password" id="password" class="form-control" value="" name="password" minlength="6" id="pswd" maxlength="255" required />
                                        </div>
                                    </div>
                                    <div>
                                        <p onclick="resetPassword()" style="color: blue;cursor: pointer;">Quên mật khẩu?</p>
                                    </div>
                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button id="btnLogin" onclick="Login()" type="button" class="btn btn-primary btn-lg">Đăng nhập</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="resetPassword">
                            <form class="mx-1 mx-md-4">
                                <div class="d-flex flex-row align-items-center mb-4">

                                    <div class="form-outline flex-fill mb-0">
                                        <label class="form-label" for="form3Example1c">Email tài khoản</sup></label>
                                        <input type="email" id="emailReset" class="form-control" minlength="3" maxlength="255" required />
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center mb-2">
                                    <button onclick="senMailReset()" type="button" class="btn btn-primary btn-lg">Ok</button>
                                    <button type="button" class="btn btn-danger" onclick="resetPassword()">Đóng</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    function resetPassword() {
        var popup = document.getElementById('resetPassword');
        popup.classList.toggle('active');
    }

    function senMailReset() {
        var emailReset = document.getElementById('emailReset').value;
        var popup = document.getElementById('resetPassword');
        if (popup.getAttribute("disabled") === "disabled") {
            alert("Bạn đã bấm trước đó")
            return;
        }
        popup.classList.toggle('active');
        popup.setAttribute("disabled", "disabled");

        setTimeout(function() {
            popup.removeAttribute("disabled");
        }, 30000);

        if (emailReset === '') return;
        jQuery.ajax({
            url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>',
            type: 'POST',
            data: {
                action: 'resetPassword',
                email: emailReset
            },
            success: function(response) {
                // Xử lý phản hồi thành công từ máy chủ
                console.log(response);
                alert("Mật khẩu mới đã được gửi");
                location.reload();
            },
            error: function(xhr, status, error) {
                // Xử lý lỗi
                console.log(error);
                alert("Lỗi");
            }
        })
    }

    function Login() {
        var loginName = document.getElementById('loginName').value;
        var password = document.getElementById('password').value;
        jQuery.ajax({
            url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>',
            type: 'POST',
            data: {
                action: 'login',
                loginName: loginName,
                password: password,
            },
            success: function(response) {
                // Xử lý phản hồi thành công từ máy chủ
                console.log(response);
                switch (response.trim()) {
                    case 'false':
                        alert("Tài khoản hoặc mật khẩu không đúng");
                        break;
                    case 'verify':
                        location.href = '<?php echo  $hosting . "/xac-nhan" ?>'
                        break;
                    case 'true':
                        location.href = '<?php echo home_url() ?>'
                        break;
                    default:
                        break;
                }
            },
            error: function(xhr, status, error) {
                // Xử lý lỗi
                console.log(error);
                alert("Lỗi");
            }
        })
    }
</script>

</html>