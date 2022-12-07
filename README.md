# Campus Plus

## 概要

在籍する大学の学生限定の「2 ちゃんねる」のような掲示板サービス


### 開発背景

コロナ禍で入学早々からオンライン授業となったことで、同級生とのコミュニケーションが取れない中一人暮らしで暇だった経験があり、なんとか同じ大学内だけでやりとりできるようなサービスが作れないかと考え、1 人で開発した。

### 開発期間

約 2 週間

## 使用技術

### フロントエンド

-   HTML
-   CSS
-   JavaSciript

### バックエンド

-   PHP
-   Laravel
-   MariaDB

### インフラ

-   AWS Lightsail

## 設計ドキュメント

### 画面設計

[Adobe XD UI 設計](https://xd.adobe.com/view/85f7834e-1c63-41b6-8807-216ad5ee1e5b-d0a4/grid)

### ER 図

![](docs/CampusPlus%20-%20ER.jpg)

### URL・データ・機能設計

[URL・データ・機能設計(2022 年 2 月 13 日時点)](https://docs.google.com/spreadsheets/d/1fvTiXiuZ5c7v-HPngHeBuOi7l_saP2EG/edit?usp=sharing&ouid=103757566859493613361&rtpof=true&sd=true)

## はじめかた

### 1. レポジトリをクローンする

```bash
git clone https://github.com/Taipoon/CampusPlus.git
```

### 2. プロジェクトディレクトリへ移動する

```bash
cd CampusPlus
```

### 3. 必要なパッケージをインストールする

```bash
composer install

npm install

npm run dev
```

### 4. `.env` ファイルを作成する

```bash
cp .env.example .env

vi .env
```

### 5. `.env` ファイルを編集する

**以下は `sqlite3` を利用する場合**

```php
/* 1行目：アプリケーション名の設定 */
APP_NAME=CampusPlus

/* 11行目：mysqlをsqliteに変更 */
DB_CONNECTION=sqlite

/* 12行目～16行目：行頭に#をつけコメントアウト */
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

### 6. アプリケーションキーを作成する

**`.env` ファイルを先に作成しないとエラーになります。**

```bash
php artisan key:generate

> Application key set successfully.
```

### 7. データベースを作成する

`/database/`ディレクトリ直下に、`database.sqlite`というファイル名で新規ファイルを作成します。デフォルトでは`database.sqlite`のファイルを期待するため、このファイル名は一致させてください。

### 8. `/public/`から`/storage/`へ、ショートカットを作成する

アプリのルートディレクトリで以下のコマンドを実行します。

```bash
php artisan storage:link

> The links have been created.
```

### 9. ダミーデータと開発用アカウントを作成する

アプリのルートディレクトリで以下のコマンドを実行します。

```bash
php artisan migrate:fresh --seed
```

以下のように表示されれば、マイグレーションおよびダミーデータの流し込みが完了しています。

```bash
> Database seeding completed successfully.
```

### 10. 開発用サーバーを立ち上げて動作を確認する

アプリのルートディレクトリで以下のコマンドを実行します。

```bash
php artisan serve

> Starting Laravel development server: http://127.0.0.1:8000
```

### 11. Web ブラウザで http://127.0.0.1:8000 へアクセスする。

ログイン画面が表示されるので、以下のダミーデータでログインできます。

-   メールアドレス： joho@dev
-   パスワード　　： password123
