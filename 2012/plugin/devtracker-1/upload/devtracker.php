<?php

/**
 * Works by sending:
 * 		devtracker.php?g=goa
 * 
 * Where dev groups have been set up in the admin tools.
 */

// ####################### SET PHP ENVIRONMENT ###########################
error_reporting(E_ALL & ~E_NOTICE);

// #################### DEFINE IMPORTANT CONSTANTS #######################
define('THIS_SCRIPT', 'search');
define('CSRF_PROTECTION', true);
define('ALTSEARCH', true);

// ################### PRE-CACHE TEMPLATES AND DATA ######################
// get special phrase groups
$phrasegroups = array('search', 'inlinemod', 'prefix');

// get special data templates from the datastore
$specialtemplates = array(
	'iconcache',
	'searchcloud'
);

// pre-cache templates used by all actions
$globaltemplates = array(
	'humanverify',
	'optgroup',
	'search_forums',
	'search_results',
	'search_results_postbit', // result from search posts
	'search_results_postbit_lastvisit',
	'threadbit', // result from search threads
	'threadbit_deleted', // result from deleted search threads
	'threadbit_lastvisit',
	'threadbit_announcement',
	'newreply_reviewbit_ignore',
	'threadadmin_imod_menu_thread',
	'threadadmin_imod_menu_post',
	'tag_cloud_link',
	'tag_cloud_box_search',
	'tag_cloud_headinclude',
	'devtracker_results',
	'devtracker_threadbit'
);

// ######################### REQUIRE BACK-END ############################
require_once('./global.php');
require_once(DIR . '/includes/functions_search.php');
require_once(DIR . '/includes/functions_forumlist.php');
require_once(DIR . '/includes/functions_misc.php');
require_once(DIR . '/includes/functions_forumdisplay.php');
require_once(DIR . '/includes/functions_bigthree.php');

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################

if (!($permissions['forumpermissions'] & $vbulletin->bf_ugp_forumpermissions['cansearch']))
{
	print_no_permission();
}

$vbulletin->input->clean_array_gpc('r', array(
	'g'    => TYPE_STR,
));

$devgroup = $vbulletin->GPC['g'];

$navbits = array('devtracker.php?' . $vbulletin->session->vars['sessionurl'] . 'g=' . urlencode($devgroup) => $vbphrase['devtracker']);

$show['results'] = false;
$show['generated'] = false;
$show['threadicons'] = true;
$show['inlinemod'] = false;
$search['showposts'] = false; // 'thread' display, but they're posts really
$searchbits = '';
$templatename = 'devtracker_results';

$results_per_page = 50;

// Determine if the "devgroup" is valid
							
$devgroup_data = $db->query_first('SELECT `title`, `usergroupids` FROM ' . TABLE_PREFIX . 'devtracker WHERE `tag`="' . $db->escape_string($devgroup) . '"');

if (is_array($devgroup_data)) {
	
	$devgroup_membergroups = explode(',', $devgroup_data['usergroupids']);
	$devgroup_name = $devgroup_data['title'];
	
} else {
	standard_error(fetch_error('devtracker_error_nodevgroup'));
}

$group_ids = array();

foreach($devgroup_membergroups as $g) {
	$group_ids[] = 'FIND_IN_SET('.$g.', `membergroupids`)';
}

$txt = '';

if (count($group_ids) > 0) {
	$txt = ' OR ' . implode(' OR ', $group_ids);
}

// CHECK CACHE

$cache_sql = 'SELECT `orderedids`, `dateline`, `searchtime` FROM `'.TABLE_PREFIX.'search` WHERE `searchhash`="devtracker-'. $db->escape_string($devgroup) .'" AND `completed`=1 AND `dateline` > ' . (TIMENOW - ($vbulletin->options['devtracker_cachetime'] * 60));

