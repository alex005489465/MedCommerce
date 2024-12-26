-- creates a new database named 'member'.
CREATE DATABASE member;

-- 使用laravel預設的遷移表進行表的創建
-- 共添加了這些表: users, password_reset_tokens
-- 添加索引到 users 表的 name 和 email 欄位