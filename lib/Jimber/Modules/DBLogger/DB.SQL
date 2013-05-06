create table `Log` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(50) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  
  PRIMARY KEY (`ID`),
  KEY `CountryID` (`countryID`),
  CONSTRAINT `CountryID` FOREIGN KEY (`countryID`) REFERENCES `Country` (`ID`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;
