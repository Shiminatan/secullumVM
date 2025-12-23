Configurar o MYSQL para ser acessado via rede. Rodar o script a baixo no Mysql


CREATE USER 'suporte'@'%' IDENTIFIED BY '_43690@SA';
GRANT ALL PRIVILEGES ON *.* TO 'suporte'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;

## Dar permissão para mexer nos bancos

GRANT ALL PRIVILEGES ON *.* TO 'suporte'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;
