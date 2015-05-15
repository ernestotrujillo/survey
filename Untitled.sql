DROP TABLE "user";
DROP TABLE "role";

CREATE TABLE "user" (
"id" INT NOT NULL,
"unumber" VARCHAR NOT NULL,
"password" VARCHAR(100) NOT NULL,
"role" INT  NOT NULL,
PRIMARY KEY ("id") 
);

CREATE TABLE "role" (
"id" INT NOT NULL,
"value" VARCHAR(50) NOT NULL,
PRIMARY KEY ("id") 
);

