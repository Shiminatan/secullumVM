Configurar o MYSQL para ser acessado via rede. Rodar o script a baixo no Mysql

GRANT ALL PRIVILEGES ON . TO 'root'@'%' IDENTIFIED BY 'SUA_SENHA_AQUI' WITH GRANT OPTION;
FLUSH PRIVILEGES;
