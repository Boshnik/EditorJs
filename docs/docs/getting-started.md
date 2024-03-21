# Getting Started

After the component is installed, the `content` field in the resource becomes a powerful builder:

[![content](/img/editorjs.gif)](/img/editorjs.gif){data-fancybox="content"}

We output it to the site as a regular content field:

```php
[[*content]]

// fenom
{$_modx->resource.content}
```