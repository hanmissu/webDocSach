<?php
add_action('profile', 'profile');
function profile()
{
    global $hosting;
    include_once THEME_DIR . '/includes/Model/khachHangModel.php';

    $userID = $_SESSION['isLogin'][0];
    $khachhang = new khachHangModel($userID, "", "", null, "", "", "", "", "", "", "", null, null);
    $data = $khachhang->getDataByID();
    //html
?>
    <section style="background-color: #eee;">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 class="my-3"><?php echo $data[0]->tenDangNhap ?></h5>
                            <div class="d-flex justify-content-center mb-2">
                                <button id="btn_logout" type="button" onclick="logout()" class="btn btn-primary">Đăng xuất</button>
                                <a href="<?php echo $hosting ?>/favourite/"> <button type="button" class="btn btn-outline-primary ms-1">Yêu thích</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Họ và tên</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo $data[0]->hoTenKH ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Email</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo $data[0]->email ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Số điện thoại</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo $data[0]->SDT ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Giới tính</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php if ($data[0]->gioiTinh === '0') echo 'Nam';
                                                                else if ($data[0]->gioiTinh == 1) echo 'Nữ';
                                                                else echo '' ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Ngày sinh</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo $data[0]->ngaySinh ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-9">
                                    <button id="btn_logout" type="button" onclick="toogle()" class="btn btn-outline-primary ms-1 icon-edit"></button>
                                </div>
                                <span><button id="" type="button" onclick="toogleChangePassword()" class="btn icon-edit">Đổi mật khẩu</button></span>
                            </div>
                        </div>
                    </div>
                    <div id="popup">
                        <h2 class="text-center">Sửa thông tin cá nhân</h2>
                        <form class="mx-1 mx-md-4">
                            <div class="d-flex flex-row align-items-center mb-4">

                                <div class="form-outline flex-fill mb-0">
                                    <label class="form-label" for="form3Example1c">Họ tên</sup>
                                        <span style="visibility: hidden;" class="Special_characters" id="message1">Vui lòng không nhập ký tự đặc biệt</span>
                                    </label>
                                    <input type="text" id="fullName" class="form-control" value="<?php echo $data[0]->hoTenKH ?>" name="fullName" minlength="3" maxlength="255" required />
                                </div>
                            </div>
                            <div class="d-flex flex-row align-items-center mb-4">

                                <div class="form-outline flex-fill mb-0">
                                    <label class="form-label" for="form3Example1c">Số điện thoại</sup>

                                    </label>
                                    <input type="text" id="phone" class="form-control" value="<?php echo $data[0]->SDT ?>" name="phone" maxlength="255" />
                                </div>
                            </div>
                            <div class="d-flex flex-row align-items-center mb-4">

                                <div class="form-outline flex-fill mb-0">
                                    <label class="form-label" for="form3Example1c">Giới tính</sup>

                                    </label>
                                    <select class="form-select" aria-label="Default select example" id="Gender" name="Gender" value="<?php echo $data[0]->gioiTinh ?>">
                                        <option <?php if ($data[0]->gioiTinh == '') echo 'selected' ?> value="">Khác</option>
                                        <option <?php if ($data[0]->gioiTinh === '0') echo 'selected' ?> value="0">Nam</option>
                                        <option <?php if ($data[0]->gioiTinh == 1) echo 'selected' ?> value="1">Nữ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-row align-items-center mb-4">

                                <div class="form-outline flex-fill mb-0">
                                    <label class="form-label" for="form3Example1c">Ngày sinh</sup>
                                    </label>
                                    <input hidden type="text" id="Birthdayold" class="form-control" name="Birthdayold" value="<?php echo $data[0]->ngaySinh ?>" maxlength="255" />
                                    <input type="date" id="Birthday" class="form-control" name="Birthday" maxlength="255" />
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mb-2">
                                <button onclick="customer_edit();" id="submit" type="button" class="btn btn-primary btn-lg">Sửa</button>
                                <button type="button" class="btn btn-danger" onclick="toogle()">Đóng</button>
                            </div>
                        </form>
                    </div>
                    <div id="popup_change_pass">
                        <form class="mx-1 mx-md-4">
                            <div class="d-flex flex-row align-items-center mb-4">

                                <div class="form-outline flex-fill mb-0">
                                    <label class="form-label" for="form3Example1c">Mật khẩu</sup>
                                        <span style="visibility: hidden;" class="Special_characters" id="message1">Vui lòng không nhập ký tự đặc biệt</span>
                                    </label>
                                    <input type="password" id="currentPassword" class="form-control" name="currentPassword" minlength="3" maxlength="255" required />
                                </div>
                            </div>
                            <div class="d-flex flex-row align-items-center mb-4">

                                <div class="form-outline flex-fill mb-0">
                                    <label class="form-label" for="form3Example1c">Mật khẩu mới</sup>

                                    </label>
                                    <input type="password" id="newPassword" class="form-control" name="newPassword" maxlength="255" required />
                                </div>
                            </div>
                            <div class="d-flex flex-row align-items-center mb-4">

                                <div class="form-outline flex-fill mb-0">
                                    <label class="form-label" for="form3Example1c">Nhập lại mật khẩu</sup>
                                        <span style="visibility: hidden;" class="Special_characters" id="message_change_password">Mật khẩu không trùng khớp</span>
                                    </label>
                                    <input type="password" onkeyup="notifyPassword()" id="confirmPassword" class="form-control" value="" name="confirmPassword" maxlength="255" />
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mb-2">
                                <button onclick="checkPassword()" id="submit" type="button" class="btn btn-primary btn-lg">Đổi</button>
                                <button type="button" class="btn btn-danger" onclick="toogleChangePassword()">Đóng</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </section>
    <script>
        function logout() {
            jQuery.ajax({
                url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>', // URL Ajax
                type: 'POST',
                data: {
                    action: 'logout',

                },
                success: function(response) {
                    console.log(response); // Xử lý kết quả thành công
                    if (response.trim() === 'true') {
                        location.href = '<?php echo home_url() ?>'
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error); // Xử lý lỗi
                }
            })
        }

        function toogle() {
            var popup = document.getElementById('popup');
            popup.classList.toggle('active');
        }

        function customer_edit() {
            var ngaySinh = document.getElementById('Birthday').value;
            var ngaySinhCu = document.getElementById('Birthdayold').value;
            var fullName = document.getElementById('fullName').value;
            var phone = document.getElementById('phone').value;
            var Gender = document.getElementById('Gender').value;
            var ngaySinhObj = new Date(ngaySinh);
            var ngayHienTai = new Date();
            var tuoi = ngayHienTai.getFullYear() - ngaySinhObj.getFullYear();
            // Kiểm tra nếu chưa đủ 13 tuổi
            if (tuoi < 13) {
                alert("Bạn phải đủ 13 tuổi trở lên để tiếp tục.");
                return;
            }
            jQuery.ajax({
                url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>', // URL Ajax
                type: 'POST',
                data: {
                    action: 'customer_edit',
                    fullName: fullName,
                    phone: phone,
                    Gender: Gender,
                    ngaySinh: ngaySinh,
                    ngaySinhCu: ngaySinhCu,
                },
                success: function(response) {
                    console.log(response); // Xử lý kết quả thành công
                    if (response.trim() === 'false') alert("Thất bại");
                    if (response.trim() === 'true') {
                        alert("Cập nhật thành công");
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error); // Xử lý lỗi
                }
            })
            return false;
        }

        function toogleChangePassword() {
            var popup = document.getElementById('popup_change_pass');
            popup.classList.toggle('active');
        }

        function notifyPassword(newPassword, confirmPassword) {
            var newPassword = document.getElementById('newPassword').value;
            var confirmPassword = document.getElementById('confirmPassword').value;
            var message = document.getElementById('message_change_password');
            if (newPassword != confirmPassword) {
                message.style.visibility = "visible";
            } else {
                message.style.visibility = "hidden";
            }
        }

        function checkPassword() {
            var currentPassword = document.getElementById('currentPassword').value;
            var newPassword = document.getElementById('newPassword').value;
            var confirmPassword = document.getElementById('confirmPassword').value;
            if (newPassword == confirmPassword) {
                jQuery.ajax({
                    url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>', // URL Ajax
                    dataType: 'text',
                    type: 'POST',
                    data: {
                        action: 'change_password',
                        currentPassword: currentPassword,
                        newPassword: newPassword
                    },
                    success: function(response) {
                        console.log(response); // Xử lý kết quả thành công

                        if (response.trim() === 'false') {
                            alert("Sai mật khẩu");
                        } else if (response === "err") {
                            alert("Lỗi");
                        } else {
                            alert("Đổi mật khẩu thành công");
                            location.reload();
                        }

                    },
                    error: function(xhr, status, error) {
                        console.log(error); // Xử lý lỗi
                    }
                });
            }
            return false;
        }
    </script>
<?php
    //end html
}
