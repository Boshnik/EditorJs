import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  title: "EditorJs",
  description: "Free block-style editor with a universal JSON output",
  cleanUrls: true,
  themeConfig: {
    // https://vitepress.dev/reference/default-theme-config
    nav: [
      { text: 'Home', link: 'https://boshnik.com/', target: '_self' },
      { text: 'Documentation', link: '/docs/' }
    ],

    sidebar: [
      {
        text: 'Introduction',
        items: [
          { text: 'Installation', link: '/docs/installation' },
          { text: 'Getting Started', link: '/docs/getting-started' },
          { text: 'Settings', link: '/docs/settings' },
          { text: 'Templates', link: '/docs/templates' },
        ]
      }
    ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/Boshnik/EditorJs' }
    ]
  }
})
