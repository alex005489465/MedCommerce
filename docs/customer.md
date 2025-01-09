1. 用戶身份驗證（Authentication）
測試項目：

用戶註冊 (POST register .. register.store)

用戶登錄 (POST login .. login.store)

用戶登出 (POST logout .... logout)

2. 電子郵件驗證（Email Verification）
測試項目：

觸發驗證通知 (POST email/verification-notification verification.send)

驗證電子郵件 (GET|HEAD email/verify/{id}/{hash} verification.verify)

3. 密碼管理（Password Management）
測試項目：

忘記密碼請求 (POST forgot-password password.email)

確認密碼 (POST user/confirm-password password.confirm.store)

確認密碼狀態 (GET|HEAD user/confirmed-password-status password.confirmation)

更新密碼 (PUT user/password user-password.update)

4. 用戶資料管理（Profile Management）
測試項目：

更新用戶資料 (PUT user/profile-information)

5. 健康檢查（Health Check）
測試項目：

應用程序健康檢查 (GET|HEAD up)


## 單元測試

### 用戶註冊（Registration）
測試成功註冊
測試用戶名重複
測試無效的電子郵件格式
測試密碼不匹配

### 用戶登錄（Login）
測試成功登錄
測試錯誤的密碼
測試未註冊的電子郵件
測試“記住我”功能

### 用戶登出（Logout）
測試成功登出