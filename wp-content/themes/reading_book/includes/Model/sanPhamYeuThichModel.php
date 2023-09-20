<?php
class sanPhamYeuThichModel
{
    private $STT;
    private $tenSanPham;
    private $maSanPham;
    private $maKH;

    public function __construct($STT, $tenSanPham, $maSanPham, $maKH)
    {
        $this->STT = $STT;
        $this->tenSanPham = $tenSanPham;
        $this->maSanPham = $maSanPham;
        $this->maKH = $maKH;
    }

    public function insert()
    {
        global $wpdb;

        $result = $wpdb->insert(
            'sanphamyeuthich',
            array(
                'STT' => $this->STT,
                'tenSanPham' => $this->tenSanPham,
                'maSanPham' => $this->maSanPham,
                'maKH' => $this->maKH
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
            'sanphamyeuthich',
            array('STT' => $this->STT)
        );
        if ($result == false) {
            return false;
        }
        return true;
    }
    public function deleteByCustomerAndProc()
    {
        global $wpdb;
        $result = $wpdb->delete(
            'sanphamyeuthich',
            array(
                'maKH' => $this->maKH,
                'maSanPham' => $this->maSanPham
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
        //$result = $wpdb->update($table_name, $data, $where);
        $result = $wpdb->update(
            'sanphamyeuthich',
            array(
                'tenSanPham' => $this->tenSanPham,
                'maSanPham' => $this->maSanPham,
                'maKH' => $this->maKH
            ),
            array('STT' => $this->STT)
        );
        if ($result == false) {
            return false;
        }
        return true;
    }

    public function getDatabyName($name)
    {
        global $wpdb;
        $results = $wpdb->get_results('SELECT * FROM sanphamyeuthich WHERE tenSanPham=' . $name);
        return $results;
    }
    public function countFavourire()
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT COUNT(maSanPham) as luotThich FROM sanphamyeuthich WHERE maSanPham=$this->maSanPham");
        return $results;
    }
    public function getDatabyID()
    {
        global $wpdb;
        $results = $wpdb->get_results('SELECT * FROM sanphamyeuthich WHERE STT=' . $this->STT);
        return $results;
    }
    public function getAll()
    {
        global $wpdb;
        $results = $wpdb->get_results('SELECT * FROM sanphamyeuthich');
        return $results;
    }

    public function favourite_exists()
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM sanphamyeuthich WHERE maKH=$this->maKH AND maSanPham=$this->maSanPham");
        return $results;
    }
    public function getFavourite()
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM sanphamyeuthich WHERE maKH= $this->maKH");
        return $results;
    }
}
