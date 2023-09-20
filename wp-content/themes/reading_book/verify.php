<?php
/*
Template Name: ch_verify
*/

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    global $hosting;
    if ($_SESSION['email_verify'] == null) {
        wp_redirect(home_url());
    }
    get_header();
    ?>
</head>

<body>
    <?php get_template_part('template-parts/nav/nav'); ?>
    <?php
    do_action('thongBao_theme', 'verify_fail');
    ?>
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Verify Email</p>
                                <p>Vui lòng nhập mã xác thực đã được gửi vào email: <?= $_SESSION['email_verify'] ?></p>
                                <form class="mx-1 mx-md-4">
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example1c">Code<sup class="sub_requied">*</sup></label>
                                            <input type="tel" id="code" value="" class="form-control" name="code" minlength="6" maxlength="6" required pattern="[0-9]{6}" title="Nhập đủ 6 số" />
                                        </div>
                                    </div>
                                    <p id="resend" style="color: blue;cursor: pointer;" onclick="Resend()">Resend</p>
                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button onclick="Verify()" id="submit" type="button" class="btn btn-primary btn-lg">Send</button>
                                    </div>
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
    function Verify() {
        var code = document.getElementById('code').value;
        jQuery.ajax({
            url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>',
            type: 'POST',
            data: {
                action: 'verify_email',
                code: code,
                email: '<?php echo $_SESSION['email_verify'] ?>'
            },
            success: function(response) {
                console.log(response);
                switch (response.trim()) {
                    case 'false':
                        alert('Sai mã xác thực');
                        break;
                    case 'true':
                        location.href = '<?php echo  home_url() ?>'
                        break;
                    default:
                        break;
                }
            },
            error: function(xhr, status, error) {
                console.log(error); // Xử lý lỗi
            }
        })
    }

    function Resend() {
        var resend = document.getElementById('resend');
        if (resend.getAttribute("disabled") === "disabled") {
            alert("Bạn đã bấm trước đó")
            return;
        }
        resend.setAttribute("disabled", "disabled");

        setTimeout(function() {
            resend.removeAttribute("disabled");
        }, 30000);

        jQuery.ajax({
            url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>',
            type: 'POST',
            data: {
                action: 'resend_email',
                email: '<?php echo $_SESSION['email_verify'] ?>'
            },
            success: function(response) {
                console.log(response);
                alert("Mã đã được gửi lại")
            },
            error: function(xhr, status, error) {
                console.log(error); // Xử lý lỗi
            }
        })
    }
</script>

</html>