<?php
require_once 'functions.php';
session_start();
session_destroy();
redirect_to('page_login.php');