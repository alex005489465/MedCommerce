CREATE ROLE 'member_manage';
GRANT ALL PRIVILEGES ON member.* TO 'member_manage';
REVOKE DROP ON member.* FROM 'member_manage';

CREATE ROLE 'other_manage';
GRANT ALL PRIVILEGES ON other.* TO 'other_manage';
REVOKE DROP ON other.* FROM 'other_manage';

CREATE USER 'member01'@'%' IDENTIFIED BY 'your_password';
GRANT 'member_manage', 'other_manage' TO 'member01'@'%';
SET DEFAULT ROLE ALL TO 'member01'@'%';
FLUSH PRIVILEGES;

