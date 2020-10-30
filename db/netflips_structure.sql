CREATE TABLE IF NOT EXISTS user(
	id INT AUTO_INCREMENT,
	firstname VARCHAR(255) NOT NULL,
	lastname VARCHAR(255) NOT NULL,
	email VARCHAR(254) NOT NULL,
	birthdate DATE NOT NULL,
	password TEXT NOT NULL,
	PRIMARY KEY(id)
); 

CREATE TABLE IF NOT EXISTS payment(
	id INT AUTO_INCREMENT,
	user_id INT NOT NULL,
	initiation_date DATE NOT NULL,
	expiration_date DATE NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS subscription(
	id INT AUTO_INCREMENT,
	type_id INT NOT NULL,
	state_id INT NOT NULL,
	plan_id INT NOT NULL,
	total_cost DECIMAL(15,2),
	PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS type(
	id INT AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL CHECK(name = 'mensual' OR name = 'semestral' OR name = 'anual'),
	PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS state(
	id INT AUTO_INCREMENT,
	state BOOL NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS plan (
	id INT AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	description TEXT NOT NULL,
	cost DECIMAL(15,2) NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS payment_subscription (
	payment_id INT NOT NULL,
	subscription_id INT NOT NULL
);


/*CONSTRAINTS*/
/*PAPYMENT*/
ALTER TABLE payment ADD CONSTRAINT FK_USER
FOREIGN KEY (user_id) REFERENCES user(id) 
ON DELETE NO ACTION ON UPDATE NO ACTION; 

/*SUBSCRIPTION*/
ALTER TABLE subscription ADD CONSTRAINT FK_TYPE
FOREIGN KEY (type_id) REFERENCES type(id) 
ON DELETE NO ACTION ON UPDATE NO ACTION; 

ALTER TABLE subscription ADD CONSTRAINT FK_STATE
FOREIGN KEY (state_id) REFERENCES state(id) 
ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE subscription ADD CONSTRAINT FK_PLAN
FOREIGN KEY (plan_id) REFERENCES plan(id) 
ON DELETE NO ACTION ON UPDATE NO ACTION;

/*PAYMENT_SUBSCRIPTION*/
ALTER TABLE payment_subscription ADD CONSTRAINT PK_PAYMENT_SUBSCRIPTION
PRIMARY KEY (payment_id, subscription_id);

ALTER TABLE payment_subscription ADD CONSTRAINT FK_PAYMENT
FOREIGN KEY (payment_id) REFERENCES payment(id)
ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE payment_subscription ADD CONSTRAINT FK_SUBSCRIPTION
FOREIGN KEY (subscription_id) REFERENCES subscription(id)
ON DELETE NO ACTION ON UPDATE NO ACTION;


