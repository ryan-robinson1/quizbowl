 CREATE TABLE project_player (
        username varchar(300) NOT NULL,
        game_id int NOT NULL,
        team ENUM("0", "1"), 
        FOREIGN KEY (game_id) REFERENCES project_runningGame(game_id),
        PRIMARY KEY (username)
    );
