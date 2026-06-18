# Dashboard Feed Killer & Customizer

Instantly removes all default WordPress dashboard widgets and replaces them with a highly customizable, client-ready support widget supporting both URL and Mailto links.

ダッシュボードの「お節介」な標準ウィジェットを一瞬で一掃し、自社専用のサポート案内窓口へと差し替える、1ファイル完結型のクライアントワーク（納品・配布）特化型カスタムツールです。WebフォームURLへの誘導だけでなく、メール起動（mailto:）にも完全対応しています。

---

## Key Features

- **Single-File Architecture**: Zero external dependencies, pure PHP, and fully self-contained in a single lightweight file.
- **Complete Dashboard Purge**: Instantly unregisters default core widgets (News, Quick Draft, Activity, Site Health, Welcome Panel) to prevent client confusion.
- **Native Settings API**: Features a clean customization panel under `Settings > Dashboard Customizer`—no hardcoding required.
- **Smart Link Validation**: Securely sanitizes and accepts both standard web URLs (`https://`) and direct email protocols (`mailto:`).
- **Zero Database Polluting**: Uses a single options array (`dfk_customizer_settings`) and leaves absolutely no residue upon uninstallation.

## 主な機能（日本語）

- **1ファイル完結アーキテクチャ**: 外部依存関係なし、純粋なPHPのみで構成された、単一ファイルで動作するプラグインです。
- **ダッシュボードのお節介フィードを一掃**: ニュース、クイックドラフト、アクティビティ、サイトヘルス、ウェルカムパネルを完全非表示にし、クライアントの混乱を防ぎます。
- **安心の設定画面を提供**: `設定 > Dashboard Customizer` から、文言や連絡先をソースコードを触らずにいつでも編集可能。
- **URL＆メールアドレス両対応**: ボタンの遷移先は WebフォームのURL（https://〜）だけでなく、メールソフト起動（mailto:〜）のサニタイズにも対応。
- **クリーン設計**: 設定値は1つの配列にまとめて保存。アンインストール時もデータベースを汚さないクリーンな仕様。

---

## Features Overview / 機能概要

### Admin Customizer / 設定画面機能
- Custom widget frame title / ウィジェットの枠タイトルの変更
- Custom header & main description text / 見出しと案内本文の自由な編集
- Configurable support handler & business hours / サポート担当名・対応時間の変更
- URL & Mailto toggle verification / URL・メールアドレスの自動判別・安全な処理

### Dashboard Clean up / ダッシュボードクリーンアップ
- Remove all default WordPress core widgets / 標準ウィジェットの完全無効化
- Suppress default Welcome Panel / ウェルカムパネルの非表示化
- Optimized full-width single widget layout / 画面幅いっぱいに見やすく広がる単一ウィジェット最適化

---

## Installation / インストール

1. Upload the plugin file to your `/wp-content/plugins/` directory.
   (`wp-content/plugins/` ディレクトリにプラグインファイルをアップロードします)
2. Activate the plugin through the 'Plugins' menu in WordPress.
   (管理画面の「プラグイン」メニューから有効化してください)
3. Navigate to **Settings > Dashboard Customizer** to configure your support desk information.
   (管理画面の「設定 > Dashboard Customizer」からサポート情報を設定してください)

---

## Technical Details

### Menu Location
`Settings > Dashboard Customizer` (`options-general.php?page=dfk-customizer-settings`)

### Technology Stack
- WordPress (Settings API, Dashboard Widgets API, Data Sanitization Layer)
- Pure PHP (Single-file Class Structure, Dynamic Protocol Mapping)

---

## Roadmap / 今後の予定
- [ ] Role-based visibility (Show/Hide widget based on user roles) / ユーザー権限ごとのウィジェット表示切り替え
- [ ] Support for custom company logo image upload / 自社ロゴ画像のアップロード・表示機能
- [ ] Integration with retro-style dashboard themes / レトロスタイル（WP-95など）テーマ向け専用CSSの同梱
- [ ] One-click emergency maintenance mode shortcut / 設定画面からのワンクリック緊急メンテナンスモード移行機能

## Developer Info / 開発者情報
- **Author**: masato shibuya (Image-box Co., Ltd.)
- **GitHub**: [https://github.com/ms13th-cyber/](https://github.com/ms13th-cyber/)
- **License**: MIT License