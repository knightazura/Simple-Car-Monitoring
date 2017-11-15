<?php

return array(


    'pdf' => array(
        'enabled' => true,
        // 'binary'  => '/usr/local/bin/wkhtmltopdf', <= on macOS
        // 'binary'  => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf"', <= on Windows (64bit)
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => '/usr/local/bin/wkhtmltoimage',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);
