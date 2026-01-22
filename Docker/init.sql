ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '*minhanov@Senha123*';
FLUSH PRIVILEGES;
ALTER USER 'root'@'%' IDENTIFIED WITH mysql_native_password BY '*minhanov@Senha123*';
FLUSH PRIVILEGES;

ALTER USER 'ProjetoUser'@'localhost' IDENTIFIED WITH mysql_native_password BY '*minhanov@Senha321*';
ALTER USER 'ProjetoUser'@'%' IDENTIFIED WITH mysql_native_password BY '*minhanov@Senha321*';
FLUSH PRIVILEGES;

GRANT ALL PRIVILEGES ON projeto.* TO 'ProjetoUser'@'%';
GRANT ALL PRIVILEGES ON projeto.* TO 'ProjetoUser'@'localhost';
FLUSH PRIVILEGES;

REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'root'@'localhost';
REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'root'@'%';
FLUSH PRIVILEGES;