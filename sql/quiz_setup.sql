CREATE TABLE quiz (
    id int not null auto_increment,
    user_id int not null,
    quiz text not null,
    question text not null,
    answer text not null,
    wrong_answer1 text not null,
    wrong_answer2 text not null,
    wrong_answer3 text not null,
    pin int not null,
    primary key (id)
);