<ul class="checklist">
    {foreach $items as $item}
        <li>
            <input type="checkbox" name="{$id}"{if $item.checked} checked{/if}>
            {$item['text']}
        </li>
    {/foreach}
</ul>