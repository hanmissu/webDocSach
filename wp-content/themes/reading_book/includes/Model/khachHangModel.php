<?php
class khachHangModel
{
    private $maKH;
    private $hoTenKH;
    private $SDT;
    private $email;
    private $maXacThucEmail;
    private $tenDangNhap;
    private $matKhau;
    private $trangThai;
    private $gioiTinh;
    private $ngaySinh;
    private $ngayDangKy;
    private $idFacebook;
    private $idGoogle;


    public function __construct(
        $maKH,
        $hoTenKH,
        $SDT,
        $email,
        $maXacThucEmail,
        $tenDangNhap,
        $matKhau,
        $trangThai,
        $gioiTinh,
        $ngaySinh,
        $ngayDangKy,
        $idFacebook,
        $idGoogle
    ) {
        $this->maKH = $maKH;
        $this->hoTenKH = $hoTenKH;
        $this->SDT = $SDT;
        $this->email = $email;
        $this->maXacThucEmail = $maXacThucEmail;
        $this->tenDangNhap = $tenDangNhap;
        $this->matKhau = $matKhau;
        $this->trangThai = $trangThai;
        $this->gioiTinh = $gioiTinh;
        $this->ngaySinh = $ngaySinh;
        $this->ngayDangKy = $ngayDangKy;
        $this->idFacebook = $idFacebook;
        $this->idGoogle = $idGoogle;
    }

    public function insert()
    {
        global $wpdb;
        $table_name = 'khachhang';

        $result = $wpdb->insert(
            $table_name,
            array(
                'maKH' => $this->maKH,
                'hoTenKH' => $this->hoTenKH,
                'SDT' => $this->SDT,
                'email' => $this->email,
                'maXacThucEmail' => $this->maXacThucEmail,
                'tenDangNhap' => $this->tenDangNhap,
                'matKhau' => $this->matKhau,
                'trangThai' => $this->trangThai,
                'gioiTinh' => $this->gioiTinh,
                'ngaySinh' => $this->ngaySinh,
                'ngayDangKy' => $this->ngayDangKy,
                'idFacebook' => $this->idFacebook,
                'idGoogle' => $this->idGoogle,
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
        $table_name = 'khachhang';

        $result = $wpdb->delete(
            $table_name,
            array(
                'maKH' => $this->maKH,
                'hoTenKH' => $this->hoTenKH,
                'SDT' => $this->SDT,
                'email' => $this->email,
                'maXacThucEmail' => $this->maXacThucEmail,
                'tenDangNhap' => $this->tenDangNhap,
                'trangThai' => $this->trangThai,
                'gioiTinh' => $this->gioiTinh,
                'ngaySinh' => $this->ngaySinh,
                'ngayDangKy' => $this->ngayDangKy,
                'idFacebook' => $this->idFacebook,
                'idGoogle' => $this->idGoogle,
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
        $table_name = 'khachhang';
        $result = $wpdb->update(
            $table_name,
            array(
                'hoTenKH' => $this->hoTenKH,
                'SDT' => $this->SDT,
                'trangThai' => $this->trangThai,
                'gioiTinh' => $this->gioiTinh,
                'ngaySinh' => $this->ngaySinh,
            ),
            array('maKH' => $this->maKH)
        );

        if ($result == false) {
            print_r($wpdb->last_error);
            return false;
        }
        return true;
    }
    public function updatePassword()
    {
        global $wpdb;
        $table_name = 'khachhang';
        $result = $wpdb->update(
            $table_name,
            array(
                'matKhau' => $this->matKhau,
            ),
            array('maKH' => $this->maKH)
        );

        if ($result == false) {
            var_dump($wpdb->last_error);
            return false;
        }
        return true;
    }
    public function resetPassword()
    {
        global $wpdb;
        $table_name = 'khachhang';
        $result = $wpdb->update(
            $table_name,
            array(
                'matKhau' => $this->matKhau,
            ),
            array('email' => $this->email)
        );

        if ($result == false) {
            var_dump($wpdb->last_error);
            return false;
        }
        return true;
    }
    public function getDataByID()
    {
        global $wpdb;
        $table_name = 'khachhang';
        $results = $wpdb->get_results("SELECT * FROM khachhang WHERE maKH=$this->maKH");
        return $results;
    }
    public function getDataByLoginName()
    {
        global $wpdb;
        $table_name = 'khachhang';
        $results = $wpdb->get_results("SELECT * FROM khachhang WHERE tenDangNhap='$this->tenDangNhap'");
        return $results;
    }
    public function getDataByEmail()
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM khachhang WHERE email='$this->email'");
        return $results;
    }
    public function updateStatus()
    {
        global $wpdb;
        $results = $wpdb->get_results("UPDATE khachhang SET maXacThucEmail = NULL, trangThai = 1 WHERE email = '$this->email'");
        return $results;
    }
}
