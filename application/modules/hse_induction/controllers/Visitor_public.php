<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'modules/hse_induction/controllers/Visitor_registration.php');

/**
 * Backward compatibility alias for Visitor_registration
 */
class Visitor_public extends Visitor_registration
{
    public function __construct()
    {
        parent::__construct();
    }
}
