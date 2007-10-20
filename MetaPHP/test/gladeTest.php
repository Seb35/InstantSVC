<?php
$glade = new GladeXML(dirname(__FILE__) . '/../Glade/helloWorld.xml');

$window = $glade->get_widget('wndClose');
$window->connect_simple('destroy', array('Gtk', 'main_quit'));
 
//Again, get the widget object and connect the clicked signal
$button = $glade->get_widget('btnClose');
$button->connect_simple('clicked', 'onClickButton');
 
//This method is called when the button is clicked
function onClickButton() {
    echo "button clicked!\r\n";
    Gtk::main_quit();
}
 
//Start the main loop
Gtk::main();
?>