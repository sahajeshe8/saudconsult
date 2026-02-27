# Fonts Directory

Place your custom font files in this directory.

## Current Fonts:

The theme currently includes **Raleway** font family with multiple weights and styles.

## Font Files:

All font files should be placed in: `/wp-content/themes/tasheel/fonts/`

## Supported Formats:

- **WOFF2** (recommended - best compression and browser support)
- **WOFF** (fallback for older browsers)
- TTF/OTF (can be converted to WOFF/WOFF2)

## Adding Custom Fonts:

1. Place your font files in this directory
2. Add @font-face declarations in your CSS or in `style.css`:

```css
@font-face {
    font-family: 'YourFontName';
    src: url('<?php echo get_template_directory_uri(); ?>/fonts/YourFont-Regular.woff2') format('woff2'),
         url('<?php echo get_template_directory_uri(); ?>/fonts/YourFont-Regular.woff') format('woff');
    font-weight: 400;
    font-style: normal;
    font-display: swap;
}
```

3. Use the font in your CSS:
```css
body {
    font-family: 'YourFontName', sans-serif;
}
```

## Font Loading Best Practices:

- Use `font-display: swap` for better performance
- Always include WOFF2 and WOFF formats
- Preload critical fonts in `functions.php` if needed

