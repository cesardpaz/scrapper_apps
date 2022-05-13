<?php 
class SCRAPP_Ajax_Admin {
    public function scrapper_apps() {
        if( isset( $_POST[ 'action' ] ) ) 
        {

            /* hquery */
            require_once SCRAPP_DIR_PATH . 'helpers/hquery/hquery.php';
            
            $textarea = trim($_POST['text']);
            $listApps = explode("\n", str_replace("\r", "", $textarea));

            $typeApp = $_POST['typeApp'];

            foreach ($listApps as $key => $list) 
            {
                $doc  = hQuery::fromUrl($list, ['Accept' => 'text/html,application/xhtml+xml;q=0.9,*/*;q=0.8' , 'user_agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36']);
                $data         = array();
                $galleryArray = array();
                
                $title     = $doc->find('h1')->text();
                $content   = trim($doc->find('.entry')->html());
                $image     = $doc->find('article.app figure img')->attr('src');
                $imageFull = str_replace('-150x150', '', $image);

                $pros = array( 'Share pictures and videos easily.', 'Includes many special filters and geofilters.', 'Shows you news according to your localization.');
                $cons = array( $title . ' keeps record of all your posts and chats, even the deleted ones.', 'It’s not recommended for teens, since many users post adult content.', 'Their privacy and protection policies are not very good.' );

                $infoList = $doc->find('.info-list li');
                foreach ($infoList as $key => $info) {
                    if( trim(strtolower($info->find('span')[0]->text())) == 'category' ) $category = $info->find('a')[0]->text();
                    if( trim(strtolower($info->find('span')[0]->text())) == 'developer' ) $developer = $info->find('a')[0]->text();
                }

                $price   = array( '$3.99', '$14.00', '$12.50', '$50.00', '$29.99', '');
                $version = array( '9.1.0', '12.4.3', '1.0.0', '0.9.3', '2.0.1', '' );
                $size    = array( '5.5M', '15M', '50M', '55.8M', '70.5M', '' );

                $howUninstallAndroid = array('You need to find the app that you want to uninstall.', 'Then, press on the app, and keep pressing until a menu of options appears.', 'Select the "delete" one and the app will be immediatelly uninstalled.');
                $howUninstalliOs     = array('You need to find the app that you want to uninstall.', 'Then, press on the app, and keep pressing until a "X" appears.' , 'Tap there and the app will be immediatelly uninstalled.');
                $howUninstallWindows = array('You need to find the app that you want to uninstall.', 'Then, press on the app, and keep pressing until a menu of options appears.', 'Select the "uninstall" one and the app will be immediatelly deleted.');

                $language = array( 'English', 'Spanish', 'French' );
                
                /* GET MAX 5 */
                $gallery = $doc->find('.gall img');
                $listImgs = array();
                $count = 0;
                foreach ($gallery as $key => $gall) {
                    if($count < 5)
                    {
                        $im = $gall->attr('src');
                        $im = str_replace('-182x300', '', $im);
                        $listImgs[] = $im;
                        $count++;
                    }   
                }

                $downloadAndroid = "#android";
                $downloadiOs     = "#ios";
                $downloadWindows = "#windows";

                $data  = array( 
                    'title'            => $title,
                    'description'      => $content,
                    'image'            => $imageFull,
                    'pros'             => $pros,
                    'cons'             => $cons,
                    'category'         => $category,
                    'price'            => $price[array_rand($price, 1)],
                    'version'          => $version[array_rand($version, 1)],
                    'developer'        => $developer,
                    'language'         => $language[array_rand($language, 1)],
                    'size'             => $size[array_rand($size, 1)],
                    'gallery'          => $listImgs,
                    'downloadAndroid'  => $downloadAndroid,
                    'downloadiOs'      => $downloadiOs,
                    'downloadWindows'  => $downloadWindows
                );

                /* insert post */
                $new_post = array(
                    'ID'            => '',
                    'post_title'    => $data['title'],
                    'post_content'  => $data['description'],
                    'post_status'   => 'publish',
                    'post_type'     => 'post',
                    'meta_input'    =>
                    array(
                        'pros_gr'     => $data['pros'],
                        'contras_gr'  => $data['cons'],
                        'precio_app'  => $data['price'],
                        'version_app' => $data['version'],
                        'lang_app'    => $data['language'],
                        'size_app'    => $data['size'],
                        'd_android'   => $data['downloadAndroid'],
                        'd_iphone'    => $data['downloadiOs'],
                        'd_windows'   => $data['downloadWindows'],
                        'radio_1'     => $typeApp
                    ),
                );
                $post_id = wp_insert_post($new_post);
                $default_category = (int)get_option('default_category');
                wp_remove_object_terms($post_id, $default_category, 'category');
                wp_set_object_terms( $post_id, $data['category'], 'category', true );
                wp_set_object_terms( $post_id, $data['developer'], 'moob_developer', true );
                Generate_Featured_Image( $imageFull, $post_id );

                foreach ($listImgs as $key => $lim) {
                    $g = Generate_Featured_Image( $lim );
                    add_post_meta( $post_id, 'image_galery', $g );
                }

            }

            $res = [
                'res'  => 'conexion',
                'data' => $data['title'],
                'gallery' => $listImgs,
            ];
            echo json_encode($res);
            wp_die();
        }
    }
}