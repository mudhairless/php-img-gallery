<div class="albums">
{if $albumtitle != ''}
<div class="album">
<a class="album" href="index.php?album={$prevalbum}">
<img class="album" src="images/folder.png" width="150" height="150" />[Go To Previous Album]</a>
</div>
{/if}
{foreach $subalbums as $album}
<div class="album">
{if $albumtitle == ''}
<a class="album" href="index.php?album=/{$album}/">
{else}
<a class="album" href="index.php?album=/{$albumtitle}/{$album}/">
{/if}
<img class="album" src="images/folder.png" width="150" height="150"/>{$album}
</a>
</div>
{/foreach}
</div>
