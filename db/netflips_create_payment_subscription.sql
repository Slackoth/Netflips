DELIMITER //
CREATE OR REPLACE FUNCTION 
create_payment_subscription(userId INT, subsId INT, subsType INT)
RETURNS BOOLEAN
BEGIN 

	SET @months := (SELECT CASE subsType
		WHEN 1 THEN 1
		WHEN 2 THEN 6
		WHEN 3 THEN 12
		ELSE 1
	END);

	INSERT INTO payment(user_id, initiation_date, expiration_date) 
	VALUES(userId, CURRENT_DATE, INTERVAL @months MONTH + CURRENT_DATE);

	INSERT INTO payment_subscription(payment_id, subscription_id)
	VALUES(LAST_INSERT_ID(), subsId);
	
	RETURN TRUE;
	
END //
DELIMITER ;









