<?php
/*======================================================================*\
|| #################################################################### ||
|| # DevTracker Product
|| # ---------------------------------------------------------------- # ||
|| # Copyright ©2008 Ben O'Neill. All Rights Reserved.                # ||
|| #################################################################### ||
\*======================================================================*/

// ######################## SET PHP ENVIRONMENT ###########################
error_reporting(E_ALL & ~E_NOTICE);

// #################### PRE-CACHE TEMPLATES AND DATA ######################
$phrasegroups = array();
$specialtemplates = array();

// ########################## REQUIRE BACK-END ############################
require_once('./global.php');
require_once(DIR . '/includes/functions.php');
require_once(DIR . '/includes/functions_giveaway.php');
require_once(DIR . '/includes/functions_misc.php');

// ############################# LOG ACTION ###############################
if (!can_administer('canadminforums'))
{
	print_cp_no_permission();
}

log_admin_action();

// ########################################################################
// ######################### START MAIN SCRIPT ############################
// ########################################################################

print_cp_header($vbphrase['devtracker']);

if (empty($_REQUEST['do']) || !in_array($_REQUEST['do'], array('modify', 'add', 'edit', 'delete')))
{
	$_REQUEST['do'] = 'modify';
}

// ########################## Start Add / Edit ##############################

if (in_array($_REQUEST['do'], array('edit', 'add'))) {
	
	$vbulletin->input->clean_array_gpc('r', array(
		'groupid' => TYPE_INT,
		'title' => TYPE_STR,
		'tag' => TYPE_STR,
		'usergroups' => TYPE_ARRAY
	));
	
	$devgroup = false;
	
	if ($_REQUEST['do'] == 'edit') {
		$groupid = $vbulletin->GPC['groupid'];
		$devgroup = $db->query_first('SELECT `devtrackid`, `title`, `usergroupids`, `tag` FROM ' . TABLE_PREFIX . 'devtracker WHERE `devtrackid`=' . $groupid);
	}
	
	if (!is_array($devgroup)) {
		$groupid = 0;
		$devgroup = array(
						'devtrackid' => 0,
						'title' => '',
						'usergroupids' => '',
						'tag' => ''
		);
	}
	
	if (isset($_POST['save'])) {
		// save the changes
		
		$new_values = array(
						'devtrackid' => $vbulletin->GPC['groupid'],
						'title' => $vbulletin->GPC['title'],
						'usergroupids' => implode(',', $vbulletin->GPC['usergroups']),
						'tag' => $vbulletin->GPC['tag']
		);
		
		$allow_save = true;
		$errors = array();
		
		if (count($vbulletin->GPC['usergroups']) == 0) {
			$allow_save = false;
			$errors['usergroups'] = 'You must select at least one usergroup';
		}
		
		if (!preg_match('#^([a-z0-9]+)$#i', $vbulletin->GPC['tag'])) {
			$allow_save = false;
			$errors['tag'] = 'You must enter a tag, it can only consist of letters and numbers';
		}
		
		if (strlen($vbulletin->GPC['title']) == 0) {
			$allow_save = false;
			$errors['title'] = 'You must enter a title';
		}
		
		if ($allow_save) {
			
			if ($new_values['devtrackid'] == 0) {
				
				// insert
				
				$fields = array();
				$values = array();
				
				foreach ($new_values as $key => $value) {
					$fields[] = '`' . $key . '`';
					$values[] = '"' . $value . '"';
				}

				$db->query_write('INSERT INTO ' . TABLE_PREFIX . 'devtracker (' . implode(', ', $fields) . ') VALUES(' . implode(', ', $values) . ')');
				
			} else {
				
				$tmp = array();
				
				foreach ($new_values as $key => $value) {
					$tmp[] = '`' . $key . '`="' . $db->escape_string($value) . '"';
				}
				
				$settings = implode(', ', $tmp);

				// update
				$db->query_write('UPDATE ' . TABLE_PREFIX . 'devtracker SET ' . $settings . ' WHERE `devtrackid`=' . $new_values['devtrackid']);
				
			}
			
			// show saved message
			
			print_cp_message(
				'The changes have been saved.',
				'devtracker.php?' . $vbulletin->session->vars['sessionurl'] .
					'do=modify',
				1,
				null,
				false
			);
			
		}
		
	}
	
	print_form_header('devtracker', 'edit');

	$_HIDDENFIELDS['save'] = 1;
	$_HIDDENFIELDS['groupid'] = $devgroup['devtrackid'];

	print_table_header('Edit DevTracker Group (id: ' . $devgroup['devtrackid'] . ')', 2);

	// giveaway name
	print_input_row('Title<br/><small>The name of the developer group.</small>', 'title', $devgroup['title']);
	
	print_input_row('Tag<br/><small>This is the URL fragment used for this developer group, it must be all one word and only contain letters and numbers.</small>', 'tag', $devgroup['tag']);
	
	print_membergroup_row('Usergroups to Track<br/><small>Select the usergroups that should be tracked by this developer group.</small>', 'usergroups', 2, array('usergroupid' => 0, 'membergroupids' => $devgroup['usergroupids']));
	
	print_hidden_fields();
	print_submit_row();
	print_table_footer();
	
}

