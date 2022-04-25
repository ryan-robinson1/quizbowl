
    CREATE TABLE project_runningGame (
        game_id int NOT NULL,
        set_id int NOT NULL,
        host varchar(300) NOT NULL,
        current_question int, 
        num_red_players int NOT NULL,
        num_blue_players int NOT NULL,
        red_score int NOT NULL,
        blue_score int NOT NULL,
        red_recent_correct int NOT NULL,
        blue_recent_correct int NOT NULL,
        FOREIGN KEY (host) REFERENCES project_user(username),
        FOREIGN KEY (set_id) REFERENCES project_questionSet(set_id),
        FOREIGN KEY (current_question) REFERENCES project_question(question_id),
        PRIMARY KEY (game_id)
    );