=== Die Jim Crow ===

Contributors: Pea
Tags: translation-ready, custom-background, theme-options, custom-menu, post-formats, threaded-comments

Requires at least: 4.0
Tested up to: 4.4.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Custom WordPress theme for Die Jim Crow.
== Description ==

A custom theme for the Die Jim Crow promo site, based on _s.

== Installation ==

1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload and Choose File, then select the theme's .zip file. Click Install Now.
3. Click Activate to use your new theme right away.

== Frequently Asked Questions ==

= Does this theme support any plugins? =

This theme includes support for Jetpack's Infinite Scroll and Site Logos, as well as other features.

== Developer Notes ==

This is a child theme of the Singl theme https://wordpress.com/themes/singl/ . It has some custom styles, functions and templates.

= File Structure =

assets/
    fonts
    images
    scripts
    styles
dist/
    scripts
    styles
inc/
    custom.php
    enqueue.php
    setup.php
functions.php
style.css

= Workflow =

This theme is set up to use gulp to process SASS, script, images, etc. The source files are in the `assets` directory and the compiled files are moved to the `dist` directory.

= SASS =

This theme used the .scss syntax. SASS variables are set-up and can be changed in `assets/styles/custom/_variables.scss`. 


== Changelog ==


== Credits ==
