<?php

class td_instagram {

    private static $caching_time = 10800;  // 3 hours
    private static $instagram_connected_account = array(); // saved ig business connected accounts
    private static $instagram_media_data_limit = 10; // the graph instagram api media feeds limit - get the first 10 feeds by default @note this is overwritten by block's attributes @see self::render_generic

    /**
     * @param $atts - the Instagram block attributes
     * @return string - the block html
     */
    public static function render_generic( $atts ) {

        // demo
        $demo_array = self::render_demo($atts);
        if ( $demo_array['status'] === 'ok' && !empty( $demo_array['buffy'] ) ) {
            // render the HTML
            $buffy = '<!-- td instagram source: DEMO -->';

            // renders the block template
            $buffy .= $demo_array['buffy'];

            return $buffy;
        }

	    // get saved ig business connected accounts
	    $td_instagram_business_accounts = td_options::get_array( 'td_instagram_business_accounts');

        //return td_util::get_block_error('Instagram',
        //    '<br><br><b>instagram_account_source:</b> ' . '<pre style="margin: 0; white-space: pre-wrap; word-break: break-all;"> ' . print_r( $atts['instagram_account_source'], true) . ' </pre>' .
        //    '<br><br><b>Atts:</b> ' . '<pre style="margin: 0; white-space: pre-wrap; word-break: break-all;"> ' . print_r( $atts, true) . ' </pre>' .
        //    '<br><br><b>saved ig business accounts:</b> ' . '<pre style="margin: 0; white-space: pre-wrap; word-break: break-all;"> ' . print_r( $td_instagram_business_accounts, true) . ' </pre>'
        //);

        // instagram_account_source ... set $instagram_connected_account
	    if ( !empty( $atts['instagram_account_source'] ) ) {

	        switch ( $atts['instagram_account_source'] ) {
                case 'ig_id':
                case 'ig_personal':

                    $instagram_account_source = $atts['instagram_account_source'] === 'ig_id' ? 'Instagram ID' : 'Instagram Personal Account';

                    return td_util::get_block_error(
                        'Instagram',
                        'Block Render Failed - <b>' . $instagram_account_source . '</b> has been discontinued ! Please connect & configure a <a href="' . admin_url('admin.php?page=td_theme_panel#td-panel-social-networks/box=facebook_account') . '" target="_blank">Business Account</a> and update the <b>Instagram Account</b> setting of this block in the <b>Instragram</b> tab.'
                    );

                case ( strpos( $atts['instagram_account_source'], 'ig_business_' ) !== false ):

	                // saved ig business connected accounts
	                $account_username = str_replace( 'ig_business_', '', $atts['instagram_account_source'] );

	                if ( !empty($td_instagram_business_accounts) && is_array($td_instagram_business_accounts) ) {

	                    foreach ( $td_instagram_business_accounts as $acc_id => $ig_business_account ) {
	                        if (
                                $acc_id === $account_username ||
                                ( isset($ig_business_account['username']) && $ig_business_account['username'] === $account_username )
                            ) {
		                        self::$instagram_connected_account = $ig_business_account;
		                        break;
                            }
                        }

	                    // if ig account was not set return block error
	                    if ( empty(self::$instagram_connected_account) ) {

		                    return td_util::get_block_error(
			                    'Instagram',
			                    'Block Render Failed - Instagram Business Account: <b>' . $account_username . '</b> not found! Please <a href="' . admin_url('admin.php?page=td_theme_panel#td-panel-social-networks/box=facebook_account') . '" target="_blank">connect your Business Instagram Account</a>.'
		                    );

                        }

	                } else {
		                return td_util::get_block_error(
			                'Instagram',
			                'Block Render Failed - There are no Instagram Business accounts connected! Please <a href="' . admin_url('admin.php?page=td_theme_panel#td-panel-social-networks/box=facebook_account') . '" target="_blank">connect your <b>' . $account_username . '</b> Business Instagram Account</a>.'
		                );
	                }

                    break;
            }

        } else {

            // no instagram business account set
            return td_util::get_block_error(
                'Instagram',
                'Block Render Failed - No Instagram Business Account set! Please connect & set a <a href="' . admin_url('admin.php?page=td_theme_panel#td-panel-social-networks/box=facebook_account') . '" target="_blank">Instagram Business Account</a>.'
            );

        }

	    // number of images per row - by default display 3 images
	    $images_per_row = 3;
	    if ( !empty( $atts['instagram_images_per_row'] ) ) {
		    $images_per_row = $atts['instagram_images_per_row'];
	    }

	    // number of rows
	    $number_of_rows = 1;
	    if ( !empty( $atts['instagram_number_of_rows'] ) ) {
		    $number_of_rows = $atts['instagram_number_of_rows'];
	    }

	    // number of total images displayed - images_row x number_of_rows
	    self::$instagram_media_data_limit = $images_per_row * $number_of_rows;

        // prepare the data
        $instagram_data = array(
            'user' => '',
        );

        // get instagram data
        if ( !empty( self::$instagram_connected_account ) ) {
	        
		    // if we have an account connected we can try to get the data using the account access token
		    $instagram_data_status = self::get_instagram_data_with_token( self::$instagram_connected_account, $instagram_data );
		    
	    } else {
		    return td_util::get_block_error(
			    'Instagram',
			    'Block Render Failed - No data received, please connect & configure a <a href="' . admin_url('admin.php?page=td_theme_panel#td-panel-social-networks/box=facebook_account') . '" target="_blank">Business Account</a>.'
            );
        }

        // check if we have an error and return that
        if ( $instagram_data_status != 'instagram_fail_cache' and
             $instagram_data_status != 'instagram_cache_updated' and
             $instagram_data_status != 'instagram_cache'
        ) {
	        return $instagram_data_status;
        }

        // render the HTML
        $buffy = '<!-- td instagram source: ' . $instagram_data_status . ' -->';

        // renders the block template
        $buffy .= self::render_block_template( $atts, $instagram_data );

        return $buffy;

    }

