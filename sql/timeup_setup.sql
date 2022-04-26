 CREATE TABLE project_timeup(
        game_id int NOT NULL,
        timeup ENUM("true", "false"), 
        FOREIGN KEY (game_id) REFERENCES project_runningGame(game_id),
        PRIMARY KEY (game_id)
    );