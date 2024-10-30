<?php
/*
Plugin Name: Last.FM Widgets
Plugin URI: http://canalplan.blogdns.com/steve/lastfm-widgets
Version: 1.8
Description: Allows users to display various Last.FM Widgets in the sidebars of their blogs
Author: Steve Atty
Author URI: http://www.tty.org.uk
*/

/*
 * This file is part of Last.FM Widgets a plugin for Word Press
 * Copyright (C) 2008 Steve Atty
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */


// Get the current settings or setup some defaults if needed
if (!$current_settings = get_option('lastfm_options')){
	$lastfm_options['lastfm_user'] = 'YourNameHere';
	$lastfm_options['lastfm_colour'] = 'grey';
	$lastfm_options['lastfm_size'] = '405';
	$lastfm_options['lastfm_artist'] = 'Artist Name Here';
	$lastfm_options['lastfm_genre'] = 'Genre Here';
	$lastfm_options['lastfm_friends'] = 'No';
	update_option('lastfm_options', $lastfm_options);
}


function lastfm_options_page() {
	$current_settings = get_option('lastfm_options');
	if ($_POST['action']){?>
		<div class="updated"><p><strong>Options saved.</strong></p></div>
 	<?php } ?>
    <div class="wrap" id="last.fm-options">
		<h2>Last.FM Options</h2>
		<form method="post" action="options-general.php?page=lastfm.php">
			<input type="hidden" name="action" value="save_options" />
			<fieldset class="options">
				<table>
					<tr>
						<td>Last.FM User Name : </td><td> <input type="text" name="lastfm_user" size="30" value="<?php echo $current_settings['lastfm_user']; ?>" /></td>
						</tr><tr><td> Widget colour: </td><td>
							<select name="lastfm_colour">
							<option value="red" <?php if ($current_settings['lastfm_colour'] == 'red') echo 'selected="selected"'; ?>>Red</option>
							<option value="blue" <?php if ($current_settings['lastfm_colour'] == 'blue') echo 'selected="selected"'; ?>>Blue</option>
							<option value="black" <?php if ($current_settings['lastfm_colour'] == 'black') echo 'selected="selected"'; ?>>Black</option>
							<option value="grey" <?php if ($current_settings['lastfm_colour'] == 'grey') echo 'selected="selected"'; ?>>Grey</option>
							</select>
						</td>
				    </tr><tr><td> Quilt Size </td><td>
						<select name="lastfm_size">
						  <option value="540" <?php if ($current_settings['lastfm_size'] == '540') echo 'selected="selected"'; ?>>Large</option>
						  <option value="405" <?php if ($current_settings['lastfm_size'] == '405') echo 'selected="selected"'; ?>>Medium</option>
						<option value="270" <?php if ($current_settings['lastfm_size'] == '270') echo 'selected="selected"'; ?>>Small</option>
						</select>
				    </td>
					</tr>
				    </tr><tr><td> Include Friends Listening Now? </td><td>
						<select name="lastfm_friends">
						  <option value="No" <?php if ($current_settings['lastfm_friends'] == 'No') echo 'selected="selected"'; ?>>No</option>
						  <option value="Yes" <?php if ($current_settings['lastfm_friends'] == 'Yes') echo 'selected="selected"'; ?>>Yes</option>
						</select>
				    </td>
					</tr>
					<tr>
						<td>Last.FM Radio Artist : </td><td> <input type="text" name="lastfm_artist" size="30" value="<?php echo $current_settings['lastfm_artist']; ?>" /></td>
						</tr>
					<tr>
						<td>Last.FM Radio Genre: </td><td> <input type="text" name="lastfm_genre" size="30" value="<?php echo $current_settings['lastfm_genre']; ?>" /></td>
						</tr>
				</table>
			<p class="submit"><input type="submit" name="Submit" value="Update Options &raquo;" /></p>
		</form>
	</div>
<?php
}

function lastfm_add_options() {
	// Add a new menu under Options:
	add_options_page('Last FM', 'Last FM', 8, __FILE__, 'lastfm_options_page');
}

