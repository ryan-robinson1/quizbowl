CREATE TABLE player (
    id int not null auto_increment,
    username text not null,
    team text not null,
    score int not null,
    user_id int not null,
    primary key (id)
);

