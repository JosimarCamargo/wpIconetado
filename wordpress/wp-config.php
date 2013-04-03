<?php
/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'iconectado');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'iconectado');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', '63fveWrdNQpXrBRs');

/** nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'pQc^C3uH1$DB.2<ba24,+cH9Mp5 U6syvleD3w,ToCTB5s5>`1AM]%2,v9&JQ!B;');
define('SECURE_AUTH_KEY',  'hJD_=7f0?CnI8u+q2#_9;{[pOj60y?.6#JJ 0$oK;Roh1kd}&m}-xlnVc;in7(wb');
define('LOGGED_IN_KEY',    'N)k5;czOoAV%cs;rq#;Jx#_l8k2@GB@ruoQz_qe/{pRmu<`#QMM0bolt&o_-WZ[I');
define('NONCE_KEY',        'l=%$mbWt)~uf7%c`4Fk|WWM_w$)W&36LC )}[3r!11yRfpZ5Qj4 {;Js,MBKGLPC');
define('AUTH_SALT',        '<;&-)iF%XeRr+n>v-y&n$Nq![?arAgJfu4UP>=S=n-*Pb?[< N@rkL-2zM$6mZ33');
define('SECURE_AUTH_SALT', 'Hi2$7B_*p`M7HOg-bwWUct~Jif&:5856 Q]p,b%k(?(6HQ*B#!WE.tBd}$2X;3k#');
define('LOGGED_IN_SALT',   ')w]pS@u$lbvdJe)3jf2_D.I41bBS#:vNc_T91qS1wJU_QVo>9Vw}6@}-fP6|(7fg');
define('NONCE_SALT',       'e%s_E.zrvUKPpEti!STQ=H>l`/hO3Pu<Q-EAKj9K$?`??hJn9Od??`5Ty^$g2S~B');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'ci_';

/**
 * O idioma localizado do WordPress é o inglês por padrão.
 *
 * Altere esta definição para localizar o WordPress. Um arquivo MO correspondente ao
 * idioma escolhido deve ser instalado em wp-content/languages. Por exemplo, instale
 * pt_BR.mo em wp-content/languages e altere WPLANG para 'pt_BR' para habilitar o suporte
 * ao português do Brasil.
 */
define('WPLANG', 'pt_BR');

/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');
