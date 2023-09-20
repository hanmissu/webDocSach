<?php
class sanPhamModel
{
    private $maSanPham;
    private $tenSanPham;
    private $tacGia;
    private $dichGia;
    private $namSanXuat;
    private $tenFile;
    private $anhDaiDien;
    private $gioiThieu;
    private $maTheLoai;
    private $maNSX;
    private $luotDoc;
    public function __construct(
        $maSanPham,
        $tenSanPham,
        $tacGia,
        $dichGia,
        $namSanXuat,
        $tenFile,
        $anhDaiDien,
        $gioiThieu,
        $maTheLoai,
        $maNSX,
        $luotDoc
    ) {
        $this->maSanPham = $maSanPham;
        $this->tenSanPham = $tenSanPham;
        $this->tacGia = $tacGia;
        $this->dichGia = $dichGia;
        $this->namSanXuat = $namSanXuat;
        $this->tenFile = $tenFile;
        $this->anhDaiDien = $anhDaiDien;
        $this->gioiThieu = $gioiThieu;
        $this->maTheLoai = $maTheLoai;
        $this->maNSX = $maNSX;
        $this->luotDoc = $luotDoc;
    }

    public function insert()
    {
        global $wpdb;
        $result = $wpdb->insert(
            'sanpham',
            array(
                'maSanPham' => 0,
                'tenSanPham' => $this->tenSanPham,
                'tacGia' => $this->tacGia,
                'dichGia' => $this->dichGia,
                'namSanXuat' => $this->namSanXuat,
                'tenFile' => $this->tenFile,
                'anhDaiDien' => $this->anhDaiDien,
                'gioiThieu' => $this->gioiThieu,
                'maTheLoai' => $this->maTheLoai,
                'maNSX' => $this->maNSX,
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
            'sanpham',
            array(
                'maSanPham' => $this->maSanPham,
            )
        );
        if ($result == false) {
            return false;
        }
        return true;
    }

    public function deleteByIdCategory()
    {
        global $wpdb;
        $result = $wpdb->delete(
            'sanpham',
            array(
                'maTheLoai' => $this->maTheLoai,
            )
        );
        if ($result == false) {
            return false;
        }
        return true;
    }
    public function deleteByIdPubliser()
    {
        global $wpdb;
        $result = $wpdb->delete(
            'sanpham',
            array(
                'maNSX' => $this->maNSX,
            )
        );
        if ($result == false) {
            return false;
        }
        return true;
    }
    public function update()
    {
        global $wpdb;


        $result =  $wpdb->update(
            'sanpham',
            array(
                'tenSanPham' => $this->tenSanPham,
                'tacGia' => $this->tacGia,
                'dichGia' => $this->dichGia,
                'namSanXuat' => $this->namSanXuat,
                'tenFile' => $this->tenFile,
                'anhDaiDien' => $this->anhDaiDien,
                'gioiThieu' => $this->gioiThieu,
                'maTheLoai' => $this->maTheLoai,
                'maNSX' => $this->maNSX,
            ),
            array('maSanPham' => $this->maSanPham)
        );
        if ($result == false) {
            return false;
        }
        return true;
    }
    public function getDatabyName()
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM sanpham WHERE tenSanPham= '$this->tenSanPham'");
        return $results;
    }
    public function getView()
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT tenSanPham, luotDoc FROM sanpham WHERE luotDoc > 0 ORDER BY luotDoc DESC LIMIT 20");
        return $results;
    }
    public function getDatabyImg()
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT anhDaiDien FROM sanpham WHERE anhDaiDien = '$this->anhDaiDien'");
        return $results;
    }
    public function getDatabyFile()
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT tenFile FROM sanpham WHERE tenFile= '$this->tenFile'");
        return $results;
    }
    public function getDatabyID()
    {
        global $wpdb;
        $results = $wpdb->get_results('SELECT * FROM sanpham WHERE maSanPham=' . $this->maSanPham);
        return $results;
    }
    public function getAll()
    {
        global $wpdb;
        $results = $wpdb->get_results('SELECT * FROM sanpham ORDER BY maSanPham DESC');
        return $results;
    }
    public function getDatabyIDCategory()
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM sanpham where maTheLoai=$this->maTheLoai");
        return $results;
    }
    public function getDatabyIDPubliser()
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM sanpham where maNSX=$this->maNSX");
        return $results;
    }
    public function searchByName($key)
    {
        global $wpdb;
        $key = '%' . $wpdb->esc_like($key) . '%'; // Chuẩn bị giá trị tìm kiếm
        $query = $wpdb->prepare("SELECT * FROM sanpham WHERE tenSanPham LIKE %s", $key);
        $results = $wpdb->get_results($query);
        return $results;
    }
    public function searchByAuthor($key)
    {
        global $wpdb;
        $key = '%' . $wpdb->esc_like($key) . '%'; // Chuẩn bị giá trị tìm kiếm
        $query = $wpdb->prepare("SELECT * FROM sanpham WHERE tacGia LIKE %s", $key);
        $results = $wpdb->get_results($query);
        return $results;
    }
}
