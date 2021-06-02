CREATE TABLE `cart` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) DEFAULT NULL,
  `CookieHash` varchar(128) DEFAULT NULL,
  `Coupon` char(24) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `cartitem` (
  `Id` int(11) NOT NULL,
  `CartId` int(11) DEFAULT NULL,
  `ProductId` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `orderitem` (
  `Id` int(11) NOT NULL,
  `OrderId` int(11) DEFAULT NULL,
  `ProductId` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Price` double(10,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `payment` (
  `Id` char(64) NOT NULL,
  `UserId` int(11) DEFAULT NULL,
  `Code` char(10) DEFAULT NULL,
  `Sum` double(10,3) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `Type` int(11) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `product` (
  `Id` int(11) NOT NULL,
  `Name` varchar(128) DEFAULT NULL,
  `Category` varchar(32) DEFAULT NULL,
  `Price` double(10,3) DEFAULT NULL,
  `Weight` double(10,3) DEFAULT NULL,
  `Hashrate` varchar(10) DEFAULT NULL,
  `Available` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `product` (`Id`, `Name`, `Category`, `Price`, `Weight`, `Hashrate`, `Available`) VALUES
(1, 'Antminer E9 – 3GH/s', 'Antminer E9 series', 20000.000, 16.500, '3GH/s', 1),
(2, 'Antminer S19j – 90TH/s', 'Antminer S19 series', 5017.000, 16.500, '90TH/s', 1),
(3, 'Antminer S19 Pro 110TH/s', 'Antminer S19 series', 3769.000, 15.500, '110TH/s', 1),
(4, 'Antminer S19 – 95TH/s', 'Antminer S19 series', 2767.000, 16.500, '95TH/s', 1),
(5, 'Antminer T17+ 58TH/s', 'Antminer T17 series', 1078.000, 12.000, '58TH/s', 1),
(6, 'Antminer T19 – 84TH/s', 'Antminer T19 series', 2118.000, 16.000, '84TH/s', 1),
(7, 'Antminer S17e-60TH/s', 'Antminer S17 series', 1055.000, 12.000, '60TH/s', 1),
(8, 'Antminer S17+ 70TH/s', 'Antminer S17 series', 1625.000, 11.500, '70TH/s', 1),
(9, 'Antminer S9 SE-16TH/s', 'Antminer S9 series', 125.000, 8.000, '16TH/s', 1),
(10, 'Antminer S9k-13.5TH/s', 'Antminer S9 series', 113.000, 8.000, '13.5TH/s', 1),
(11, 'Antminer Z15 (APW7 included)', 'Antminer Z15 series', 2065.000, 10.000, '420KSol/s', 1),
(12, 'APW7 for Antminer', 'Power supply', 113.000, 2.500, '', 1),
(13, 'ANTBOX N5 SE', 'Antbox', 14896.000, 3200.000, '', 1),
(14, 'ANTBOX N5', 'Antbox', 29821.000, 3800.000, '', 1);

CREATE TABLE `productimage` (
  `Id` int(11) NOT NULL,
  `ProductId` int(11) DEFAULT NULL,
  `Image` varchar(128) DEFAULT NULL,
  `ThumbImage` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `productimage` (`Id`, `ProductId`, `Image`, `ThumbImage`) VALUES
(1, 1, 'Antminer-E9_1.png', 'Antminer-E9_1-300x300.png'),
(2, 1, 'Antminer-E9_2.png', 'Antminer-E9_2-300x300.png'),
(3, 1, 'Antminer-E9_3.png', 'Antminer-E9_3-300x300.png'),
(4, 1, 'Antminer-E9_4.png', 'Antminer-E9_4-300x300.png'),
(5, 1, 'Antminer-E9_5.png', 'Antminer-E9_5-300x300.png'),
(6, 1, 'Antminer-E9_6.png', 'Antminer-E9_6-300x300.png'),
(7, 1, 'Antminer-E9_7.png', 'Antminer-E9_7-300x300.png'),
(8, 2, 'Antminer-S19j-90THs_1.png', 'Antminer-S19j-90THs_1-300x300.png'),
(9, 2, 'Antminer-S19j-90THs_2.png', 'Antminer-S19j-90THs_2-300x300.png'),
(10, 2, 'Antminer-S19j-90THs_3.png', 'Antminer-S19j-90THs_3-300x300.png'),
(11, 2, 'Antminer-S19j-90THs_4.png', 'Antminer-S19j-90THs_4-300x300.png'),
(12, 2, 'Antminer-S19j-90THs_5.png', 'Antminer-S19j-90THs_5-300x300.png'),
(13, 2, 'Antminer-S19j-90THs_6.png', 'Antminer-S19j-90THs_6-300x300.png'),
(14, 2, 'Antminer-S19j-90THs_7.png', 'Antminer-S19j-90THs_7-300x300.png'),
(15, 3, 'Antminer-S19-Pro-110THs_1.png', 'Antminer-S19-Pro-110THs_1-300x300.png'),
(16, 3, 'Antminer-S19-Pro-110THs_2.png', 'Antminer-S19-Pro-110THs_2-300x300.png'),
(17, 3, 'Antminer-S19-Pro-110THs_3.png', 'Antminer-S19-Pro-110THs_3-300x300.png'),
(18, 3, 'Antminer-S19-Pro-110THs_4.png', 'Antminer-S19-Pro-110THs_4-300x300.png'),
(19, 3, 'Antminer-S19-Pro-110THs_5.png', 'Antminer-S19-Pro-110THs_5-300x300.png'),
(20, 3, 'Antminer-S19-Pro-110THs_6.png', 'Antminer-S19-Pro-110THs_6-300x300.png'),
(21, 4, 'Antminer-S19-95THs_1.png', 'Antminer-S19-95THs_1-300x300.png'),
(22, 4, 'Antminer-S19-95THs_2.png', 'Antminer-S19-95THs_2-300x300.png'),
(23, 4, 'Antminer-S19-95THs_3.png', 'Antminer-S19-95THs_3-300x300.png'),
(24, 4, 'Antminer-S19-95THs_4.png', 'Antminer-S19-95THs_4-300x300.png'),
(25, 4, 'Antminer-S19-95THs_5.png', 'Antminer-S19-95THs_5-300x300.png'),
(26, 4, 'Antminer-S19-95THs_6.png', 'Antminer-S19-95THs_6-300x300.png'),
(27, 5, 'Antminer-T17-58THs_1.png', 'Antminer-T17-58THs_1-300x300.png'),
(28, 5, 'Antminer-T17-58THs_2.png', 'Antminer-T17-58THs_2-300x300.png'),
(29, 5, 'Antminer-T17-58THs_3.png', 'Antminer-T17-58THs_3-300x300.png'),
(30, 5, 'Antminer-T17-58THs_4.png', 'Antminer-T17-58THs_4-300x300.png'),
(31, 5, 'Antminer-T17-58THs_5.png', 'Antminer-T17-58THs_5-300x300.png'),
(32, 5, 'Antminer-T17-58THs_6.png', 'Antminer-T17-58THs_6-300x300.png'),
(33, 5, 'Antminer-T17-58THs_7.png', 'Antminer-T17-58THs_7-300x300.png'),
(34, 6, 'Antminer-T19-84THs_1.png', 'Antminer-T19-84THs_1-300x300.png'),
(35, 6, 'Antminer-T19-84THs_2.png', 'Antminer-T19-84THs_2-300x300.png'),
(36, 6, 'Antminer-T19-84THs_3.png', 'Antminer-T19-84THs_3-300x300.png'),
(37, 6, 'Antminer-T19-84THs_4.png', 'Antminer-T19-84THs_4-300x300.png'),
(38, 6, 'Antminer-T19-84THs_5.png', 'Antminer-T19-84THs_5-300x300.png'),
(39, 6, 'Antminer-T19-84THs_6.png', 'Antminer-T19-84THs_6-300x300.png'),
(40, 6, 'Antminer-T19-84THs_7.png', 'Antminer-T19-84THs_7-300x300.png'),
(41, 7, 'Antminer-S17e-60THs_1.png', 'Antminer-S17e-60THs_1-300x300.png'),
(42, 7, 'Antminer-S17e-60THs_2.png', 'Antminer-S17e-60THs_2-300x300.png'),
(43, 7, 'Antminer-S17e-60THs_3.png', 'Antminer-S17e-60THs_3-300x300.png'),
(44, 7, 'Antminer-S17e-60THs_4.png', 'Antminer-S17e-60THs_4-300x300.png'),
(45, 7, 'Antminer-S17e-60THs_5.png', 'Antminer-S17e-60THs_5-300x300.png'),
(46, 7, 'Antminer-S17e-60THs_6.png', 'Antminer-S17e-60THs_6-300x300.png'),
(47, 8, 'Antminer-S17-70THs_1.png', 'Antminer-S17-70THs_1-300x300.png'),
(48, 8, 'Antminer-S17-70THs_2.png', 'Antminer-S17-70THs_2-300x300.png'),
(49, 8, 'Antminer-S17-70THs_3.png', 'Antminer-S17-70THs_3-300x300.png'),
(50, 8, 'Antminer-S17-70THs_4.png', 'Antminer-S17-70THs_4-300x300.png'),
(51, 8, 'Antminer-S17-70THs_5.png', 'Antminer-S17-70THs_5-300x300.png'),
(52, 8, 'Antminer-S17-70THs_6.png', 'Antminer-S17-70THs_6-300x300.png'),
(53, 8, 'Antminer-S17-70THs_7.png', 'Antminer-S17-70THs_7-300x300.png'),
(54, 9, 'Antminer-S9-SE-16THs_1.png', 'Antminer-S9-SE-16THs_1-300x300.png'),
(55, 9, 'Antminer-S9-SE-16THs_2.png', 'Antminer-S9-SE-16THs_2-300x300.png'),
(56, 9, 'Antminer-S9-SE-16THs_3.png', 'Antminer-S9-SE-16THs_3-300x300.png'),
(57, 9, 'Antminer-S9-SE-16THs_4.png', 'Antminer-S9-SE-16THs_4-300x300.png'),
(58, 9, 'Antminer-S9-SE-16THs_5.png', 'Antminer-S9-SE-16THs_5-300x300.png'),
(59, 9, 'Antminer-S9-SE-16THs_6.png', 'Antminer-S9-SE-16THs_6-300x300.png'),
(60, 9, 'Antminer-S9-SE-16THs_7.png', 'Antminer-S9-SE-16THs_7-300x300.png'),
(61, 10, 'Antminer-S9k-13.5THs_1.png', 'Antminer-S9k-13.5THs_1-300x300.png'),
(62, 10, 'Antminer-S9k-13.5THs_2.png', 'Antminer-S9k-13.5THs_2-300x300.png'),
(63, 10, 'Antminer-S9k-13.5THs_3.png', 'Antminer-S9k-13.5THs_3-300x300.png'),
(64, 10, 'Antminer-S9k-13.5THs_4.png', 'Antminer-S9k-13.5THs_4-300x300.png'),
(65, 10, 'Antminer-S9k-13.5THs_5.png', 'Antminer-S9k-13.5THs_5-300x300.png'),
(66, 10, 'Antminer-S9k-13.5THs_6.png', 'Antminer-S9k-13.5THs_6-300x300.png'),
(67, 10, 'Antminer-S9k-13.5THs_7.png', 'Antminer-S9k-13.5THs_7-300x300.png'),
(68, 11, 'Antminer-Z15（APW7-included）_1.png', 'Antminer-Z15（APW7-included）_1-300x300.png'),
(69, 11, 'Antminer-Z15（APW7-included）_2.png', 'Antminer-Z15（APW7-included）_2-300x300.png'),
(70, 11, 'Antminer-Z15（APW7-included）_3.png', 'Antminer-Z15（APW7-included）_3-300x300.png'),
(71, 11, 'Antminer-Z15（APW7-included）_4.png', 'Antminer-Z15（APW7-included）_4-300x300.png'),
(72, 11, 'Antminer-Z15（APW7-included）_5.png', 'Antminer-Z15（APW7-included）_5-300x300.png'),
(73, 11, 'Antminer-Z15（APW7-included）_6.png', 'Antminer-Z15（APW7-included）_6-300x300.png'),
(74, 12, 'APW7-for-Antminer_1.png', 'APW7-for-Antminer_1-300x300.png'),
(75, 12, 'APW7-for-Antminer_2.png', 'APW7-for-Antminer_2-300x300.png'),
(76, 12, 'APW7-for-Antminer_3.png', 'APW7-for-Antminer_3-300x300.png'),
(77, 12, 'APW7-for-Antminer_4.png', 'APW7-for-Antminer_4-300x300.png'),
(78, 13, 'ANTBOX-N5-SE_1.png', 'ANTBOX-N5-SE_1-300x300.png'),
(79, 13, 'ANTBOX-N5-SE_2.png', 'ANTBOX-N5-SE_2-300x300.png'),
(80, 13, 'ANTBOX-N5-SE_3.png', 'ANTBOX-N5-SE_3-300x300.png'),
(81, 13, 'ANTBOX-N5-SE_4.png', 'ANTBOX-N5-SE_4-300x300.png'),
(82, 14, 'ANTBOX-N5_1.png', 'ANTBOX-N5_1-300x300.png'),
(83, 14, 'ANTBOX-N5_2.png', 'ANTBOX-N5_2-300x300.png'),
(84, 14, 'ANTBOX-N5_3.png', 'ANTBOX-N5_3-300x300.png'),
(85, 14, 'ANTBOX-N5_4.png', 'ANTBOX-N5_4-300x300.png'),
(86, 14, 'ANTBOX-N5_5.png', 'ANTBOX-N5_5-300x300.png'),
(87, 14, 'ANTBOX-N5_6.png', 'ANTBOX-N5_6-300x300.png'),
(88, 14, 'ANTBOX-N5_7.png', 'ANTBOX-N5_7-300x300.png');


CREATE TABLE `userorder` (
  `Id` int(11) NOT NULL,
  `Code` char(8) DEFAULT NULL,
  `UserId` int(11) DEFAULT NULL,
  `FName` varchar(64) DEFAULT NULL,
  `LName` varchar(64) DEFAULT NULL,
  `Country` varchar(64) DEFAULT NULL,
  `StreetAddress1` varchar(128) DEFAULT NULL,
  `StreetAddress2` varchar(128) DEFAULT NULL,
  `Postcode` varchar(16) DEFAULT NULL,
  `City` varchar(64) DEFAULT NULL,
  `Phone` varchar(64) DEFAULT NULL,
  `Email` varchar(64) DEFAULT NULL,
  `State` varchar(64) DEFAULT NULL,
  `Comment` varchar(256) DEFAULT NULL,
  `Status` int(11) DEFAULT 0,
  `PaymentId` char(64) DEFAULT NULL,
  `OrderDate` datetime DEFAULT current_timestamp(),
  `PayExpireDate` datetime DEFAULT NULL,
  `Coupon` char(24) DEFAULT NULL,
  `Subtotal` double(10,3) DEFAULT NULL,
  `Total` double(10,3) DEFAULT NULL,
  `DeliveryStatus` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `cart`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `cartitem`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `orderitem`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `payment`
  ADD PRIMARY KEY (`Id`);


ALTER TABLE `product`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `productimage`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `userorder`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `cart`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `cartitem`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `orderitem`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `product`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

ALTER TABLE `productimage`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

ALTER TABLE `userorder`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;