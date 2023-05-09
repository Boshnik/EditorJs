<div class="gallery" data-type="{$style}">
    {foreach $files as $file}
        {include file='image.tpl' caption=$file.title}
    {/foreach}
</div>