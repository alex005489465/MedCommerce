-- creates new database
CREATE DATABASE shop;
CREATE DATABASE customer;

-- creates new role
CREATE ROLE 'shop_dev';
GRANT ALL PRIVILEGES ON shop.* TO 'shop_dev';

CREATE ROLE 'customer_dev';
GRANT ALL PRIVILEGES ON customer.* TO 'customer_dev';


-- creates new user
CREATE USER 'customer_001'@'%' IDENTIFIED BY 'your_password';
GRANT 'shop_dev' TO 'customer_001'@'%';
GRANT 'customer_dev' TO 'customer_001'@'%';
SET DEFAULT ROLE 'shop_dev', 'customer_dev' TO 'customer_001'@'%';
FLUSH PRIVILEGES;







-- 使用laravel預設的遷移表進行表的創建
-- 共添加了這些表: users, password_reset_tokens
-- 添加索引到 users 表的 name 和 email 欄位