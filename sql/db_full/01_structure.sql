CREATE TABLE IF NOT EXISTS APP_USER(
	APP_USER_ID INTEGER NOT NULL AUTO_INCREMENT,
	APP_USER_PASSWD VARCHAR(255) NOT NULL,
	APP_USER_NAME VARCHAR(32) NOT NULL,
	APP_USER_FIRSTNAME VARCHAR(32) NULL,
	APP_USER_MAIL VARCHAR(255) UNIQUE NOT NULL,
	PRIMARY KEY (APP_USER_ID)
);

CREATE TABLE IF NOT EXISTS ITEM (
	ITEM_ID INTEGER NOT NULL AUTO_INCREMENT,
	ITEM_NAME VARCHAR(255) NOT NULL,
	ITEM_LINK TEXT NULL,
	ITEM_PRICE NUMERIC(10,2) NULL,
	ITEM_ORDER INTEGER NULL,
	APP_USER_ID INTEGER NOT NULL,
	PRIMARY KEY(ITEM_ID),
	FOREIGN KEY(APP_USER_ID) REFERENCES APP_USER(APP_USER_ID)
);

