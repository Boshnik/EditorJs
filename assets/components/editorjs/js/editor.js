window.onload = () => {
    const content = document.querySelector('[name="ta"]');
    if (!content) return;

    EditorJs.uploader = function(file, filetype) {
        const form_data = new FormData();
        form_data.append('filetype', filetype);
        form_data.append('file', file, file.name);
        form_data.append('action', 'mgr/upload');
        form_data.append('source', MODx.config.editor_media_source || MODx.config.default_media_source);
        let path = MODx.config.editorjs_image_path.replace('{resource_id}', EditorJs.resource_id);
        form_data.append('path', path);

        return fetch(EditorJs.config.connectorUrl, {
            method: 'POST',
            body: form_data,
            headers: {
                'Powered-By': 'MODx',
                'modAuth': MODx.siteId
            }
        })
        .then(res => res.json())
        .then(res => {
            console.log(res);
            if (res.success) {
                return {
                    success: 1,
                    file: res.object
                };
            } else {
                MODx.msg.alert('Error', res.message);
                return {
                    success: 0,
                };
            }
        });
    };

    const editor = new EditorJS({
        holder: 'modx-content-above',
        tools: {
            paragraph: {
                class: Paragraph,
                inlineToolbar: true,
            },
            header: {
                class: Header,
                inlineToolbar: true,
                config: {
                    placeholder: 'Header',
                    allowAnchor: true,
                    anchorLength: 100,
                    defaultAlignment: 'left'
                },
            },
            quote: {
                class: Quote,
                inlineToolbar: true,
                config: {
                    quotePlaceholder: 'Enter a quote',
                    captionPlaceholder: 'Quote\'s author',
                },
            },
            // simpleImage: SimpleImage,
            image: {
                class: ImageTool,
                config: {
                    uploader: {
                        uploadByFile(file) {
                            return EditorJs.uploader(file, 'image');
                        }
                    }
                }
            },
            list: {
                class: NestedList,
                inlineToolbar: true,
                config: {
                    defaultStyle: 'unordered'
                },
            },
            checklist: {
                class: Checklist,
                inlineToolbar: true,
            },
            embed: {
                class: Embed,
                inlineToolbar: true,
            },
            table: {
                class: Table,
                inlineToolbar: true,
                config: {
                    rows: 2,
                    cols: 3,
                },
            },
            delimiter: Delimiter,
            warning: {
                class: Warning,
                inlineToolbar: true,
                config: {
                    titlePlaceholder: 'Title',
                    messagePlaceholder: 'Message',
                },
            },
            code: CodeTool,
            raw: RawTool,
            attaches: {
                class: AttachesTool,
                config: {
                    uploader: {
                        uploadByFile: function (file) {
                            return EditorJs.uploader(file, 'file');
                        }
                    }
                }
            },
            marker: {
                class: Marker,
            },
            inlineCode: {
                class: InlineCode,
            },
            strikethrough: Strikethrough,
            underline: Underline,
            // tooltip: {
            //     class: Tooltip,
            //     config: {
            //         location: 'left',
            //         highlightColor: '#FFEFD5',
            //         underline: true,
            //         backgroundColor: '#154360',
            //         textColor: '#FDFEFE',
            //         holder: 'editorId',
            //     }
            // },
            changeCase: {
                class: ChangeCase,
                inlineToolbar: true,
                config: {
                    showLocaleOption: true,
                    locale: 'TR' // or ['tr', 'TR', 'tr-TR']
                }
            },
            style: EditorJSStyle.StyleInlineTool,
            // template: {
            //     class: EditorJSInlineTemplate.TemplateInlineTool,
            //     config: {
            //         buttonHTML: `
            //     <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
            //       <path d="M336 64h32a48 48 0 0148 48v320a48 48 0 01-48 48H144a48 48 0 01-48-48V112a48 48 0 0148-48h32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/>
            //       <rect x="176" y="32" width="160" height="64" rx="26.13" ry="26.13" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/>
            //     </svg>
            //   `,
            //         html: "<b>template</b>⭐",
            //     },
            // },
            // hyperlink: {
            //     class: Hyperlink,
            //     config: {
            //         shortcut: 'CMD+L',
            //         target: '_blank',
            //         rel: 'nofollow',
            //         availableTargets: ['_blank', '_self'],
            //         availableRels: ['author', 'noreferrer'],
            //         validate: false,
            //     }
            // },
            columns : {
                class : editorjsColumns,
                config : {
                    tools : {
                        header: Header,
                        delimiter : Delimiter
                    },
                }
            },
            gallery: {
                class: ImageGallery,
                config: {
                    uploader: {
                        uploadByFile: function (file) {
                            return EditorJs.uploader(file, 'file');
                        }
                    }
                },
            },
            // carousel: {
            //     class: Carousel,
            //     config: {
            //         uploader: {
            //             uploadByFile: function (file) {
            //                 return EditorJs.uploader(file, 'file');
            //             }
            //         }
            //     },
            // },
            toggle: {
                class: ToggleBlock,
                inlineToolbar: true,
            },
            alert: {
                class: Alert,
                inlineToolbar: true,
                config: {
                    defaultType: 'primary',
                    messagePlaceholder: 'Enter something',
                },
            },
        },

        placeholder: MODx.config.editorjs_placeholder,
        data: EditorJs.content ? JSON.parse(EditorJs.content) : {},
        onReady: () => {
            console.log('Editor.js is ready to work!');
            new DragDrop(editor);
        },
        onChange: (api, event) => {
            editor.save().then((outputData) => {
                content.value = JSON.stringify(outputData);
            }).catch((error) => {
                console.log('Saving failed: ', error);
            });
        }
    });
    console.log(editor);
}