<?php
/*
Plugin Name: Video Gallery by Burgosoft
Plugin URI: http://wpguru.me/
Description: The last video gallery you'll ever need.
Version: 1.0.0
Author: Randolph B. Burgos
Author URI: http://burgosoft.com/
*/

class Burgosoft_Video_Gallery
{
	private $plugin_dir;
	private $plugin_url;
	
	function __construct()
	{
		$this->plugin_dir = plugin_dir_path(__FILE__);
		$this->plugin_url = plugin_dir_url(__FILE__);
		
		$this->actions();
		$this->shortcodes();
		$this->acf();
	}
	
	function actions()
	{
		add_action('init', array($this, 'init'));
		add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
		add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
		add_action('media_buttons', array($this, 'media_buttons'), 20);
		add_action('admin_footer',  array($this, 'admin_footer'));
	}
	
	function init()
	{
		register_post_type('bs-video-gallery', array(
				'labels' => array(
					'name' => 'Video Galleries',
					'singular_name' => 'Video Gallery',
					'add_new_item' => 'Add New Video Gallery',
					'edit_item' => 'Edit Video Gallery',
					'new_item' => 'New Video Gallery',
					'view_item' => 'View Video Gallery',
					'search_items' => 'Search Videos Galleries',
					'not_found' => 'No video galleries found',
					'not_found_in_trash' => 'No video gallery found in Trash',
					'all_items' => 'All Video Galleries',
					'archives' => 'Video Gallery Archives',
					'insert_into_item' => 'Insert into video gallery',
					'uploaded_to_this_item' => 'Uploaded to this video gallery'
				),
				'public' => false,
				'show_ui' => true,
				'menu_icon' => 'dashicons-video-alt3',
				'supports' => array(
					'title',
					'editor' => false
				)
			)
		);
	}
	
	function wp_enqueue_scripts()
	{
		wp_enqueue_style('lity', $this->plugin_url . 'assets/vendor/lity/lity.min.css', array(), '1.6.4');
		wp_enqueue_style('animate', $this->plugin_url . 'assets/css/animate.css', array(), '3.5.1');
		wp_enqueue_style('styles', $this->plugin_url . 'assets/css/styles.css', array(), time());
		
		wp_enqueue_script('lity', $this->plugin_url . 'assets/vendor/lity/lity.min.js', array('jquery'), '1.6.4', true);
		wp_enqueue_script('scripts', $this->plugin_url . 'assets/js/scripts.js', array('jquery'), time(), true);
	}
	
	function admin_enqueue_scripts()
	{
		wp_enqueue_style('admin-styles', $this->plugin_url . 'assets/css/admin.css', array(), time());
		wp_enqueue_script('admin-scripts', $this->plugin_url . 'assets/js/admin.js', array('jquery'), time(), true);
	}
	
	function media_buttons()
	{
		include_once($this->plugin . 'content/media_buttons.php');
	}
	
	function admin_footer()
	{
		$video_galleries = get_posts(array(
			'post_type' => 'bs-video-gallery',
			'posts_per_page' => -1
			));
		
		include_once($this->plugin . 'content/admin_footer.php');
	}
	
	function shortcodes()
	{
		add_shortcode('bsvg', array($this, 'bsvg_shortcode'));
	}
	
	function bsvg_shortcode($atts)
	{
		$id = $atts['id'];
		$videos = get_field('bsvg_videos', $id);
		$display = get_field('bsvg_display', $id);
		$out = '';
		$columns = get_field('bsvg_columns', $id);
		$list_item_width = 100 / $columns;
		$thumb_only = false;
		
		if ($videos)
		{
			$out .= '<ul class="bsvg-list">';
			foreach ($videos as $video)
			{
				$thumbnail = $video['custom_thumb'] ? $video['custom_thumb']['url'] : "http://img.youtube.com/vi/{$video['youtube_video_id']}/maxresdefault.jpg" ;
				
				if ($display == 'thumb')
				{
					$out .= "<li style='width:{$list_item_width}%'>";
					$out .= "<a href='https://www.youtube.com/watch?v={$video['youtube_video_id']}' data-lity>";
					$out .= '<div class="icon-overlay">';
					$out .= "<img src='$thumbnail' class='faded'>";
					$out .= '</div>';
					$out .= '</a>';
					$out .= '</li>';
				}
				else
				{
					$out .= "<li style='width:{$list_item_width}%'>";
					$out .= "<a href='https://www.youtube.com/watch?v={$video['youtube_video_id']}' data-lity>";
					$out .= "<div class='title-overlay animated'><h3>{$video['title']}</h3>";
					if ($display == 'thumb_title_desc')
					{
						$out .= $video['description'];
					}
					$out .= '</div>';
					$out .= "<img src='$thumbnail'>";
					$out .= '</a>';
					$out .= '</li>';
				}
			}
			$out .= '</ul> <!-- .bsvg-list -->';
		}
		
		return $out;
	}
	
	function acf()
	{
		add_filter('acf/settings/path', array($this, 'acf_settings_path'));
		add_filter('acf/settings/dir', array($this, 'acf_settings_dir'));
		add_filter('acf/settings/show_admin', '__return_false');
		
		include_once($this->plugin_dir . 'includes/acf/acf.php');
		include_once($this->plugin_dir . 'includes/acf-local-fields.php');
	}
	
	function acf_settings_path($path)
	{
		$path = $this->plugin_dir . 'includes/acf/';
	    return $path;
	}
	
	function acf_settings_dir($dir)
	{
		$dir = $this->plugin_url . 'includes/acf/';
		return $dir;
	}
}

new Burgosoft_Video_Gallery;









