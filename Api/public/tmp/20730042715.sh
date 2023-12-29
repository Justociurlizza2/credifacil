db=20730042715
mysql -u wiedens -pEr41mp3ri@l:2023 <<EOF
CREATE DATABASE $db;
EOF
mysqldump -R -d -u wiedens -pEr41mp3ri@l:2023 mx.homedecor | mysql -u wiedens -pEr41mp3ri@l:2023 $db; <<EOF
EOF