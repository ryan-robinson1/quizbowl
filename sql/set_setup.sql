CREATE TABLE project_questionSet (
        set_id int NOT NULL auto_increment,
        set_name varchar(500) NOT NULL,
        username varchar(300) NOT NULL,
        FOREIGN KEY (username) REFERENCES project_user (username),
        PRIMARY KEY (set_id)
    );