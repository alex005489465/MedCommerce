#!/bin/sh

# 生成應用加密密鑰
php artisan key:generate

# 啟動 Octane Swoole 服務
php artisan octane:start --server=swoole
