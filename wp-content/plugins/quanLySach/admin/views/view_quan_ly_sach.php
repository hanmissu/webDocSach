<?php
global $hosting;
include_once PLUGIN_DIR . "admin/Model/khachHangModel.php";
$khachhang = new khachHangModel(0, "", "", "", "", "", "", "", "", "", "", "", "");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once PLUGIN_DIR . 'admin/views/head.php' ?>
</head>

<body>
    <div hidden id="spinner" role="status" class="spinner-border"></div>
    <div class="row">
        <div class="col-12">
            <h4>TÀI KHOẢN</h4>
            <span>
                Lọc
                <select id="select" class="form-select" aria-label="Default select example">
                    <option selected value="month">Theo Tháng</option>
                    <option value="year">Theo Năm</option>
                </select>
            </span>
            <span>Tổng : <?php echo count($khachhang->getAll()) ?></span>
            <div id="account" style="height: 250px;"></div>
        </div>
    </div>
    <hr>
    <div class="row mb-4">
        <div class="col-12">
            <h4>YÊU THÍCH</h4>
            <div id="favourite" style="height: 250px;"></div>
        </div>

    </div>
    <hr>
    <div class="row mb-4">
        <div class="col-12">
            <h4>LƯỢT ĐỌC</h4>
            <div id="view" style="height: 250px;"></div>
        </div>

    </div>
