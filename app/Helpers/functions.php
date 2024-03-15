<?php

if (!function_exists('consoleText')) {
    function consoleText($data) {
        echo date("d-m-Y H:i:s") . ": \033[0m$data\n";
    }
}

if (!function_exists('consoleSuccess')) {
    function consoleSuccess($data) {
        echo date("d-m-Y H:i:s") . ": \033[32m$data\n";
    }
}

if (!function_exists('consoleInfo')) {
    function consoleInfo($data) {
        echo date("d-m-Y H:i:s") . ": \033[34m$data\n";
    }
}

if (!function_exists('consoleDanger')) {
    function consoleDanger($data) {
        echo date("d-m-Y H:i:s") . ": \033[31m$data\n";
    }
}

if (!function_exists('consoleWarning')) {
    function consoleWarning($data) {
        echo date("d-m-Y H:i:s") . ": \033[33m$data\n";
    }
}