$cache_result = $db->query_read_slave($cache_sql);
if (($cache = $db->fetch_array($cache_result)) && $vbulletin->options['devtracker_usecache']) {
	
	// CACHED
	$orderedids = unserialize($cache['orderedids']);
	DEVDEBUG('Got cached result!');
	
	$show['generated'] = true;
	$searchminutes = (TIMENOW - $cache['orderedids'] > 0) ? floor((TIMENOW - $cache['dateline']) / 60) : 0;
	$searchtime = vb_number_format($cache['searchtime'], 2);
	
} else {
	
	// CALCULATE ORDEREDIDS
	$t = microtime();

	$user_sql = 'SELECT `userid` FROM `'.TABLE_PREFIX.'user` WHERE `usergroupid` IN (0' . implode(', ', $devgroup_membergroups) . ')'.$txt;

	$userids = array();

	$user_result = $db->query_read_slave($user_sql);
	while ($x = $db->fetch_array($user_result))
	{
		$userids[] = intval($x['userid']);
	}

	DEVDEBUG('User Id Fetch: ' . vb_number_format(fetch_microtime_difference($t, microtime()), 4));

	// find all the users in the user groups

	$userid_str = implode(',', $userids);
	
	$maxage = TIMENOW - 1313280;

	// find all the posts made by the users
	//$search_sql = 'SELECT `postid` AS pid FROM `' . TABLE_PREFIX . 'post` WHERE `userid` IN (0'.$userid_str.')';// LIMIT ' . $vbulletin->options['maxresults'];
	
	$search_sql = 'SELECT `postid` AS pid, `dateline` FROM `' . TABLE_PREFIX . 'post` WHERE `userid` IN (0'.$userid_str.') AND `dateline` > '.$maxage.' ORDER BY `dateline` DESC';

	$orderedids = array(0); // ordered post id;

	$t = microtime();
	$s_items = $db->query_read_slave($search_sql);

	while ($s_item = $db->fetch_array($s_items))
	{
		$orderedids[] = intval($s_item['pid']);
	}
	
	$searchtime = fetch_microtime_difference($t, microtime());
	DEVDEBUG('Post Id Fetch (& sort in MySQL): ' . vb_number_format($searchtime, 2));
	
	$db->query_write('REPLACE INTO `'.TABLE_PREFIX.'search` (`ipaddress`, `query`, `searchuser`, `sortby`, `sortorder`, `searchtime`, `orderedids`, `dateline`, `searchhash`, `completed`) VALUES("", "", "devtracker", "lastpost", "DESC", '.$searchtime.', "' . $db->escape_string(serialize($orderedids)) . '", '.TIMENOW.', "devtracker-' . $db->escape_string($devgroup) . '", 1)');
	
	$searchtime = vb_number_format($searchtime, 2);
	
}

if (!is_array($orderedids) || count($orderedids) < 1) {
	$orderedids = array(0);
}

// Get the results for display

// query moderators for forum password purposes (and inline moderation)
if ($vbulletin->userinfo['userid'])
{
	cache_moderators();
}

// query threads
$permQuery = "
	SELECT postid AS itemid, post.visible AS post_visible, thread.visible AS thread_visible, thread.forumid, thread.threadid, thread.postuserid, post.userid,
	IF(postuserid = " . $vbulletin->userinfo['userid'] . ", 'self', 'other') AS starter
	FROM " . TABLE_PREFIX . "post AS post
	INNER JOIN " . TABLE_PREFIX . "thread AS thread ON(thread.threadid = post.threadid)
	WHERE postid IN(" . implode(', ', $orderedids) . ")
	AND thread.open <> 10
";