    /**
     * @param $atts - the block attributes
     * @param $instagram_data - the instagram user data
     * @return string - the rendered block html
     */
    private static function render_block_template( $atts, $instagram_data ) {

        // determine the instagram user name
        $instagram_user = $instagram_data['user']['instagram_id'] ?? '';

        // stop render if no user data was received
        if ( $instagram_data['user'] == '' ) {
	        return td_util::get_block_error(
                'Instagram',
                'Block render Failed - no data received, please check connected account data for user: ' . $instagram_user
            );
        }

        ob_start();

        // number of images per row - by default display 3 images
        $images_per_row = 3;
        if ( !empty( $atts['instagram_images_per_row'] ) ) {
            $images_per_row = $atts['instagram_images_per_row'];
        }

        // number of rows
        $number_of_rows = 1;
        if ( !empty( $atts['instagram_number_of_rows'] ) ) {
            $number_of_rows = $atts['instagram_number_of_rows'];
        }

        // number of total images displayed - images_row x number_of_rows
        $images_total_number = $images_per_row * $number_of_rows;

        // image gap
        $image_gap = '';
        if ( !empty( $atts['instagram_margin'] ) ) {
            $image_gap = ' td-image-gap-' . $atts['instagram_margin'];
        }

        // link rel
        $rel = '';
        if ( !empty( $atts['instagram_rel'] ) ) {
            $rel = ' rel="' . $atts['instagram_rel'] . '"';
        }

        // profile picture
        $instagram_profile_picture = '';
        if( isset($atts['instagram_user_photo']) && $atts['instagram_user_photo'] != '' ) {
            $instagram_profile_picture = tdc_util::get_image_or_placeholder($atts['instagram_user_photo']);
        } else if ( isset( $instagram_data['user']['profile_pic_url'] ) ) {
            $instagram_profile_picture = $instagram_data['user']['profile_pic_url'];
        }

        // instagram followers
        $instagram_followers = 0;
        if ( isset( $instagram_data['user']['edge_followed_by']['count'] ) ) {
            $instagram_followers = $instagram_data['user']['edge_followed_by']['count'];
        }

        if ( !empty($instagram_followers) ) {

	        // instagram followers - check followers count data type
	        $instagram_followers_type = gettype($instagram_followers);
	        if ( $instagram_followers_type === 'string' ) {

		        // retrieve number from string
		        $number_from_string = self::get_number_from_string($instagram_followers);
		        if ( $number_from_string !== false ) {
			        $instagram_followers = $number_from_string;
		        } else {

                    // log unsupported type debug msg
			        td_log::log(
                        __FILE__,
                        __FUNCTION__,
                        'Instagram followers is a string with no numbers included',
                        [
                            '$instagram_followers_type' => $instagram_followers_type,
                            '$instagram_followers' => $instagram_followers,
                            '$instagram_user' => $instagram_user
                        ]
                    );

			        $instagram_followers = 0;

		        }

	        } elseif ( $instagram_followers_type === 'integer' ) {
		        // do nothing, integer is ok
	        } else {

                // log unsupported type debug msg
		        td_log::log(
                    __FILE__,
                    __FUNCTION__,
                    'Instagram followers has an unsupported type',
                    [
                        '$instagram_followers_type' => $instagram_followers_type,
                        '$instagram_followers' => $instagram_followers,
                        '$instagram_user' => $instagram_user
                    ]
                );

                // for other types return 0
		        $instagram_followers = 0;

	        }

	        // instagram followers - format the followers number (the number is not rounded because it may return unrealistic values)
	        if ( $instagram_followers >= 1000000 ) {
		        // display 1.100.000 as 1.1m
		        $instagram_followers = number_format_i18n($instagram_followers / 1000000, 1) . 'm';
	        } elseif ( $instagram_followers >= 10000 ) {
		        // display 10.100 as 10.1k
		        $instagram_followers = number_format_i18n($instagram_followers / 1000, 1) . 'k';
	        } else {
		        // default
		        $instagram_followers = number_format_i18n($instagram_followers);
	        }

        }

        ?>
        <!-- header section -->
        <?php
        if ( empty( $atts['instagram_header'] ) ) {
            ?>
            <div class="td-instagram-header">
                <div class="td-instagram-profile-image">
                    <!-- profile img -->
                    <?php
                    if ( ! empty( $instagram_profile_picture ) ) {
                    ?>
                        <div class="td-instagram-profile-image-elem" style="background-image: url(<?php echo $instagram_profile_picture ?>)"></div>
                    <?php
                    } else {
                    ?>
                        <svg class="sbi_new_logo fa-instagram fa-w-14"
                             aria-hidden="true"
                             data-fa-processed=""
                             aria-label="Instagram"
                             data-prefix="fab"
                             data-icon="instagram"
                             role="img"
                             viewBox="0 0 448 512"
                             style="
                                position: absolute;
                                top: 49%;
                                left: 52%;
                                margin-top: -14px;
                                margin-left: -16px;
                                width: 30px;
                                height: 30px;
                                font-size: 30px;
                             "
                        >
                            <path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path>
                        </svg>
                    <?php
                    }
                    ?>
                </div>
                <div class="td-instagram-meta">
                    <div class="td-instagram-user"><a href="https://www.instagram.com/<?php echo self::strip_instagram_user($instagram_user) ?>" target="_blank">@<?php echo self::strip_instagram_user($instagram_user) ?></a></div>
                    <!-- followers -->
	                <?php
	                if ( ! empty( $instagram_followers ) ) {
		                ?>
                        <div class="td-instagram-followers"><span><?php echo $instagram_followers . '</span> ' .  __td('Followers', TD_THEME_NAME); ?></div>
		                <?php
	                }
	                ?>
                    <a class="td-instagram-button" href="https://www.instagram.com/<?php echo self::strip_instagram_user($instagram_user) ?>" target="_blank"><?php echo __td('Follow', TD_THEME_NAME); ?></a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <?php
        }
        ?>

        <!-- user feeds -->
        <?php
        $user_feeds = $instagram_data['user']['feeds'] ?? [];
        if ( $user_feeds ) {
            ?>
            <div class="td-instagram-main td-images-on-row-<?php echo $images_per_row . $image_gap; ?>">
                <?php
                $feed_count = 0;
                foreach ( $user_feeds as $feed ) {

                    $media_type = strtolower( str_replace( '_ALBUM','', $feed['media_type'] ) );
                    $image_size = ( isset( $atts['instagram_images_size'] ) && $atts['instagram_images_size'] != '' ) ? $atts['instagram_images_size'] : 'full';
                    $feed_attachment_id = $feed['attachment_id'] ?? '';

                    if ( !empty($feed_attachment_id) ) {
                        $attachment_image_url = wp_get_attachment_image_url( $feed_attachment_id, $image_size );
                        $media_url = $attachment_image_url ?: ( $media_type === 'video' ? $feed['thumbnail_url'] : $feed['media_url'] );
                    } else {
                        $media_url = $media_type === 'video' ? $feed['thumbnail_url'] : $feed['media_url'];
                    }

                    ?>
                    <div class="td-instagram-element">
                        <!-- image -->
                        <a class="td-instagram-image" href="<?php echo $feed['permalink'] ?>" <?php echo $rel ?> aria-label="instagram-image" target="_blank" style="background-image: url(<?php echo $media_url ?>)">
                        </a>
                        <!-- video icon -->
                        <?php
                        if ( $media_type === 'video' ) {
                            ?>
                            <span class="td-video-play-ico">
                                <i class="td-icon-video-thumb-play"></i>
                            </span>
                            <?php
                        } elseif ( $media_type === 'carousel' ) {
                            ?>
                            <span class="td-video-play-ico td-insta-carousel-ico">
                                <i class="td-icon-insta-carousel"></i>
                            </span>
                            <?php
                        }
                        ?>
                    </div>
                    <!-- number of feeds to display -->
                    <?php
                    $feed_count ++;
                    if ( $feed_count == $images_total_number ) {
                        break;
                    }
                }
                ?>
                <div class="clearfix"></div>
            </div>
            <?php
        }

        return ob_get_clean();
    }

