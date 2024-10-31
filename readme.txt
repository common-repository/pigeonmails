=== Plugin Name ===
Plugin Name: Pigeonmails
Contributors: pigeonmails
Tags: email
Requires at least: 4.6
Tested up to: 4.7
Stable tag: 4.3
Requires PHP: 5.2.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Here is a short description of the plugin.  This should be no more than 150 characters.  No markup here.

== Description ==

This is the long description.  No limit, and you can use Markdown (as well as in the following sections).

For backwards compatibility, if this section is missing, the full length of the short description will be used, and
Markdown parsed.

A few notes about the sections above:

*   "Contributors" is a comma separated list of wordpress.org usernames
*   "Tags" is a comma separated list of tags that apply to the plugin
*   "Requires at least" is the lowest version that the plugin will work on
*   "Tested up to" is the highest version that you've *successfully used to test the plugin*. Note that it might work on
higher versions... this is just the highest one you've verified.
*   Stable tag should indicate the Subversion "tag" of the latest stable version, or "trunk," if you use `/trunk/` for
stable.

    Note that the `readme.txt` of the stable tag is the one that is considered the defining one for the plugin, so
if the `/trunk/readme.txt` file says that the stable tag is `4.3`, then it is `/tags/4.3/readme.txt` that'll be used
for displaying information about the plugin.  In this situation, the only thing considered from the trunk `readme.txt`
is the stable tag pointer.  Thus, if you develop in trunk, you can update the trunk `readme.txt` to reflect changes in
your in-development version, without having that information incorrectly disclosed about the current stable version
that lacks those changes -- as long as the trunk's `readme.txt` points to the correct stable tag.

    If no stable tag is provided, it is assumed that trunk is stable, but you should specify "trunk" if that's where
you put the stable version, in order to eliminate any doubt.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the Settings->Plugin Name screen to configure the plugin
1. (Make your instructions match the desired user flow for activating and installing your plugin. Include any steps that might be needed for explanatory purposes)

How to use :-

$data = wp_pigeonmails_mails($username,$password,$to,$fromname,$fromemail,$replyto, $subject, $message,$attachments)

$username - optional (default username will take from api details) (eg.demo)
$password - optional (default username will take from api details) (eg.demo)
$to - seperate by comma (eg. abc@gmail.com,abc2@gmail.com,abc3@gmail.com,abc4@gmail.com)
$fromname - optional (default fromname will take from api details) (eg. Noreply)
$fromemail - optional (default fromemail will take from api details) (eg. noreply@gmail.com)
$replyto - It is reply emailid (eg. replyonthisid@gmail.com)
$subject - email subject (eg. test subject)
$message - email body (eg. Dear Sir)
$attachments - optional field (file object)

eg.
$attachments = array(
	array(
		'filepath' => 'C:\Users\Public\Pictures\Sample\\test.pdf',
		'filename' => 'test.pdf'),
	array(
		'filepath' => 'C:\Users\Public\Pictures\Sample\\Hydrangeas.jpg',
		'filename' => 'Desert.jpg')		
);





