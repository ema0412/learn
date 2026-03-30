# 勤怠管理アプリ（Laravel）

Laravel 8 で構築された勤怠管理アプリです。
Docker（Nginx / PHP-FPM / MySQL / phpMyAdmin）でローカル実行でき、
一般ユーザーの打刻・勤怠修正申請と、管理者の承認・勤怠管理に対応しています。

## 主な機能

### 一般ユーザー
- 会員登録 / ログイン
- メール認証
- 出勤 / 休憩開始 / 休憩終了 / 退勤
- 日別勤怠一覧・詳細確認
- 勤怠修正申請

### 管理者
- 管理者ログイン
- 日次勤怠一覧・詳細更新
- スタッフ一覧
- スタッフ別月次勤怠の確認
- 勤怠修正申請の承認

## 技術スタック
- PHP 8 系（Laravel 8.75）
- MySQL 8.0
- Nginx 1.21
- Docker / Docker Compose

## セットアップ

### 1. リポジトリ直下でコンテナ起動
```bash
docker compose up -d --build
```

### 2. PHP コンテナに入る
```bash
docker compose exec php bash
```

### 3. アプリ初期設定（`/var/www` で実行）
```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
```

### 4. アクセス
- アプリ: http://localhost
- phpMyAdmin: http://localhost:8080

## テスト実行
PHP コンテナ内で以下を実行してください。

```bash
php artisan test
```

## 主要ルート
- `/login` : ログイン
- `/register` : 会員登録
- `/attendance` : 打刻画面
- `/attendance/list` : 勤怠一覧
- `/stamp_correction_request/list` : 修正申請一覧
- `/admin/attendance/list` : 管理者向け日次勤怠一覧
- `/admin/staff/list` : スタッフ一覧

## ディレクトリ構成（抜粋）
```text
.
├── docker/
│   ├── nginx/
│   ├── php/
│   └── mysql/
├── src/
│   ├── app/
│   ├── database/
│   ├── resources/views/
│   ├── routes/
│   └── tests/
└── docker-compose.yml
```

## 補足
- 既存の Laravel デフォルト README は `src/README.md` にあります。
