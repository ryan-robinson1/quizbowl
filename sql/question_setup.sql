CREATE TABLE project_question (
        question_id int NOT NULL auto_increment,
        set_id int NOT NULL, 
        question varchar(500) NOT NULL,
        question_number int NOT NULL,
        answer1 varchar(500) NOT NULL,
        answer2 varchar(500) NOT NULL,
        answer3 varchar(500) NOT NULL,
        answer4 varchar(500) NOT NULL,
        correct_answer ENUM("1", "2", "3", "4") NOT NULL,
        FOREIGN KEY (set_id) REFERENCES project_questionSet(set_id),
        PRIMARY KEY (question_id)
    );