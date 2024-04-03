DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS main_directories;
DROP TABLE IF EXISTS favorites;

CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    username TEXT,
    password TEXT,
    email TEXT,
    server TEXT,
    ssh_port INTEGER,
    ssh_username TEXT,
    ssh_password TEXT,
    terminal_port INTEGER,
    webserver_home_directory TEXT,
    get_network_information TEXT
);

CREATE TABLE main_directories (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    username TEXT,
    name TEXT,
    color TEXT,
    icon TEXT
);

CREATE TABLE favorites (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    username TEXT,
    path TEXT
);
