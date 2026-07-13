<?php
/*
Plugin Name: Dashboard Feed Killer & Customizer
Description: Instantly removes all default dashboard widgets and replaces them with a clean, custom support widget.
Version: 1.0.1
Tested up to: 6.9.4
Requires PHP: 8.3.23
Author: masato shibuya (Image-box Co., Ltd.)
Author URI: https://github.com/ms13th-cyber
License: GPLv2 or later
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DashboardFeedKiller {

	private $option_key = 'dfk_customizer_settings';

	public function __construct() {
		add_action( 'wp_dashboard_setup', [ $this, 'clean_and_customize_dashboard' ], 999 );
		add_action( 'welcome_panel', '__return_false', 999 );
		add_action( 'admin_menu', [ $this, 'add_settings_menu' ] );
		add_action( 'admin_init', [ $this, 'register_settings' ] );
	}

	public function clean_and_customize_dashboard() {
		$target_widgets = [
			'dashboard_primary', 'dashboard_quick_press',
			'dashboard_right_now', 'dashboard_activity', 'dashboard_site_health'
		];

		foreach ( [ 'normal', 'side', 'advanced' ] as $context ) {
			foreach ( [ 'core', 'default' ] as $priority ) {
				foreach ( $target_widgets as $widget ) {
					remove_meta_box( $widget, 'dashboard', $context );
				}
			}
		}

		wp_add_dashboard_widget(
			'custom_support_widget',
			'📌 ' . esc_html( $this->get_setting( 'widget_title', '運営・保守サポートのご案内' ) ),
			[ $this, 'render_support_widget' ]
		);
	}

	private function get_setting( $key, $default = '' ) {
		$options = get_option( $this->option_key );
		return isset( $options[$key] ) ? $options[$key] : $default;
	}

	public function render_support_widget() {
		$title   = $this->get_setting( 'content_title', 'このウェブサイトは安全に管理・保守されています' );
		$text    = $this->get_setting( 'content_text', 'サイトの運用方法や不具合に関するご質問は、下記窓口までお気軽にお問い合わせください。' );
		$company = $this->get_setting( 'company_name', 'Image-box Co., Ltd.' );
		$hours   = $this->get_setting( 'support_hours', '平日 10:00 〜 18:00' );
		$url     = $this->get_setting( 'button_url', 'mailto:support@example.com' );
		$label   = $this->get_setting( 'button_label', '✉️ サポート窓口へ連絡する' );

		// mailto: から始まる場合は esc_url ではなく sanitize_url / esc_attr で安全に出力
		$clean_url = ( strpos( $url, 'mailto:' ) === 0 ) ? esc_attr( $url ) : esc_url( $url );
		?>
		<div style="padding: 12px 4px; font-size: 14px; line-height: 1.6;">
			<div style="margin-bottom: 15px; border-bottom: 1px solid #ccd0d4; padding-bottom: 12px;">
				<p style="margin-top: 0; font-weight: bold; font-size: 15px; color: #1d2327;"><?php echo esc_html( $title ); ?></p>
				<p style="color: #50575e; margin: 0; white-space: pre-wrap;"><?php echo esc_html( $text ); ?></p>
			</div>
			<table style="margin: 0 0 20px 0; width: 100%; border-collapse: collapse;">
				<?php if ( $company ) : ?><tr style="display: flex; padding: 4px 0;"><th style="width: 100px; text-align: left; font-weight: bold; color: #50575e;">サポート担当</th><td style="color: #1d2327;"><?php echo esc_html( $company ); ?></td></tr><?php endif; ?>
				<?php if ( $hours ) : ?><tr style="display: flex; padding: 4px 0;"><th style="width: 100px; text-align: left; font-weight: bold; color: #50575e;">対応時間</th><td style="color: #1d2327;"><?php echo esc_html( $hours ); ?></td></tr><?php endif; ?>
			</table>
			<?php if ( $url ) : ?>
			<div>
				<a href="<?php echo $clean_url; ?>" class="button button-primary button-large" style="font-weight: bold; text-decoration: none;">
					<?php echo esc_html( $label ); ?>
				</a>
			</div>
			<?php endif; ?>
		</div>
		<style>#custom_support_widget { width: 100% !important; } #custom_support_widget .inside { margin-top: 0; padding-top: 0; } #custom_support_widget .postbox-header .hndle { justify-content: flex-start; }</style>
		<?php
	}

	public function add_settings_menu() {
		add_options_page(
			'Dashboard Customizer',
			'Dashboard Customizer',
			'manage_options',
			'dfk-customizer-settings',
			[ $this, 'render_settings_page' ]
		);
	}

	public function register_settings() {
		register_setting( $this->option_key, $this->option_key, [ $this, 'sanitize_settings' ] );
	}

	/**
	 * サニタイズ処理（mailto: スキームを許容する設計）
	 */
	public function sanitize_settings( $input ) {
		$sanitized = [];
		foreach ( $input as $key => $val ) {
			if ( $key === 'button_url' ) {
				$val = trim( $val );
				if ( strpos( $val, 'mailto:' ) === 0 ) {
					// mailto: の場合はメールとしての安全性を検証しつつ格納
					$email = str_replace( 'mailto:', '', $val );
					$sanitized[$key] = 'mailto:' . sanitize_email( $email );
				} else {
					$sanitized[$key] = esc_url_raw( $val );
				}
			} elseif ( $key === 'content_text' ) {
				$sanitized[$key] = sanitize_textarea_field( $val );
			} else {
				$sanitized[$key] = sanitize_text_field( $val );
			}
		}
		return $sanitized;
	}

	public function render_settings_page() {
		?>
		<div class="wrap">
			<h1>Dashboard Feed Killer & Customizer 設定</h1>
			<p class="description">ダッシュボードに表示する独自サポートウィジェットの表示内容をカスタマイズできます。</p>
			<hr>
			<form method="post" action="options.php">
				<?php
				settings_fields( $this->option_key );
				?>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="widget_title">ウィジェットの枠タイトル</label></th>
						<td><input type="text" id="widget_title" name="<?php echo $this->option_key; ?>[widget_title]" value="<?php echo esc_attr( $this->get_setting('widget_title', '運営・保守サポートのご案内') ); ?>" class="regular-text"></td>
					</tr>
					<tr>
						<th scope="row"><label for="content_title">見出しテキスト</label></th>
						<td><input type="text" id="content_title" name="<?php echo $this->option_key; ?>[content_title]" value="<?php echo esc_attr( $this->get_setting('content_title', 'このウェブサイトは安全に管理・保守されています') ); ?>" class="regular-text"></td>
					</tr>
					<tr>
						<th scope="row"><label for="content_text">案内本文</label></th>
						<td><textarea id="content_text" name="<?php echo $this->option_key; ?>[content_text]" rows="4" class="large-text"><?php echo esc_textarea( $this->get_setting('content_text', 'サイトの運用方法や不具合に関するご質問は、下記窓口までお気軽にお問い合わせください。') ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="company_name">サポート担当（会社名など）</label></th>
						<td><input type="text" id="company_name" name="<?php echo $this->option_key; ?>[company_name]" value="<?php echo esc_attr( $this->get_setting('company_name', 'Image-box Co., Ltd.') ); ?>" class="regular-text"></td>
					</tr>
					<tr>
						<th scope="row"><label for="support_hours">対応時間</label></th>
						<td><input type="text" id="support_hours" name="<?php echo $this->option_key; ?>[support_hours]" value="<?php echo esc_attr( $this->get_setting('support_hours', '平日 10:00 〜 18:00') ); ?>" class="regular-text"></td>
					</tr>
					<tr>
						<th scope="row"><label for="button_url">ボタンのリンク先（URL / メールアドレス）</label></th>
						<td>
							<input type="text" id="button_url" name="<?php echo $this->option_key; ?>[button_url]" value="<?php echo esc_attr( $this->get_setting('button_url', 'mailto:support@example.com') ); ?>" class="regular-text" placeholder="https://... または mailto:info@example.com">
							<p class="description">WebフォームのURL（https://〜）か、メール起動用の（mailto:アドレス）を入力してください。</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="button_label">ボタンのラベル</label></th>
						<td><input type="text" id="button_label" name="<?php echo $this->option_key; ?>[button_label]" value="<?php echo esc_attr( $this->get_setting('button_label', '✉️ サポート窓口へ連絡する') ); ?>" class="regular-text"></td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}
}

new DashboardFeedKiller();


require_once __DIR__ . '/plugin-update-checker/plugin-update-checker.php';

$updateChecker = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
	'https://github.com/ms13th-cyber/dashboard-feed-killer/',
	__FILE__,
	'dashboard-feed-killer'
);

$updateChecker->setBranch('main');