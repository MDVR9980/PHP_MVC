RewriteEngine On

#accept loading of actual files and directories
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

#send everything else to the index page
RewriteRule ^(.*)$ index.php?url=$1 [L,QSA]