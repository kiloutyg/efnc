CREATE USER 'powerbi'@'%' IDENTIFIED BY 'powerbi';
GRANT SELECT ON efncdb.* TO 'powerbi'@'%';
FLUSH PRIVILEGES;