function lastfm_save_options() {
	$lastfm_options['lastfm_user'] = $_POST['lastfm_user'];
	$lastfm_options['lastfm_colour'] = $_POST['lastfm_colour'];
	$lastfm_options['lastfm_size'] = $_POST['lastfm_size'];
	$lastfm_options['lastfm_artist'] = $_POST['lastfm_artist'];
	$lastfm_options['lastfm_genre'] = $_POST['lastfm_genre'];
	$lastfm_options['lastfm_friends'] = $_POST['lastfm_friends'];
	update_option('lastfm_options', $lastfm_options);
}

function create_lastfm_object($list_type)
{
	$current_settings = get_option('lastfm_options');
$lastfmcode= <<< EOGS
<p><br>
	<style type="text/css">table.lfmWidget788a7c8aRAND td {margin:0 !important;padding:0 !important;border:0 !important;}table.lfmWidget788a7c8aRAND tr.lfmHead a:hover {background:url(http://cdn.last.fm/widgets/images/en/header/chart/charttype_regular_selectedcolour.png) no-repeat 0 0 !important;}table.lfmWidget788a7c8aRAND tr.lfmEmbed object {float:left;}table.lfmWidget788a7c8aRAND tr.lfmFoot td.lfmConfig a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour.png) no-repeat 0px 0 !important;;}table.lfmWidget788a7c8aRAND tr.lfmFoot td.lfmView a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour.png) no-repeat -85px 0 !important;}table.lfmWidget788a7c8aRAND tr.lfmFoot td.lfmPopup a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour.png) no-repeat -159px 0 !important;}</style>
	<table class="lfmWidget788a7c8aRAND" cellpadding="0" cellspacing="0" border="0" ><tr class="lfmHead"><td><a title="lastfmusername: chartlinktext" href="chartlinkurl" target="_blank" style="display:block;overflow:hidden;height:20px;background:url(http://cdn.last.fm/widgets/images/en/header/chart/charttype_regular_selectedcolour.png) no-repeat 0 -20px;text-decoration:none;border:0;"></a></td></tr><tr class="lfmEmbed"><td>
	<object type="application/x-shockwave-flash" data="http://cdn.last.fm/widgets/chart/lfmchartftype.swf" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" height="chartheight" width=100% >
	<param name="movie" value="http://cdn.last.fm/widgets/chart/lfmchartftype.swf" /> <param name="WMODE" value="Transparent" /> <param name="flashvars" value="type=chartxtype&amp;user=lastfmusername&amp;theme=selectedcolour&amp;lang=en&amp;widget_id=788a7c8aRAND" /> <param name="quality" value="high" /> <param name="allowScriptAccess" value="always" /> <param name="allowNetworking" value="all" /> </object></td></tr><tr class="lfmFoot"><td style="background:url(http://cdn.last.fm/widgets/images/footer_bg/selectedcolour.png) repeat-x 0 0;text-align:left;"><table cellspacing="0" cellpadding="0" border="0" ><tr><td class="lfmConfig"><a href="http://www.last.fm/widgets/?url=user%2Flastfmusername%2Fpersonal&amp;colour=selectedcolour&amp;quiltType=album&amp;orient=vertical&amp;height=large&amp;from=code&amp;widget=quilt" title="Get your own widget" target="_blank" style="display:block;overflow:hidden;width:85px;height:20px;float:left;background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour.png) no-repeat 0px -20px;text-decoration:none;border:0;"></a></td><td class="lfmView" style="width:74px;"><a href="http://www.last.fm/user/lastfmusername/" title="View lastfmusername's profile" target="_blank" style="display:block;overflow:hidden;width:74px;height:20px;background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour.png) no-repeat -85px -20px;text-decoration:none;border:0;"></a></td><td 	class="lfmPopup"style="width:25px;background:url(http://cdn.last.fm/widgets/images/footer_bg/selectedcolour.png) repeat-x 0 0;" ></td></tr></table></td></tr></table>
EOGS;


$chartheight=179;
$charttypef="19";

	switch($list_type){
		case "recenttracks":
			$chartlinkurl="http://www.last.fm/user/lastfmusername/";
			$chartlinktext="Recently Listened Tracks";
			$chart_type=$list_type;
			if ($current_settings['lastfm_friends']=='Yes') {$charttypef='friends_6';}
		break;
		case "toptracks":
			$chartlinkurl="http://www.last.fm/user/lastfmusername/charts/?charttype=overall&subtype=track";
			$chartlinktext="Overall Top Tracks";
			$chart_type=$list_type;
			$chartheight=160;
		break;
		case "topartists":
			$chartlinkurl="http://www.last.fm/user/lastfmusername/charts/?charttype=overall&subtype=artist";
			$chartlinktext="Overall Top Artists";
			$chart_type=$list_type;
		break;
		case "weeklytracks":
			$chartlinkurl="http://www.last.fm/user/lastfmusername/charts/?charttype=weekly&subtype=track";
			$chartlinktext="Weekly Top Tracks";
			$chart_type="weeklytrackchart";
			$chartheight=160;
		break;
		case "weeklyartists":
			$chartlinkurl="http://www.last.fm/user/lastfmusername/charts/?charttype=weekly&subtype=artist";
			$chartlinktext="Weekly Top Artists";
			$chart_type="weeklyartistchart";
		break;

}

	$lastfmcode=str_replace ( "charttype", $list_type, $lastfmcode );
	$lastfmcode=str_replace ( "chartheight", $chartheight, $lastfmcode );
	$lastfmcode=str_replace ( "chartxtype", $chart_type, $lastfmcode );
	$lastfmcode=str_replace ( "chartlinktext", $chartlinktext, $lastfmcode );
	$lastfmcode=str_replace ( "chartlinkurl", $chartlinkurl, $lastfmcode );
	$lastfmcode=str_replace ( "lfmchartftype", $charttypef, $lastfmcode );
	$lastfmcode=str_replace ( "lastfmusername", $current_settings['lastfm_user'], $lastfmcode );
	$lastfmcode=str_replace ( "selectedcolour", $current_settings['lastfm_colour'], $lastfmcode );
	$lastfmcode=str_replace ( "c8aRAND", $chart_type, $lastfmcode );
	return $lastfmcode;
}


function widget_lastfm_init() {
	if ( !function_exists('register_sidebar_widget') )
		return;

function widget_lastfm_recent($args) {
	extract($args);
	$current_settings = get_option('lastfm_options');
   $title="Recent Tracks";
  # echo $before_title . $title .$after_title;
	echo create_lastfm_object('recenttracks');
   echo $after_widget;
}

function widget_lastfm_toptracks($args) {
	extract($args);
	$current_settings = get_option('lastfm_options');
	echo create_lastfm_object('toptracks');
	echo $after_widget;
}


function widget_lastfm_topartists($args) {
	extract($args);
	$current_settings = get_option('lastfm_options');
	echo create_lastfm_object('topartists');
 	echo $after_widget;
}

function widget_lastfm_weeklytrack($args) {
	extract($args);
	$current_settings = get_option('lastfm_options');
	echo create_lastfm_object('weeklytracks');
 	echo $after_widget;
}

function widget_lastfm_weeklyartist($args) {
	extract($args);
	$current_settings = get_option('lastfm_options');
	echo create_lastfm_object('weeklyartists');
 	echo $after_widget;
}

function widget_lastfm_albumquilt($args) {
	extract($args);
	$current_settings = get_option('lastfm_options');
   $lastfmcode= <<< EOGS
   <p><br>
   <style type="text/css">table.lfmWidget44365cRAND td {margin:0 !important;padding:0 !important;border:0 !important;}table.lfmWidget44365cRAND  tr.lfmHead a:hover {background:url(http://cdn.last.fm/widgets/images/en/header/quilt/album_vertical_selectedcolour.png) no-repeat 0 0 !important;}table.lfmWidget44365cRAND  tr.lfmEmbed object {float:left;}table.lfmWidget44365c921e tr.lfmFoot td.lfmConfig a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour.png) no-repeat 0px 0 !important;;}table.lfmWidget44365cRAND tr.lfmFoot td.lfmView a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour.png) no-repeat -85px 0 !important;}table.lfmWidget44365cRAND tr.lfmFoot td.lfmPopup a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour.png) no-repeat -159px 0 !important;}</style>
   <table class="lfmWidget44365cRAND " cellpadding="0" cellspacing="0" border="0" ><tr class="lfmHead"><td><a title="Top albums" href="http://www.last.fm/user/lastfmusername/charts/" target="_blank" style="display:block;overflow:hidden;height:20px;width:100%;background:url(http://cdn.last.fm/widgets/images/en/header/quilt/album_vertical_selectedcolour.png) no-repeat 0 -20px;text-decoration:none;border:0;"></a></td></tr><tr class="lfmEmbed"><td><object type="application/x-shockwave-flash" data="http://cdn.last.fm/widgets/quilt/13.swf" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width=100% height="lastfm_size" > <param name="movie" value="http://cdn.last.fm/widgets/quilt/13.swf" /> <param name="WMODE" value="Transparent" /> <param name="flashvars" value="type=user&amp;variable=lastfmusername&amp;file=topalbums&amp;bgColor=selectedcolour&amp;theme=selectedcolour&amp;lang=en&amp;widget_id=44365cRAND" /> <param name="quality" value="high" /> <param name="allowScriptAccess" value="always" /> <param name="allowNetworking" value="all" /> </object></td></tr><tr class="lfmFoot"><td style="background:url(http://cdn.last.fm/widgets/images/footer_bg/selectedcolour.png) repeat-x 0 0;text-align:left;"><table cellspacing="0" cellpadding="0" border="0" ><tr><td class="lfmConfig"><a href="http://www.last.fm/widgets/?url=user%2Flastfmusername%2Fpersonal&amp;colour=selectedcolour&amp;quiltType=album&amp;orient=vertical&amp;height=large&amp;from=code&amp;widget=quilt" title="Get your own widget" target="_blank" style="display:block;overflow:hidden;width:85px;height:20px;float:left;background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour.png) no-repeat 0px -20px;text-decoration:none;border:0;"></a></td><td class="lfmView" style="width:74px;"><a href="http://www.last.fm/user/lastfmusername/" title="View lastfmusername's profile" target="_blank" style="display:block;overflow:hidden;width:74px;height:20px;background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour.png) no-repeat -85px -20px;text-decoration:none;border:0;"></a></td><td class="lfmPopup" style="width:25px;" ></td></tr></table></td></tr></table>
EOGS;
   $lastfmcode=str_replace ( "cRAND", "albquilt", $lastfmcode );
   $lastfmcode=str_replace ( "lastfmusername", $current_settings['lastfm_user'], $lastfmcode );
   $lastfmcode=str_replace ( "selectedcolour", $current_settings['lastfm_colour'], $lastfmcode );
   $lastfmcode=str_replace ( "lastfm_size", $current_settings['lastfm_size'], $lastfmcode );
	echo $lastfmcode;
 	echo $after_widget;
}

function widget_lastfm_artistquilt($args) {
	extract($args);
	$current_settings = get_option('lastfm_options');
$lastfmcode= <<< EOGS
<p><br>
<style type="text/css">table.lfmWidgetff9eeRAND td {margin:0 !important;padding:0 !important;border:0 !important;}table.lfmWidgetff9eeRAND tr.lfmHead a:hover {background:url(http://cdn.last.fm/widgets/images/en/header/quilt/artist_vertical_selectedcolour.png) no-repeat 0 0 !important;}table.lfmWidgetff9eeRAND tr.lfmEmbed object {float:left;}table.lfmWidgetff9eeRAND tr.lfmFoot td.lfmConfig a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour.png) no-repeat 0px 0 !important;;}table.lfmWidgetff9eeRAND tr.lfmFoot td.lfmView a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour.png) no-repeat -85px 0 !important;}table.lfmWidgetff9eeRAND tr.lfmFoot td.lfmPopup a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour.png) no-repeat -159px 0 !important;}</style>
<table class="lfmWidgetff9eeRAND" cellpadding="0" cellspacing="0" border="0" ><tr class="lfmHead"><td><a title="Top artists" href="http://www.last.fm/user/lastfmusername/charts/" target="_blank" style="display:block;overflow:hidden;height:20px;width:100%;background:url(http://cdn.last.fm/widgets/images/en/header/quilt/artist_vertical_selectedcolour.png) no-repeat 0 -20px;text-decoration:none;border:0;"></a></td></tr><tr class="lfmEmbed"><td><object type="application/x-shockwave-flash" data="http://cdn.last.fm/widgets/quilt/13.swf" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width=100% height="lastfm_size" > <param name="movie" value="http://cdn.last.fm/widgets/quilt/13.swf" /><param name="WMODE" value="Transparent" /> <param name="flashvars" value="type=user&amp;variable=lastfmusername&amp;file=topartists&amp;bgColor=selectedcolour&amp;theme=selectedcolour&amp;lang=en&amp;widget_id=ff9eeRAND" />  <param name="quality" value="high" /> <param name="allowScriptAccess" value="always" /> <param name="allowNetworking" value="all" /> </object></td></tr><tr class="lfmFoot"><td style="background:url(http://cdn.last.fm/widgets/images/footer_bg/selectedcolour.png) repeat-x 0 0;text-align:left;"><table cellspacing="0" cellpadding="0" border="0" ><tr><td class="lfmConfig"><a href="http://www.last.fm/widgets/?url=user%2Flastfmusername%2Fpersonal&amp;colour=selectedcolour&amp;quiltType=artist&amp;orient=vertical&amp;height=small&amp;from=code&amp;widget=quilt" title="Get your own widget" target="_blank" style="display:block;overflow:hidden;width:85px;height:20px;float:left;background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour.png) no-repeat 0px -20px;text-decoration:none;border:0;"></a></td><td class="lfmView" style="width:74px;"><a href="http://www.last.fm/user/lastfmusername/" title="View lastfmusername's profile" target="_blank" style="display:block;overflow:hidden;width:74px;height:20px;background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour.png) no-repeat -85px -20px;text-decoration:none;border:0;"></a></td><td class="lfmPopup"style="width:25px;"></td></tr></table></td></tr></table>
EOGS;


$lastfmcode=str_replace ( "eRAND", "artquilt", $lastfmcode );
$lastfmcode=str_replace ( "lastfmusername", $current_settings['lastfm_user'], $lastfmcode );
$lastfmcode=str_replace ( "selectedcolour", $current_settings['lastfm_colour'], $lastfmcode );
$lastfmcode=str_replace ( "lastfm_size", $current_settings['lastfm_size'], $lastfmcode );
	echo $lastfmcode;
 	echo $after_widget;
}

function widget_lastfm_artistradio($args) {
	extract($args);
	$current_settings = get_option('lastfm_options');
$lastfmcode= <<< EOGS
<p><br>
<style type="text/css">table.lfmWidget4dabc26d2e5b8d4407a723f9cd9c4e7b td {margin:0 !important;padding:0 !important;border:0 !important;}table.lfmWidget4dabc26d2e5b8d4407a723f9cd9c4e7b tr.lfmHead a:hover {background:url(http://cdn.last.fm/widgets/images/en/header/radio/regular_selectedcolour.png) no-repeat 0 0 !important;}table.lfmWidget4dabc26d2e5b8d4407a723f9cd9c4e7b tr.lfmEmbed object {float:left;}table.lfmWidget4dabc26d2e5b8d4407a723f9cd9c4e7b tr.lfmFoot td.lfmConfig a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour_np.png) no-repeat 0px 0 !important;;}table.lfmWidget4dabc26d2e5b8d4407a723f9cd9c4e7b tr.lfmFoot td.lfmView a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour_np.png) no-repeat -85px 0 !important;}table.lfmWidget4dabc26d2e5b8d4407a723f9cd9c4e7b tr.lfmFoot td.lfmPopup a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour_np.png) no-repeat -159px 0 !important;}</style>
<table class="lfmWidget4dabc26d2e5b8d4407a723f9cd9c4e7b" cellpadding="0" cellspacing="0" border="0"><tr class="lfmHead"><td><a title="Music like selectedartist" href="http://www.last.fm/listen/artist/selectedartist/similarartists" target="_blank" style="display:block;overflow:hidden;height:20px;width:100%;background:url(http://cdn.last.fm/widgets/images/en/header/radio/regular_selectedcolour.png) no-repeat 0 -20px;text-decoration:none;border:0;"></a></td></tr><tr class="lfmEmbed"><td><object type="application/x-shockwave-flash" data="http://cdn.last.fm/widgets/radio/19.swf" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width=100% height="140" > <param name="WMODE" value="Transparent" /> <param name="movie" value="http://cdn.last.fm/widgets/radio/19.swf" /> <param name="flashvars" value="lfmMode=radio&amp;radioURL=artist%2Fselectedartist%2Fsimilarartists&amp;title=Music+like+selectedartist&amp;theme=selectedcolour&amp;autostart=&amp;lang=en&amp;widget_id=4dabc26d2e5b8d4407a723f9cd9c4e7b" /> <param name="quality" value="high" /> <param name="allowScriptAccess" value="always" /> <param name="allowNetworking" value="all" /> </object></td></tr><tr class="lfmFoot"><td style="background:url(http://cdn.last.fm/widgets/images/footer_bg/selectedcolour.png) repeat-x 0 0;text-align:left;"><table cellspacing="0" cellpadding="0" border="0" ><tr><td class="lfmPopup"style="width:20px;"><a href="http://www.last.fm/widgets/popup/?url=artist%2Fselectedartist%2Fsimilarartists&amp;colour=selectedcolour&amp;size=regular&amp;autostart=&amp;from=code&amp;widget=radio&amp;path=wordpress&amp;resize=1" title="Load this radio in a pop up" target="_blank" style="display:block;overflow:hidden;width:25px;height:20px;background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour_np.png) no-repeat -159px -20px;text-decoration:none;border:0;" onclick="window.open(this.href + '&amp;resize=0','lfm_popup','height=240,width=234,resizable=yes,scrollbars=yes'); return false;"></a></td><td class="lfmConfig"><a href="http://www.last.fm/widgets/?url=artist%2Fselectedartist%2Fsimilarartists&amp;colour=selectedcolour&amp;size=regular&amp;autostart=&amp;from=code&amp;widget=radio&amp;path=wordpress" title="Get your own widget" target="_blank" style="display:block;overflow:hidden;width:64px;height:20px;float:left;background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour_np.png) no-repeat 0px -20px;text-decoration:none;border:0;"></a></td><td class="lfmView" style="width:64px;"><a href="http://www.last.fm/" title="Visit Last.fm" target="_blank" style="display:block;overflow:hidden;width:64px;height:20px;background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour_np.png) no-repeat -85px -20px;text-decoration:none;border:0;"></a></td></tr></table></td></tr></table>
EOGS;
$lastfmcode=str_replace ( "selectedcolour", $current_settings['lastfm_colour'], $lastfmcode );
$lastfmcode=str_replace ( "selectedartist", $current_settings['lastfm_artist'], $lastfmcode );
	echo $lastfmcode;
 	echo $after_widget;
}

function widget_lastfm_genreradio($args) {
	extract($args);
	$current_settings = get_option('lastfm_options');
$lastfmcode= <<< EOGS
<p><br>
<style type="text/css">table.lfmWidget4dabc26d2e5b8d4407a723f4dabc2dfd td {margin:0 !important;padding:0 !important;border:0 !important;}table.lfmWidget4dabc26d2e5b8d4407a723f4dabc2dfd tr.lfmHead a:hover {background:url(http://cdn.last.fm/widgets/images/en/header/radio/regular_selectedcolour.png) no-repeat 0 0 !important;}table.lfmWidget4dabc26d2e5b8d4407a723f4dabc2dfd tr.lfmEmbed object {float:left;}table.lfmWidget4dabc26d2e5b8d4407a723f4dabc2dfd tr.lfmFoot td.lfmConfig a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour_np.png) no-repeat 0px 0 !important;;}table.lfmWidget4dabc26d2e5b8d4407a723f4dabc2dfd tr.lfmFoot td.lfmView a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour_np.png) no-repeat -85px 0 !important;}table.lfmWidget4dabc26d2e5b8d4407a723f4dabc2dfd tr.lfmFoot td.lfmPopup a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour_np.png) no-repeat -159px 0 !important;}</style>
<table class="lfmWidget4dabc26d2e5b8d4407a723f4dabc2dfd" cellpadding="0" cellspacing="0" border="0"><tr class="lfmHead"><td><a title="Music tagged metal " href="http://www.last.fm/listen/globaltags/selectedgenre" target="_blank" style="display:block;overflow:hidden;height:20px;width:100%;background:url(http://cdn.last.fm/widgets/images/en/header/radio/regular_selectedcolour.png) no-repeat 0 -20px;text-decoration:none;border:0;"></a></td></tr><tr class="lfmEmbed"><td> <object type="application/x-shockwave-flash" data="http://cdn.last.fm/widgets/radio/19.swf" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width=100% height="140" > <param name="WMODE" value="Transparent" /> <param name="movie" value="http://cdn.last.fm/widgets/radio/19.swf" /> <param name="flashvars" value="lfmMode=radio&amp;radioURL=globaltags%2Fselectedgenre&amp;title=Music+tagged+selectedgenre+&amp;theme=selectedcolour&amp;autostart=&amp;lang=en&amp;widget_id=4dabc26d2e5b8d4407a723f4dabc2dfd" /> <param name="quality" value="high" /> <param name="allowScriptAccess" value="always" /> <param name="allowNetworking" value="all" /> </object></td></tr><tr class="lfmFoot"><td style="background:url(http://cdn.last.fm/widgets/images/footer_bg/selectedcolour.png) repeat-x 0 0;text-align:left;"><table cellspacing="0" cellpadding="0" border="0" ><tr><td class="lfmPopup"style="width:20px;"><a href="http://www.last.fm/widgets/popup/?url=globaltags%2Fselectedgenre&amp;colour=selectedcolour&amp;size=regular&amp;autostart=&amp;from=code&amp;widget=radio&amp;path=wordpress&amp;resize=1" title="Load this radio in a pop up" target="_blank" style="display:block;overflow:hidden;width:25px;height:20px;background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour_np.png) no-repeat -159px -20px;text-decoration:none;border:0;" onclick="window.open(this.href + '&amp;resize=0','lfm_popup','height=240,width=234,resizable=yes,scrollbars=yes'); return false;"></a></td><td class="lfmConfig"><a href="http://www.last.fm/widgets/?url=globaltags%2Fselectedgenre&amp;colour=selectedcolour&amp;size=regular&amp;autostart=&amp;from=code&amp;widget=radio&amp;path=wordpress"  title="Get your own widget" target="_blank" style="display:block;overflow:hidden;width:64px;height:20px;float:left;background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour_np.png) no-repeat 0px -20px;text-decoration:none;border:0;"></a></td><td class="lfmView" style="width:64px;"><a href="http://www.last.fm/" title="Visit Last.fm" target="_blank" style="display:block;overflow:hidden;width:64px;height:20px;background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour_np.png) no-repeat -85px -20px;text-decoration:none;border:0;"></a></td></tr></table></td></tr></table>
EOGS;
$lastfmcode=str_replace ( "selectedcolour", $current_settings['lastfm_colour'], $lastfmcode );
$lastfmcode=str_replace ( "selectedgenre", $current_settings['lastfm_genre'], $lastfmcode );
	echo $lastfmcode;
 	echo $after_widget;
}
function widget_lastfm_playlist($args) {
	extract($args);
	$current_settings = get_option('lastfm_options');
$lastfmcode= <<< EOGS
<p><br>
<style type="text/css">table.lfmWidget4dabc26d2e5b8d4407a723f4dabc2dfd td {margin:0 !important;padding:0 !important;border:0 !important;}table.lfmWidget4dabc26d2e5b8d4407a723f4dabc2dfd tr.lfmHead a:hover {background:url(http://cdn.last.fm/widgets/images/en/header/playlist/regular_selectedcolour.png) no-repeat 0 0 !important;}table.lfmWidget4dabc26d2e5b8d4407a723f4dabc2dfd tr.lfmEmbed object {float:left;}table.lfmWidget4dabc26d2e5b8d4407a723f4dabc2dfd tr.lfmFoot td.lfmConfig a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour_np.png) no-repeat 0px 0 !important;;}table.lfmWidget4dabc26d2e5b8d4407a723f4dabc2dfd tr.lfmFoot td.lfmView a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour_np.png) no-repeat -85px 0 !important;}table.lfmWidget4dabc26d2e5b8d4407a723f4dabc2dfd tr.lfmFoot td.lfmPopup a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour_np.png) no-repeat -159px 0 !important;}</style>
<table class="lfmWidget4dabc26d2e5b8d4407a723f4dabc2dfd" cellpadding="0" cellspacing="0" border="0"><tr class="lfmHead"><td><a title="lastfmusername`s Playlist" href="http://www.last.fm/listen/user/lastfmusername/playlist" target="_blank" style="display:block;overflow:hidden;height:20px;width:100%;background:url(http://cdn.last.fm/widgets/images/en/header/playlist/regular_selectedcolour.png) no-repeat 0 -20px;text-decoration:none;border:0;"></a></td></tr><tr class="lfmEmbed"><td> <object type="application/x-shockwave-flash" data="http://cdn.last.fm/widgets/playlist/19.swf" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width=100% height="284" > <param name="movie" value="http://cdn.last.fm/widgets/playlist/19.swf" /> <param name="flashvars" value="lfmMode=playlist&amp;resourceType=37&amp;resourceID=1312186&amp;username=lastfmusername&amp;title=lastfmusername%E2%80%99s+Playlist&amp;theme=selectedcolour&amp;autostart=&amp;radioURL=user%2Flastfmusername%2Fplaylist&amp;lang=en&amp;widget_id=7a7d8a68bb2001fd96596bf855045eeb" /> <param name="quality" value="high" /> <param name="WMODE" value="Transparent"  <param name="allowScriptAccess" value="always" /> <param name="allowNetworking" value="all" /> </object></td></tr><tr class="lfmFoot"><td style="background:url(http://cdn.last.fm/widgets/images/footer_bg/selectedcolour.png) repeat-x 0 0;text-align:left;"><table cellspacing="0" cellpadding="0" border="0" ><tr><td class="lfmPopup"style="width:20px;"><a href="http://www.last.fm/widgets/popup/?colour=selectedcolour&amp;size=regular&amp;autostart=&amp;url=user%2Flastfmusername%2Fplaylist&amp;user=lastfmusername&amp;from=code&amp;widget=playlist&amp;path=wordpress&amp;resize=1" title="Load this playlist in a pop up" target="_blank" style="display:block;overflow:hidden;width:25px;height:20px;background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour_np.png) no-repeat -159px -20px;text-decoration:none;border:0;" onclick="window.open(this.href + '&amp;resize=0','lfm_popup','height=240,width=234,resizable=yes,scrollbars=yes'); return false;"></a></td><td class="lfmConfig"><a href="http://www.last.fm/widgets/?colour=selectedcolour&amp;size=regular&amp;autostart=&amp;url=user%2Flastfmusername%2Fplaylist&amp;user=lastfmusername&amp;from=code&amp;widget=playlist&amp;path=wordpress"  title="Get your own widget" target="_blank" style="display:block;overflow:hidden;width:64px;height:20px;float:left;background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour_np.png) no-repeat 0px -20px;text-decoration:none;border:0;"></a></td><td class="lfmView" style="width:64px;"><a href="http://www.last.fm/" title="Visit Last.fm" target="_blank" style="display:block;overflow:hidden;width:64px;height:20px;background:url(http://cdn.last.fm/widgets/images/en/footer/selectedcolour_np.png) no-repeat -85px -20px;text-decoration:none;border:0;"></a></td></tr></table></td></tr></table>
EOGS;
$lastfmcode=str_replace ( "lastfmusername", $current_settings['lastfm_user'], $lastfmcode );
$lastfmcode=str_replace ( "selectedcolour", $current_settings['lastfm_colour'], $lastfmcode );
$lastfmcode=str_replace ( "selectedartist", $current_settings['lastfm_artist'], $lastfmcode );
	echo $lastfmcode;
 	echo $after_widget;
 	}

	register_sidebar_widget(array('Last FM Recent', 'widgets'), 'widget_lastfm_recent');
	register_sidebar_widget(array('Last FM Top Tracks', 'widgets'), 'widget_lastfm_toptracks');
	register_sidebar_widget(array('Last FM Top Artists', 'widgets'), 'widget_lastfm_topartists');
	register_sidebar_widget(array('Last FM Weekly Top Tracks', 'widgets'), 'widget_lastfm_weeklytrack');
	register_sidebar_widget(array('Last FM Weekly Top Artists', 'widgets'), 'widget_lastfm_weeklyartist');
	register_sidebar_widget(array('Last FM Album Quilt', 'widgets'), 'widget_lastfm_albumquilt');
	register_sidebar_widget(array('Last FM Artist Quilt', 'widgets'), 'widget_lastfm_artistquilt');
	register_sidebar_widget(array('Last FM Artist Radio', 'widgets'), 'widget_lastfm_artistradio');
	register_sidebar_widget(array('Last FM Genre Radio', 'widgets'), 'widget_lastfm_genreradio');
	register_sidebar_widget(array('Last FM Play List', 'widgets'), 'widget_lastfm_playlist');
}

add_action('widgets_init', 'widget_lastfm_init');
add_action('admin_menu', 'lastfm_add_options'); 		// Insert the Admin panel.

if ($_POST['action'] == 'save_options'){
	lastfm_save_options();
}
?>
