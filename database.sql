-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: company
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `produk_tiket`
--

DROP TABLE IF EXISTS `produk_tiket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produk_tiket` (
  `id_produk` int(11) NOT NULL AUTO_INCREMENT,
  `nama_acara` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `poster` varchar(255) NOT NULL,
  PRIMARY KEY (`id_produk`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produk_tiket`
--

LOCK TABLES `produk_tiket` WRITE;
/*!40000 ALTER TABLE `produk_tiket` DISABLE KEYS */;
INSERT INTO `produk_tiket` VALUES (2,'Simfoni Sunyi','Teater','Pertunjukan kolaborasi antara musik orkestra minimalis dan puisi.',20000,'2026-06-20','20:00:00','1780622640_1780620977_Screenshot (47).png'),(4,'Terserah','Drama','Sepakat',99000,'2026-06-17','20:27:00','1780625769_Screenshot (44).png'),(5,'apa jaa','Musical','yaudah',30000,'2026-06-14','09:17:00','1780625849_Screenshot (23).png'),(6,'Hamba Sang Maha Cahaya','Teater','Seorang pemuda bernama Ary┬átumbuh dengan cita-cita sederhana: menjadi manusia yang berguna bagi sesama.\r\n\r\nNamun ketika ambisi, kehilangan, dan kesepian datang bertubi-tubi, ia mulai mempertanyakan makna dari kata berguna┬áitu sendiri. Dalam perjalanan spiritual dan sosial yang penuh luka, Ary dihadapkan pada kegagalan, penolakan, dan sunyi.\r\n\r\nIa perlahan menyadari bahwa selama ini ia berlari bukan menuju Tuhan, melainkan menuju pengakuan manusia.\r\n\r\nHingga pada satu titik ketika segalanya runtuh,harapan, keyakinan, dan kebanggaan Ary mendengar panggilan lembut dari dalam jiwanya: panggilan untuk kembali mencintai tanpa syarat.',165000,'2026-05-16','13:30:00','1782658672_flayer_HSMC.jpeg'),(7,'TEPI WAKTU !!','Teater','Satya tumbuh dalam keluarga sederhana yang harus membuat keputusan pahit demi bertahan hidup. Ia dikirim kepesantren yang ternyata  adalah panti asuhan. saat ia pulang membawa rindu, kenyataannya justru tak banyak berubah, kemiskinan masih mencengkam, dan harapan terasa jauh\r\n\r\nDiluar sana, ia mencari jalan. Kerja serabutan, dihantam realita, hingga nyaris menyerah bahkan jauh dari tuhannya.\r\n\r\nKetika idealisme berbenturan dengan realita, haruskah berjuang mempertaruhkan mimpinya atau menyerah pada keadaan ?',200000,'2025-04-12','13:30:00','1782658916_Flayer Tepi Waktu.jpeg');
/*!40000 ALTER TABLE `produk_tiket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `metode_bayar` varchar(50) NOT NULL,
  `tanggal_transaksi` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction`
--

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
INSERT INTO `transaction` VALUES (1,1,1,2,300000,'QRIS','2026-06-03 09:13:24',''),(2,1,2,1,200000,'QRIS','2026-06-03 09:20:16',''),(3,8,1,5,750000,'Transfer Bank','2026-06-03 09:30:23',''),(4,1,1,5,750000,'Transfer Bank','2026-06-04 13:44:53',''),(5,1,3,10,500000,'Transfer Bank','2026-06-05 01:20:49',''),(6,1,3,10,500000,'QRIS','2026-06-05 02:14:40',''),(7,12,3,1,10000,'QRIS','2026-06-14 13:38:08',''),(8,13,1,2,330000,'QRIS','2026-06-14 18:47:22',''),(9,13,1,2,330000,'QRIS','2026-06-14 18:50:07',''),(10,13,1,2,330000,'QRIS','2026-06-14 19:16:48',''),(11,13,1,2,330000,'QRIS','2026-06-14 19:18:19',''),(12,13,1,2,330000,'QRIS','2026-06-14 19:22:56',''),(13,13,1,2,330000,'QRIS','2026-06-14 19:42:50',''),(14,13,3,3,30000,'Transfer Bank','2026-06-14 19:43:58',''),(15,13,2,3,60000,'QRIS','2026-06-15 04:52:07',''),(16,13,4,2,198000,'Transfer Bank','2026-06-15 04:55:26',''),(17,13,3,4,40000,'QRIS','2026-06-15 05:00:50',''),(18,14,1,2,330000,'Transfer Bank','2026-06-15 05:06:27',''),(19,3,3,1,10000,'Midtrans Gateway','2026-06-15 17:09:32','pending'),(20,13,5,2,60000,'Midtrans Gateway','2026-06-15 17:21:34','pending'),(21,13,2,2,40000,'Midtrans Gateway','2026-06-15 19:09:54','pending'),(22,13,4,1,99000,'echannel','2026-06-15 19:55:24','success'),(23,15,3,1,10000,'bank_transfer','2026-06-16 13:08:46','success'),(24,15,1,1,165000,'bank_transfer','2026-06-16 13:13:43','pending'),(25,15,1,1,165000,'bank_transfer','2026-06-16 14:05:53','success'),(26,15,2,1,20000,'bank_transfer','2026-06-16 18:35:00','success'),(27,15,3,1,10000,'Midtrans Gateway','2026-06-17 08:39:49','pending'),(28,15,3,1,10000,'bank_transfer','2026-06-17 08:41:11','success'),(29,16,3,1,10000,'qris','2026-06-17 09:03:13','success'),(30,13,1,2,330000,'Midtrans Gateway','2026-06-24 04:12:19','pending'),(31,13,1,2,330000,'qris','2026-06-24 04:13:43','success'),(32,13,3,5,50000,'bank_transfer','2026-06-24 04:15:41','success'),(33,13,2,4,80000,'bank_transfer','2026-06-24 04:33:50','success'),(34,12,5,1,30000,'Midtrans Gateway','2026-06-28 14:12:11','pending'),(35,12,5,1,30000,'bank_transfer','2026-06-28 14:38:49','success'),(36,13,5,3,90000,'bank_transfer','2026-06-28 14:41:42','success'),(37,13,2,4,80000,'bank_transfer','2026-06-28 14:46:07','success'),(38,13,7,1,200000,'bank_transfer','2026-06-28 15:03:55','success'),(39,12,7,1,200000,'Midtrans Gateway','2026-10-16 08:19:46','pending'),(40,12,7,1,200000,'Midtrans Gateway','2026-10-16 08:21:30','pending');
/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(30) NOT NULL,
  `role` varchar(10) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'employee@gmail.com','$2y$10$kyw7CIXyUi/grWUJLrKPrOL6Q.TVztjOjIN8iLV2sN5gW52jJACtq','Jennifer S Wallace ','employee'),(2,'manager@gmail.com','$2y$10$kyw7CIXyUi/grWUJLrKPrOL6Q.TVztjOjIN8iLV2sN5gW52jJACtq','Ramesh K Narayan','manager'),(3,'admin@gmail.com','$2y$10$kyw7CIXyUi/grWUJLrKPrOL6Q.TVztjOjIN8iLV2sN5gW52jJACtq','Ahmad V Jabbar','admin'),(4,'firdhoaulia@gmail.com','$2y$10$6h1647G3V11e6KgMmbBdLefSCSLx4xwfeT8Q80BI.fqsDr8MMBoku','Firdho','employee'),(5,'irvan@gmail.com','$2y$10$3K0OMslsbiD0g6bIq57UeeNbfynRLiunK7xmly7lnrXJ5MvfSoSdO','Irvan','employee'),(6,'bagong@gmail.com','$2y$10$J3.1SbK391i2ZBu0M2yVyuHkKcpekbIA0E.6HKx12E8JB8orOlWFe','Bagong','employee'),(7,'testing@gmail.com','$2y$10$kyw7CIXyUi/grWUJLrKPrOL6Q.TVztjOjIN8iLV2sN5gW52jJACtq','Tester','employee'),(8,'zandatsu@gmail.com','$2y$10$Y1OCEii8ORC0Qv55VGfC/ObdLlv/ezxcKvxzpGUWUTPafqTEyHxc2','Zandatsu','employee'),(10,'akumager91@gmail.com','$2y$10$JMLbMDzGyNrkDwMcyEb4euej1paLakIFS22xjf0/L2atqckX4eOf2','Manusia','employee'),(11,'zandatsuzandatsu@gmail.com','$2y$10$/haCSmW6H2kSp5rso4BCyO.hgeFEYX7FCnndPXQajor3z1WKvE9ay','Manusia Biasa','employee'),(12,'bismillah@gmail.com','$2y$10$HXGVY/JV8QlZ5tPti4p/se4z1uco2mywRHXCPsXWTROkWTW7J0Cc2','sapok','employee'),(13,'kianabdul415@gmail.com','$2y$10$HMD6q9cvGF8rk5H2Jkh3NOb6IFhcpXfS73Eb6wPrHN/Ubv1HAQSNa','kiana','employee'),(14,'zami.irzam@students.uag.ac.id','$2y$10$3jiXXGB7fthSjYkil7CJmeqCfZL/8S6egG26esqxlZvoGuAns.XcG','ZamBae','employee'),(15,'projectwebprogram@gmail.com','$2y$10$9/szc5cwrsVrH9gL83W4cO00D90ETwUwHuSTUrsjZdOj3F6MIj4fa','projc','employee'),(16,'irvanadr8@gmail.com','$2y$10$ehvyiavIyqj7ae0Wk/R.XOZdglQljRbPB5.MuEaUjNhWRK7.oyQNC','ipan','employee'),(17,'Customer@gmail.com','$2y$10$PZcQyO2uXV.z6j7EwLAskeO7WUfp7IZR2Mg56UAywH5Jz4IiukNea','Customer','employee');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-10 12:16:09
