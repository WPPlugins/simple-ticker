<?php
/**
 * Simple Ticker
 * 
 * @package    SimpleTicker
 * @subpackage SimpleTicker Management screen
    Copyright (c) 2016- Katsushi Kawamori (email : dodesyoswift312@gmail.com)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; version 2 of the License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

class SimpleTickerAdmin {

	/* ==================================================
	 * Add a "Settings" link to the plugins page
	 * @since	1.0
	 */
	function settings_link( $links, $file ) {
		static $this_plugin;
		if ( empty($this_plugin) ) {
			$this_plugin = SIMPLETICKER_PLUGIN_BASE_FILE;
		}
		if ( $file == $this_plugin ) {
			$links[] = '<a href="'.admin_url('options-general.php?page=SimpleTicker').'">'.__( 'Settings').'</a>';
		}
			return $links;
	}

	/* ==================================================
	 * Settings page
	 * @since	1.0
	 */
	function plugin_menu() {
		add_options_page( 'Simple Ticker Options', 'Simple Ticker', 'manage_options', 'SimpleTicker', array($this, 'plugin_options') );
	}

	/* ==================================================
	 * Add Css and Script
	 * @since	1.0
	 */
	function load_custom_wp_admin_style() {
		if ($this->is_my_plugin_screen()) {
			wp_enqueue_style( 'jquery-responsiveTabs', SIMPLETICKER_PLUGIN_URL.'/css/responsive-tabs.css' );
			wp_enqueue_style( 'jquery-responsiveTabs-style', SIMPLETICKER_PLUGIN_URL.'/css/style.css' );
			wp_enqueue_script('jquery');
			wp_enqueue_script( 'jquery-responsiveTabs', SIMPLETICKER_PLUGIN_URL.'/js/jquery.responsiveTabs.min.js' );
			wp_enqueue_script( 'jquery-jscolor', SIMPLETICKER_PLUGIN_URL.'/js/jscolor.min.js' );
			wp_enqueue_script( 'simpleticker-js', SIMPLETICKER_PLUGIN_URL.'/js/jquery.simpleticker.js', array('jquery') );
		}
	}

	/* ==================================================
	 * For only admin style
	 * @since	1.0
	 */
	function is_my_plugin_screen() {
		$screen = get_current_screen();
		if (is_object($screen) && $screen->id == 'settings_page_SimpleTicker') {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/* ==================================================
	 * Settings page
	 * @since	1.0
	 */
	function plugin_options() {

		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}


		if( !empty($_POST) ) {
			$post_nonce_field = 'simpleticker_tabs';
			if ( isset($_POST[$post_nonce_field]) && $_POST[$post_nonce_field] ) {
				if ( check_admin_referer( 'simpleticker_settings', $post_nonce_field ) ) {
					$this->options_updated(intval($_POST['simpleticker_admin_tabs']));
				}
			}
		}

		$scriptname = admin_url('options-general.php?page=SimpleTicker');

		$simpleticker_option = get_option('simple_ticker');

		?>

	<div class="wrap">
	<h2>Simple Ticker</h2>

	<div id="simpleticker-admin-tabs">
	  <ul>
	    <li><a href="#simpleticker-admin-tabs-1"><?php _e('How to use', 'simple-ticker'); ?></a></li>
	    <li><a href="#simpleticker-admin-tabs-2"><?php _e('Settings'); ?></a></li>
		<li><a href="#simpleticker-admin-tabs-3"><?php _e('Donate to this plugin &#187;'); ?></a></li>
	<!--
		<li><a href="#simpleticker-admin-tabs-4">FAQ</a></li>
	 -->
	  </ul>
	  <div id="simpleticker-admin-tabs-1">
		<div class="wrap">

			<h2><?php _e('How to use', 'simple-ticker'); ?></h2>

			<div style="width: 100%; height: 100%; margin: 5px; padding: 5px; border: #CCC 2px solid;">
				<h3><?php _e('Set the widget', 'simple-ticker'); ?></h3>
				<?php
				$widget_html = '<a href="'.admin_url('widgets.php').'" style="text-decoration: none; word-break: break-all;">'.__('Widgets').'['.__( 'Ticker', 'simple-ticker' ).']</a>';
				?>
				<div style="padding: 5px 20px; font-weight: bold;"><?php echo sprintf(__('Please set the %1$s.', 'simple-ticker'), $widget_html); ?></div>
			</div>

			<div style="width: 100%; height: 100%; margin: 5px; padding: 5px; border: #CCC 2px solid;">
				<h3><?php _e('Set up a shortcode', 'simple-ticker'); ?></h3>

				<div style="padding: 5px 20px; font-weight: bold;"><?php _e('Example', 'simple-ticker'); ?></div>
				<div style="padding: 5px 25px;"><?php _e('to the post or pages', 'simple-ticker'); ?></div>
				<div style="padding: 5px 35px;"><code>[simpleticker]</code></div>
				<div style="padding: 5px 35px;"><code>[simpleticker ticker1_text="Ticker test!!" ticker1_color="#008000" sticky_posts_display=FALSE]</code></div>
				<div style="padding: 5px 25px;"><?php _e('to the template of the theme', 'simple-ticker'); ?></div>
				<div style="padding: 5px 35px;"><code>&lt;?php echo do_shortcode('[simpleticker]'); ?&gt</code></div>
				<div style="padding: 5px 35px;"><code>&lt;?php echo do_shortcode('[simpleticker ticker1_text="Ticker test!!" ticker1_color="#008000" sticky_posts_display=FALSE]'); ?&gt</code></div>

				<div style="padding: 5px 20px; font-weight: bold;"><?php _e('Description of each attribute', 'simple-ticker'); ?></div>

				<div style="padding: 5px 35px;"><?php _e('Text of ticker', 'simple-ticker'); ?> : <code>ticker1_text</code> <code>ticker2_text</code> <code>ticker3_text</code></div>
				<div style="padding: 5px 35px;"><?php _e('Color of ticker', 'simple-ticker'); ?> : <code>ticker1_color</code> <code>ticker2_color</code> <code>ticker3_color</code></div>
				<div style="padding: 5px 35px;"><?php _e('Boolean value of sticky_posts', 'simple-ticker'); ?> : <code>sticky_posts_display</code></div>
				<div style="padding: 5px 35px;"><?php _e('Title color of sticky_posts', 'simple-ticker'); ?> : <code>sticky_posts_title_color</code></div>
				<div style="padding: 5px 35px;"><?php _e('Content color of sticky_posts', 'simple-ticker'); ?> : <code>sticky_posts_content_color</code></div>

				<?php
				$settings_html = '<a href="'.$scriptname.'#simpleticker-admin-tabs-2" style="text-decoration: none; word-break: break-all;">'.__('Settings', 'simple-ticker').'</a>';
				?>
				<div style="padding: 5px 20px; font-weight: bold;"><?php echo sprintf(__('Attribute value of short codes can also be specified in the %1$s. Attribute value of the short code takes precedence.', 'simple-ticker'), $settings_html); ?></div>
			</div>

		</div>
	  </div>

	  <div id="simpleticker-admin-tabs-2">
		<div class="wrap">

			<h2><?php _e('Settings'); ?></h2>	

			<form method="post" action="<?php echo $scriptname.'#simpleticker-admin-tabs-2'; ?>">
			<?php wp_nonce_field('simpleticker_settings', 'simpleticker_tabs'); ?>

			<div class="submit">
			  <input type="submit" class="button" name="Submit" value="<?php _e('Save Changes') ?>" />
			  <input type="submit" class="button" name="Default" value="<?php _e('Default') ?>" />
			</div>

			<div style="width: 100%; height: 100%; margin: 5px; padding: 5px; border: #CCC 2px solid;">

				<div style="display: block; padding:5px 5px;">
					<h3><?php _e('Own Ticker', 'simple-ticker'); ?></h3>
					<div style="display: block; padding:5px 20px;">
						<?php _e('Ticker1', 'simple-ticker'); ?> : 
						<div style="display: block; padding:5px 35px;">
							<div>
							<?php _e('Text', 'simple-ticker'); ?> : 
							<textarea name="simpleticker_ticker1_text" rows="4" cols="40" style="vertical-align: top"><?php echo $simpleticker_option['ticker1']['text']; ?></textarea>
							</div>
							<div>
							<?php _e('Color', 'simple-ticker'); ?> : 
							<input type="text" class="jscolor" name="simpleticker_ticker1_color" value="<?php echo $simpleticker_option['ticker1']['color']; ?>" size="10" />
							</div>
						</div>
					</div>
					<div style="display: block; padding:5px 20px;">
						<?php _e('Ticker2', 'simple-ticker'); ?> : 
						<div style="display: block; padding:5px 35px;">
							<div>
							<?php _e('Text', 'simple-ticker'); ?> : 
							<textarea name="simpleticker_ticker2_text" rows="4" cols="40" style="vertical-align: top"><?php echo $simpleticker_option['ticker2']['text']; ?></textarea>
							</div>
							<div>
							<?php _e('Color', 'simple-ticker'); ?> : 
							<input type="text" class="jscolor" name="simpleticker_ticker2_color" value="<?php echo $simpleticker_option['ticker2']['color']; ?>" size="10" />
							</div>
						</div>
					</div>
					<div style="display: block; padding:5px 20px;">
						<?php _e('Ticker3', 'simple-ticker'); ?> : 
						<div style="display: block; padding:5px 35px;">
							<div>
							<?php _e('Text', 'simple-ticker'); ?> : 
							<textarea name="simpleticker_ticker3_text" rows="4" cols="40" style="vertical-align: top"><?php echo $simpleticker_option['ticker3']['text']; ?></textarea>
							</div>
							<div>
							<?php _e('Color', 'simple-ticker'); ?> : 
							<input type="text" class="jscolor" name="simpleticker_ticker3_color" value="<?php echo $simpleticker_option['ticker3']['color']; ?>" size="10" />
							</div>
						</div>
					</div>
				</div>
			</div>
			<div style="width: 100%; height: 100%; margin: 5px; padding: 5px; border: #CCC 2px solid;">
				<div style="display: block; padding:5px 5px;">
					<h3><?php _e('Sticky Posts', 'simple-ticker'); ?></h3>
					<div style="display: block; padding:5px 20px;">
						<input type="checkbox" name="simpleticker_sticky_posts" value="1" <?php checked('1', $simpleticker_option['sticky_posts']['display']); ?> />
						<?php _e('Include sticky_posts', 'simple-ticker'); ?>
					</div>
					<div style="display: block; padding:5px 35px;">
						<?php _e('Title color', 'simple-ticker'); ?> : 
						<input type="text" class="jscolor" name="simpleticker_sticky_posts_titlecolor" value="<?php echo $simpleticker_option['sticky_posts']['title_color']; ?>" size="10" />
					</div>
					<div style="display: block; padding:5px 35px;">
						<?php _e('Content color', 'simple-ticker'); ?> : 
						<input type="text" class="jscolor" name="simpleticker_sticky_posts_contentcolor" value="<?php echo $simpleticker_option['sticky_posts']['content_color']; ?>" size="10" />
					</div>
				</div>
			</div>

			<div class="submit">
				<input type="hidden" name="simpleticker_admin_tabs" value="2" />
				<input type="submit" class="button" name="Submit" value="<?php _e('Save Changes') ?>" />
			</div>

			</form>

		</div>
	  </div>

	  <div id="simpleticker-admin-tabs-3">
		<div class="wrap">
			<?php
			$plugin_datas = get_file_data( SIMPLETICKER_PLUGIN_BASE_DIR.'/simpleticker.php', array('version' => 'Version') );
			$plugin_version = __('Version:').' '.$plugin_datas['version'];
			?>
			<h4 style="margin: 5px; padding: 5px;">
			<?php echo $plugin_version; ?> |
			<a style="text-decoration: none;" href="https://wordpress.org/support/plugin/simple-ticker" target="_blank"><?php _e('Support Forums') ?></a> |
			<a style="text-decoration: none;" href="https://wordpress.org/support/view/plugin-reviews/simple-ticker" target="_blank"><?php _e('Reviews', 'simple-ticker') ?></a>
			</h4>
			<div style="width: 250px; height: 170px; margin: 5px; padding: 5px; border: #CCC 2px solid;">
			<h3><?php _e('Please make a donation if you like my work or would like to further the development of this plugin.', 'simple-ticker'); ?></h3>
			<div style="text-align: right; margin: 5px; padding: 5px;"><span style="padding: 3px; color: #ffffff; background-color: #008000">Plugin Author</span> <span style="font-weight: bold;">Katsushi Kawamori</span></div>
	<a style="margin: 5px; padding: 5px;" href='https://pledgie.com/campaigns/28307' target="_blank"><img alt='Click here to lend your support to: Various Plugins for WordPress and make a donation at pledgie.com !' src='https://pledgie.com/campaigns/28307.png?skin_name=chrome' border='0' ></a>
			</div>
		</div>
	  </div>

	<!--
	  <div id="simpleticker-admin-tabs-4">
		<div class="wrap">
		<h2>FAQ</h2>

		</div>
	  </div>
	-->

	</div>
	</div>
	<?php

	}

	/* ==================================================
	 * Update wp_options table.
	 * @param	string	$tabs
	 * @since	1.0
	 */
	function options_updated($tabs){


		include_once( SIMPLETICKER_PLUGIN_BASE_DIR . '/inc/SimpleTicker.php' );
		$simpleticker = new SimpleTicker();

		$simple_ticker_reset_tbl = array(
								'ticker1' => array(
											'text' => '',
											'color' => '#ff0000'
											),
								'ticker2' => array(
											'text' => '',
											'color' => '#ffff00'
											),
								'ticker3' => array(
											'text' => '',
											'color' => '#008000'
											),
								'sticky_posts' => array(
											'display' => TRUE,
											'title_color' => '#ff0000',
											'content_color' => '#000000'
											)
								);

		switch ($tabs) {
			case 1:
				break;
			case 2:
				if ( !empty($_POST['Default']) ) {
					update_option( 'simple_ticker', $simple_ticker_reset_tbl );
					echo '<div class="updated"><ul><li>'.__('Settings').' --> '.__('Default').' --> '.__('Changes saved.').'</li></ul></div>';
				} else {
					if ( !empty($_POST['simpleticker_ticker1_text']) ) {
						$simpleticker_ticker1_text = $_POST['simpleticker_ticker1_text'];
					} else {
						$simpleticker_ticker1_text = NULL;
					}
					if ( !empty($_POST['simpleticker_ticker2_text']) ) {
						$simpleticker_ticker2_text = $_POST['simpleticker_ticker2_text'];
					} else {
						$simpleticker_ticker2_text = NULL;
					}
					if ( !empty($_POST['simpleticker_ticker3_text']) ) {
						$simpleticker_ticker3_text = $_POST['simpleticker_ticker3_text'];
					} else {
						$simpleticker_ticker3_text = NULL;
					}
					if ( !empty($_POST['simpleticker_sticky_posts']) ) {
						$simpleticker_sticky_posts = intval($_POST['simpleticker_sticky_posts']);
					} else {
						$simpleticker_sticky_posts = FALSE;
					}
					$simple_ticker_tbl = array(
									'ticker1' => array(
												'text' => $simpleticker->html_text($simpleticker_ticker1_text),
												'color' => $_POST['simpleticker_ticker1_color']
												),
									'ticker2' => array(
												'text' => $simpleticker->html_text($simpleticker_ticker2_text),
												'color' => $_POST['simpleticker_ticker2_color']
												),
									'ticker3' => array(
												'text' => $simpleticker->html_text($simpleticker_ticker3_text),
												'color' => $_POST['simpleticker_ticker3_color']
												),
									'sticky_posts' => array(
												'display' => $simpleticker_sticky_posts,
												'title_color' => $_POST['simpleticker_sticky_posts_titlecolor'],
												'content_color' => $_POST['simpleticker_sticky_posts_contentcolor']
												)
								);
					update_option( 'simple_ticker', $simple_ticker_tbl );
					echo '<div class="updated"><ul><li>'.__('Settings').' --> '.__('Changes saved.').'</li></ul></div>';
				}
				break;
		}

		unset($simpleticker);

		return;

	}

}

?>