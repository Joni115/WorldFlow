<?php

class td_audio_support {

    private static $on_save_post_post_id; // here we keep the post_id when the save_post hook runs. We need the post_id to pass it to the other hook @see on_add_attachment_set_featured_image

    // flag to make sure we run the 'on_save_post_get_audio_thumb' save_post hook only once..
    // ..this is mainly bacause on gutenberg editor this hook runs twice and triggers a duplicate on audio thumb generation
    private static $on_save_post_did_action = false;


    /**
     * Render an audio on the fornt end from URL
     * @param $audioUrl - the audio url that we want to render
     *
     * @return string - the player HTML
     */
    static function render_audio($audioUrl) {
        $buffy = '';

        switch (self::detect_audio_service($audioUrl)) {
            case 'soundcloud':
                $opts = array('http'=>array('header' => "User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0\r\n"));
                $context = stream_context_create($opts);

                // request info based on soundcloud url
                $soundCloudEmbed = json_decode( substr( file_get_contents('https://soundcloud.com/oembed?format=js&url=' . $audioUrl . '&iframe=true', false, $context), 1, -2) );

                // get the html for the embed
                $soundCloudEmbedHTML = $soundCloudEmbed->html;

                // set visual false & disabled teaser
                $soundCloudEmbedHTML = str_replace('visual=true', 'visual=false&show_teaser=false', $soundCloudEmbedHTML);
                // overwrite height
                $soundCloudEmbedHTML = str_replace('height="400"', 'height="120"', $soundCloudEmbedHTML);

                // return embed
                $buffy .= '<div class="td-audio-player">';
                    $buffy .= $soundCloudEmbedHTML;
                $buffy .= '</div>';

                break;

            case 'spotify':
                // Parse the URL in order to get the type and ID.
                $parsed_url = parse_url($audioUrl);
                $path = $parsed_url['path'];
                $path_parts = explode('/', $path);

                $type = $path_parts[1];
                $id = $path_parts[2];

                // Generate the embed HTML.
                $embed_html = '<iframe src="https://open.spotify.com/embed/' . $type . '/' . $id . '?theme=0" width="100%" height="80" frameBorder="0" allowfullscreen="" allow="autoplay;clipboard-write;encrypted-media; fullscreen;picture-in-picture"></iframe>';

                // Return the embed code.
                $buffy .= '<div class="td-audio-player">';
                    $buffy .= $embed_html;
                $buffy .= '</div>';

                break;

            case 'self-hosted':
                $buffy .= '<div class="td-audio-player">';
                    $buffy .= do_shortcode('[audio src="' . $audioUrl . '"]');
                $buffy .= '</div>';

                break;
        }

        return $buffy;
    }


    /**
     * Downloads the audio thumb on the save_post hook
     * @param $post_id
     *
     */
    static function on_save_post_get_audio_thumb($post_id) {

        // bail if this hook has already run
        if( !td_global::get_demo_installing() && self::$on_save_post_did_action ){
            return;
        }

        // if this is the first time this hook runs update the flag to avoid running this again
        self::$on_save_post_did_action = true;

        //verify post is not a revision
        if ( !wp_is_post_revision( $post_id ) ) {

            if (
                ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ||
                td_util::tdc_is_live_editor_ajax() ||
                td_util::tdc_is_live_editor_iframe() ||
                'post' !== get_post_type($post_id)
            ) {
                return;
            }

            // get the current submitted audio url and the last saved post audio url
            $td_post_audio = td_util::get_post_meta_array($post_id, 'td_post_audio');
            $td_last_set_audio = get_post_meta($post_id, 'td_last_set_audio', true);

            // check to see if we have a audio url submitted
            if ( empty( $td_post_audio['td_audio'] ) ) {

                // if we have a last audio saved
                if ( !empty( $td_last_set_audio ) ) {
                    // if we have an empty audio url field and we have a last audio saved, empty the last audio saved meta..
                    // ..to avoid cases in which we don't have an featured image set and we use the same audio url the img does not set
                    update_post_meta( $post_id, 'td_last_set_audio', $td_post_audio['td_audio'] );
                }

                return;
            }

            // check to see if the url is valid
            if ( self::validate_audio_url( $td_post_audio['td_audio'] ) === false ) {
                // we stop here if we do not have a valid audio url
                return;
            }

            // check to see if we have a last saved post audio url and bail if its the same as the submitted audio url
            if ( !empty( $td_last_set_audio ) and $td_last_set_audio == $td_post_audio['td_audio'] ) {
                return;
            }

            $audioThumbUrl = self::get_thumb_url( $td_post_audio['td_audio'] );

            // its time to setup the thumb
            if ( !empty( $audioThumbUrl ) ) {

                // save the post id
                self::$on_save_post_post_id = $post_id;

                // update the last saved post audio url post meta
                update_post_meta( $post_id, 'td_last_set_audio', $td_post_audio['td_audio'] );

                // add the function above to catch the attachments creation
                add_action('add_attachment', array(__CLASS__, 'on_add_attachment_set_featured_image'));

                // load the attachment from the URL
                $audio_service = self::detect_audio_service($td_post_audio['td_audio']);

                if( $audio_service == 'spotify' ) {
                    td_util::upload_and_attach_external_image($audioThumbUrl, $post_id);
                } else {
                    media_sideload_image($audioThumbUrl, $post_id, $post_id);
                }

                // we have the Image now, and the function above will have fired too setting the thumbnail ID in the process, so lets remove the hook so we don't cause any more trouble
                remove_action('add_attachment', array(__CLASS__, 'on_add_attachment_set_featured_image'));
            }
        }
    }


