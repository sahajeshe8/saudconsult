# ACF Flexible Content Layout Previews

Preview images shown next to layout names in the WordPress admin (when adding flexible content blocks).

## How it works

- The theme uses the filter `acf/fields/flexible_content/layout_title` in `functions.php`.
- If an image exists here with the **layout name** as filename, it is shown (40×28px) next to the layout title.
- Supported extensions: `.png`, `.jpg`, `.jpeg`, `.gif`, `.webp`.

## Image filenames to add

Use the **layout name** as the filename (e.g. `inner_banner.png`). One image per layout name is enough; the same layout in different field groups reuses it.

| Layout name             | Used in                    | Suggested filename        |
|-------------------------|----------------------------|---------------------------|
| `inner_banner`          | Service, Category, Project, Services Page | `inner_banner.png` |
| `image_text_block`      | Service, Service Category  | `image_text_block.png`    |
| `image_text_block_2`    | Service                    | `image_text_block_2.png`  |
| `projects_home`         | Service                    | `projects_home.png`       |
| `what_to_expect`        | Service                    | `what_to_expect.png`      |
| `why_partner`           | Service                    | `why_partner.png`         |
| `banner_add`            | Service, Category, Project | `banner_add.png`          |
| `engineering_expertise` | Service Category           | `engineering_expertise.png` |
| `project_info_block`    | Project                    | `project_info_block.png`  |
| `design_scope`          | Project                    | `design_scope.png`        |
| `project_gallery`       | Project                    | `project_gallery.png`     |
| `content_block`         | Services Page              | `content_block.png`       |
| `services_grid`         | Services Page              | `services_grid.png`       |

Add any of the above as PNG/JPG (e.g. `inner_banner.png`). If a file is missing, the layout title still shows without a preview.
