<?php
/**
 * Simple Ticker
 * 
 * @package    Simple Ticker
 * @subpackage SimpleTicker
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

class SimpleTicker {

	/*
	 * Main
	 * @param	string	$ticker1_color
	 * @param	string	$ticker1_text
	 * @param	string	$ticker2_color
	 * @param	string	$ticker2_text
	 * @param	string	$ticker3_color
	 * @param	string	$ticker3_text
	 * @param	bool	$sticky_posts_display
	 * @param	string	$sticky_posts_title_color
	 * @param	string	$sticky_posts_content_color
	 * @return	string	$ticker_html
	 * @since	1.0
	 */
	function read_tickers($ticker1_color, $ticker1_text, $ticker2_color, $ticker2_text, $ticker3_color, $ticker3_text, $sticky_posts_display, $sticky_posts_title_color, $sticky_posts_content_color) {

		$simpleticker_option = get_option('simple_ticker');

		if ( empty($ticker1_color) ) { $ticker1_color = $simpleticker_option['ticker1']['color']; }
		if ( empty($ticker1_text) ) { $ticker1_text = $simpleticker_option['ticker1']['text']; }
		if ( empty($ticker2_color) ) { $ticker2_color = $simpleticker_option['ticker2']['color']; }
		if ( empty($ticker2_text) ) { $ticker2_text = $simpleticker_option['ticker2']['text']; }
		if ( empty($ticker3_color) ) { $ticker3_color = $simpleticker_option['ticker3']['color']; }
		if ( empty($ticker3_text) ) { $ticker3_text = $simpleticker_option['ticker3']['text']; }

		if ( empty($sticky_posts_display) ) { $sticky_posts_display = $simpleticker_option['sticky_posts']['display']; }
		if ( empty($sticky_posts_title_color) ) { $sticky_posts_title_color = $simpleticker_option['sticky_posts']['title_color']; }
		if ( empty($sticky_posts_content_color) ) { $sticky_posts_content_color = $simpleticker_option['sticky_posts']['content_color']; }


		$ticker_html = NULL;

		if ( !empty($ticker1_text) ) {
			$ticker_html .= '<div><marquee><font color='.$ticker1_color.'><b>';
			$ticker_html .= ' '.$ticker1_text;
			$ticker_html .= '</b></font></marquee></div>';
		}
		if ( !empty($ticker2_text) ) {
			$ticker_html .= '<div><marquee><font color='.$ticker2_color.'><b>';
			$ticker_html .= ' '.$ticker2_text;
			$ticker_html .= '</b></font></marquee></div>';
		}
		if ( !empty($ticker3_text) ) {
			$ticker_html .= '<div><marquee><font color='.$ticker3_color.'><b>';
			$ticker_html .= ' '.$ticker3_text;
			$ticker_html .= '</b></font></marquee></div>';
		}

		if ( $sticky_posts_display == 1 ) {
			$stickies = get_option( 'sticky_posts' );
			if ( !empty($stickies) ) {
				rsort( $stickies );
				foreach ( $stickies as $sticky ) {
					$post = NULL;
					$title = NULL;
					$content = NULL;
					$post = get_post($sticky);
					$title = $post->post_title;
					$content = $this->html_text($post->post_content);
					$ticker_html .= '<div><marquee><font color='.$sticky_posts_title_color.'><b>';
					$ticker_html .= ' '.$title.':';
					$ticker_html .= '</b></font>';
					$ticker_html .= '<font color='.$sticky_posts_content_color.'><b>';
					$ticker_html .= $content;
					$ticker_html .= '</b></font></marquee></div>';
				}
			}
		}

		return $ticker_html;

	}

	/* ==================================================
	 * short code
	 * @param	array	$atts
	 * @return	string	$this->read_tickers()
	 */
	function simpleticker_func( $atts ) {

		extract(shortcode_atts(array(
			'ticker1_color' => '',
			'ticker1_text' => '',
			'ticker2_color' => '',
			'ticker2_text' => '',
			'ticker3_color' => '',
			'ticker3_text' => '',
			'sticky_posts_display' => '',
			'sticky_posts_title_color' => '',
			'sticky_posts_content_color' => ''
		), $atts));

		return $this->read_tickers($ticker1_color, $this->html_text($ticker1_text), $ticker2_color, $this->html_text($ticker2_text), $ticker3_color, $this->html_text($ticker3_text), $sticky_posts_display, $sticky_posts_title_color, $sticky_posts_content_color);

	}

	/*
	 * @param	string	$html
	 * @return	string	$text
	 * @since	1.0
	 */
	function html_text($html) {

		$text = strip_tags($html);
		$text = str_replace(array("\r", "\n"), '', $text);

		return $text;

	}

}

?>