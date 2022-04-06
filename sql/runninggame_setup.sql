
    CREATE TABLE project_runningGame (
        game_id int NOT NULL,
        set_id int NOT NULL,
        host varchar(300) NOT NULL,
        FOREIGN KEY (host) REFERENCES project_user(username),
        FOREIGN KEY (set_id) REFERENCES project_questionSet(set_id),
        PRIMARY KEY (game_id)
    );