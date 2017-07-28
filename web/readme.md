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

### 檔案、資料夾簡述
#### index.html
入口處，基本上就是一個表單，讓使用者可以上傳影片或是圖片
#### auto_style.sh
預計是要將很多bash指令打在這個script裡面，遠端遙控運算伺服器做事
#### upload.php
如何上傳東西、上傳到哪裡，會在這個php檔案裡面做設定
