<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://ingmmo.com
 * @since      1.0.0
 *
 * @package    Mn_Charts
 * @subpackage Mn_Charts/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Mn_Charts
 * @subpackage Mn_Charts/public
 * @author     Marco Montanari <marco.montanari@gmail.com>
 */
class Mn_Charts_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mn_Charts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mn_Charts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mn-charts-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mn_Charts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mn_Charts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/echarts.all.js', array(), $this->version, false );

	}


	function generateIdentifier($length = 9, $add_dashes = false, $available_sets = 'lud')
	{
		$sets = array();
		if(strpos($available_sets, 'l') !== false)
			$sets[] = 'abcdefghjkmnpqrstuvwxyz';
		if(strpos($available_sets, 'u') !== false)
			$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
		if(strpos($available_sets, 'd') !== false)
			$sets[] = '23456789';
		if(strpos($available_sets, 's') !== false)
			$sets[] = '!@#$%&*?';

		$all = '';
		$password = '';
		foreach($sets as $set)
		{
			$password .= $set[array_rand(str_split($set))];
			$all .= $set;
		}

		$all = str_split($all);
		for($i = 0; $i < $length - count($sets); $i++)
			$password .= $all[array_rand($all)];

		$password = str_shuffle($password);

		if(!$add_dashes)
			return $password;

		$dash_len = floor(sqrt($length));
		$dash_str = '';
		while(strlen($password) > $dash_len)
		{
			$dash_str .= substr($password, 0, $dash_len) . '-';
			$password = substr($password, $dash_len);
		}
		$dash_str .= $password;
		return $dash_str;
	}

	
	function raw_charts( $atts, $content = "" ) {
		remove_filter('the_content', 'wpautop');
		add_filter('the_content', 'wpautop', 12);

		$a = shortcode_atts( array(
			'height' => '50',
		), $atts );

		$h = $a['height'];
		$ident = $this->generateIdentifier();
		$ret = '<script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/4.6.0/echarts.min.js"></script>';
		$ret .= "<div id='$ident' style=\"height: ".$h."px\"></div>";
		$ret .= "<script>var chart_$ident = echarts.init(document.getElementById('$ident')); let object = JSON.parse(`".$content."`.replace(/&#8220;/g,'\"').replace(/&#038;/g,'&').replace(/&#8221;/g,'\"')); chart_$ident.setOption(object);</script>";
		return $ret;

	}

	function raw_bar($atts, $content = "") {
		$sc = explode(":", $content);
		$title = $sc[0];
		$pctgs = explode(",", $sc[1]);
		$icontent = '{
			"tooltip": {
				"trigger": "axis"
			},
			"legend": {
				"data": ["Solution & Cloud Development", "Ricerca qualitativa HC", "Service & Process Design", "UX/UI Design", "Analisi organizzativa", "Agile Development"]
			},
			"grid": {
				"left": "3%",
				"right": "4%",
				"bottom": "3%",
				"containLabel": true
			},
			"xAxis": {
				"type": "value"
			},
			"yAxis": {
				"type": "category",
				"data": ["'.$title.'"]
			},
			"series": [
				{
					"name": "Solution & Cloud Development",
					"type": "bar",
					"stack": "Smart e-procurement e dematerializzazione",
					"label": {
						"show": true,
						"position": "insideRight"
					},
					"data": ['.$pctgs[0].']
				},
				{
					"name": "Ricerca qualitativa HC",
					"type": "bar",
					"stack": "Smart e-procurement e dematerializzazione",
					"label": {
						"show": true,
						"position": "insideRight"
					},
					"data": ['.$pctgs[1].']
				},
				{
					"name": "Service & Process Design",
					"type": "bar",
					"stack": "Smart e-procurement e dematerializzazione",
					"label": {
						"show": true,
						"position": "insideRight"
					},
					"data": ['.$pctgs[2].']
				},
				{
					"name": "UX/UI Design",
					"type": "bar",
					"stack": "Smart e-procurement e dematerializzazione",
					"label": {
						"show": true,
						"position": "insideRight"
					},
					"data": ['.$pctgs[3].']
				},
				{
					"name": "Analisi organizzativa",
					"type": "bar",
					"stack": "Smart e-procurement e dematerializzazione",
					"label": {
						"show": true,
						"position": "insideRight"
					},
					"data": ['.$pctgs[4].']
				},
				{
					"name": "Agile Development",
					"type": "bar",
					"stack": "Smart e-procurement e dematerializzazione",
					"label": {
						"show": true,
						"position": "insideRight"
					},
					"data": ['.$pctgs[5].']
				}
			]
		}';


		return $this->raw_charts($atts, $icontent);
	}

	public function enqueue_shortcodes(){
		add_shortcode("mn-charts-raw", [$this, "raw_charts"]);
		add_shortcode("mn-charts-bar", [$this, "raw_bar"]);
	}

}