    /**
     * @param $str
     * @return bool|int
     * - bool: false - $str is not a string or we don't have a number
     * - integer - return the number
     */
    private static function get_number_from_string( $str ) {

        // no string received
        if ( gettype($str) !== 'string' ) {
            return false;
        }

        // retrieve the numbers
        $string_length = strlen($str);
        $id = '';
        for( $i = 0; $i <= $string_length; $i++ ) {
            $char = substr($str, $i, 1);
            if( is_numeric($char) ) {
                $id .= $char;
            }
        }

        // we have a number
        if ( $id != '' ) {
            return intval($id);
        }

        return false;

    }

	/**
	 * @param $connected_account - the Instagram account connected from theme's panel > social networks
	 * @param $instagram_data
	 *
	 * @return string - the data retrieval status
	 */
	private static function get_instagram_data_with_token( $connected_account, &$instagram_data ) {

		$cache_key = 'td_instagram_tk_' . strtolower( $connected_account['username'] );

		$instagram_cached_data_feeds_limit = self::$instagram_media_data_limit;
		$instagram_cached_data = td_remote_cache::get(__CLASS__, $cache_key );
		if ( $instagram_cached_data !== false ) {
			$instagram_cached_data_feeds_limit = $instagram_cached_data['user']['api_media_request_limit'];
        }

		// check the cache
		if (
		     td_remote_cache::is_expired(__CLASS__, $cache_key ) === true ||
             (int) $instagram_cached_data_feeds_limit < self::$instagram_media_data_limit
        ) {

			// api access token
            $access_token = $connected_account['page_access_token'] ?? '';

			// api account id
            $account_id = $connected_account['id'] ?? '';

		    // api base url
            $api_base_url = 'graph.facebook.com';

            // media fields array
            $media_fields = 'media_url,thumbnail_url,caption,id,media_type,timestamp,username,permalink,children{media_url,id,media_type,timestamp,permalink,thumbnail_url}';

            // limit
            $limit = self::$instagram_media_data_limit;

			// cache is expired - do a request
			$instagram_get_media_data = td_remote_http::get_page(
                'https://' . $api_base_url . '/' . $account_id . '/media?fields=' . $media_fields . '&limit=' . $limit . '&access_token=' . $access_token,
                __CLASS__
            );

			// check the call response
			if ( $instagram_get_media_data === false ) {

			    // check the cache and return the last stored data even if it's expired
				$instagram_data = td_remote_cache::get(__CLASS__, $cache_key );
				
				if ( $instagram_data === false ) {
					td_log::log(
						__FILE__,
						__FUNCTION__,
						'Instagram access token api account data cannot be retrieved for the connected account: ' . $connected_account['username']
					);
				}

				// extend the cache validity for now, we will try to get the data again when the cache expires
				td_remote_cache::extend(__CLASS__, $cache_key, self::$caching_time );

				return 'instagram_fail_cache';
				
            }

			// try to decode the json
			$instagram_media_json = json_decode( $instagram_get_media_data, true );

            // instagram media json decode error
			if ( ( $instagram_media_json === null ) and json_last_error() !== JSON_ERROR_NONE ) {
				td_log::log(
                    __FILE__,
                    __FUNCTION__,
                    'Error decoding the instagram API json',
                    $instagram_media_json
                );
                return td_util::get_block_error('Instagram', 'Error decoding the Instagram API json' );
			}

			// current instagram data is not set
			if ( !isset( $instagram_media_json['data'] ) ) {

			    $error_message = '';

			    if ( isset($instagram_media_json['error']) ) {

			        // if we have an error message like an invalid access token, if the access token is over the rate limit etc.
                    // ..set a specific message to let the user know that
			        if ( isset( $instagram_media_json['error']['message'] ) ) {
			            if ( $instagram_media_json['error']['type'] === 'OAuthRateLimitException' ) {
				            $error_message = 'Block Render Failed - This account\'s access token is currently over the rate limit. Please try removing this account and wait at least an hour before reconnecting it.';
			            } else {
				            $error_message = 'Block Render Failed - ' . $instagram_media_json['error']['message'];
			            }
                    }
                }

			    // log the instagram reply json for debugging
				td_log::log(
                    __FILE__,
                    __FUNCTION__,
                    'Instagram access token API reply',
                    $instagram_media_json
                );

				return td_util::get_block_error('Instagram', $error_message );

			}

            $instagram_data['user'] = array();
            $instagram_data['user']['with_access_token'] = true;
            $instagram_data['user']['profile_pic_url'] = $connected_account['profile_picture'] ?? '';
            $instagram_data['user']['instagram_id'] = $connected_account['username'];
            $instagram_data['user']['edge_followed_by']['count'] = $connected_account['followers'] ?? '';
			$instagram_data['user']['feeds'] = $instagram_media_json['data'];
			$instagram_data['user']['api_media_request_limit'] = self::$instagram_media_data_limit;

            // we have a valid reply, set the cache
			td_remote_cache::set(__CLASS__, $cache_key, $instagram_data, self::$caching_time );

			return 'instagram_cache_updated';

		} else {

			// cache is valid
			$instagram_data = td_remote_cache::get(__CLASS__, $cache_key );

			return 'instagram_cache';

		}

    }

