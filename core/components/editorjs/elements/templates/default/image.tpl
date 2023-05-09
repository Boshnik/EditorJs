{*$img = $modx->runSnippet('phpthumbon', [
    'input' => $file['url'],
    'options' => ''
])*}
<picture>
    <img loading="lazy" src="{$file['url']}" alt="{$caption}">
</picture>