    /**
     * Set the last uploaded image as a featured image. We 'upload' the audio thumb via the media_sideload_image call from above
     * @internal
     */
    static function on_add_attachment_set_featured_image($att_id){
        update_post_meta(self::$on_save_post_post_id, '_thumbnail_id', $att_id);
    }


    /**
     * Detects if we have a recognized audio service and makes sure that it's a valid url
     * @param $audioUrl
     * @return bool
     */
    private static function validate_audio_url($audioUrl) {
        if (self::detect_audio_service($audioUrl) === false) {
            return false;
        }
        if (!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $audioUrl)) {
            return false;
        }
        return true;
    }


    /**
     * Returns the audio thumb url from the audio URL
     * @param $audioUrl
     * @return string
     */
    protected static function get_thumb_url($audioUrl) {

        $thumbnail_url = '';

        switch (self::detect_audio_service($audioUrl)) {
            case 'soundcloud':
                // request info based on soundcloud url
                $soundCloudEmbed = json_decode( substr( file_get_contents('http://soundcloud.com/oembed?format=js&url=' . $audioUrl . '&iframe=true'), 1, -2) );

                // return image url
                $thumbnail_url = $soundCloudEmbed->thumbnail_url;
                break;

            case 'spotify':
                // Get data about the track.
                $spotify_data = self::get_spotify_data($audioUrl);

                // Retrieve the thumbnail URL.
                if( $spotify_data && !empty( $spotify_data['thumbnail_url'] ) ) {
                    $thumbnail_url = $spotify_data['thumbnail_url'];
                }
                break;
        }

        return $thumbnail_url;

    }


    /*
     * Detect the audio service from url
     */
    public static function detect_audio_service($audioUrl) {

        $audioUrl = strtolower($audioUrl);
        if ( strpos($audioUrl, 'spotify.com') !== false ) {
            return 'spotify';
        }
        if (strpos($audioUrl, 'soundcloud.com') !== false) {
            return 'soundcloud';
        }
        if( preg_match('(.flac|.aiff|.wav|.m4a|.mid|.au|.mp3|.wma|.oga|.opus|.webm)', $audioUrl) != false ) {
            return 'self-hosted';
        }

        return false;

    }


    /**
     * RETRIEVES TRACK INFO FROM A SPOTIFY URL.
     *
     * @param string $audioUrl
     * @return array|bool An array containing track info (e.g., embed html, thumbnail url);
     *                    False if data could not be retrieved.
     */
    public static function get_spotify_data( $audioUrl ) {

        // Initialize cURL session.
        $curl = curl_init();

        // Set cURL options.
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://open.spotify.com/oembed?url=' . urlencode($audioUrl),
            CURLOPT_USERAGENT => 'Spotify oEmbed Request'
        ]);

        // Execute cURL request and decode the JSON response.
        $response = curl_exec($curl);
        $spotify_data = json_decode($response, true);

        // Close cURL session.
        curl_close($curl);

        // Bail if data is invalid.
        if( $spotify_data === null || !is_array( $spotify_data ) ) {
            return false;
        }

        // Return the data.
        return $spotify_data;

    }

}