# Welcome to NS-Core-Theme

- **package**:   NS-Core-Theme
- **version**:   v0.6.9

## All the core functionality of the NS-Base-Theme, with none of the proxy site build or component theme build! 

This theme doesn't do much other than providing base backend functions and helpers, useful for building out child themes. 

**Dev Url: http://ns.core-theme.test:2326**

### WordPress Admin Credentials

* Username: ns-admin
* Password: northstreet

### Theme Installation

**Note: This repo contains the **Full WordPress build**. The default database is set to 'ns_core_theme' and is largely empty, by design.**

1. First, clone this repo.

2. Kill the `.git` folder, rename this folder (e.g., `client-name`), and initialize a new repo in the root folder (to include the entire WordPress build)

3. This theme is pretty pointless on it's own, so you'll want to use one of the in-house child themes. Based on the project, decide which theme you'd like to use. Currently there are three child themes (but there may be more in the future):

* [ns-proxy-theme](https://bitbucket.org/northstreetcreative/proxy-theme) : This theme is best used for SARD proxy builds.
* [ns-component-theme](https://bitbucket.org/northstreetcreative/component-theme) : This theme is best used for non-SARD client builds.
* [ns-single-page-theme](https://bitbucket.org/northstreetcreative/single-page-theme) : This theme is best used for Single Page websites such as commonly used for Annual Reports.

4. Clone the appropriate child theme for your build into the themes directory. Once you've cloned it, change the theme name (e.g `client-name-theme`) and kill the `.git` repo folder.

### Database Installation (At the North Street Office)

1. If you're working locally in the North Street office, then open up `Sequel Pro` (or phpMyAdmin) and connect to `El Centro` (the internal database server). (Credentials can be found in the `wp-config.elcentro.php` file.)

2. Make a **COPY** of the database that corresponds to the theme you're working with. e.g, `ns_proxy_theme`, `ns_component_theme`, `ns_single_page_theme` or if you're starting from scratch (`ns_core_theme`), and name it to match the project, e.g, `ns_client_name`or `sard_code_name`

3. Open up wp-config.elcentro.php. Around line 19, you'll see a `switch` statement that serves up differnt databases based on which theme is in use. You can safely remove this switch statement entirely and instead just add one `define('DB_NAME', 'ns_client_name');` line. You should also entirely remove the `define( 'UPLOADS' ... )` statement. (More on that below).

### Database Installation (If not at North Street Office)

1. If you are **not** working locally in the North Street office, then you can grab a backup of the the database from within the repo. First, open up `wp-config.env` and uncomment out the `define('WP_ENV', 'local')` line and comment out the `define('WP_ENV', 'elcentro')` line.

2. The database backup is stored in the uploads folder for the given theme. E.g., if the child theme you are using is the proxy theme, you'll find the backup database file in `wp-content/uploads/proxy/backupbuddy_backups`

3. You'll find a `zip` file that contains multiple `sql` files that you can import into your local database server. *(Pro-tip: Make importing easier by combining these sql files into one file. Use the following command when in that directory: `cat *.sql  > all_files.sql`)*

4. Open up `wp-config.local.php` and adjust the `DB_NAME`, `DB_USER`, `DB_PASSWORD` lines to match your local database credentials. 

### FPO Image Installation

1. Each child theme comes with default Lorem Ipsum content and FPO images. To keep things tidy in the repo, each theme has it's own image directory that matches the theme name, e.g: 

* `ns-core-theme` : `wp-content/uploads/core`
* `ns-proxy-theme` : `wp-content/uploads/proxy`
* `ns-component-theme` : `wp-content/uploads/component`
* `ns-single-page-theme` : `wp-content/uploads/single-page`

2. For a new build however, you don't need this scheme. So instead, entirely remove the image folders of the themes not in use. E.g., if this is a proxy build, you can safely remove the `wp-content/uploads/core`, `wp-content/uploads/component` and `wp-content/uploads/single-page` folders.

3. Then, move all the images from the remaining folder (in this example, `wp-content/uploads/proxy`) into the `wp-content/uploads/` folder, and delete the now empty folder. 

*Note: You may decide you'd prefer not to have FPO images at all. In that scenario, you can skip this step and simply delete the contents of the entire uploads folder*

### Commit your new project!

1. Create a new repo in bitbucket for this project, and git pushing!



## Theme Tour

`ns-core-theme` has *NO* front-facing styles. It mostly contains useful functions, codes and snippets. 

**You should especially the `ns-functions.php` and `ns-acf.php` files as they contain many useful, well-documented, functions to make developing your build easier!** 

*(Note: DO NOT directly modify ns-core-theme!! This theme is meant to be used for all builds, therefore the only modifications to this theme should be generic functions that can be used in all possible scenarios. If you find yourself modifying this theme for a specific build instead of the child theme -- ask yourself if there's a way you could add that code to the child theme instead.)* 

* `functions.php` : Opinionated defaults for all WordPress builds. 

	* `do_action('ns_core_theme_loaded')` : If you ever need to call a function that exists in the parent, from
the child theme, then you need to reference this action, `ns_parent_loaded` so that you can ensure the child function loads after the parent has loaded! 

* `inc/ns-core.php` : This file serves as a place to put awesome filters and functions that are of a "Set it and forget it" nature. That is, functions that once placed in here, will not need to be actively called or reference or thought about again. These functions are relevant to *all builds*

* `inc/ns-functions.php` : Library of functions useful for WordPress builds, collected around the internet and/or heavily edited for NS use. If you find yourself writing a function that would be useful for a future build, add it here, but make sure it's reusable and generic enough!

* `inc/ns-acf.php` : Library of functions useful for WordPress builds, that rely on or are directly related to the Advanced Custom Fields plugin.

* `inc/ns-gravity.php` : Library of functions useful for WordPress builds, that rely on or are directly related to the Gravity Forms plugin.

* `inc/ns-customposts.php` : This file generates both custom posts & default meta fields in one shot. *(You don't really need to know anything about this function other than it makes life simplier. This function could probably be merged into ns-core and this file removed.)*

* `plugins/ns-plugins.php` : Plugins so useful we just install them by default directly in the theme. 

	* Disable Comments plugin : Disables comments
	* SCPO_Engine : Allow Drag & Drop ordering of posts
	* SVG : Allow SVG Support

## Plugins (and Licences for Pro plugins)

* `ns-core-theme` includes many plugins by default, however not all of them are activated. Depending on the child theme you choose, differnt plugins may be activated or deactived. You'll likely want to remove some plugins for your given build. 

* `BackupBuddy` is really only used to keep a backup of the various databases in the repo. You'll probably want to remove this in a real build as we no longer have an up-to-date license for this plugin.

* The license for `WP Migrate Pro` is in the database, so you should not need it, but it can also be found in 1Password or by asking your contact at North Street Creative.

* The license for `Advanced Custom Fields` differs on Sard vs Non-Sard sites. It is in the database by defualt, but make sure you enter the proper license for your build. It can be found in 1Password or by asking your contact at North Street Creative.



### Maintaining and adding to these themes (At the North Street Office)

1. The procedure for maintaining and adding to these themes is very similar...

2. Download this core repo.

3. Download `ns-proxy-theme`, `ns-component-theme`, and `single-page-theme` into the theme folders.

4. Use `ns-add-dev` *three* times, each time adding the following dev servers:
* `core-theme`
* `proxy-theme`
* `component-theme`
* `single-page-theme`

*(Note: ns-add-dev is a simple in-house script for adding dev servers to the virtual host file in MAMP. You can manually install these these servers into your virtual host files if you don't have the script intalled)*

5. The `wp.config.elcentro.php` file is set up to detect which "site" you are on, and swap out the database accordingingly. 

Using this method, only one WordPress installation is required (and therefore, only one installation is required
to be updated, as well as the associated plugins). 

6. **Note about media files** It's important that the each theme uses a different media folder (so that it's easy to remove the folders you don't need for a particular build). These special folders are specified in `wp-config.elcentro.php` and are mapped as such:
 
* `core-theme` : `wp-content/uploads/core`
* `proxy-theme` : `wp-content/uploads/proxy`
* `component-theme` : `wp-content/uploads/component`
* `single-page-theme` : `wp-content/uploads/single-page`


### RECENT Change Log

* v0.6.9 - Make updates to fonticonpicker plugin to work on sites behind an htaccess wall
  * Note, will need to define HTA_USER and HTA_PASS inside of your theme's functions.php

* v0.6.7 - Fixing small warnings ns-core be throwin'

* v0.6.6 - Fleshing out readme

* v0.6.5 - Adding BackupBuddy Database backups for all theses, changing media folders, updating readme

* v0.6.4 - CHORE - Plugin updates

* v0.6.3 - Moving location of UPLOADS folder to inside wp-content for component and single-page themes

* v0.6.2 - Fixing error in `use` function that cause incompatibility with PHP7.1+

* v0.6.1 - Added action 'ns_core_theme_loaded' to bottom of function.php; useful for hoooking into when you have child theme relies on parent functions
 
* v0.6.0 - Adding in some great new functions from MDS

in `ns-functions.php`

	**ns_has_children()**
	Simple function that returns true if the current page has kids

	**ns_custom_breadcrumbs()**
	For creating breadcrumbs easily....

	in `ns-acf.php`

	**ns_the_sub_field()**
	**ns_get_sub_field()**
	Just like ns_get_field, but works with sub_fields

* v0.5.1 - More cleaning up and reconfiguring things

* v0.5.0 - Writing up clearer instructions, cleaning up repo & database (s)

* v0.4.2 - Cleaning up functions.php, letting WP use default JS but keeping files in vendor for now

* v0.4.1 - Fixing versioning (Middle numnber is feature, last is for bugs)

* v0.4.0 - Killing problematic retina function (basically built into wp anyway now)

* v0.3.0 - Killing problematic compression class

* v0.2.0 - Removing ns-disclaimer from core theme, and moving to ns-proxy-theme

* v0.1.1 - Adding in classic editor plugin












