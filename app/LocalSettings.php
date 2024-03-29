<?php
# This file was automatically generated by the MediaWiki 1.31.1
# installer. If you make manual changes, please keep track in case you
# need to recreate them later.
#
# See includes/DefaultSettings.php for all configurable settings
# and their default values, but don't forget to make changes in _this_
# file, not there.
#
# Further documentation for configuration settings may be found at:
# https://www.mediawiki.org/wiki/Manual:Configuration_settings

# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

$wgSitename = "LiTHe Blås";
$wgMetaNamespace = "Meta";

# See https://www.mediawiki.org/wiki/Manual:Short_URL/Nginx as well as the
# nginx config file
$wgScriptPath = "/w";
$wgScriptExtension = ".php";
$wgArticlePath = "/$1";
$wgUsePathInfo = true;

## The protocol and server name to use in fully-qualified URLs
$wgServer = getenv("MW_BASE_URL");

## The URL path to static resources (images, scripts, etc.)
$wgResourceBasePath = $wgScriptPath;

## The URL path to the logo.  Make sure you change this from the default,
## or else you'll overwrite your logo when you upgrade!
$wgLogo = "$wgResourceBasePath/resources/assets/logo.svg";

$wgEmergencyContact = getenv("MW_EMAIL_ADDRESS");
$wgPasswordSender = getenv("MW_EMAIL_ADDRESS");
$wgEnableEmail = true;
$wgEnableUserEmail = true;
$wgEnotifUserTalk = true;
$wgEnotifWatchlist = true;
$wgEmailAuthentication = true;

## Database settings
$wgDBtype = "mysql";
$wgDBserver = getenv("MW_DB_HOST");
$wgDBname = getenv("MW_DB_NAME");
$wgDBuser = getenv("MW_DB_USER");
$wgDBpassword = getenv("MW_DB_PASSWORD");

# MySQL specific settings
$wgDBprefix = "";

# MySQL table options to use during installation or update
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";

## Shared memory settings
$wgMainCacheType = CACHE_ACCEL;
$wgMemCachedServers = [];

## File uploads
$wgEnableUploads = true;
$wgStrictFileExtensions = false;
$wgFileExtensions = array_merge(
  $wgFileExtensions,
  [
    "ai",  # Adobe Illustrator
    "eps",  # Encapsulated PostScript
    "m4a",  # MPEG-4 audio
    "mid",  # MIDI
    "mp3",
    "mp4",  # MPEG-4 audio
    "otf",  # OpenType font
    "pdf",
    "ps",  # PostScript
    "sib",  # Sibelius
    "svg",
    "ttf",  # TrueType font
    "ps",
  ]
);
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";

# InstantCommons allows wiki to use images from https://commons.wikimedia.org
$wgUseInstantCommons = false;

# Periodically send a pingback to https://www.mediawiki.org/ with basic data
# about this MediaWiki instance. The Wikimedia Foundation shares this data
# with MediaWiki developers to help guide future development efforts.
$wgPingback = true;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale
$wgShellLocale = "en_US.UTF-8";

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publically accessible from the web.
$wgCacheDirectory = "/tmp/mediawiki_cache";

# Site language code, should be one of the list in ./languages/data/Names.php
$wgLanguageCode = "sv";

$wgSecretKey = getenv("MW_SECRET_KEY");

# Changing this will log out all existing sessions.
$wgAuthenticationTokenVersion = "1";

# Site upgrade key. Must be set to a string (default provided) to turn on the
# web installer while LocalSettings.php is in place
$wgUpgradeKey = getenv("MW_UPGRADE_KEY");

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl = "";
$wgRightsText = "";
$wgRightsIcon = "";

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";

# The following permissions were set based on your choice in the installer
$wgGroupPermissions['*']['createaccount'] = false;
$wgGroupPermissions['*']['autocreateaccount'] = true;
$wgGroupPermissions['*']['edit'] = false;
$wgGroupPermissions['*']['read'] = false;

## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'vector', 'monobook':
$wgDefaultSkin = "vector";

#wfLoadSkin( 'MonoBook' );
#wfLoadSkin( 'Timeless' );
wfLoadSkin( 'Vector' );
wfLoadSkin( 'MinervaNeue' );

wfLoadExtension( 'PluggableAuth' );
wfLoadExtension( 'OpenIDConnect' );
wfLoadExtension( 'WikiEditor' );
wfLoadExtension( 'MobileFrontend' );

$wgPFEnableStringFunctions = true;

$wgMFAutodetectMobileView = true;
$wgMFDefaultSkinClass = 'SkinMinerva';

$wgPluggableAuth_EnableLocalLogin = false;
$wgPluggableAuth_EnableAutoLogin = false;

$wgPluggableAuth_Config[] = [
  'plugin' => 'OpenIDConnect',
  'data' => [
    'providerURL' => getenv('MW_OIDC_URL'),
    'clientID' => getenv('MW_OIDC_CLIENT_ID'),
    'clientsecret' => getenv('MW_OIDC_CLIENT_SECRET'),
    'name' => getenv('MW_OIDC_NAME'),
    'scope' => [ 'openid', 'profile', 'email' ],
  ]
];
$wgOpenIDConnect_MigrateUsersByUserName = true;

## Semantic MediaWiki
// enableSemantics( 'wiki.litheblas.org' );

## Maps
wfLoadExtension( 'Maps' );
require_once __DIR__ . '/extensions/Maps/Maps_Settings.php';
$egMapsDefaultService = 'leaflet';

wfLoadExtension('RandomInCategory');

# These settings should probably be commented in production.
# $wgDebugLogFile = "/var/log/mediawiki-debug.log";
# $wgShowExceptionDetails = true;
# $wgShowDBErrorBacktrace = true;