$dataQuery = "
	SELECT post.postid, post.title AS posttitle, post.dateline AS postdateline,
		post.iconid AS posticonid, post.pagetext, post.visible, post.attach,
		IF(post.userid = 0, post.username, user.username) AS username,
		thread.threadid, thread.title AS threadtitle, thread.iconid AS threadiconid, thread.replycount,
		IF(thread.views=0, thread.replycount+1, thread.views) as views, thread.firstpostid, thread.prefixid, thread.taglist,
		thread.pollid, thread.sticky, thread.open, thread.lastpost, thread.forumid, thread.visible AS thread_visible,
		user.userid
		" . (can_moderate() ? ",pdeletionlog.userid AS pdel_userid, pdeletionlog.username AS pdel_username, pdeletionlog.reason AS pdel_reason" : "") . "
		" . (can_moderate() ? ",tdeletionlog.userid AS tdel_userid, tdeletionlog.username AS tdel_username, tdeletionlog.reason AS tdel_reason" : "") . "
		" . iif($vbulletin->options['threadmarking'] AND $vbulletin->userinfo['userid'], ', threadread.readtime AS threadread') . "
		$hook_query_fields
	FROM " . TABLE_PREFIX . "post AS post
	INNER JOIN " . TABLE_PREFIX . "thread AS thread ON(thread.threadid = post.threadid)

	" . (can_moderate() ?
	"LEFT JOIN " . TABLE_PREFIX . "deletionlog AS tdeletionlog ON(thread.threadid = tdeletionlog.primaryid AND tdeletionlog.type = 'thread')
	LEFT JOIN " . TABLE_PREFIX . "deletionlog AS pdeletionlog ON(post.postid = pdeletionlog.primaryid AND pdeletionlog.type = 'post')"
		: "") . "

	" . iif($vbulletin->options['threadmarking'] AND $vbulletin->userinfo['userid'], " LEFT JOIN " . TABLE_PREFIX . "threadread AS threadread ON (threadread.threadid = thread.threadid AND threadread.userid = " . $vbulletin->userinfo['userid'] . ")") . "

	LEFT JOIN " . TABLE_PREFIX . "user AS user ON(user.userid = post.userid)
	$hook_query_joins
	WHERE post.postid IN";

$Coventry_array = fetch_coventry();

$tmp = array();
$items = $db->query_read_slave($permQuery);
unset($permQuery);

while ($item = $db->fetch_array($items))
{
	if (!can_moderate($item['forumid']) AND (in_array($item['userid'], $Coventry_array) OR in_array($item['postuserid'], $Coventry_array)))
	{
		continue;
	}

	if (!$search['showposts'])
	{
		// fake post_visible since we aren't looking for it in thread results
		$item['post_visible'] = 1;
	}

	if ((!$item['post_visible'] OR !$item['thread_visible']) AND !can_moderate($item['forumid'], 'canmoderateposts'))
	{	// post/thread is moderated and we don't have permission to see it
		continue;
	}
	else if (($item['post_visible'] == 2 OR $item['thread_visible'] == 2) AND !can_moderate($item['forumid']))
	{	// post/thread is deleted and we don't have permission to
		continue;
	}

	$tmp["$item[forumid]"]["$item[starter]"][] = $item['itemid'];
}
unset($item);
$db->free_result($items);

if ($vbulletin->options['threadmarking'] AND $vbulletin->userinfo['userid'])
{
	// we need this for forum read times
	cache_ordered_forums(1);
}

foreach (array_keys($tmp) AS $forumid)
{
	$forum =& $vbulletin->forumcache["$forumid"];
	if (!$forum)
	{
		// we don't know anything about this forum
		DEVDEBUG('Removed unknown forum');
		unset($tmp["$forumid"]);
		continue;
	}

	$fperms = $vbulletin->userinfo['forumpermissions']["$forumid"];

	$items = vb_number_format(sizeof($tmp["$forumid"]['self']) + sizeof($tmp["$forumid"]['other']));

	// check CANVIEW / CANSEARCH permission and forum password for current forum
	if (
		!($fperms & $vbulletin->bf_ugp_forumpermissions['canview'])
		OR !($fperms & $vbulletin->bf_ugp_forumpermissions['cansearch'])
		OR !verify_forum_password($forumid, $forum['password'], false)
	)
	{
		// cannot view / search this forum, or does not have forum password
		unset($tmp["$forumid"]);
	}
	else if (!($fperms & $vbulletin->bf_ugp_forumpermissions['canviewthreads']) AND ($search['showposts'] OR ($display['options']['action'] != 'getnew' AND $display['options']['action'] != 'getdaily' AND !$search['titleonly'])))
	{
		unset($tmp["$forumid"]);
	}
	else
	{
		if ($vbulletin->options['threadmarking'] AND $vbulletin->userinfo['userid'])
		{
			$lastread["$forumid"] = max($forum['forumread'], (TIMENOW - ($vbulletin->options['markinglimit'] * 86400)));
		}
		else
		{
			$forumview = intval(fetch_bbarray_cookie('forum_view', $forumid));

			//use which one produces the highest value, most likely cookie
			$lastread["$forumid"] = ($forumview > $vbulletin->userinfo['lastvisit'] ? $forumview : $vbulletin->userinfo['lastvisit']);
		}

		// check CANVIEWOTHERS permission
		if (!($fperms & $vbulletin->bf_ugp_forumpermissions['canviewothers']))
		{
			// cannot view others' threads
			unset($tmp["$forumid"]['other']);
		}
	}

	$items = vb_number_format(sizeof($tmp["$forumid"]['self']) + sizeof($tmp["$forumid"]['other']));
}

