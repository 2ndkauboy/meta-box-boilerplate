# Meta Box Boilerplate #

With this boilerplate plugin, creating new meta boxes for the WordPress backend becomes very easy.
All you have to do is creating a new class implementing the meta box base class and write a function to render and one to save the meta box.

### Quickstart ###

In the `example-plugin` folder you'll find a very simple plugin that uses the boilerplate. It uses the boilerplate plugin as a "helper plugin".
So to give it a try, just copy both folders into your `wp-content/plugin` directory and activate both of them, first the boilderplate, than the example plugin.
 
## Frequently Asked Questions ##

### How can I add my meta box using the boilerplate? ###

Just write a new PHP class which extends the `Meta_Box` base class and implements the `Meta_Box_Interface`.
This new new class needs to have two functions: `render()` and `save()`. In the constructor of this new class, you call the constructor of the parent class.
Here you can define the name, label, post type and, position and priority of the new meta box.

### Can I use this boilderplate inside of my own plugin or theme? ###

Absolutely! You don't have to use it as a "helper plugin". The only thing you have to make sure is that the PHP files with the classes can be found.
The easiest way to achieve this is using the provided autoloader function from the `Meta_Box_Boilerplate` class.
Just copy this function into your theme or plugin, rename it to something unique like `meta_box_boilerplate_autoload` and hook it in like so:
 
```
spl_autoload_register( 'meta_box_boilerplate_autoload' );
```
 
You also have to copy the `inc` folder into you plugin or theme and copy all of your new meta box implementing classes into this folder.
As the function `spl_autoload_register` and namspaces are used, you need PHP 5.3 or greater, to use it this way.