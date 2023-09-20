-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th7 30, 2023 lúc 09:23 AM
-- Phiên bản máy phục vụ: 8.0.31
-- Phiên bản PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webdocsach`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhgiasanpham`
--

DROP TABLE IF EXISTS `danhgiasanpham`;
CREATE TABLE IF NOT EXISTS `danhgiasanpham` (
  `id` int NOT NULL AUTO_INCREMENT,
  `diemDanhGia` int DEFAULT NULL,
  `noiDung` varchar(255) DEFAULT NULL,
  `ngaybl` char(50) DEFAULT NULL,
  `ngayChinhSua` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `maSanPham` int NOT NULL,
  `maKH` int NOT NULL,
  `trangThai` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_danhGiaSanPham_khachHang` (`maKH`),
  KEY `FK_danhGiaSanPham_sanPham` (`maSanPham`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

DROP TABLE IF EXISTS `khachhang`;
CREATE TABLE IF NOT EXISTS `khachhang` (
  `maKH` int NOT NULL AUTO_INCREMENT,
  `hoTenKH` varchar(50) NOT NULL,
  `SDT` char(10) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `maXacThucEmail` int DEFAULT NULL,
  `tenDangNhap` varchar(255) DEFAULT NULL,
  `matKhau` varchar(255) DEFAULT NULL,
  `trangThai` int DEFAULT NULL,
  `gioiTinh` char(10) DEFAULT NULL,
  `ngaySinh` char(50) DEFAULT NULL,
  `ngayDangKy` char(50) NOT NULL,
  `idFacebook` varchar(255) DEFAULT NULL,
  `idGoogle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`maKH`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `SDT` (`SDT`),
  UNIQUE KEY `idGoogle` (`idGoogle`),
  UNIQUE KEY `idFacebook` (`idFacebook`),
  UNIQUE KEY `tenDangNhap` (`tenDangNhap`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhaxuatban`
--

DROP TABLE IF EXISTS `nhaxuatban`;
CREATE TABLE IF NOT EXISTS `nhaxuatban` (
  `maNXB` int NOT NULL AUTO_INCREMENT,
  `tenNXB` varchar(50) NOT NULL,
  PRIMARY KEY (`maNXB`),
  UNIQUE KEY `tenNXB` (`tenNXB`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

DROP TABLE IF EXISTS `sanpham`;
CREATE TABLE IF NOT EXISTS `sanpham` (
  `maSanPham` int NOT NULL AUTO_INCREMENT,
  `tenSanPham` varchar(255) NOT NULL,
  `tacGia` varchar(50) NOT NULL,
  `dichGia` varchar(50) DEFAULT NULL,
  `namSanXuat` varchar(4) DEFAULT NULL,
  `tenFile` varchar(255) NOT NULL,
  `anhDaiDien` varchar(255) NOT NULL,
  `gioiThieu` varchar(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `maTheLoai` int NOT NULL,
  `maNSX` int NOT NULL,
  `luotDoc` int NOT NULL,
  PRIMARY KEY (`maSanPham`),
  UNIQUE KEY `tenSanPham` (`tenSanPham`),
  KEY `FKsanPham290301` (`maNSX`),
  KEY `FKsanPham801488` (`maTheLoai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanphamyeuthich`
--

DROP TABLE IF EXISTS `sanphamyeuthich`;
CREATE TABLE IF NOT EXISTS `sanphamyeuthich` (
  `STT` int NOT NULL AUTO_INCREMENT,
  `tenSanPham` varchar(255) NOT NULL,
  `maSanPham` int NOT NULL,
  `maKH` int NOT NULL,
  PRIMARY KEY (`STT`,`maSanPham`,`maKH`),
  KEY `FKsanPhamYeu390483` (`maKH`),
  KEY `FKsanPhamYeu234920` (`maSanPham`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `theloai`
--

DROP TABLE IF EXISTS `theloai`;
CREATE TABLE IF NOT EXISTS `theloai` (
  `maTheLoai` int NOT NULL AUTO_INCREMENT,
  `tenTheLoai` varchar(50) NOT NULL,
  PRIMARY KEY (`maTheLoai`),
  UNIQUE KEY `tenTheLoai` (`tenTheLoai`),
  UNIQUE KEY `maTheLoai` (`maTheLoai`),
  UNIQUE KEY `tenTheLoai_2` (`tenTheLoai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `danhgiasanpham`
--
ALTER TABLE `danhgiasanpham`
  ADD CONSTRAINT `FK_danhGiaSanPham_khachHang` FOREIGN KEY (`maKH`) REFERENCES `khachhang` (`maKH`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_danhGiaSanPham_sanPham` FOREIGN KEY (`maSanPham`) REFERENCES `sanpham` (`maSanPham`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `FKsanPham290301` FOREIGN KEY (`maNSX`) REFERENCES `nhaxuatban` (`maNXB`),
  ADD CONSTRAINT `FKsanPham801488` FOREIGN KEY (`maTheLoai`) REFERENCES `theloai` (`maTheLoai`);

--
-- Các ràng buộc cho bảng `sanphamyeuthich`
--
ALTER TABLE `sanphamyeuthich`
  ADD CONSTRAINT `FKsanPhamYeu234920` FOREIGN KEY (`maSanPham`) REFERENCES `sanpham` (`maSanPham`),
  ADD CONSTRAINT `FKsanPhamYeu390483` FOREIGN KEY (`maKH`) REFERENCES `khachhang` (`maKH`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
