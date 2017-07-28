# 網頁界面

## 相依性要求
1. PHP
2. Web Server (Apache or Nginx)
得必須是確定可以執行PHP Script的環境

## 手動操作
### 創建uploads資料夾
請手動建立名為uploads的資料夾(`uploads/`)
```
mkdir uploads
```
並且設定好權限，讓PHP的程式能夠進入並且上傳東西
```
chmod o+w uploads
```
### 確認PHP允許的最大上傳大小
在`uploads.php`裡面有10000000這個數字，請將此數字改成伺服器允許的上傳大小

