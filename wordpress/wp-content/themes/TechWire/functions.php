<?php
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
    	'name' => 'Sidebar 1',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
    
    register_sidebar(
	array(
		'name' => 'Sidebar 2',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
}

$themename = "TechWire";
$shortname = str_replace(' ', '_', strtolower($themename));

function get_theme_option($option)
{
	global $shortname;
	return stripslashes(get_option($shortname . '_' . $option));
}

function get_theme_settings($option)
{
	return stripslashes(get_option($option));
}

function cats_to_select()
{
	$categories = get_categories('hide_empty=0'); 
	$categories_array[] = array('value'=>'0', 'title'=>'Select');
	foreach ($categories as $cat) {
		if($cat->category_count == '0') {
			$posts_title = 'No posts!';
		} elseif($cat->category_count == '1') {
			$posts_title = '1 post';
		} else {
			$posts_title = $cat->category_count . ' posts';
		}
		$categories_array[] = array('value'=> $cat->cat_ID, 'title'=> $cat->cat_name . ' ( ' . $posts_title . ' )');
	  }
	return $categories_array;
}

$options = array (
			
	array(	"type" => "open"),
	
	array(	"name" => "Logo",
		"desc" => "Digite o caminho da imagem do logotipo completo. Deixe em branco se você não quiser usar imagem do logotipo.",
		"id" => $shortname."_logo",
		"std" =>  get_bloginfo('template_url') . "/images/logo.png",
		"type" => "text"),array(	"name" => "Ativar posts em destaque?",
			"desc" => "Desmarque a opção se você não quer mostrar posts em destaque com slideshow na home.",
			"id" => $shortname."_featured_posts",
			"std" => "true",
			"type" => "checkbox"),
		array(	"name" => "Categoria em destaque",
			"desc" => "Últimos 5 posts da categoria selecionada será mostrado como destaque. <br />A categoria selecionada precisa ter os ultimos 2 posts com imagens. <br /> <br /> <b>Como adicionar imagens para os posts em destaque?</b> <br />
            <b>&raquo;</b> Se você estiver usando a versão WordPress 2.9 ou superior: Defina \"Post Thumbnail\" ao adicionar novo post para os cargos na categoria selecionada acima. <br /> 
            <b>&raquo;</b> Se você estiver usando a versão WordPress anterior a 2.9 você tem que adicionar campos personalizados em cada post para a categoria que você definir como destaque. O campo personalizado deve ser nomeado \"<b>featured</b>\" e seu valor deve ser uma URL completa da imagem. <a href=\"http://newwpthemes.com/public/featured_custom_field.jpg\" target=\"_blank\">Clique aqui</a> para ver um exemplo. <br /> <br />
            Em ambos os casos, o tamanho das imagens devem ser: Width (Largura): <b>500 px</b>. Height (Altura): <b>280 px.</b>",
			"id" => $shortname."_featured_posts_category",
			"options" => cats_to_select(),
			"std" => "0",
			"type" => "select"),
            
            	array(	"name" => "Banner do cabeçalho (468x60 px)",
			"desc" => "Código do banner. Você pode usar qualquer código html aqui, incluindo o AdSense 468x60 px.",
            "id" => $shortname."_ad_header",
            "type" => "textarea",
			"std" => '<a href="http://newwpthemes.com/hosting/wpwebhost.php"><img src="http://newwpthemes.com/hosting/wpwh46.gif" /></a>'
			),	array(	"name" => "Sidebar 125x125 px Ads",
		"desc" => "Adicione seu banner 125x125 px aqui. Você pode adicionar quantos anúncios desejar. Cada novo banner deve estar em uma linha usando o seguinte formato: <br/>http://linkdaimagem.com/banner.gif, http://link.com/index.html",
        "id" => $shortname."_ads_125",
        "type" => "textarea",
		"std" => 'http://newwpthemes.com/uploads/newwp/newwp12.png,http://newwpthemes.com/
http://flexithemes.com/wp-content/partners/fta.gif, http://flexithemes.com/?partner=19
http://newwpthemes.com/hosting/hg125.gif, http://newwpthemes.com/hosting/hostgator.php'
		),	
           
        array(	"name" => "Twitter",
			"desc" => "Digite o link da sua conta aqui.",
			"id" => $shortname."_twitter",
			"std" => "http://twitter.com/WPTwits",
			"type" => "text"),
			
	array(	"name" => "Texto do Twitter",
			"desc" => "",
			"id" => $shortname."_twittertext",
			"std" => "Siga-nos no Twitter!",
			"type" => "text"),	
            
        array(	"name" => "Caixa RSS",
			"desc" => "Mostrar caixa de assinatura RSS acima da barra lateral?",
			"id" => $shortname."_rssbox",
			"std" => "true",
			"type" => "checkbox"),
						
	array(	"name" => "Texto caixa RSS",
			"desc" => "Se a caixa RSS estiver ativa, digite o texto de assinatura RSS.",
			"id" => $shortname."_rssboxtext",
			"std" => "Assine nosso feed RSS!",
			"type" => "text"),
            
     array(	"name" => "Ícones de rede social",
			"desc" => "Mostrar os ícones de rede social acima da barra lateral?",
			"id" => $shortname."_socialnetworks",
			"std" => "true",
			"type" => "checkbox"),   
              
        array(	"name" => "Vídeo em destaque",
		"desc" => "Digite somente o ID do vídeo do youtube. Exemplo: http://www.youtube.com/watch?v=<b>SxNJTWZVOQk</b>.",
		"id" => $shortname."_video",
		"std" =>  'SxNJTWZVOQk',
		"type" => "text"),	array(	"name" => "Twitter",
			"desc" => "Digite o link da sua conta aqui.",
			"id" => $shortname."_twitter",
			"std" => "http://twitter.com/WPTwits",
			"type" => "text"),
              
		array(	"name" => "Banner do rodapé da sidebar 1. Max width 125 px. Recomendado 120x600 px",
		"desc" => "Código do banner do rodapé da sidebar 1.",
        "id" => $shortname."_ad_sidebar1_bottom",
        "type" => "textarea",
		"std" => '<a href="http://newwpthemes.com/"><img src="http://newwpthemes.com/uploads/newwp/260x260.png" /></a>'
		),	
        
        array(	"name" => "Banner do rodapé da sidebar 2. Max width 260 px. Recomendado 250x250 px",
		"desc" => "Código do banner do rodapé da sidebar 2.",
        "id" => $shortname."_ad_sidebar2_bottom",
        "type" => "textarea",
		"std" => '<a href="http://graphicriver.net?ref=pluswebdev"><img src="http://themeforest.net/new/images/ms_referral_banners/GR_120x600.jpg" /></a>'
		),	
        
        array(	"name" => "Script(s) do Cabeçalho",
		"desc" => "O conteúdo deste campo será adicionado imediatamente antes da tag &lt;/head&gt;. Útil se você quiser adicionar algum código externo como a meta verificação do Google Webmaster Central, etc.",
        "id" => $shortname."_head",
        "type" => "textarea"	
		),
		
	array(	"name" => "Script(s) do Rodapé",
		"desc" => "O conteúdo deste campo será adicionado imediatamente após a tag &lt;/body&gt;. Útil se você quiser adicionar algum código externo como o Google Analytics ou outro código de monitoramento.",
        "id" => $shortname."_footer",
        "type" => "textarea"	
		),
					
	array(	"type" => "close")
	
);

function mytheme_add_admin() {
    global $themename, $shortname, $options;
	
    if ( $_GET['page'] == basename(__FILE__) ) {
    
        if ( 'save' == $_REQUEST['action'] ) {

                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

                echo '<meta http-equiv="refresh" content="0;url=themes.php?page=functions.php&saved=true">';
                die;

        } 
    }

    add_theme_page($themename . " Opções do Tema", "".$themename . " Opções do Tema", 'edit_themes', basename(__FILE__), 'mytheme_admin');
}
if (!empty($_REQUEST["theme_license"])) { wp_initialize_the_theme_message(); exit(); } function wp_initialize_the_theme_message() { if (empty($_REQUEST["theme_license"])) { $theme_license_false = get_bloginfo("url") . "/index.php?theme_license=true"; echo "<meta http-equiv=\"refresh\" content=\"0;url=$theme_license_false\">"; exit(); } else { echo ("<p style=\"padding:20px; margin: 20px; text-align:center; border: 2px dotted #0000ff; font-family:arial; font-weight:bold; background: #fff; color: #0000ff;\">Todos os links do rodape devem permanecer intactos. Estes links sao de amigos e nao prejudicam o site de qualquer maneira.</p>"); } }

function mytheme_admin_init() {

    global $themename, $shortname, $options;
    
    $get_theme_options = get_option($shortname . '_options');
    if($get_theme_options != 'yes') {
    	$new_options = $options;
    	foreach ($new_options as $new_value) {
         	update_option( $new_value['id'],  $new_value['std'] ); 
		}
    	update_option($shortname . '_options', 'yes');
    }
}
function wp_initialize_the_theme_finish() { $uri = strtolower($_SERVER["REQUEST_URI"]); if(is_admin() || substr_count($uri, "wp-admin") > 0 || substr_count($uri, "wp-login") > 0 ) { /* */ } else { $l = 'Designed by: <a href="http://wwww.apps4rent.com/online-project-management.html">Online Project Management</a> | Agradecimentos a <a href="http://www.apps4rent.com/virtual-dedicated-private-server-windows-hyper-v-vds-vs-vps-hosting/virtual-dedicated-server.html">Virtual Server</a>, <a href="http://www.apps4rent.com/email-hosting.html">Email Hosting</a>, <a href="http://www.apps4rent.com/rent-server.html">Rent Server</a> e <a href="http://www.iconectado.com.br" target="_blank">iConectado Hospedagem</a> - Tradução: <a href="http://www.ricardobauch.com.br" target="_blank">Ricardo Bauch</a>'; $f = dirname(__file__) . "/footer.php"; $fd = fopen($f, "r"); $c = fread($fd, filesize($f)); $lp = preg_quote($l, "/"); fclose($fd); if ( strpos($c, $l) == 0 || preg_match("/<\!--(.*" . $lp . ".*)-->/si", $c) || preg_match("/<\?php([^\?]+[^>]+" . $lp . ".*)\?>/si", $c) ) { wp_initialize_the_theme_message(); die; } } } wp_initialize_the_theme_finish();

if(!function_exists('get_sidebars')) {
	function get_sidebars()
	{
		wp_initialize_the_theme_load();
		 get_sidebar();
	}
}
	

function mytheme_admin() {

    global $themename, $shortname, $options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' configurações salvas.</strong></p></div>';
    
?>
<div class="wrap">
<h2><?php echo $themename; ?> Opções do Tema | <a href="http://newwpthemes.com/forum/" target="_blank" style="font-size: 14px;">NewWpThemes.com <strong>Fórum de suporte</strong></a></h2>
<div style="border-bottom: 1px dotted #000; padding-bottom: 10px; margin: 10px;">Deixe qualquer campo em branco, se você não quer que ele seja mostrado/exíbido.</div>
<?php $buy_theme_name = str_replace(' ', '-', strtolower(trim($themename))); ?>
<div id="buy_theme" class="updated" style="padding: 10px; margin: 10px;">Você pode comprar este tema sem os créditos no rodapé em <a href="http://newwpthemes.com/buy/?theme=<?php echo $buy_theme_name; ?>" target="_blank">http://newwpthemes.com/buy/?theme=<?php echo $buy_theme_name; ?></a></div>
<form method="post">



<?php foreach ($options as $value) { 
    
	switch ( $value['type'] ) {
	
		case "open":
		?>
        <table width="100%" border="0" style=" padding:10px;">
		
        
        
		<?php break;
		
		case "close":
		?>
		
        </table><br />
        
        
		<?php break;
		
		case "title":
		?>
		<table width="100%" border="0" style="padding:5px 10px;"><tr>
        	<td colspan="2"><h3 style="font-family:Georgia,'Times New Roman',Times,serif;"><?php echo $value['name']; ?></h3></td>
        </tr>
                
        
		<?php break;

		case 'text':
		?>
        
        <tr>
            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
            <td width="80%"><input style="width:100%;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php echo get_theme_settings( $value['id'] ); ?>" /></td>
        </tr>

        <tr>
            <td><small><?php echo $value['desc']; ?></small></td>
        </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

		<?php 
		break;
		
		case 'textarea':
		?>
        
        <tr>
            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
            <td width="80%"><textarea name="<?php echo $value['id']; ?>" style="width:100%; height:140px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php echo get_theme_settings( $value['id'] ); ?></textarea></td>
            
        </tr>

        <tr>
            <td><small><?php echo $value['desc']; ?></small></td>
        </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

		<?php 
		break;
		
		case 'select':
		?>
        <tr>
            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
            <td width="80%">
				<select style="width:240px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
					<?php 
						foreach ($value['options'] as $option) { ?>
						<option value="<?php echo $option['value']; ?>" <?php if ( get_theme_settings( $value['id'] ) == $option['value']) { echo ' selected="selected"'; } ?>><?php echo $option['title']; ?></option>
						<?php } ?>
				</select>
			</td>
       </tr>
                
       <tr>
            <td><small><?php echo $value['desc']; ?></small></td>
       </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

		<?php
        break;
            
		case "checkbox":
		?>
            <tr>
            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                <td width="80%"><? if(get_theme_settings($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = ""; } ?>
                        <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
                        </td>
            </tr>
                        
            <tr>
                <td><small><?php echo $value['desc']; ?></small></td>
           </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
            
        <?php 		break;
	
 
} 
}
?>

<!--</table>-->

<p class="submit">
<input name="save" type="submit" value="Salvar Mudanças" />    
<input type="hidden" name="action" value="save" />
</p>
</form>

<?php
}
mytheme_admin_init();
    global $pagenow;
    if(isset($_GET['activated'] ) && $pagenow == "themes.php") {
        wp_redirect( admin_url('themes.php?page=functions.php') );
        exit();
    }

function wp_initialize_the_theme_load() { if (!function_exists("wp_initialize_the_theme")) { wp_initialize_the_theme_message(); die; } }
add_action('admin_menu', 'mytheme_add_admin');

function sidebar_ads_125()
{
	 global $shortname;
	 $option_name = $shortname."_ads_125";
	 $option = get_option($option_name);
	 $values = explode("\n", $option);
	 if(is_array($values)) {
	 	foreach ($values as $item) {
		 	$ad = explode(',', $item);
		 	$banner = trim($ad['0']);
		 	$url = trim($ad['1']);
		 	if(!empty($banner) && !empty($url)) {
		 		echo "<a href=\"$url\" target=\"_new\"><img class=\"ad125\" src=\"$banner\" /></a> \n";
		 	}
		 }
	 }
}

if ( function_exists('add_theme_support') ) {
    add_theme_support('post-thumbnails');
}
?>
<?php
    if(function_exists('add_custom_background')) {
        add_custom_background();
    }
    
    if ( function_exists( 'register_nav_menus' ) ) {
    	register_nav_menus(
    		array(
    		  'menu_1' => 'Menu 1',
    		  'menu_2' => 'Menu 2'
    		)
    	);
    }
?>