=== Dashboard Feed Killer & Customizer ===
Contributors: masato shibuya (Image-box Co., Ltd.)
Tags: dashboard, widget, white-label, client-work, support, customizer, admin, cleaner
Requires at least: 5.0
Tested up to: 7.0.0
Requires PHP: 8.3.23
Stable tag: 1.0.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

ダッシュボードの標準ウィジェットをすべて一掃し、自社専用のカスタムサポート窓口（URL・メールアドレス両対応）に差し替えるクライアントワーク特化型ツールです。

== Description ==

Dashboard Feed Killer & Customizer は、WordPressを納品する制作会社やフリーランス、あるいはプラグインを配布したい開発者のための、1ファイル完結型ダッシュボードホワイトラベルツールです。

WordPress標準の「お節介」なニュースやクイックドラフト、サイトヘルスなどをすべて非表示にし、代わりに「自社への問い合わせURL」や「直接起動するメールアドレス（mailto:）」を埋め込んだシンプルなウィジェットを1つだけ綺麗に配置します。

ソースコードを直接変更するプラグインエディターでの編集は不要です。専用の設定画面からいつでも安全にテキストやリンクを書き換えることができます。

主な特徴：

* **標準ウィジェットの根こそぎ消去**: ニュース、クイックドラフト、概要、アクティビティ、ウェルカムパネルを完全一掃。
* **専用の設定画面を設置**: 「設定 > Dashboard Customizer」から、表示する会社名、対応時間、ボタンURLを簡単に変更可能。
* **メールアドレス（mailto:）に完全対応**: Web問い合わせフォームを持たない制作者でも、直接メールを受け取れるようにメールプロトコルを安全に検証・サニタイズ。
* **1ファイル完結・超軽量**: 外部依存なし。フックとSettings APIのみを使用した高速動作。
* **データベースを汚さない設計**: 全設定値を1つの配列として保存。アンインストール時も痕跡を残しません。

== Installation ==

1. プラグインファイルを以下へアップロードします。
   `/wp-content/plugins/dashboard-feed-killer`

2. WordPress管理画面の「プラグイン」から有効化します。

3. 管理画面の「設定」配下に追加されるメニューからアクセスして情報を設定します。
   `設定 > Dashboard Customizer`

== Usage ==

このプラグインは有効化すると即座に標準ウィジェットを消去し、初期状態のサポート窓口を表示します。

* **情報のカスタマイズ**: 「設定 > Dashboard Customizer」を開き、ウィジェットのタイトル、案内テキスト、担当者名、対応時間を入力します。
* **リンク先の設定**: お問い合わせ用WebフォームのURL（`https://～`）、またはメール起動リンク（`mailto:info@example.com`）を入力して保存すると、ウィジェット上のボタンに安全に反映されます。

== Changelog ==

= 1.0.1 =
* 軽微なスタイル修正。

= 1.0.0 =
* 初版リリース。
* 1ファイル完結型クラス構造の基本実装。
* コアダッシュボードウィジェットおよびウェルカムパネルの完全一掃ロジックの実装。
* Settings APIを使用した専用カスタマイズ設定画面の実装。
* ボタンリンクにおける標準URL（https）およびメールプロトコル（mailto）の相互安全サニタイズ処理の実装。
* WordPress 7.0.0 および PHP 8.3 環境での動作検証済み。

== License ==

This plugin is licensed under the GPLv2 or later.