<table class="table">
    {if $withHeadings}
        <thead>
            <tr>
                {foreach $content as $idx => $rows}
                    {if !$idx}
                        {foreach $rows as $column}
                            <th>{$column}</th>
                        {/foreach}
                    {/if}
                {/foreach}
            </tr>
        </thead>
    {/if}
    <tbody>
        {foreach $content as $idx => $rows}
            {if $withHeadings}
                {if !$idx} {continue} {/if}
            {/if}
            <tr>
                {foreach $rows as $column}
                    <td>{$column}</td>
                {/foreach}
            </tr>
        {/foreach}
    </tbody>
</table>