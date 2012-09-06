<?php
/**
*
* it [Italian]
*
* @package language
* @copyright (c) 2012 Bokeh Teknology
* @author Bokeh Teknology
* @version 1.0.0-b5
* @license http://opensource.org/licenses/gpl-3.0.html GNU GPL v3
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_BOKEH'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

# UTF-8 (no BOM)
# Some characters
# ’ » “ ” …

$lang = array_merge($lang, array(
	'LANG_PREFIX'			=> 'it',
	'TRANSLATION_INFO'		=> 'Traduzione Italiana by Bokeh Teknology',

	# error_box() messages
	'ERROR'						=> 'Errore',
	'ERR_SQL_CONNECT'			=> 'Impossibile collegarsi al server del database.',
	'ERR_SQL_SELECT_DB'			=> 'Impossibile selezionare il database.',
	'ERR_SQL_QUERY'				=> 'Si è verificato un errore durante l’esecuzione di una query.',
	'ERR_SQL_NO_QUERY'			=> 'Nessuna query specificata.',
	'ERR_SQL_FETCH'				=> 'Si è verificato un errore durante il fetching della query.',
	'ERR_NO_TEMPLATE_FILE'		=> 'Il file del template richiesto non esiste.',
	'ERR_TEMPLATE_IF_PARSING'	=> 'Si è verificato un errore durante il parsing del template.',
	'ERR_API_SERVER_OFFLINE'	=> 'Il server API per i servizi Bokeh Teknology è irragiungibile, pertanto non è possibile effettuare la richiesta desiderata.',
	'ERR_API_REQUEST'			=> 'Si è verificato un errore durante l’esecuzione della richiesta API per i servizi Bokeh Teknology.',
	'ERR_APIKEY_NOT_SET'		=> 'L’apikey per i servizi Bokeh Teknology non è stata configurata, pertanto non è possibile eseguire la richiesta API.',

	# http errors
	'ERROR_403_TITLE'	=> 'Errore 403',
	'ERROR_403_EXPLAIN'	=> 'Non hai i permessi per accedere a questa pagina.',
	'ERROR_404_TITLE'	=> 'Errore 404',
	'ERROR_404_EXPLAIN'	=> 'Non c’è nessuna pagina con questo nome.',

	# explain mode messages
	'EXPLAIN_PAGE_GENERATE'		=> 'Pagina generata in',
	'EXPLAIN_SECONDS_WITH'		=> 'secondi con',
	'EXPLAIN_QUERIES'			=> 'query',
	'EXPLAIN_SPENT_PHP'			=> 'Tempo speso su PHP',
	'EXPLAIN_SPENT_SQL'			=> 'Tempo speso sul database',
	'EXPLAIN_BEFORE'			=> 'Prima',
	'EXPLAIN_AFTER'				=> 'Dopo',
	'EXPLAIN_ELAPSED'			=> 'Tempo',

	# some default messages
	'USERNAME'	=> 'Utente',
	'PASSWORD'	=> 'Password',

	# pages title
	'HOME'		=> 'Home',

	# server messages
	'SITE_INFO'			=> 'Informazioni sul sito',
	'DATABASE_INFO'		=> 'Informazioni sul database',
	'SITENAME'			=> 'Nome del sito',
	'SITE_DESCRIPTION'	=> 'Descrizione del sito',
	'META_DESCRIPTION'	=> 'Descrizione [META]',
	'META_KEYWORDS'		=> 'Keywords [META]',
	'TEMPLATE'			=> 'Template',
	'SETTINGS'			=> 'Configurazioni',

	# version check
	'BOKEH_NOT_UPDATED'	=> 'Bokeh Platform non è aggiornato! L’ultima versione disponibile è: ',
	'BOKEH_NOT_STABLE'	=> 'Ti ricordiamo che non stai usando la versione <b>stabile</b> di Bokeh Platform!',

	# months
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
	'MONTH_12'	=> 'Dicembre'
));
