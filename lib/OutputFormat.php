<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OutputFormat
 *
 * @author jorgezfx@gmail.com
 */
class OutputFormat {

    public static function formatScore($number) {
        return is_null($number) ? null : number_format($number, 2);
    }

}
