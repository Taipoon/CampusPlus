# Campus Plus

## インストール手順

1. レポジトリをクローンする。
>$ git clone https://github.com/Taipoon/Campus-Plus.git

2. プロジェクトディレクトリへ移動する
>$ cd Campus-Plus

3. 必要なパッケージをインストールする

>$ composer install

>$ npm install

>$ npm run dev


4. .env ファイルを作成する
  1. Campus-Plus プロジェクトフォルダ配下の .env.example をコピーしてファイル名を .env にする。
  
5. .env を編集する
  1. アプリケーションキーの作成
    .env ファイルを先に作成しないとエラーになります。

>$ php artisan key:generate

>Application key set successfully.

  
  2. .env ファイル内の以下の項目を変更する

    - (1行目) #アプリケーションの名前を設定
      APP_NAME=CampusPlus 
    - (11行目) # mysqlをsqliteに変更
      DB_CONNECTION=sqlite 
    - (12行目~16行目) 行頭に # をつけてコメントアウト
      #DB_HOST=127.0.0.1
      #DB_PORT=3306
      #DB_DATABASE=laravel
      #DB_USERNAME=root
      #DB_PASSWORD=

5. データベースを作成する(SQLite)
プロジェクトフォルダ/database/ に database.sqlite というファイル名で作成する

6. 公開用フォルダからストレージフォルダへショートカットを作成
>$ php artisan storage:link

>The links have been created.

7. ダミーデータと開発用アカウントを作成する
>$ php artisan migrate --seed

以下の用にマイグレーションが始まればOK。

"Database seeding completed successfully." が表示されれば事前準備は完了。


8. 開発用サーバーを立ち上げて動作確認
>$ php artisan serve

>Starting Laravel development server: http://127.0.0.1:8000

9. Webブラウザで http://127.0.0.1:8000 へアクセスする。
ログイン画面が表示されるので、
メールアドレス： joho@dev
パスワード　　： password123
でログインする。
