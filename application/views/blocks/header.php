<?php defined('SYSPATH') or die('No direct script access.');?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="en-us" />
    <link rel="stylesheet" href="/css/main.css" type="text/css" media="screen" />
    <script type="text/javascript" src="/js/jquery-1.4.2.min.js"></script>
    <title><?php if (isset($title)): echo Kohana::config('app_config.site_title') . ' / ' . $title ; endif;?></title>
  </head>
<body>
<div id="header">
<h1><a href="/">conkeep</a></h1>
<h4>Config Keeper</h4>
</div>
<div class="page-name"><h2><?php if (!empty($title)): echo $title; endif; ?></h2></div>
