db=bretsiadb
mysql -u wiedens -pEr41mp3ri@l:2023 <<EOF
CREATE DATABASE $db;
EOF
mysqldump -R -u wiedens -pEr41mp3ri@l:2023 bretsiadb | mysql -u wiedens -pEr41mp3ri@l:2023 $db; <<EOF
EOF