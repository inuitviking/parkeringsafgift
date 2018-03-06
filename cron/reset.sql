DELETE FROM `regPlates` WHERE userId IS NULL;
UPDATE `regPlates` SET `timeParked`=NULL,`confirmed`=0,`confirmationTime`=NULL,`ticketType`=NULL WHERE userId IS NOT NULL;