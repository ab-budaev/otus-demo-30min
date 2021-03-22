<?php
/** @noinspection PhpUndefinedConstantInspection */
/** @noinspection PhpUndefinedFunctionInspection */

tideways_xhprof_enable(TIDEWAYS_XHPROF_FLAGS_MEMORY | TIDEWAYS_XHPROF_FLAGS_CPU | TIDEWAYS_XHPROF_FLAGS_NO_BUILTINS);

echo "test";

file_put_contents(
    sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('', true) . '.myapplication.xhprof',
    serialize(tideways_xhprof_disable())
);