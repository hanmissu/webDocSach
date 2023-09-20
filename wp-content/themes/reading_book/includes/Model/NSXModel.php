<?php
class NSXModel
{
    private $maNXB;
    private $tenNXB;

    public function __construct($maNXB, $tenNXB)
    {
        $this->maNXB = $maNXB;
        $this->tenNXB = $tenNXB;
    }

    public function insert()
    {
        global $wpdb;

        $result = $wpdb->insert(
            'nhaxuatban',
            array(
                'maNXB' => $this->maNXB,
                'tenNXB' => $this->tenNXB
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
            'nhaxuatban',
            array('maNXB' => $this->maNXB)
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
            'nhaxuatban',
            array('tenNXB' => $this->tenNXB),
            array('maNXB' => $this->maNXB)
        );
        if ($result == false) {
            return false;
        }
        return true;
    }

    public function getDatabyName($name)
    {
        global $wpdb;
        $results = $wpdb->get_results('SELECT * FROM nhaxuatban WHERE tenNXB=' . $name);
        return $results;
    }

    public function getAll()
    {
        global $wpdb;
        $results = $wpdb->get_results('SELECT * FROM nhaxuatban');
        return $results;
    }
    public function getDatabyID()
    {
        global $wpdb;
        $results = $wpdb->get_results('SELECT * FROM nhaxuatban WHERE maNXB=' . $this->maNXB);
        return $results;
    }
}
