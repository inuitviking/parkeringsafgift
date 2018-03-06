-- Slet fra tabellen regPlates hvor userID er lige med NULL
DELETE FROM `regPlates` WHERE userId IS NULL;
-- Opdater tabellen regPlates, sæt timeParked lige med Null, confirmed lige med 0, confirmationTime lige med NULL, og ticketType lige med NULL
-- hvor userId er IKKE NULL
UPDATE `regPlates` SET `timeParked`=NULL,`confirmed`=0,`confirmationTime`=NULL,`ticketType`=NULL WHERE userId IS NOT NULL;
-- Dette bliver kørt hver dag klokken 2 via et cron job på en server.
