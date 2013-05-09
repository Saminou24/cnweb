README
======

This directory should be used to place project specfic documentation including
but not limited to project notes, generated API/phpdoc documentation, or
manual files generated or hand written.  Ideally, this directory would remain
in your development environment only and should not be deployed with your
application to it's final production location.


Setting Up Your VHOST
=====================

The following is a sample VHOST you might want to consider for your project.

<VirtualHost *:80>
   DocumentRoot "/var/www/cnweb/public"
   ServerName cnweb.local

   # This should be omitted in the production environment
   SetEnv APPLICATION_ENV development

   <Directory "/var/www/cnweb/public">
       Options Indexes MultiViews FollowSymLinks
       AllowOverride All
       Order allow,deny
       Allow from all
   </Directory>

</VirtualHost>

====================================
- Thêm cơ sở dữ liệu bằng cách import cơ sở dữ liệu từ file cnweb_sql_update.sql vào 
- Sửa cấu hình host ảo như trên
- Chỉnh lại thông tin trong file application/configs/application.ini tại
resources.db.params.dbname= cnweb
resources.db.params.username=root 
resources.db.params.password=something
trong đó cnweb, root, something lần lưọt là tên cơ sở dữ liệu, tên tài khoản, mật khẩu
