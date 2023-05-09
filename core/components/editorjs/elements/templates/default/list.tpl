<{($style == 'ordered')?'ol':'ul'}>
    {foreach $items as $item}
        <li>{$item['content']}
            {if $item.items}
                {include file='list.tpl' items=$item.items style=$style}
            {/if}
        </li>
    {/foreach}
</{($style=='ordered')?'ol':'ul'}>