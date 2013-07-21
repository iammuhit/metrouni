<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Metrouni Events Class
 * 
 * @package     PyroCMS\Addon\Modules\Metrouni
 * @subpackage  Metrouni Module
 * @category    events
 * @author      The Primitive Solution
 * @website     http://primitivesolution.com
 */
class Events_Metrouni {

    protected $ci;

    public function __construct() {
        $this->ci = & get_instance();

        //register the public_controller event
        Events::register('public_controller', array($this, 'run'));

        //register a second event that can be called any time.
        // To execute the "run" method below you would use: Events::trigger('sample_event');
        // in any php file within PyroCMS, even another module.
        Events::register('metrouni_event', array($this, 'run'));
    }

    public function run() {
        
    }

}

/* End of file events.php */
/* Location: ./modules/metrouni/events.php */