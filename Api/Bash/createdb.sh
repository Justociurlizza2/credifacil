db=bretsiadb
mysql -u wiedens -pEr41mp3ri@l:2023 <<EOF 
CREATE DATABASE $db;
use $db
CREATE TABLE usuarios(id int (2) primary key not null, usuario varchar (15) not null, estado int (1) not null);
EOF