// now get all threadids that still remain...
$remaining = array();
$i = 1;
foreach ($tmp AS $A)
{
	foreach ($A AS $B)
	{
		foreach ($B AS $itemid)
		{
			$remaining["$itemid"] = $itemid;
		}
	}
}
unset($tmp, $A, $B);

// remove all ids from $orderedids that do not exist in $remaining
$orderedids = array_intersect($orderedids, $remaining);
unset($remaining);

// rebuild the $orderedids array so keys go from 0 to n with no gaps
$orderedids = array_merge($orderedids, array());

// count the number of items
$numitems = sizeof($orderedids);

if ($numitems == 0) {
	//eval(standard_error(fetch_error('searchnoresults', false), '', false));
} else if ($numitems > 0) {
	$show['results'] = true;
}

// extra check to prevent DB error if someone sets it at 0
if ($vbulletin->options['searchperpage'] < 1)
{
	$vbulletin->options['searchperpage'] = 20;
}

// trim results down to maximum $vbulletin->options[maxresults]
/*if ($vbulletin->options['maxresults'] > 0 AND $numitems > $vbulletin->options['maxresults'])
{
	$clippedids = array();
	for ($i = 0; $i < $vbulletin->options['maxresults']; $i++)
	{
		$clippedids[] = $orderedids["$i"];
	}
	$orderedids =& $clippedids;
	$numitems = $vbulletin->options['maxresults'];
}*/

// #############################################################################
// #############################################################################

// get page split...
sanitize_pageresults($numitems, $vbulletin->GPC['pagenumber'], $results_per_page, 200, $vbulletin->options['searchperpage']);

// get list of thread to display on this page
$startat = ($vbulletin->GPC['pagenumber'] - 1) * $results_per_page;
$endat = $startat + $results_per_page;
$itemids = array();
for ($i = $startat; $i < $endat; $i++)
{
	if (isset($orderedids["$i"]))
	{
		$itemids["$orderedids[$i]"] = true;
	}
}

// #############################################################################
// do data query
if (!empty($itemids))
{
	$ids = implode(', ', array_keys($itemids));
	$dataQuery .= '(' . $ids . ')';
	$items = $db->query_read_slave($dataQuery);
	$itemidname = 'postid';

	$dotthreads = fetch_dot_threads_array($ids);
}

if (!empty($itemids))
{
	$managepost = $approvepost = $managethread = $approveattachment = $movethread = $deletethread = $approvethread = $openthread = array();
	while ($item = $db->fetch_array($items))
	{
		if (can_moderate($item['forumid'], 'candeleteposts') OR can_moderate($item['forumid'], 'canremoveposts'))
		{
			$managepost["$item[postid]"] = 1;
			$show['managepost'] = true;
		}

		if (can_moderate($item['forumid'], 'canmoderateposts'))
		{
			$approvepost["$item[postid]"] = 1;
			$show['approvepost'] = true;
		}

		if (can_moderate($item['forumid'], 'canmanagethreads'))
		{
			$managethread["$item[postid]"] = 1;
			$show['managethread'] = true;
		}

		if (can_moderate($item['forumid'], 'canmoderateattachments') AND $item['attach'])
		{
			$approveattachment["$item[postid]"] = 1;
			$show['approveattachment'] = true;
		}

		$item['forumtitle'] = $vbulletin->forumcache["$item[forumid]"]['title'];
		$itemids["$item[$itemidname]"] = $item;
	}
	unset($item, $dataQuery);
	$db->free_result($items);
}
// #############################################################################