if ($_REQUEST['do'] == 'delete') {
	
	$vbulletin->input->clean_array_gpc('r', array(
		'groupid' => TYPE_INT
	));
	
	$groupid = $vbulletin->GPC['groupid'];
	
	$db->query_write('DELETE FROM ' . TABLE_PREFIX . 'devtracker WHERE `devtrackid`=' . $groupid . ' LIMIT 1');
	
	$_REQUEST['do'] = 'modify';
	
}

if ($_REQUEST['do'] == 'modify') {
	
	
	print_form_header('', '');
	print_table_header('DevTracker Groups', 6);
	print_cells_row(array('Title', 'Tag', 'Controls'), 1);
	
	$r = $db->query('SELECT `devtrackid`, `title`, `tag` FROM ' . TABLE_PREFIX . 'devtracker ORDER BY `title` ASC');
	
	while ($d = $db->fetch_array($r)) {
		
		$options = array('edit' => 'Edit Group (id: ' . $d['devtrackid'] . ')',
						 'delete' => 'Delete Group');
		
		print_cells_row(array(
			'<a href="devtracker.php?' .
				$vbulletin->session->vars['sessionurl'] .
				'do=edit&amp;groupid=' . $d['devtrackid'] . '"><strong>'.$d['title'].'</strong></a>',
			'<a href="' . $vbulletin->options['bburl'] . '/devtracker.php?' . $vbulletin->session->vars['sessionurl'] . 'g=' . $d['tag'] . '" target="_blank">' . $d['tag'] . '</a>', 
			'<select name="d' . $d['devtrackid'] . '" onchange="js_jump(' .
			 	$d['devtrackid'] . ');" class="bginput">' .
			 	construct_select_options($options) . 
				'</select><input type="button" class="button" value="' .
				$vbphrase['go'] . 
				'" onclick="js_jump(' . $d['devtrackid'] . ');" />'));
	}
	
	echo '<tr valign="middle" align="center"><td colspan="3" class="tfoot" ' .
	 			'align="center"><input type="button" class="button" ' . 
				'value="Create New DevTracker Group" onclick="window.location=\'devtracker.php?' .
				$vbulletin->session->vars['sessionurl'] . 'do=add\';" /></td></tr>';
	
	print_table_footer();
	
	?>
	<script type="text/javascript">
	function js_jump(id)
	{
		task = eval("document.cpform.d" + id + ".options[document.cpform.d" + id + ".selectedIndex].value");
		switch (task)
		{
			case 'edit': window.location = "devtracker.php?<?php echo $vbulletin->session->vars['sessionurl_js']; ?>do=edit&groupid=" + id; break;
			case 'delete': window.location = "devtracker.php?<?php echo $vbulletin->session->vars['sessionurl_js']; ?>do=delete&groupid=" + id; break;
			default: return false; break;
		}
	}
	</script>
	<?php
	
}

// ################################# END ####################################

print_cp_footer();

?>