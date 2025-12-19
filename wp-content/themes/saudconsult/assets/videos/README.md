# Videos Directory

Place your theme videos in this directory.

## Video Paths:

All videos should be placed in: `/wp-content/themes/tasheel/videos/`

## Supported Formats:

- MP4 (recommended for web)
- WebM (for better browser compatibility)
- OGG (optional)

## Usage:

You can reference videos in your components using:
```php
get_template_directory_uri() . '/videos/your-video.mp4'
```

You can also upload videos through WordPress Media Library and reference them via URL.

## Example Usage:

```html
<video autoplay muted loop>
    <source src="<?php echo get_template_directory_uri(); ?>/videos/banner-video.mp4" type="video/mp4">
</video>
```