if (!empty($managepost) OR !empty($approvepost) OR !empty($managethread) OR !empty($approveattachment) OR !empty($movethread) OR !empty($deletethread) OR !empty($approvethread) OR !empty($openthread))
{
	$show['inlinemod'] = false;
	$show['spamctrls'] = ($show['deletethread'] OR $show['managepost']);
	$url = SCRIPTPATH;
}
else
{
	$show['inlinemod'] = false;
	$url = '';
}

$threadcolspan = 7;
$announcecolspan = 6;

if ($show['inlinemod'])
{
	$threadcolspan++;
	$announcecolspan++;
}
if (!$show['threadicons'])
{
	$threadcolspan--;
	$announcecolspan--;
}

$highlightwords = '';
$searchbits = '';
$itemcount = $startat;
$first = $itemcount + 1;

// initialize variable for inlinemod popup
$threadadmin_imod_menu = '';
$oldposts = false;

// #############################################################################
// show results as threads (although they are post)
$show['forumlink'] = true;

// threadbit_deleted conditionals
$show['threadtitle'] = true;
$show['viewthread'] = true;
$show['managethread'] = true;

foreach ($itemids AS $thread)
{

	$thread['dev_userid'] = $thread['userid'];
	$thread['dev_lastposter'] = $thread['username'];
	$thread['dev_postid'] = $thread['postid'];
	
	// get info from thread
	$thread = process_thread_array($thread, $lastread["$thread[forumid]"]);
	
	// Inline Moderation
	$show['disabled'] = ($movethread["$thread[threadid]"] OR $deletethread["$thread[threadid]"] OR $approvethread["$thread[threadid]"] OR $openthread["$thread[threadid]"]) ? false : true;

	$itemcount++;
	exec_switch_bg();
	
	$forumperms = fetch_permissions($thread['forumid']);
	if ($thread['visible'] == 2)
	{
		$thread['deletedcount']++;
		$show['deletereason'] = (!empty($thread['del_reason'])) ?  true : false;
		$show['moderated'] = ($thread['hiddencount'] > 0 AND can_moderate($thread['forumid'], 'canmoderateposts')) ? true : false;
		$show['deletedthread'] = (can_moderate($thread['forumid']) OR $forumperms & $vbulletin->bf_ugp_forumpermissions['canseedelnotice']) ? true : false;
//		eval('$searchbits .= "' . fetch_template('threadbit_deleted') . '";');
	}
	else
	{
		if (!$thread['visible'])
		{
			$thread['hiddencount']++;
		}
		$show['moderated'] = ($thread['hiddencount'] > 0 AND can_moderate($thread['forumid'], 'canmoderateposts')) ? true : false;
		$show['deletedthread'] = ($thread['deletedcount'] > 0 AND (can_moderate($thread['forumid']) OR $forumperms & $vbulletin->bf_ugp_forumpermissions['canseedelnotice'])) ? true : false;
		eval('$searchbits .= "' . fetch_template('devtracker_threadbit') . '";');
	}
}

if ($show['popups'] AND $show['inlinemod'])
{
	eval('$threadadmin_imod_menu = "' . fetch_template('threadadmin_imod_menu_post') . '";');
}

$last = $itemcount;

$pagenav = construct_page_nav($vbulletin->GPC['pagenumber'], $results_per_page, $numitems, 'devtracker.php?' . $vbulletin->session->vars['sessionurl'] . 'devgroup=' . urlencode($_REQUEST['devgroup']));

// select the correct part of the forum jump menu
$frmjmpsel['search'] = 'class="fjsel" selected="selected"';
construct_forum_jump();

$show['titleonlysearch'] = true;

// #############################################################################
// finish off the page

if ($templatename != '')
{
	$navbits = construct_navbits($navbits);

	eval('$navbar = "' . fetch_template('navbar') . '";');
	eval('print_output("' . fetch_template($templatename) . '");');
}

?>