<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . '/third_party/mpdf/mpdf.php';

class Pdf {

    public $param;
    public $pdf;

    public function __construct($param = '"en-GB-x","A4","","",10,10,10,10,6,3') {
        $this->param = $param;
        $this->pdf = new mPDF($this->param);
    }

    public function load() {
        return $this->pdf = new mPDF('c', 'A4-L');
    }

    public function ptwload() {
        return $this->pdf = new mPDF('utf-8','A4','','','8','8','32','18');
}
    public function incUpload() {
         return $this->pdf = new mPDF('utf-8','A4','','','8','8','32','18');
    }
    
    public function ptwUpload() {
         return $this->pdf = new mPDF('utf-8','A4','','','8','8','32','18');
    }
    
    public function gtsUpload() {
         return $this->pdf = new mPDF('utf-8','A4','','','8','8','32','18');
    }

     public function QrUpload() {
         return $this->pdf = new mPDF('utf-8','A4','','','8','8','32','18');
    }

}
