<?php
/*
 * Plugin Name:       Quản lý sách
 * Plugin URI:        #
 * Description:       
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Chương hân
 * Author URI:        #
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        #
 * Text Domain:       quanLySach
 * Domain Path:       /languages
 */

define('PLUGIN_URL', plugin_dir_url(__FILE__));
define('PLUGIN_DIR', plugin_dir_path(__FILE__));
global  $hosting;
$hosting = 'http://localhost/wordpress/';
// khi duoc kich hoat
// khhi tat di
register_deactivation_hook(__FILE__, 'wp_de_quanLySach');
session_start();
if (!is_admin()) {
	// User
} else {
	// Admin
	include_once(PLUGIN_DIR . 'includes/admin.php');
	new admin();
	include_once(PLUGIN_DIR . 'admin/Controller/khachHangController.php');
	include_once(PLUGIN_DIR . 'admin/Controller/sanPhamController.php');
	include_once(PLUGIN_DIR . 'admin/Controller/theLoaiController.php');
	include_once(PLUGIN_DIR . 'admin/Controller/NSXController.php');
	include_once(PLUGIN_DIR . 'includes/san-Pham.php');
	include_once(PLUGIN_DIR . 'includes/the-Loai.php');
	include_once(PLUGIN_DIR . 'admin/Controller/danhGiaSanPhamController.php');
	add_action('admin_init', 'restrict_access_to_edit_product_page');
	function restrict_access_to_edit_product_page()
	{
		// Kiểm tra nếu trang đang được truy cập là quản lý sách và không có tham số "action"
		if (isset($_GET['page']) && $_GET['page'] === 'quan_ly_sach_edit_prouct' && !isset($_GET['maSanPham'])) {
			wp_redirect(admin_url('admin.php?page=quan_ly_sach_product_manager'));
			exit;
		}
	}
	add_action('wp_ajax_dashboardAccount', 'dashboardAccount');
	add_action('wp_ajax_nopriv_dashboardAccount', 'dashboardAccount');
	function dashboardAccount()
	{
		include_once PLUGIN_DIR . "admin/Model/khachHangModel.php";
		$khachhang = new khachHangModel(0, "", "", "", "", "", "", "", "", "", "", "", "");
		if ($_POST['select'] == 'month') {
			$month = $khachhang->getMonth();
			for ($i = 0; $i < count($month); $i++) {
				$dataMonth = $khachhang->getDataByMonth($month[$i]->month);
				$active = 0;
				$deactive = 0;
				for ($j = 0; $j < count($dataMonth); $j++) {
					if ($dataMonth[$j]->trangThai == 0) {
						$deactive++;
					} else {
						$active++;
					}
				}
				$response[$i] = array(
					'month' => $month[$i]->month,
					'active' => $active,
					'deactive' => $deactive,
				);
			}
			echo json_encode($response);
			exit;
		}
		if ($_POST['select'] == 'year') {
			$year = $khachhang->getYear();
			for ($i = 0; $i < count($year); $i++) {
				$dataYear = $khachhang->getDataByYear($year[$i]->year);
				$active = 0;
				$deactive = 0;
				for ($j = 0; $j < count($dataYear); $j++) {
					if ($dataYear[$j]->trangThai == 0) {
						$deactive++;
					} else {
						$active++;
					}
				}
				$response[$i] = array(
					'year' => $year[$i]->year,
					'active' => $active,
					'deactive' => $deactive,
				);
			}
			echo json_encode($response);
			exit;
		}
	}
	add_action('wp_ajax_dashboardFavourite', 'dashboardFavourite');
	add_action('wp_ajax_nopriv_dashboardFavourite', 'dashboardFavourite');
	function dashboardFavourite()
	{
		include_once PLUGIN_DIR . "admin/Model/sanPhamYeuThichModel.php";
		include_once PLUGIN_DIR . 'admin/Model/sanPhamModel.php';
		$yeuthich = new sanPhamYeuThichModel(0, "", "", "");
		$data = $yeuthich->getProductFavorites();
		for ($i = 0; $i < count($data); $i++) {
			$sanpham = new sanPhamModel($data[$i]->maSanPham, "", "", "", "", "", "", "", "", "", "");
			$response[$i] = array(
				'tenSanPham' => $sanpham->getDatabyID()[0]->tenSanPham,
				'luotthich' => $data[$i]->luotthich,
			);
		}
		echo json_encode($response);
		exit;
	}

	add_action('wp_ajax_dashboardView', 'dashboardView');
	add_action('wp_ajax_nopriv_dashboardView', 'dashboardView');
	function dashboardView()
	{
		include_once PLUGIN_DIR . 'admin/Model/sanPhamModel.php';
		$sanpham = new sanPhamModel(0, "", "", "", "", "", "", "", "", "", "");
		$data = $sanpham->getView();
		echo json_encode($data);
		exit;
	}

	add_action('wp_ajax_loadCmt', 'loadCmt');
	add_action('wp_ajax_nopriv_loadCmt', 'loadCmt');
	function loadCmt()
	{
		include_once PLUGIN_DIR . 'admin/Model/danhGiaSanPhamModel.php';
		include_once PLUGIN_DIR . 'admin/Model/khachHangModel.php';
		include_once PLUGIN_DIR . 'admin/Model/sanPhamModel.php';
	}
	add_action('wp_ajax_Adminsearch', 'Adminsearch');
	add_action('wp_ajax_nopriv_Adminsearch', 'Adminsearch');
	function Adminsearch()
	{
		include_once PLUGIN_DIR . 'admin/Model/theLoaiModel.php';
		include_once PLUGIN_DIR . 'admin/Model/NSXModel.php';
		include_once PLUGIN_DIR . 'admin/Model/sanPhamModel.php';
		$sanpham = new sanPhamModel(0, "", "", "", "", "", "", "", "", "", "", "");
		if ($_POST['select'] == 'tacgia') {
			echo 'aa';
			$allSanPham = $sanpham->searchByAuthor($_POST['keysearh']);
		} else {
			echo 'nn';
			$allSanPham = $sanpham->searchByName($_POST['keysearh']);
		}
?>

		<?php
		for ($i = 0; $i < count($allSanPham); $i++) {

			$theloai = new theLoaiModel($allSanPham[$i]->maTheLoai, '');
			// lấy tên thể loại
			$dataTheLoai = $theloai->getDatabyID();
			$tenTheLoai = $dataTheLoai[0]->tenTheLoai;

			// lấy tên nhà sản xuất
			$NSX = new NSXModel($allSanPham[$i]->maNSX, '');
			$dataNSX = $NSX->getDatabyID();
			$tenNSX = $dataNSX[0]->tenNXB;
			//html
		?>
			<tr>
				<td><?php echo  $allSanPham[$i]->maSanPham ?></td>
				<td><?php echo  $allSanPham[$i]->tenSanPham ?></td>
				<td><?php echo  $allSanPham[$i]->tacGia ?></td>
				<td><?php echo  $allSanPham[$i]->dichGia ?></td>
				<td><?php echo  $allSanPham[$i]->namSanXuat ?></td>
				<td><img style="widtd:100px;height:150px" src="<?php echo PLUGIN_URL . 'images/' . $tenTheLoai . '/' . $allSanPham[$i]->anhDaiDien ?>">
				</td>
				<td><span class="line-5"><?php echo mb_substr($allSanPham[$i]->gioiThieu, 0, 500, "UTF-8") . ' ... ';   ?></span></td>
				<td>
					<?php
					echo  $tenTheLoai
					?>
				</td>
				<td>
					<?php

					echo  $tenNSX

					?>

				</td>
				<td>
					<a onclick="showAlert(<?php echo $allSanPham[$i]->maSanPham  ?>)">
						<i class="icon-trash" style="font-size:20px;color:red;cursor: pointer;">xóa</i>
					</a>
					<a href="<?php echo esc_url(add_query_arg(array('maSanPham' => $allSanPham[$i]->maSanPham), admin_url('admin.php?page=quan_ly_sach_edit_prouct'))); ?>"><i class="bi bi-x-circle" style="font-size:20px;color:green">sửa</i></a>
				</td>

			</tr>

		<?php
			//end html
		}
		?>

<?php
		exit;
	}
}
