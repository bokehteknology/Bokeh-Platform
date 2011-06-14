<?php
/**
*
* it [Italian]
*
* @package language
* @copyright (c) 2011 Bokeh Platform
* @author Carlo [uid: 2]
* @version 1.0.0-dev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_BOKEH')) {
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// UTF-8 (no BOM)
// Some characters
// ’ » “ ” …

$lang = array_merge($lang, array(
	'LANG_PREFIX'			=> 'it',
	'TRANSLATION_INFO'		=> 'Traduzione Italiana by carlino1994',
	
	// error_box() messages
	'ERROR'						=> 'Errore',
	'ERR_SQL_CONNECT'			=> 'Impossibile collegarsi al server del database.',
	'ERR_SQL_SELECT_DB'			=> 'Impossibile selezionare il database.',
	'ERR_SQL_QUERY'				=> 'Si è verificato un errore durante l’esecuzione della query:',
	'ERR_SQL_QUERY_ERR'			=> 'Informazioni sull’errore:',
	'ERR_SQL_NO_QUERY'			=> 'Nessuna query specificata.',
	'ERR_SQL_FETCH'				=> 'Si è verificato un errore durante il fetching della query.',
	'ERR_NO_TEMPLATE'			=> 'Il template richiesto non esiste.',
	'ERR_NO_TEMPLATE_FILE'		=> 'Il file del template richiesto non esiste.',
	'ERR_NO_STYLESHEET_FILE'	=> 'Lo stylesheet richiesto non esiste.',
	'ERR_NO_TEMPLATE_INFO'		=> 'Il file contenente le informazioni sul template non esiste.',
	'ERR_TEMPLATE_IF_PARSING'	=> 'Si è verificato un errore durante il parsing del template.',
	
	// explain mode messages
	'EXPLAIN_PAGE_GENERATE'		=> 'Pagina generata in',
	'EXPLAIN_SECONDS_WITH'		=> 'secondi con',
	'EXPLAIN_QUERIES'			=> 'query',
	'EXPLAIN_SPENT_PHP'			=> 'Tempo speso su PHP',
	'EXPLAIN_SPENT_SQL'			=> 'Tempo speso sul database',
	'EXPLAIN_BEFORE'			=> 'Prima',
	'EXPLAIN_AFTER'				=> 'Dopo',
	'EXPLAIN_ELAPSED'			=> 'Tempo',
	
	// install messages
	'INSTALL_BOKEH'				=> 'Pannello d’installazione di Bokeh Platform',
	'INSTALL_PAGE'				=> '<p><strong>Bokeh Platform</strong> è la “piattaforma semplice e veloce”, l’ideale per lo sviluppo tuo sito/blog.</p><p>Potrai contare anche ad una community che mette a disposizioni dei suoi utenti diversi plugins, cui avranno la capacità di aumentare le funzionalità.</p><p>Bokeh Platform nasce come progetto Open Source nel dicembre 2009, sviluppato da <a href="http://BOKEH_SITE/"><em>Bokeh Teknology</em></a>.</p><p>Se anche tu vuoi aiutarci in questo progetto, vieni a trovarci sul nostro sito <a href="http://BOKEH_SITE/">BOKEH_SITE</a>.</p>',
	'INSTALL_INSTALL_ERRORS'	=> 'Durante l’installazione, si sono verificati i seguenti errori all’interno del database:',
	'INSTALL_OK'				=> 'L’installazione è stata completata. Puoi ora eliminare il file <em>install.php</em>.',
	'INSTALL_MAIN'				=> 'Principale',
	'INSTALL_INSTALL'			=> 'Installazione',
	'INSTALL_INFORMATIONS'		=> 'Informazioni',
	'INSTALL_TYPE'				=> 'Tipo',
	'INSTALL_HOST'				=> 'Host',
	'INSTALL_PORT'				=> 'Porta',
	'INSTALL_DBNAME'			=> 'Nome database',
	'INSTALL_TABLE_PREFIX'		=> 'Prefisso tabelle',
	'INSTALL_CONTINUE'			=> '» Continua',
	'INSTALL_INSTALL'			=> '» Installa',
	'INSTALL_DETAILS'			=> 'Dettagli',
	
	// some default messages
	'USERNAME'	=> 'Utente',
	'PASSWORD'	=> 'Password',
	
	// pages title
	'HOME'		=> 'Home',
	
	// server messages
	'SITE_INFO'			=> 'Informazioni sul sito',
	'DATABASE_INFO'		=> 'Informazioni sul database',
	'SITENAME'			=> 'Nome del sito',
	'SITE_DESCRIPTION'	=> 'Descrizione del sito',
	'META_DESCRIPTION'	=> 'Descrizione [META]',
	'META_KEYWORDS'		=> 'Keywords [META]',
	'TEMPLATE'			=> 'Template',
	'SETTINGS'			=> 'Configurazioni',
	
	// default blog strings
	'BLOG_SEARCH'		=> 'Cerca',
	'BLOG_PUBLISHED_ON'	=> 'Pubblicato il',
	'BLOG_BY'			=> 'da',
	'BLOG_CONTINUE'		=> 'Continua',
	'BLOG_COMMENTS'		=> 'Commenti',
	'BLOG_NO_CATS'		=> 'Nessuna categoria.',
	
	// months
	'MONTH_1'	=> 'Gennaio',
	'MONTH_2'	=> 'Febbraio',
	'MONTH_3'	=> 'Marzo',
	'MONTH_4'	=> 'Aprile',
	'MONTH_5'	=> 'Maggio',
	'MONTH_6'	=> 'Giugno',
	'MONTH_7'	=> 'Luglio',
	'MONTH_8'	=> 'Agosto',
	'MONTH_9'	=> 'Settembre',
	'MONTH_10'	=> 'Ottobre',
	'MONTH_11'	=> 'Novembre',
	'MONTH_12'	=> 'Dicembre',
	
	// siderbar strings
	'CATEGORIES'		=> 'Categorie',
	
	// first article strings
	'ARTICLE_TITLE'		=> 'Benvenuto su',
	'ARTICLE_CONTENT'	=> '<p>la la la la la</p>',
));
?>