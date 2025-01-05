-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2025 at 01:25 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employe`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `reset_id_daftar_pekerjaan` ()   BEGIN
    
    DECLARE max_id INT;

    
    CREATE TEMPORARY TABLE temp_siswa AS
    SELECT * FROM daftar_pekerjaan ORDER BY id;

    
    SET @num = 0;
    UPDATE temp_siswa SET id = (@num := @num + 1);

    
    DELETE FROM daftar_pekerjaan;

    
    INSERT INTO daftar_pekerjaan SELECT * FROM temp_siswa;

    
    DROP TEMPORARY TABLE temp_siswa;

    
    SELECT MAX(id) INTO max_id FROM daftar_pekerjaan;

    
    IF max_id IS NULL THEN
        SET max_id = 0;
    END IF;

    
    SET @query = CONCAT('ALTER TABLE daftar_pekerjaan AUTO_INCREMENT = ', max_id + 1);
    PREPARE stmt FROM @query;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `reset_id_pendaftar` ()   BEGIN
    
    DECLARE max_id INT DEFAULT 0;

    
    CREATE TEMPORARY TABLE temp_siswa AS
    SELECT * FROM pendaftar ORDER BY id;

    
    SET @num = 0;
    UPDATE temp_siswa SET id = (@num := @num + 1);

    
    DELETE FROM pendaftar;

    
    INSERT INTO pendaftar SELECT * FROM temp_siswa;

    
    DROP TEMPORARY TABLE temp_siswa;

    
    SELECT MAX(id) INTO max_id FROM pendaftar;

    
    IF max_id IS NULL THEN
        SET max_id = 0;
    END IF;

    
    SET @query = CONCAT('ALTER TABLE pendaftar AUTO_INCREMENT = ', max_id + 1);
    PREPARE stmt FROM @query;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `reset_id_pendaftar_umum` ()   BEGIN
    
    DECLARE max_id INT;

    
    CREATE TEMPORARY TABLE temp_siswa AS
    SELECT * FROM pendaftar_umum ORDER BY id;

    
    SET @num = 0;
    UPDATE temp_siswa SET id = (@num := @num + 1);

    
    DELETE FROM pendaftar_umum;

    
    INSERT INTO pendaftar_umum SELECT * FROM temp_siswa;

    
    DROP TEMPORARY TABLE temp_siswa;

    
    SELECT MAX(id) INTO max_id FROM pendaftar_umum;

    
    IF max_id IS NULL THEN
        SET max_id = 0;
    END IF;

    
    SET @query = CONCAT('ALTER TABLE pendaftar_umum AUTO_INCREMENT = ', max_id + 1);
    PREPARE stmt FROM @query;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('aktif','tidak aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `status`) VALUES
(1, 'admin', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `daftar_pekerjaan`
--

CREATE TABLE `daftar_pekerjaan` (
  `id` int(11) NOT NULL,
  `nama_pekerjaan` varchar(20) NOT NULL,
  `kategori` varchar(20) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `daftar_pekerjaan`
--

INSERT INTO `daftar_pekerjaan` (`id`, `nama_pekerjaan`, `kategori`, `deskripsi`) VALUES
(1, 'Developer Web', 'IT', 'Mengembangkan dan memelihara website perusahaan menggunakan berbagai teknologi web'),
(2, 'Administrator Sistem', 'IT', 'Mengelola server dan infrastruktur IT perusahaan, memastikan sistem berjalan dengan lancar'),
(3, 'Operator Produksi', 'Produksi', 'Mengoperasikan mesin dan perangkat dalam proses produksi untuk memastikan kualitas produk'),
(4, 'Supervisor Produksi', 'Produksi', 'Memantau dan mengawasi jalannya proses produksi agar sesuai dengan standar kualitas'),
(5, 'Manajer Proyek', 'Manajemen', 'Mengarahkan dan mengelola proyek-proyek perusahaan dari perencanaan hingga pelaksanaan'),
(6, 'Marketing Digital', 'Pemasaran', 'Mengelola strategi pemasaran digital dan media sosial untuk meningkatkan brand awareness'),
(7, 'Asisten Administrasi', 'Administrasi', 'Membantu dalam pengelolaan dokumen dan jadwal perusahaan'),
(8, 'Quality Control', 'Produksi', 'Memastikan kualitas produk yang dihasilkan memenuhi standar perusahaan'),
(9, 'Staff HRD', 'Sumber Daya Manusia', 'Mengelola rekrutmen, pelatihan, dan kesejahteraan karyawan perusahaan');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftar`
--

CREATE TABLE `pendaftar` (
  `id` int(11) NOT NULL,
  `id_pekerjaan` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `umur` int(11) NOT NULL,
  `alamat` text NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pendaftar`
--

INSERT INTO `pendaftar` (`id`, `id_pekerjaan`, `nama`, `umur`, `alamat`, `jenis_kelamin`, `no_telepon`, `email`) VALUES
(1, 3, 'Wakhid Khoirul Aziz', 25, 'Bekasi', 'Laki-laki', '081336889643', 'Wakhidaziz220804@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftar_umum`
--

CREATE TABLE `pendaftar_umum` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `status` enum('pending','diterima','ditolak') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pendaftar_umum`
--

INSERT INTO `pendaftar_umum` (`id`, `nama`, `status`) VALUES
(1, 'Wakhid Khoirul Aziz', 'pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `daftar_pekerjaan`
--
ALTER TABLE `daftar_pekerjaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pekerjaan` (`id_pekerjaan`);

--
-- Indexes for table `pendaftar_umum`
--
ALTER TABLE `pendaftar_umum`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `daftar_pekerjaan`
--
ALTER TABLE `daftar_pekerjaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pendaftar`
--
ALTER TABLE `pendaftar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pendaftar_umum`
--
ALTER TABLE `pendaftar_umum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
