<?php
require('config.inc');
require('functions.inc');
require('smarty/Smarty.class.php');
$smarty = new Smarty();

$smarty->setTemplateDir($config['template_dir']);
$smarty->setCompileDir($config['templ_cache']);
$smarty->setCacheDir($config['cache_dir']);
$smarty->setConfigDir($config['smartyconf']);

if( isset($_GET['album']) ) {
    $album = $_GET['album'];
} else {
    $album = '/';
};

if( $album[0] != '/' ) {
    $album = '/';
};

$album = str_replace('..','',$album);
$album = str_replace('./','/',$album);
$album = html_entity_decode($album);

$albumfiles = read_all_files($config['pics_dir'] . $album);
$subalbums = array();
$errors = array();

if(isset($albumfiles['error'])){
    $errors[] = $albumfiles['error'];
    $album = '/';
    $albumfiles = read_all_files($config['pics_dir'] . $album);
}

foreach($albumfiles['dirs'] as $dirk) {
    $thisdir = str_replace($config['pics_dir'].'/','',$dirk);
    $thisdir = str_replace('//','',$thisdir);
    $thisdir = str_replace('\\','',$thisdir);
    $thisdir = str_replace('//','',$thisdir);
    $tsubd = explode('/',$thisdir);
    $tsubdd = array_pop($tsubd);
    if($tsubdd == '') {
        $subalbums[] = array_pop($tsubd);
    } else {
        $subalbums[] = $tsubdd;
    };
};

$smarty->assign('subalbums',$subalbums);

$pics = array();
foreach($albumfiles['files'] as $filek) {
    $filea = $filek;
    str_replace('//','/',$filea);
    if(substr($filea,0,1) == '/')
        $filea = substr($filea,1);
    $ext = strtolower(pathinfo($filea, PATHINFO_EXTENSION));
    switch($ext){
        case 'png':
        case 'jpg':
        case 'gif':
        case 'jpeg':
            $thumb = str_replace('/','_',$album.'/'.$filea) . '.jpg';
            $pics[$filea] = $config['cache_dir'] . '/' . $thumb;
            if(!file_exists($pics[$filea])){
            //create thumbnail
            make_thumb($filea,$pics[$filea],$config['thumb_width']);
            };
            break;
        default:
        break;
    };
};


$smarty->assign('pics',$pics);

$talbum = explode('/',$album);
$album = array_pop($talbum);
if($album == '') {
    $album = array_pop($talbum);
};
$palbum = '/'.join('/',$talbum).'/';
$palbum = str_replace('//','/',$palbum);
$album = str_replace('/','',$album);
$album = htmlentities($album);

if($album == '') {
    $smarty->assign('pagetitle','Root Album'.$config['site_title']);
} else {
    $smarty->assign('pagetitle',"Album: '".$album."'".$config['site_title']);
};
$smarty->assign('prevalbum',$palbum);
$smarty->assign('albumtitle',$album);
$smarty->assign('errors',$errors);
$smarty->display($config['template']);
?>
