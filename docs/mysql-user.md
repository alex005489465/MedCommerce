# MySQL User and Group Privilege Planning Guide

## Root User Configuration
- Root Username: `root`
- Root Password: `example` 

## member User
### member01 User Configuration
- Username: `customer_001`
- Password: `your_password`
- Privileges: `ALL`, except drop on database.
- Database: `shop`, `customer`