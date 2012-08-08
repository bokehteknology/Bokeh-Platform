<?php
/**
*
* it [Italian]
*
* @plugin PluginManager
* @package PluginManager
* @copyright (c) 2012 Bokeh Platform
* @author Bokeh Teknology
* @version 1.0.1
* @license http://opensource.org/licenses/gpl-3.0.html GNU GPL v3
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

# UTF-8 (no BOM)
# Some characters
# ’ » “ ” …

$lang = array_merge($lang, array(
	'PLUGIN_PLUGIN_MANAGER_TITLE'	=> 'Plugin Manager',

	'PLUGIN_PLUGIN_MANAGER_ERR_PASSKEY'	=> 'Hai bisogno della passkey della modalità explain per accedere al Plugin Manager.<br />Aggiungi ?passkey=PASSKEY all’URL.',
	'PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN'	=> 'Nessun plugin specificato.',
	'PLUGIN_PLUGIN_MANAGER_ERR_FILE'	=> 'La cartella “plugins/plugin_manager/tmp” non è scrivibile.',
	'PLUGIN_PLUGIN_MANAGER_ERR_ZIP'		=> 'Non è stato possibile trovare la cartella principale del plugin. Probabilmente l’archivio ZIP non è strutturato correttamente.',
	'PLUGIN_PLUGIN_MANAGER_ERR_MOVE'	=> 'Non è stato possibile aggiornare il plugin. Controlla i permessi di scrittura sulla cartella “plugins”.',

	'PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN_NOT_EXIST'	=> 'Il plugin specificato non esiste.',
	'PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN_EXIST_YET'	=> 'Il plugin specificato è già installato.',
	'PLUGIN_PLUGIN_MANAGER_ERR_THIS_PLUGIN'			=> 'Non puoi aggiornare questo plugin automaticamente. Devi aggiornarlo manualmente.',
	'PLUGIN_PLUGIN_MANAGER_ERR_IS_ACTIVE'			=> 'Non puoi eliminare un plugin attivo. Disattivalo, e riprova.',

	'PLUGIN_PLUGIN_MANAGER_WELCOME'		=> 'Benvenuto',
	'PLUGIN_PLUGIN_MANAGER_REQUESTS'	=> 'Richieste',

	'PLUGIN_PLUGIN_MANAGER_INSTALLED'	=> 'Plugin installati',
	'PLUGIN_PLUGIN_MANAGER_DOWNLOAD'	=> 'Scarica plugin',

	'PLUGIN_PLUGIN_MANAGER_YES'			=> 'Sì',
	'PLUGIN_PLUGIN_MANAGER_NO'			=> 'No',

	'PLUGIN_PLUGIN_MANAGER_PLUGIN_ID'	=> 'Plugin ID',
	'PLUGIN_PLUGIN_MANAGER_NAME'		=> 'Nome',
	'PLUGIN_PLUGIN_MANAGER_DESCRIPTION'	=> 'Descrizione',
	'PLUGIN_PLUGIN_MANAGER_DOWNLOADS'	=> 'Downloads',
	'PLUGIN_PLUGIN_MANAGER_VERSION'		=> 'Versione',
	'PLUGIN_PLUGIN_MANAGER_AUTHOR'		=> 'Autore',
	'PLUGIN_PLUGIN_MANAGER_IS_ACTIVE'	=> 'Attivo',
	'PLUGIN_PLUGIN_MANAGER_OPTIONS'		=> 'Opzioni',
	'PLUGIN_PLUGIN_MANAGER_CONTROLLER'	=> 'Controller',
	'PLUGIN_PLUGIN_MANAGER_BRANCH'		=> 'Branch',

	'PLUGIN_PLUGIN_MANAGER_UPDATE'		=> 'Aggiornamento',
	'PLUGIN_PLUGIN_MANAGER_INSTALLING'	=> 'Installazione',
	'PLUGIN_PLUGIN_MANAGER_DELETING'	=> 'Rimozione',

	'PLUGIN_PLUGIN_MANAGER_UPDATE_STARTING'		=> 'L’aggiornamento è iniziato!<br />Se il plugin è abbastanza grande, l’aggiornamento può richiedere più di 1 minuto.',
	'PLUGIN_PLUGIN_MANAGER_INSTALL_STARTING'	=> 'L’installazione è iniziata!<br />Se il plugin è abbastanza grande, l’installazione può richiedere più di 1 minuto.',
	'PLUGIN_PLUGIN_MANAGER_DELETE_STARTING'		=> 'Il plugin è in fase di rimozione!<br />Attendi qualche istante.',
	'PLUGIN_PLUGIN_MANAGER_MSG_UPDATED'			=> 'Il plugin è stato aggiornato con successo!',
	'PLUGIN_PLUGIN_MANAGER_MSG_INSTALLED'		=> 'Il plugin è stato installato con successo!',
	'PLUGIN_PLUGIN_MANAGER_MSG_DELETED'			=> 'Il plugin è stato rimosso con successo!',
	'PLUGIN_PLUGIN_MANAGER_MSG_API_OFFLINE'		=> 'Il server API è offline, pertanto non è stato possibile recuperare informazioni richieste!',
	'PLUGIN_PLUGIN_MANAGER_MSG_DWL_OFFLINE'		=> 'Non è stato possibile recuperare il plugin!',

	'PLUGIN_PLUGIN_MANAGER_DELETE'		=> 'Elimina',
	'PLUGIN_PLUGIN_MANAGER_INSTALL'		=> 'Installa',

	'PLUGIN_PLUGIN_MANAGER_INSTALLED_COUNT'		=> 'Hai installato <strong>%d</strong> plugin (<strong>%d</strong> attivo/i).',
	'PLUGIN_PLUGIN_MANAGER_UPDATE_COUNT'		=> 'Ci sono <strong>%d</strong> plugin non aggiornati.',
	'PLUGIN_PLUGIN_MANAGER_DOWNLOADS_COUNT'		=> 'Il database contiene <strong>%d</strong> plugin (<strong>%d</strong> già installato/i).',

	'PLUGIN_PLUGIN_MANAGER_UPDATE_TO'	=> 'Aggiorna a',

	'PLUGIN_PLUGIN_MANAGER_NOT_REGISTERED'	=> 'non registrato sul forum BT'
));
