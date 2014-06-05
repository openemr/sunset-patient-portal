<?php
/*
Plugin Name: Sunset Patient Portal
Plugin URI: http://www.sunsetsystems.com/
Description: Patient interface to a medical clinic EHR system.
Version: 0.2
Author: Rod Roark
Author URI: http://www.sunsetsystems.com/
License: GPL2+
*/

/*
Copyright 2014 Rod Roark (email: rod@sunsetsystems.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

if (!class_exists('Sunset_Patient_Portal')) {
  class Sunset_Patient_Portal {

    const CLASS_NAME = 'Sunset_Patient_Portal';

    public static function initialize() {

      // From http://codex.wordpress.org/Function_Reference/register_activation_hook:
      // The register_activation_hook function registers a plugin function to be run when the plugin
      // is activated.
      //
      // From PHP documentation of callable types: "Static class methods can also be passed without
      // instantiating an object of that class by passing the class name instead of an object at
      // index 0. As of PHP 5.2.3, it is also possible to pass 'ClassName::methodName'."
      //
      register_activation_hook  (__FILE__, array(self::CLASS_NAME, 'activate'  ));
      register_deactivation_hook(__FILE__, array(self::CLASS_NAME, 'deactivate'));

    } // END function initialize()

    //
    // Activate the plugin
    //
    public static function activate() {
      // Do nothing
    }

    //
    // Deactivate the plugin
    //		
    public static function deactivate() {
      // Do nothing
    }

  } // END class Sunset_Patient_Portal
} // END if (!class_exists('Sunset_Patient_Portal'))

Sunset_Patient_Portal::initialize();

