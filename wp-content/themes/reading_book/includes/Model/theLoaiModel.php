<?php
class theLoaiModel {
    private $maTheLoai;
    private $tenTheLoai;

    public function __construct($maTheLoai, $tenTheLoai) {
        $this->maTheLoai = $maTheLoai;
        $this->tenTheLoai = $tenTheLoai;
    }

    public function insert() {
        global $wpdb;

       $result= $wpdb->insert(
            'theloai',
            array(
                'maTheLoai' => $this->maTheLoai,
                'tenTheLoai' => $this->tenTheLoai
            )
        );
        if($result == false){
            return false;
        }
        return true;
    }

    public function delete() {
        global $wpdb;
        $result=$wpdb->delete(
            'theloai',
            array('maTheLoai' => $this->maTheLoai)
        );
        if($result == false){
            return false;
        }
        return true;
    }

    public function update() {
        global $wpdb;
        //$result = $wpdb->update($table_name, $data, $where);
       $result= $wpdb->update(
            'theloai',
            array('tenTheLoai' => $this->tenTheLoai),
            array('maTheLoai' => $this->maTheLoai)
        );
        if($result == false){
            return false;
        }
        return true;
    }

    public function getDatabyName($name){
        global $wpdb;
        $results = $wpdb->get_results( 'SELECT * FROM theloai WHERE tenTheLoai='.$name );
        return $results;
    }
    public function getDatabyID(){
        global $wpdb;
        $results = $wpdb->get_results( 'SELECT * FROM theloai WHERE maTheLoai='.$this->maTheLoai );
        return $results;
    }
    public function getAll(){
        global $wpdb;
        $results = $wpdb->get_results( 'SELECT * FROM theloai' );
        return $results;
    }
}
