<?php
/*
  Plugin Name: LidPlay Player
  Plugin URI: https://lidplay.net/en/#install
  Description: Playing video from VK.com, Mail.ru, OK.ru, Vimeo, RedTube, Google Drive, Mp4upload.com, Facebook.com in one player.
  Version: 1.5.16
  Author: LidPlay
  Author URI: https://lidplay.net
  Text Domain: lidplay
 */

/*  Copyright 2017  LidPlay  (email: contact@lidplay.net)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

function lidplay_options_version() {
    return 4; // increment before update
}

function lidplay_init() {

    // load language
    load_plugin_textdomain('lidplay', false, basename(dirname(__FILE__)) . '/languages/');

    // force setup options
    if (!get_option('lidplay_force_setup_' . lidplay_options_version())) {
        lidplay_set_default_options();
        add_option('lidplay_force_setup_' . lidplay_options_version(), true);
    }
}

function lidplay_create_menu() {

    //create new top-level menu
    add_menu_page(__('LidPlay Settings', 'lidplay'), __('LidPlay Settings', 'lidplay'), 'administrator', __FILE__, 'lidplay_settings_page', plugins_url('/icon.png', __FILE__));

    //call register settings function
    add_action('admin_init', 'register_lidplay_settings');
}

function lidplay_add_settings_link($links) {
    array_push($links, '<a href="' . admin_url('admin.php?page=' . plugin_basename(__FILE__)) . '">' . __('Settings', 'lidplay') . '</a>');
    return $links;
}

function register_lidplay_settings() {

    //settings
    register_setting('lidplay-settings-group', 'lidplay_domain');
    register_setting('lidplay-settings-group', 'lidplay_collection');
    register_setting('lidplay-settings-group', 'lidplay_default_resolution');

    //providers
    foreach (lidplay_providers() as $key => $values) {
        register_setting('lidplay-settings-group', 'lidplay_provider_' . $key);
    }
}

function lidplay_set_default_options() {

    // options
    $default = array(
        'lidplay_domain' => '1',
        'lidplay_collection' => '1',
        'lidplay_default_resolution' => '360',
    );

    // providers
    foreach (lidplay_providers() as $key => $values) {
        $default = array_merge($default, array('lidplay_provider_' . $key => '1'));
    }

    // set default
    foreach ($default as $key => $value) {
        if (!get_option($key)) {
            add_option($key, $value);
        }
    }

    // remove old setup versions
    for ($version = 1; $version < lidplay_options_version(); $version++) {
        delete_option('lidplay_force_setup_' . $version);
    }
}

function lidplay_settings_page() {
    ?>

    <div class="wrap">
        <h2><?php _e('LidPlay Settings', 'lidplay') ?></h2>

        <form method="post" action="options.php">
            <?php settings_fields('lidplay-settings-group'); ?>
            <table class="form-table">

                <tr valign="top">
                    <th scope="row"><?php _e('Default resolution', 'lidplay') ?></th>
                    <td>
                        <select name="lidplay_default_resolution">
                            <option value="1080" <?php selected(get_option('lidplay_default_resolution'), '1080'); ?>>1080P</option>
                            <option value="720" <?php selected(get_option('lidplay_default_resolution'), '720'); ?>>720P</option>
                            <option value="480" <?php selected(get_option('lidplay_default_resolution'), '480'); ?>>480P</option>
                            <option value="360" <?php selected(get_option('lidplay_default_resolution'), '360'); ?>>360P</option>
                            <option value="240" <?php selected(get_option('lidplay_default_resolution'), '240'); ?>>240P</option>
                            <option value="144" <?php selected(get_option('lidplay_default_resolution'), '144'); ?>>144P</option>
                        </select>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><?php _e('Use providers', 'lidplay') ?></th>
                    <td>
                        <?php foreach (lidplay_providers() as $key => $values): ?>
                            <label><input type="checkbox" name="lidplay_provider_<?= $key ?>" value="1" <?php checked(get_option('lidplay_provider_' . $key), 1); ?> /> <?= $values['label'] ?></label><br>
                        <?php endforeach; ?>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><?php _e('Use collection', 'lidplay') ?></th>
                    <td>
                        <label><input type="checkbox" name="lidplay_collection" value="1" <?php checked(get_option('lidplay_collection'), 1); ?> /> <?php _e('To allow the script to create a collection videos from your site ?', 'lidplay') ?></label><br>
                        <p  class="description">
                            <?php _e('In the absence of video, will get a random video from site collection.', 'lidplay') ?><br>
                            <?php _e('Enabling this option can significantly reduce the failure rate.', 'lidplay') ?>
                        </p>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><?php _e('Other', 'lidplay') ?></th>
                    <td>
                        <label><input type="checkbox" name="lidplay_domain" value="1" <?php checked(get_option('lidplay_domain'), 1); ?> /> <?php _e('Use own domain for player', 'lidplay') ?></label><br>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><?php _e('Extra params', 'lidplay') ?></th>
                    <td>
                        <p>
                        <h4><?php _e('Subtitles (do not forget about CORS)', 'lidplay') ?>:</h4>
                        <code>&lt;iframe src="..." <strong>subtitles_src</strong>="//site.com/subtitles.vtt" allowfullscreen&gt;&lt;/iframe&gt;</code>
                        </p>
                        <p>
                        <h4><?php _e('Subtitles label', 'lidplay') ?>:</h4>
                        <code>&lt;iframe src="..." <strong>subtitles_src</strong>="//site.com/subtitles.vtt" <strong>subtitles_label</strong>="<?php _e('Subtitles label', 'lidplay') ?>" allowfullscreen&gt;&lt;/iframe&gt;</code>
                        </p>
                        <p>
                        <h4><?php _e('Default resolution', 'lidplay') ?>:</h4>
                        <code>&lt;iframe src="..." <strong>default_resolution</strong>="480" allowfullscreen&gt;&lt;/iframe&gt;</code>
                        </p>
                        <p>
                        <h4><?php _e('Start position (seconds)', 'lidplay') ?>:</h4>
                        <code>&lt;iframe src="..." <strong>start</strong>="40" allowfullscreen&gt;&lt;/iframe&gt;</code>
                        </p>
                        <p>
                        <h4><?php _e('Autoplay', 'lidplay') ?>:</h4>
                        <code>&lt;iframe src="..." <strong>autoplay</strong>="true" allowfullscreen&gt;&lt;/iframe&gt;</code>
                        </p>
                    </td>
                </tr>

            </table>

            <h2 class="title"><?php _e('Feedback', 'lidplay') ?></h2>
            <p><?php _e('If you have any questions or suggestions please contact us on', 'lidplay') ?> <a href="https://lidplay.net/#feedback" target="_blank">lidplay.net/#feedback</a></p>

            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'lidplay') ?>" />
            </p>

        </form>
    </div>

    <?php
}

function lidplay_js_loader() {
    wp_enqueue_script('lidplay', plugins_url('loader.js', __FILE__), array(), '1.0.5');
}

function lidplay_js_init() {

    $default_resolution = get_option('lidplay_default_resolution', '360');
    $collection = filter_var(get_option('lidplay_collection'), FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
    $domain = get_option('lidplay_domain') ? plugins_url('video.php?', __FILE__) : '//lidplay.net/video/?';

    $providers = array();

    foreach (lidplay_providers() as $key => $values) {
        if (get_option('lidplay_provider_' . $key)) {
            $providers = array_merge($providers, $values['url_parts']);
        }
    }

    $providers = json_encode($providers);

    echo <<<JS
<!-- LidPlay.net Player -->
<script type='text/javascript'>
(function(){
	lidplay({
		default_resolution: '{$default_resolution}',
		collection: '{$collection}',
		referrer: window.location.href
	}, '{$domain}', {$providers});
})();
</script>
<!--/ LidPlay.net Player -->

JS;
}

function lidplay_providers() {
    return array(
        'vk' => array(
            'url_parts' => array('vk.com/video_ext.php', 'vk.me/video_ext.php', 'new.vk.com/video_ext.php', 'vkontakte.ru/video_ext.php'),
            'label' => 'VK.com',
        ),
        'ok' => array(
            'url_parts' => array('ok.ru/videoembed/'),
            'label' => 'OK.ru',
        ),
        'mailru' => array(
            'url_parts' => array('my.mail.ru', 'videoapi.my.mail.ru', 'video.mail.ru'),
            'label' => 'Mail.ru',
        ),
        'google' => array(
            'url_parts' => array('drive.google.com', 'docs.google.com'),
            'label' => 'Google Drive',
        ),
        'vimeo' => array(
            'url_parts' => array('vimeo.com', 'player.vimeo.com'),
            'label' => 'Vimeo',
        ),
        'facebook' => array(
            'url_parts' => array('facebook.com/plugins/video.php'),
            'label' => 'Facebook',
        ),
        'dailymotion' => array(
            'url_parts' => array('www.dailymotion.com'),
            'label' => 'Dailymotion',
        ),
        'mp4upload' => array(
            'url_parts' => array('www.mp4upload.com'),
            'label' => 'Mp4upload',
        ),
        'dropbox' => array(
            'url_parts' => array('www.dropbox.com'),
            'label' => 'Dropbox',
        ),
        'adult' => array(
            'url_parts' => array('embed.redtube.com', 'www.pornhub.com', 'xhamster.com', 'flashservice.xvideos.com'),
            'label' => 'Adult (Redtube, Pornhub, xHamster, xVideos)',
        ),
    );
}

add_action('plugins_loaded', 'lidplay_init');
add_action('admin_menu', 'lidplay_create_menu');
add_action('wp_enqueue_scripts', 'lidplay_js_loader');

add_filter('wp_head', 'lidplay_js_init');
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'lidplay_add_settings_link');

register_activation_hook(__FILE__, 'lidplay_set_default_options');
?>