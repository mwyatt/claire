<?php 

// set time zone to uk 
ini_set('date.timezone', "Europe/London");

// keep processing after user disconnect (for cron)
ignore_user_abort(true);

// max out memory limit, needed for class image which was crashing
// while creating jpg
ini_set('memory_limit', '-1');

// execution time for url increased to 5min
ini_set('max_execution_time', 300);

// will this setup errors?
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