</body>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<!-- dashboard -->
<script src="<?php echo PLUGIN_URL . 'admin/js/js.js' ?>">
</script>
<script>
    jQuery(document).ready(function() {
        var barAcount;
        var barFavourite;
        var barView;
        // tài khoản
        if (localStorage.getItem('dashboardAccount') != null) {
            console.log(localStorage.getItem('dashboardAccount'));
            if (JSON.parse(localStorage.getItem('dashboardAccount'))[0].year) {
                var month_year = 'year';
            } else if (JSON.parse(localStorage.getItem('dashboardAccount'))[0].month) {
                var month_year = 'month';
            }
            barAcount = new Morris.Bar({
                element: 'account',
                xkey: month_year,
                ykeys: ['active', 'deactive'],
                labels: ['Đã kích hoạt', 'Chưa kích hoạt'],
                hideHover: true,
                barColors: function(row, series, type) {
                    if (series.key === 'active') {
                        return '#00FF00'; // Màu xanh lá cây cho giá trị "active"
                    } else if (series.key === 'deactive') {
                        return '#FF0000'; // Màu đỏ cho giá trị "deactive"
                    }
                }
            });
            barAcount.setData(JSON.parse(localStorage.getItem('dashboardAccount')));
        }

        // yêu thích
        if (localStorage.getItem('dashboardFavourite') !== null) {
            barFavourite = new Morris.Bar({
                element: 'favourite',
                xkey: 'tenSanPham',
                ykeys: ['luotthich'],
                labels: ['Lượt thích'],
                hideHover: true,
                xLabelAngle: 45, // Góc quay của nhãn trên trục x
                xLabelMargin: 10, // Khoảng cách giữa nhãn và trục x
                resize: true
            });
            barFavourite.setData(JSON.parse(localStorage.getItem('dashboardFavourite')));
        }
        // lượt đọc
        if (localStorage.getItem('dashboardView') !== null) {
            barView = new Morris.Bar({
                element: 'view',
                xkey: 'tenSanPham',
                ykeys: ['luotDoc'],
                labels: ['Lượt Đọc'],
                hideHover: true,
                barColors: ['#00adef'],
                xLabelAngle: 45, // Góc quay của nhãn trên trục x
                xLabelMargin: 10, // Khoảng cách giữa nhãn và trục x
                resize: true
            });
            barView.setData(JSON.parse(localStorage.getItem('dashboardView')));
        }
        /////////////////////////////////////////////////
        jQuery(document).on('change', '#select', thongKeTaiKhoan);

        function thongKeTaiKhoan() {
            var select = jQuery('#select').val();
            jQuery.ajax({
                url: hosting + 'wp-admin/admin-ajax.php', // URL Ajax
                type: 'POST',
                dataType: 'JSON',
                data: {
                    action: 'dashboardAccount',
                    select: select
                },
                success: function(response) {
                    // barAcount.setData(response);
                    if (localStorage.getItem('dashboardAccount') === null || localStorage.getItem('dashboardAccount') !== JSON.stringify(response)) {
                        if (barAcount) {
                            jQuery("#account").empty();
                        }
                        barAcount = new Morris.Bar({
                            element: 'account',
                            xkey: select,
                            ykeys: ['active', 'deactive'],
                            labels: ['Đã kích hoạt', 'Chưa kích hoạt'],
                            hideHover: true,
                            barColors: function(row, series, type) {
                                if (series.key === 'active') {
                                    return '#00FF00'; // Màu xanh lá cây cho giá trị "active"
                                } else if (series.key === 'deactive') {
                                    return '#FF0000'; // Màu đỏ cho giá trị "deactive"
                                }
                            }
                        });

                        localStorage.setItem('dashboardAccount', JSON.stringify(response));
                        barAcount.setData(JSON.parse(localStorage.getItem('dashboardAccount')));
                        console.log(localStorage.getItem('dashboardAccount'));
                    } else {
                        if (barAcount) {
                            jQuery("#account").empty();
                        }
                        barAcount = new Morris.Bar({
                            element: 'account',
                            xkey: select,
                            ykeys: ['active', 'deactive'],
                            labels: ['Đã kích hoạt', 'Chưa kích hoạt'],
                            hideHover: true,
                            barColors: function(row, series, type) {
                                if (series.key === 'active') {
                                    return '#00FF00'; // Màu xanh lá cây cho giá trị "active"
                                } else if (series.key === 'deactive') {
                                    return '#FF0000'; // Màu đỏ cho giá trị "deactive"
                                }
                            }
                        });
                        barAcount.setData(JSON.parse(localStorage.getItem('dashboardAccount')));
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error); // Xử lý lỗi
                }
            });
        }

        function thongTheLuotThich() {
            jQuery.ajax({
                url: hosting + 'wp-admin/admin-ajax.php', // URL Ajax
                type: 'POST',
                dataType: 'JSON',
                data: {
                    action: 'dashboardFavourite',
                },
                success: function(response) {
                    if (localStorage.getItem('dashboardFavourite') === null || localStorage.getItem('dashboardFavourite') !== JSON.stringify(response)) {
                        if (barFavourite) {
                            jQuery("#favourite").empty();
                        }
                        barFavourite = new Morris.Bar({
                            element: 'favourite',
                            xkey: 'tenSanPham',
                            ykeys: ['luotthich'],
                            labels: ['Lượt thích'],
                            hideHover: true,
                            xLabelAngle: 45, // Góc quay của nhãn trên trục x
                            xLabelMargin: 10, // Khoảng cách giữa nhãn và trục x
                            resize: true
                        });

                        localStorage.setItem('dashboardFavourite', JSON.stringify(response));
                        barFavourite.setData(JSON.parse(localStorage.getItem('dashboardFavourite')));
                        console.log(localStorage.getItem('dashboardFavourite'));
                        return;
                    } else {
                        if (barFavourite) {
                            jQuery("#favourite").empty();
                        }
                        barFavourite = new Morris.Bar({
                            element: 'favourite',
                            xkey: 'tenSanPham',
                            ykeys: ['luotthich'],
                            labels: ['Lượt thích'],
                            hideHover: true,
                            xLabelAngle: 45, // Góc quay của nhãn trên trục x
                            xLabelMargin: 10, // Khoảng cách giữa nhãn và trục x
                            resize: true
                        });
                        barFavourite.setData(JSON.parse(localStorage.getItem('dashboardFavourite')));
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error); // Xử lý lỗi
                }
            });
        }

        function thongKeLuotDoc() {
            jQuery.ajax({
                url: hosting + 'wp-admin/admin-ajax.php', // URL Ajax
                type: 'POST',
                dataType: 'JSON',
                data: {
                    action: 'dashboardView',
                },
                success: function(response) {
                    //console.log(response);
                    if (localStorage.getItem('dashboardView') === null || localStorage.getItem('dashboardView') !== JSON.stringify(response)) {
                        if (barView) {
                            jQuery("#view").empty();
                        }
                        barView = new Morris.Bar({
                            element: 'view',
                            xkey: 'tenSanPham',
                            ykeys: ['luotDoc'],
                            labels: ['Lượt Đọc'],
                            hideHover: true,
                            barColors: ['#00adef'],
                            xLabelAngle: 45, // Góc quay của nhãn trên trục x
                            xLabelMargin: 10, // Khoảng cách giữa nhãn và trục x
                            resize: true
                        });

                        localStorage.setItem('dashboardView', JSON.stringify(response));
                        barView.setData(JSON.parse(localStorage.getItem('dashboardView')));
                        console.log(localStorage.getItem('dashboardView'));
                        return;
                    } else {
                        if (barView) {
                            jQuery("#view").empty();
                        }
                        barView = new Morris.Bar({
                            element: 'view',
                            xkey: 'tenSanPham',
                            ykeys: ['luotDoc'],
                            labels: ['Lượt Đọc'],
                            hideHover: true,
                            barColors: ['#00adef'],
                            xLabelAngle: 45, // Góc quay của nhãn trên trục x
                            xLabelMargin: 10, // Khoảng cách giữa nhãn và trục x
                            resize: true
                        });
                        barView.setData(JSON.parse(localStorage.getItem('dashboardView')));
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error); // Xử lý lỗi
                }
            });
        }
        setInterval(thongTheLuotThich, 5000);
        setInterval(thongKeTaiKhoan, 5000);
        setInterval(thongKeLuotDoc, 5000);
    });
</script>

</html>