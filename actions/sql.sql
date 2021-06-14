DROP TABLE IF EXISTS cartitem,cart,orderitem,payment,userorder,productimage,product,user,role;

CREATE TABLE role
(
    Id   INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(64)
);
CREATE TABLE user
(
    Id           INT AUTO_INCREMENT PRIMARY KEY,
    Email        VARCHAR(64),
    DisplayName  VARCHAR(64),
    Password     VARCHAR(128),
    Role         INT      DEFAULT 2,
    RegisterDate DATETIME DEFAULT NOW(),
    FOREIGN KEY (Role)
        REFERENCES role (id)
        ON DELETE CASCADE

);
CREATE TABLE `product`
(
    `Id`        INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Name`      VARCHAR(128)  DEFAULT NULL,
    `Category`  VARCHAR(32)   DEFAULT NULL,
    `Price`     DOUBLE(10, 3) DEFAULT NULL,
    `Weight`    DOUBLE(10, 3) DEFAULT NULL,
    `Hashrate`  VARCHAR(10)   DEFAULT NULL,
    `Available` INT(11)       DEFAULT 1
);
CREATE TABLE `productimage`
(
    `Id`         INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `ProductId`  INT(11)      DEFAULT NULL,
    `Image`      VARCHAR(128) DEFAULT NULL,
    `ThumbImage` VARCHAR(128) DEFAULT NULL,
    FOREIGN KEY (ProductId)
        REFERENCES product (id)
        ON DELETE CASCADE
);
CREATE TABLE `cart`
(
    `Id`         INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `UserId`     INT(11)      DEFAULT NULL,
    `CookieHash` VARCHAR(128) DEFAULT NULL,
    `Coupon`     CHAR(24)     DEFAULT NULL,
    `CreateDate` DATETIME     DEFAULT NULL
);
CREATE TABLE `userorder`
(
    `Id`             INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `UserId`         INT           DEFAULT NULL,
    `Code`           CHAR(32)      DEFAULT NULL,
    `FName`          VARCHAR(64)   DEFAULT NULL,
    `LName`          VARCHAR(64)   DEFAULT NULL,
    `Country`        VARCHAR(64)   DEFAULT NULL,
    `StreetAddress1` VARCHAR(128)  DEFAULT NULL,
    `StreetAddress2` VARCHAR(128)  DEFAULT NULL,
    `Postcode`       VARCHAR(16)   DEFAULT NULL,
    `City`           VARCHAR(64)   DEFAULT NULL,
    `Phone`          VARCHAR(64)   DEFAULT NULL,
    `Email`          VARCHAR(64)   DEFAULT NULL,
    `Comment`        VARCHAR(256)  DEFAULT NULL,
    `Status`         INT(11)       DEFAULT 0,
    `OrderDate`      DATETIME      DEFAULT CURRENT_TIMESTAMP(),
    `Total`          DOUBLE(10, 3) DEFAULT NULL,
    `DeliveryStatus` INT(11)       DEFAULT 0
);
CREATE TABLE `payment`
(
    `Id`         INT AUTO_INCREMENT PRIMARY KEY,
    `Code`       CHAR(64) NOT NULL,
    `OrderId`    INT UNIQUE,
    `Sum`        DOUBLE(10, 3) DEFAULT NULL,
    `CreateDate` DATETIME      DEFAULT NULL,
    `Type`       INT(11)       DEFAULT NULL,
    `Status`     INT(11)       DEFAULT NULL,
    FOREIGN KEY (OrderId)
        REFERENCES userorder (id)
        ON DELETE CASCADE
);
CREATE TABLE `cartitem`
(
    `Id`        INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `CartId`    INT(11) DEFAULT NULL,
    `ProductId` INT(11) DEFAULT NULL,
    `Quantity`  INT(11) DEFAULT NULL,
    FOREIGN KEY (CartId)
        REFERENCES cart (id)
        ON DELETE CASCADE,
    FOREIGN KEY (ProductId)
        REFERENCES product (id)
        ON DELETE CASCADE
);
CREATE TABLE `orderitem`
(
    `Id`        INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `OrderId`   INT(11)       DEFAULT NULL,
    `ProductId` INT(11)       DEFAULT NULL,
    `Quantity`  INT(11)       DEFAULT NULL,
    `Price`     DOUBLE(10, 3) DEFAULT NULL,
    FOREIGN KEY (OrderId)
        REFERENCES userorder (id)
        ON DELETE CASCADE,
    FOREIGN KEY (ProductId)
        REFERENCES product (id)
        ON DELETE CASCADE
);

INSERT INTO role (Name)
VALUES ('Admin'),
       ('User');

INSERT INTO `product` (`Id`, `Name`, `Category`, `Price`, `Weight`, `Hashrate`, `Available`)
VALUES (1, 'Antminer E9 – 3GH/s', 'Antminer E9 series', 20000.000, 16.500, '3GH/s', 1),
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
INSERT INTO `productimage` (`Id`, `ProductId`, `Image`, `ThumbImage`)
VALUES (1, 1, 'Antminer-E9_1.png', 'Antminer-E9_1-300x300.png'),
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

SELECT e1.Code, e1.OrderDate, e2.ProductId, e2.Quantity, e2.Price, e3.Name
FROM UserOrder e1
         LEFT JOIN OrderItem e2
                   ON e1.Id = e2.OrderId
         LEFT JOIN Product e3
                   ON e2.ProductId = e3.Id
WHERE e1.UserId = 1 AND e1.Status=1