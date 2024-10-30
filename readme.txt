=== Books You’ve Read ===
Contributors: trevorelwell
Donate link: http://trevorelwell.me
Tags: books, books you’ve read, reading, 
Requires at least: 3.0.1
Tested up to: 4.3.1
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create custom post type for books you’ve read, with prompts to remember the important parts.

== Description ==

It’s important to write about what you’ve read. For a long time I’ve been meaning to write blog posts for all of the books that I’ve read recently but found that I got lost when it came time to begin the process. So I created a plugin that makes it easy to keep track! Basically, it’s a good-looking way to write about the books you’ve read and display them on your website. I utilize some basic prompts to help you extract the meaningful parts of the book and the plugin then creates a blog post entry from this information. Presently the prompts are: 
-Date Finished
-Book Summary
-What Did You Learn from the Book?
-Any Final Thoughts?

If you have any recommendations for other prompts to use please let me know at `me@trevorelwell.com` and I’d be happy to consider them!

== Installation ==

Installation of Books You’ve Read is simple. The shortcode utilized is `[byr_show_all_books]` which you can put onto any of your pages or posts. Here’s some more installation info: 

1. Upload the `byr` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place `<?php do_action('byr_show_all_books'); ?>` in your templates or place `[byr_show_all_books]` in a post or a page
4. Begin writing about the books that you’ve read!

Please keep in mind that *books need a featured image* in order to properly show up on the list of all books. I recommend using a high-quality image of the cover of the book but you can be as creative as you’d like.


== Screenshots ==

1. Rendered version of the `[byr_show_all_books]` shortcode
2. View of the `Books Read` blog post type and where/how it’s displayed on your WordPress installation
3. View of the prompts on the `Books Read` blog post type under `Add New`

== Changelog ==

= 0.1 =
-First released version of the Books You’ve Read plugin