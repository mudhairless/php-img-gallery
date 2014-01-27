<!doctype html>
<html>
<head>
<title>{$pagetitle}</title>
<link rel="stylesheet" type="text/css" href="css/colorbox.css"/>
<link rel="stylesheet" type="text/css" href="css/main.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/jquery.colorbox-min.js"></script>
<script type="text/javascript">
{literal}
$(document).ready(function(){
    $(".thumb").colorbox({rel:'thumb',fixed:true,scalePhotos:true,maxHeight:$(window).height()});
});
{/literal}
</script>
</head>
<body>
<h1>
{if $albumtitle == ''}
Root Album
{else}
{$albumtitle}
{/if}
</h1>
