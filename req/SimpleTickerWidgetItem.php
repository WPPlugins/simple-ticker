<?php
/**
 * Simple Ticker
 * 
 * @package    SimpleTicker
 * @subpackage SimpleTicker Widget
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

/* ==================================================
 * Widget
 * @since	1.0
 */
class SimpleTickerWidgetItem extends WP_Widget {

	function __construct() {
		parent::__construct(
			'SimpleTickerWidgetItem', // Base ID
			__( 'Ticker', 'simple-ticker' ), // Name
			array( 'description' => __( 'Ticker from SimpleTicker.', 'simple-ticker'), ) // Args
		);
	}

	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		if ($title) {
			echo $before_widget;
			echo $before_title . $title . $after_title;
			include_once( SIMPLETICKER_PLUGIN_BASE_DIR . '/inc/SimpleTicker.php' );
			$simpleticker = new SimpleTicker();
			echo $simpleticker->read_tickers(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
			unset($simpleticker);
			echo $after_widget;
		}

	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	
	function form($instance) {

		if (isset($instance['title'])) {
			$title = esc_attr($instance['title']);
		} else {
			$title = NULL;
		}

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title'); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<?php
	}

}

?>