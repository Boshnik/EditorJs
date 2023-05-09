<section class="section-columns">
    <div class="container">
        <div class="row">
            {foreach $cols as $col}
                <div class="col">
                    {foreach $col.blocks as $block}
                        {if $block['type'] == 'header'}
                            {include file="header.tpl" text=$block['data']['text'] level=$block['data']['level']}
                        {/if}
                        {if $block['type'] == 'paragraph'}
                            {include file="paragraph.tpl" text=$block['data']['text']}
                        {/if}
                    {/foreach}
                </div>
            {/foreach}
        </div>
    </div>
</section>