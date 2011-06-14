<?php
#######################################################################
######################## START MAIN SCRIPT ############################
#######################################################################

define('IN_BOKEH', true);
$root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($root_path . 'common.' . $phpEx);

# Add template vars for example article
$smarty->assign(array(
	'article_data'	=> formatdate(1265309922)
));

######################## GENERATE TEMPLATES ###########################
page_header($user['lang']['HOME']);
_template('home_body');
page_footer();
?>