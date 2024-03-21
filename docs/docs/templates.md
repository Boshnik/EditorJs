# Templates

After saving the resource, the json content is processed through Smarty, and there is a specific template 
for each element. All templates are available in the directory 
`core/components/editorjs/elements/templates/default/`, which is specified in the system setting 
`editorjs_templates_url`.

Additionally, you have the option to override any template. To do this, specify the path to your custom templates 
in the system setting `editorjs_templates_custom_url`.


## Paragraph
```html
<p>{$text}</p>
```

## Header
```html
<h{$level}>
    {if $anchor}
        <a href="#{$anchor}"></a>
    {/if}
    {$text}
</h{$level}>
```

## Qoute
```html
<blockquote>
    <p>{$text}</p>
    <span>{$caption}</span>
</blockquote>
```

## Image
```html
<picture>
    <img loading="lazy" src="{$file['url']}" alt="{$caption}">
</picture>
```

## List
```html
<{($style == 'ordered')?'ol':'ul'}>
    {foreach $items as $item}
        <li>{$item['content']}
            {if $item.items}
                {include file='list.tpl' items=$item.items style=$style}
            {/if}
        </li>
    {/foreach}
</{($style=='ordered')?'ol':'ul'}>
```

## Checklist
```html
<ul class="checklist">
    {foreach $items as $item}
        <li>
            <input type="checkbox" name="{$id}"{if $item.checked} checked{/if}>
            {$item['text']}
        </li>
    {/foreach}
</ul>
```

## Table
```html
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
```

## Delimiter
```html
<hr>
```

## Warning
```html
<div class="alert alert-warning" role="alert">
    {if $title}
        <h2>{$title}</h2>
    {/if}
    {$message}
</div>
```

## Code
```html
<code>
    {$code}
</code>
```

## Raw HTML
```html
{$html}
```

## Attachment
```html
<div class="card" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title">{$file['title']}</h5>
        <a href="{$file['url']}" class="card-link">Download</a>
    </div>
</div>
```

## Columns
```html
<section class="section-columns">
    <div class="container">
        <div class="row">
            {foreach $cols as $col}
                <div class="col">
                    {foreach $col.blocks as $block}
                        {if $block['type'] == 'header'}
                            {include file="header.tpl" 
                                     text=$block['data']['text'] 
                                     level=$block['data']['level']}
                        {/if}
                        {if $block['type'] == 'paragraph'}
                            {include file="paragraph.tpl" 
                                     text=$block['data']['text']}
                        {/if}
                    {/foreach}
                </div>
            {/foreach}
        </div>
    </div>
</section>
```

## Gallery
```html
<div class="gallery" data-type="{$style}">
    {foreach $files as $file}
        {include file='image.tpl' caption=$file.title}
    {/foreach}
</div>
```

## Toggle
```html
<div class="toggle toggle-{$status}" data-idx="{$idx}" id="{$id}">
    {$wrapper}
</div>
```

## Alert
```html
<div class="alert alert-{$type}" role="alert">
    {$message}
</div>
```