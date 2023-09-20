<?php
class danhGiaSanPhamModel
{
    private $id;
    private $diemDanhGia;
    private $noiDung;
    private $ngaybl;
    private $ngayChinhSua;
    private $maSanPham;
    private $maKH;
    private $trangThai;
    public function __construct($id, $diemDanhGia, $noiDung, $ngaybl, $ngayChinhSua, $maSanPham, $maKH, $trangThai)
    {
        $this->id = $id;
        $this->diemDanhGia = $diemDanhGia;
        $this->noiDung = $noiDung;
        $this->ngaybl = $ngaybl;
        $this->ngayChinhSua = $ngayChinhSua;
        $this->maSanPham = $maSanPham;
        $this->maKH = $maKH;
        $this->trangThai = $trangThai;
    }

    public function insert()
    {
        global $wpdb;
        $result = $wpdb->insert(
            'danhgiasanpham',
            array(
                'id' => $this->id,
                'diemDanhGia' => $this->diemDanhGia,
                'noiDung' => $this->noiDung,
                'ngaybl' => $this->ngaybl,
                'ngayChinhSua' => $this->ngayChinhSua,
                'maSanPham' => $this->maSanPham,
                'maKH' => $this->maKH,
                'trangThai' => $this->trangThai,
            )
        );
        if ($result == false) {
            return false;
        }
        return true;
    }

    public function delete()
    {
        global $wpdb;
        $result = $wpdb->delete(
            'danhgiasanpham',
            array('id' => $this->id)
        );
        if ($result == false) {
            return false;
        }
        return true;
    }
    public function deleteByIdCustomer()
    {
        global $wpdb;
        $result = $wpdb->delete(
            'danhgiasanpham',
            array('maKH' => $this->maKH)
        );
        if ($result == false) {
            return false;
        }
        return true;
    }
    public function deleteByIdProduct()
    {
        global $wpdb;
        $result = $wpdb->delete(
            'danhgiasanpham',
            array('maSanPham' => $this->maSanPham)
        );
        if ($result == false) {
            return false;
        }
        return true;
    }
    public function update()
    {
        global $wpdb;
        //$result = $wpdb->update($table_name, $data, $where);
        $result =  $wpdb->update(
            'danhgiasanpham',
            array(
                'diemDanhGia' => $this->diemDanhGia,
                'noiDung' => $this->noiDung,
                'ngaybl' => $this->ngaybl,
                'ngayChinhSua' => $this->ngayChinhSua,
                'maSanPham' => $this->maSanPham,
                'maKH' => $this->maKH,
            ),
            array('id' => $this->id)
        );
        if ($result == false) {
            return false;
        }
        return true;
    }
    public function updateStatus()
    {
        global $wpdb;
        $result =  $wpdb->update(
            'danhgiasanpham',
            array(
                'trangThai' => $this->trangThai,
            ),
            array('id' => $this->id)
        );
        if ($result == false) {
            return false;
        }
        return true;
    }
    public function getAll()
    {
        global $wpdb;
        $results = $wpdb->get_results('SELECT * FROM danhgiasanpham ORDER BY id DESC');
        return $results;
    }
    public function getDatabyIDProduct()
    {
        global $wpdb;
        $results = $wpdb->get_results('SELECT * FROM danhgiasanpham WHERE maSanPham=' . $this->maSanPham);
        return $results;
    }
    public function calculate_average()
    {
        global $wpdb;
        // Truy vấn để tính trung bình cộng
        $average = $wpdb->get_var("SELECT AVG(diemDanhGia) FROM danhgiasanpham WHERE maSanPham=$this->maSanPham");
        return $average;
    }
    public function getDataByIdCustomer($id = null)
    {
        global $wpdb;
        $valueId = $id != null ? $id : $this->maKH;
        $results = $wpdb->get_results("SELECT * FROM danhgiasanpham WHERE maKH= $valueId AND maSanPham=$this->maSanPham");
        return $results;
    }
}
