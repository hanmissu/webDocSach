<?php
class quanLySach_transient
{
    public function getAllPublisher()
    {
        // Kiểm tra xem có transient đã lưu trữ hay chưa
        $transient_name = 'allPublisher';
        $posts = get_transient($transient_name);

        // Nếu transient đã tồn tại, trả về kết quả từ transient
        if ($posts !== false) {
            return $posts;
        }
        // Nếu transient không tồn tại, thực hiện truy vấn cơ sở dữ liệu để lấy dữ liệu mới
        include_once PLUGIN_DIR . "admin/Model/NSXModel.php";
        $NSX = new NSXModel(0, "");
        $data = $NSX->getAll();
        // Lưu kết quả của truy vấn vào transient trong 1 giờ
        set_transient($transient_name, $data, 3600);
        // Trả về kết quả từ truy vấn
        return $data;
    }
    public function getAllCategory()
    {
        // Kiểm tra xem có transient đã lưu trữ hay chưa
        $transient_name = 'allCategory';
        $posts = get_transient($transient_name);

        // Nếu transient đã tồn tại, trả về kết quả từ transient
        if ($posts !== false) {
            return $posts;
        }
        // Nếu transient không tồn tại, thực hiện truy vấn cơ sở dữ liệu để lấy dữ liệu mới
        include_once PLUGIN_DIR . "admin/Model/theLoaiModel.php";
        $theloai = new theLoaiModel(0, "");
        $datatheLoai = $theloai->getAll();

        // Lưu kết quả của truy vấn vào transient trong 1 giờ
        set_transient($transient_name, $datatheLoai, 3600);

        // Trả về kết quả từ truy vấn
        return $datatheLoai;
    }
    public function getAllProduct()
    {
        // Kiểm tra xem có transient đã lưu trữ hay chưa
        $transient_name = 'allProduct';
        $posts = get_transient($transient_name);

        // Nếu transient đã tồn tại, trả về kết quả từ transient
        if ($posts !== false) {
            return $posts;
        }
        // Nếu transient không tồn tại, thực hiện truy vấn cơ sở dữ liệu để lấy dữ liệu mới
        include_once PLUGIN_DIR . "admin/Model/sanPhamModel.php";
        $sanpham = new sanPhamModel(0, '', '', '', '', '', '', '', '', '');
        $dataSanPham = $sanpham->getAll();

        // Lưu kết quả của truy vấn vào transient trong 1 giờ
        set_transient($transient_name, $dataSanPham, 3600);

        // Trả về kết quả từ truy vấn
        return $dataSanPham;
    }
}
