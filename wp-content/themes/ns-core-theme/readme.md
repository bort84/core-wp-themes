# Welcome to NS-Proxy-Theme

- **package**:   NS-Proxy-Theme
- **version**:   v1.0.3

## Table of Contents

* Notes
* Functions
* Structure
  * Inc
  * JS
  * Plugins
* ACF [DONE]
* Changelog [DONE]

## Notes
## Versioning
Given a version number MAJOR.MINOR.PATCH, increment the:

* MAJOR version when you make incompatible API changes,
* MINOR version when you add functionality in a backwards compatible manner, and
* PATCH version when you make backwards compatible bug fixes.

Additional labels for pre-release and build metadata are available as extensions to the MAJOR.MINOR.PATCH format.


## Functions
### Misc. settings
Wordpress Core specific functionality that doesnt need to change between builds. Certain defined constants, like KILL_ATTACHMENT_PAGE and DISABLE_COMMENTS, can be found here.

### Theme supports
Add supported theme funcionality into this section isntead of in each child theme. This section should be reviewed with each major WordPress release.

### Scripts/Styles
Admin-specific scripts are enqueued here.

### Required files
Each of these files can be found in the /inc/ folder and have their own internal documentation for each function. Most of these files have one or two specific functions to keep them lean.


## Structure
### Inc
This folder holds the individual functions of the site seperated by category into specific files. For any new funcitonality, either add it to an existing category file or create a new one. Make sure to include the new file in functions.php

### JS
Scripts specific to the admin area. There should not be any front-facing scripts in this folder.

### Plugins
Plugins that are required for the build should be put into this folder and added to the ns-plugins.php file. There are two plugins here currently:

* Disable Comments: disables comments on all custom post types
* Enable SVG Uploads: Allows SVG files to be uploaded to the media library


### Change Log
* v1.0.3 - Update Readme
* v1.0.2 - Clean Up Proxy
* v1.0.1 - Added check to see if Primary and Privacy menus have been selected in Appearance > Menus
* v1.0.0 - Proxy Theme fresh start