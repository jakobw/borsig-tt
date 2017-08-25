cd /var/www/html/wp-content/themes/borsig

composer update

cp phinx.example.yml phinx.yml

vendor/bin/phinx migrate -e development

apache2-foreground
