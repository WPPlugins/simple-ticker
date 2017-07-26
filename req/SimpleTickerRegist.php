<?php
/**
 * Simple Ticker
 * 
 * @package    SimpleTicker
 * @subpackage SimpleTicker registered in the database
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

class SimpleTickerRegist {

	/* ==================================================
	 * Settings register
	 * @since	1.0
	 */
	function register_settings(){

		if ( !get_option('simple_ticker') ) {
			$simple_ticker_tbl = array(
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
			update_option( 'simple_ticker', $simple_ticker_tbl );
		}

	}

}

?>