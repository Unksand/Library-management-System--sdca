<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Include PHP QR Code library
class Ciqrcode {

    public function generate($params = []) {
        // Include the QR code generation logic
        if (!isset($params['data']) || !isset($params['savename'])) {
            throw new Exception("Missing required parameters: 'data' and 'savename'");
        }

        // Default settings
        $level = isset($params['level']) ? $params['level'] : 'L';
        $size = isset($params['size']) ? $params['size'] : 4;
        $margin = isset($params['margin']) ? $params['margin'] : 2;

        // Generate the QR code
        include_once APPPATH . 'third_party/phpqrcode/qrlib.php';
        QRcode::png($params['data'], $params['savename'], $level, $size, $margin);
    }
}
