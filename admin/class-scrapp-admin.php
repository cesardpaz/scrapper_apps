<?php 
class SCRAPP_Admin 
{
    private $theme_name;
    private $version;
    private $build_menupage;
    
    public function __construct( $theme_name, $version ) 
    {
        $this->theme_name     = $theme_name;
        $this->version        = $version;
        $this->build_menupage = new SCRAPP_Build_Menupage();
    }
    
    public function enqueue_styles( $hook ) 
    {
        if( isset($_GET['page']) ) 
        {
            if( $_GET['page'] == 'scrapper_apps' || $_GET['page'] == 'scrapper_help' )
            {
                wp_enqueue_style( 'scrapp_admin_css', SCRAPP_DIR_URI . 'admin/css/admin_scrapp.css', array(), filemtime(SCRAPP_DIR_PATH . 'admin/css/admin_scrapp.css'), 'all' );
            }
        }
    }

    public function enqueue_scripts( $hook ) 
    {
        if( isset($_GET['page']) ) 
        {
            if( $_GET['page'] == 'scrapper_apps' || $_GET['page'] == 'scrapper_help' )
            {
                wp_enqueue_script( 'materialize_js', 'https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js', [], '1.0.0', true );

                wp_enqueue_script( 'scrapp_admin_js', SCRAPP_DIR_URI . 'admin/js/scrapp_admin.js', [], filemtime(SCRAPP_DIR_PATH . 'admin/js/scrapp_admin.js'), true );

                $scrapp_Public = [
                    'url'   => admin_url( 'admin-ajax.php' ),
                    'nonce' => wp_create_nonce( 'scrapp_seg' ),
                ];
                wp_localize_script( 'scrapp_admin_js', 'scrapp_Public', $scrapp_Public );
            }
        }
    }

    /* PANEL ADMIN */
    public function add_menu() 
    {
        $this->build_menupage->add_menu_page(
            __( 'Scrapper Apps', 'scrapp' ),
            __( 'Scrapper Apps', 'scrapp' ),
            'manage_options',
            'scrapper_apps',
            [ $this, 'scrapper_apps' ]
        );

        $this->build_menupage->add_submenu_page(
            'scrapper_apps',
            __( 'Help', 'scrapp' ),
            __( 'Help', 'scrapp' ),
            'manage_options',
            'scrapper_help',
            [ $this, 'scrapper_help' ]
        );
        $this->build_menupage->run();
    }
    
    public function scrapper_apps()
    {
        require_once SCRAPP_DIR_PATH . 'admin/partials/scrapper_apps.php';
    }
    public function scrapper_help()
    {
        require_once SCRAPP_DIR_PATH . 'admin/partials/scrapper_help.php';
    }
}