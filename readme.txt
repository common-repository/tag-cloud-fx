=== Tag Cloud FX ===
Contributors: flashxml
Tags: images, photos, widget, post, plugin, posts, sidebar, tag, cloud, free, flash, as3, text, images, effects, tagcloud, animation, xml, photo, auto, roll, over, out, shade, speed
Requires at least: 2.8.0
Tested up to: 3.0.1
Stable tag: trunk

One of the most advanced Tag Clouds on the web. Fully XML customizable without any Flash knowledge. And it's free!

== Description ==

The Tag Cloud FX can be embedded in any website for free without even using Flash. The overall width and height can be customized up to 1680 x 1050 pixels. There are roll over effects, roll out speed and angle properties as well as multiple configurable properties for shade and background. The tags perspective, radius and offset is customizable with different text properties. Also, there are many other customizable properties on the Live Demo.

== Installation ==

Make sure your Wordpress version is greater than 2.8 and your hosting provider is using PHP5.

1. There are two files to download: [WordPress Plugin](http://downloads.wordpress.org/plugin/tag-cloud-fx.zip "Tag Cloud FX Plugin") (that you have to install and activate) & [Free archive](http://www.flashxml.net/free/download/tag-cloud.zip "Tag Cloud FX")
2. Create a new folder inside your **wp-content** folder called **flashxml**, inside this folder create a new one called **tag-cloud-fx** and copy the content of the **free archive** there
3. If you copied the **free archive** to a location different than the one above, go to **Tag Cloud FX** from the **Settings** tab in your **WordPress Dashboard** and update the path accordingly
4. Add `[tag-cloud-fx][/tag-cloud-fx]` where you want the Flash to show up in your post/page
5. If you want to make the Tag Cloud FX part of your theme, edit the template files and add `<?php tagcloudfx_echo_embed_code(); ?>` where you want it to show up
6. Go to [FlashXML.net](http://www.flashxml.net/ "Free Flash Components") and [customize your Tag Cloud FX](http://www.flashxml.net/tag-cloud.html "Tag Cloud FX") using the Live Demo. Generate the `settings.xml` text and use it to overwrite `wp-content/flashxml/tag-cloud-fx/settings.xml`
7. To use your own tags, update the `wp-content/flashxml/tag-cloud-fx/tagcloud.xml` file accordingly

= Additional settings file =

To embed the Tag Cloud FX more than once, you will need another settings file. Let's assume your new file is called `settings2.xml`. Add `[tag-cloud-fx settings="settings2.xml"][/tag-cloud-fx]` where you want the Flash to show up in your post/page. If you made the Flash part of your theme, add the file name as **the first argument** of the `tagcloudfx_echo_embed_code()` function call (for example `<?php tagcloudfx_echo_embed_code("settings2.xml"); ?>`).

= No Flash support text =

To support visitors without Adobe Flash Player, you can provide alternative content by adding the text between `[tag-cloud-fx]` and `[/tag-cloud-fx]`. If you made the Flash part of your theme, add the text as **the second argument** of the `tagcloudfx_echo_embed_code()` function call (for example `<?php tagcloudfx_echo_embed_code("","Alternative content"); ?>`).

= If you have PHP4 =

To make it work with PHP4, add `[tag-cloud-fx width="600" height="300"][/tag-cloud-fx]` where you want the Flash to show up in your post/page. If you made the Flash part of your theme, add the width and height as **the third and fourth argument** of the `tagcloudfx_echo_embed_code()` function call. Don't forget to provide your own width and height values, since 600 and 300 are just examples.

= Getting rid of the FlashXML.net label =

To remove the FlashXML.net label from the top-left corner you'll need to buy the [paid package](http://www.flashxml.net/tag-cloud.html "Tag Cloud FX"). Once you'll do that, simply use the SWF file from the paid package to overwrite the SWF file from the `wp-content/flashxml/tag-cloud-fx/` folder.

== Screenshots ==

1. The Live Demo on [FlashXML.net](http://www.flashxml.net/tag-cloud.html "Tag Cloud FX") is the utility that helps easily customize your Tag Cloud FX to fit all your needs.