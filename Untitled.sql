DROP TABLE "users";
DROP TABLE "role";

CREATE TABLE "users" (
"id" INT NOT NULL,
"name" VARCHAR(255) NOT NULL,
"unumber" VARCHAR(200) NOT NULL,
"password" VARCHAR(50) NOT NULL,
"role" INT  NOT NULL,
"active" INT  NOT NULL,
PRIMARY KEY ("id") 
);

CREATE TABLE "role" (
"id" INT NOT NULL,
"value" VARCHAR(50) NOT NULL,
"active" INT  NOT NULL,
PRIMARY KEY ("id") 
);