    /**
     * @param $id - the instagram ID
     * @return string - user inserted instagram ID without @
     */
    public static function strip_instagram_user( $id ) {
        $pos = strpos( $id, '@' );

        if ( $pos !== false ) {
            return substr( $id, $pos+1 );
        }

        return $id;
    }

    /**
     * @param $block_atts
     * @return string[]
     */
    private static function render_demo( $block_atts ) {

        $reply = array(
            'status' => '',
            'buffy' => ''
        );

        if ( TD_DEPLOY_MODE == 'dev' || TD_DEPLOY_MODE == 'demo' ) {

            if ( empty( $block_atts['instagram_demo_data'] ) ) {
                $reply['status'] = 'missing_demo_data';
                return $reply;
            }

            // number of images per row - by default display 3 images
            $images_per_row = 3;
            if ( !empty( $block_atts['instagram_images_per_row'] ) ) {
                $images_per_row = $block_atts['instagram_images_per_row'];
            }
            // number of rows
            $number_of_rows = 1;
            if ( !empty( $block_atts['instagram_number_of_rows'] ) ) {
                $number_of_rows = $block_atts['instagram_number_of_rows'];
            }
            // number of total images displayed - images_row x number_of_rows
            $images_total_number = $images_per_row * $number_of_rows;
            // image gap
            $image_gap = '';
            if ( !empty( $block_atts['instagram_margin'] ) ) {
                $image_gap = ' td-image-gap-' . $block_atts['instagram_margin'];
            }
            $instagram_user = '';
            if ( !empty( $block_atts['instagram_id'] ) ) {
                $instagram_user = $block_atts['instagram_id'];
            }

            $instagram_demo_data = explode(',', $block_atts['instagram_demo_data']);
            //widget data is not encoded, but the shortcode is (we have some old demos)
            if ( base64_decode( $block_atts['instagram_demo_data'], true ) && base64_encode( base64_decode( $block_atts['instagram_demo_data'], true ) ) === $block_atts['instagram_demo_data'] ) {
                $instagram_demo_data = explode(',', rawurldecode(base64_decode($block_atts['instagram_demo_data'])));
            }
            $instagram_profile_picture = wp_get_attachment_image_url($instagram_demo_data[0], 'thumbnail');
            $instagram_followers = $instagram_demo_data[1];
            $instagram_image_ids = array_slice($instagram_demo_data, 2);
            $reply['status'] = 'ok';

            ob_start();?>

            <!-- header section -->
            <?php
            if ( empty($block_atts['instagram_header'] ) ) {
                ?>
                <div class="td-instagram-header">
                    <div class="td-instagram-profile-image">
                        <img src="<?php echo $instagram_profile_picture ?>" width="100" height="100" alt="profile picture"/>
                    </div>
                    <div class="td-instagram-meta">
                        <div class="td-instagram-user">
                            <a href="https://www.instagram.com/<?php echo self::strip_instagram_user($instagram_user) ?>" aria-label="instagram-user-image" rel="noopener" target="_blank">
                                @<?php echo self::strip_instagram_user($instagram_user) ?>
                            </a>
                        </div>
                        <div class="td-instagram-followers">
                            <span><?php echo $instagram_followers . '</span> ' .  __td('Followers', TD_THEME_NAME); ?>
                        </div>
                        <a class="td-instagram-button" href="https://www.instagram.com/<?php echo self::strip_instagram_user($instagram_user) ?>" target="_blank" rel="noopener">
                            <?php echo __td('Follow', TD_THEME_NAME); ?>
                        </a>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <?php
            }
            ?>

            <!-- user custom images -->
            <div class="td-instagram-main td-images-on-row-<?php echo $images_per_row . $image_gap; ?>">
                <?php
                $image_count = 0;
                if ( $instagram_image_ids != '' ) {
                    foreach ( $instagram_image_ids as $image_id ) {
                        $image_url = wp_get_attachment_image_url( $image_id, 'td_696x0' );
                        ?>
                        <div class="td-instagram-element">
                            <a class="td-instagram-image" href="#" aria-label="instagram-image" style="background-image: url(<?php echo $image_url ?>)"></a>
                        </div>
                        <?php
                        $image_count++;
                        if ( $image_count == $images_total_number ) {
                            break;
                        }
                    }
                }
                ?>
                <div class="clearfix"></div>
            </div>

            <?php $reply['buffy'] = ob_get_clean();

        }

        return $reply;

    }

}

