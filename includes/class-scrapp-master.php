<?php 
class SCRAPP_Master {
    protected $charger;
    protected $theme_name;
    protected $version;
    public function __construct() 
    {
        $this->theme_name = 'SCRAPP_Theme';
        $this->version = SCRAPP_VERSION;
        $this->load_dependencies();
        $this->load_instances();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }
    private function load_dependencies() 
    {
        require_once SCRAPP_DIR_PATH . 'includes/class-scrapp-charger.php';        
        require_once SCRAPP_DIR_PATH . 'includes/class-scrapp-build-menupage.php';
        require_once SCRAPP_DIR_PATH . 'admin/class-scrapp-admin.php';
        require_once SCRAPP_DIR_PATH . 'public/class-scrapp-public.php';
        require_once SCRAPP_DIR_PATH . 'includes/class-scrapp-ajax-admin.php';  
    }
    private function load_instances() 
    {
        $this->charger           = new SCRAPP_Charger;
        $this->scrapp_admin      = new SCRAPP_Admin( $this->get_theme_name(), $this->get_version() );
        $this->scrapp_public     = new SCRAPP_Public( $this->get_theme_name(), $this->get_version() );
        $this->scrapp_ajax_admin = new SCRAPP_Ajax_Admin;
    }
    private function define_admin_hooks() 
    {
        $this->charger->add_action( 'admin_enqueue_scripts', $this->scrapp_admin, 'enqueue_styles' );
        $this->charger->add_action( 'admin_enqueue_scripts', $this->scrapp_admin, 'enqueue_scripts' );
        $this->charger->add_action( 'admin_menu', $this->scrapp_admin, 'add_menu' );

        /* ajax */
        $this->charger->add_action('wp_ajax_action_scrapper_apps',  $this->scrapp_ajax_admin, 'scrapper_apps');		  
    }
    private function define_public_hooks() 
    {
        $this->charger->add_action( 'wp_enqueue_scripts', $this->scrapp_public, 'enqueue_styles' );
        $this->charger->add_action( 'wp_footer', $this->scrapp_public, 'enqueue_scripts' );
    }
    public function run() 
    {
        $this->charger->run();
    }
    public function get_theme_name() 
    {
        return $this->theme_name;
    }
    public function get_charger() 
    {
        return $this->charger;
    }
    public function get_version() 
    {
        return $this->version;
    }
}