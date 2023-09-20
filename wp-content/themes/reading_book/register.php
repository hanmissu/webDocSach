<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    /*
Template Name: ch_register
*/
    get_header();
    global $hosting;
    ?>
</head>

<body>
    <?php get_template_part('template-parts/nav/nav'); ?>
    <?php
    do_action('thongBao_theme', 'register_fail');
    do_action('thongBao_theme', 'exists_email_or_phone');
    ?>
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5" style="background-color: #eee;">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Đăng ký</p>
                                <form onsubmit="return Register()" class="mx-1 mx-md-4">
                                    <div class="d-flex flex-row align-items-center mb-4">

                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example1c">Họ tên<sup class="sub_requied">*</sup>
                                                <span hidden class="Special_characters" id="message1"> Vui lòng không nhập ký tự đặc biệt</span>
                                            </label>
                                            <input type="text" class="form-control" name="fullName" id="fullName" minlength="3" maxlength="50" required />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">

                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example1c">Số điện thoại</label>
                                            <input type="tel" id="phoneNumber" class="form-control" name="phoneNumber" minlength="10" maxlength="10" pattern="[0-9]{10}" title="Nhập đủ 10 số" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">

                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example1c">Email<sup class="sub_requied">*</sup></label>
                                            <input type="email" id="userEmail" class="form-control" name="userEmail" minlength="3" maxlength="255" required />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">

                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example1c">Tên đăng nhập<sup class="sub_requied">*</sup>
                                                <span hidden class="Special_characters" id="message4">Vui lòng không nhập ký tự đặc biệt</span>
                                            </label>
                                            <input type="text" id="loginName" class="form-control" name="loginName" minlength="3" maxlength="255" required />

                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">

                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example1c">Mật khẩu<sup class="sub_requied">*</sup></label>
                                            <input type="password" id="password" class="form-control" name="password" minlength="6" id="pswd" maxlength="255" required />
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">

                                        <button id="submit" type="submit" class="btn btn-primary btn-lg">Đăng ký</button>

                                    </div>
                                    <?php
                                    //end html
                                    ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    var inputs = document.querySelectorAll("input");
    var submit = document.getElementById("submit");
    for (var i = 0; i < inputs.length; i++) {
        var input = inputs[i];
        var message = document.getElementById("message" + (i));
        input.addEventListener("input", createInputHandler(input, message));
    }

    function createInputHandler(input, message) {
        return function() {
            var value = input.value;
            var regex = /[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/;

            if (regex.test(value) && input.type !== 'email') {
                message.removeAttribute("hidden");
                submit.style.visibility = "hidden";
            } else {
                message.setAttribute("hidden", true);
                submit.style.visibility = "visible";
            }
        };
    }

    function isValidEmail(email) {
        // Biểu thức chính quy kiểm tra email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function Register() {
        event.preventDefault();
        var fullName = document.getElementById('fullName').value;
        var phoneNumber = document.getElementById('phoneNumber').value;
        var userEmail = document.getElementById('userEmail').value;
        var loginName = document.getElementById('loginName').value;
        var password = document.getElementById('password').value;
        if (isValidEmail(userEmail)) {
            var userEmail = document.getElementById('userEmail').value;
        } else {
            alert("Email không hợp lệ");
            return;
        }
        if (fullName == '' || userEmail == '' || loginName == '' || password == '') {
            alert("Vui lòng điền đủ thông tin");
            return;
        }
        jQuery.ajax({
            url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>',
            type: 'POST',
            data: {
                action: 'register',
                fullName: fullName,
                phoneNumber: phoneNumber,
                userEmail: userEmail,
                loginName: loginName,
                password: password,
            },
            success: function(response) {
                console.log(response);
                switch (response.trim()) {
                    case 'existsEmail':
                        alert('Email bị trùng');
                        break;
                    case 'existsLoginName':
                        alert('Tên đăng nhập bị trùng');
                        break;
                    case 'false':
                        alert('Đăng ký thất bại');
                        break;
                    case 'true':
                        location.href = '<?php echo  $hosting . "/xac-nhan" ?>'
                        break;
                    default:
                        break;
                }
            },
            error: function(xhr, status, error) {
                console.log(error); // Xử lý lỗi
            }
        })
        return false;
    }
</script>

</html>