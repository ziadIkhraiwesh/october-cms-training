# NexaTech October CMS Training

A custom October CMS website developed for Task 20 of the Blue University Field Training Program. The project demonstrates how October CMS organizes reusable layouts, partials, pages, assets, and editable content.

## Features

* Custom `nexatech-training` theme
* Home, About, and Contact pages
* Reusable default layout
* Reusable header, footer, and hero partials
* CMS-editable hero title and description
* Active navigation styling
* Responsive desktop and mobile design
* Organized theme assets

## Technologies

* October CMS 4
* Laravel
* PHP 8.3
* MySQL
* Twig
* HTML5
* CSS3
* Composer

## Theme Structure

```
themes/nexatech-training/
├── assets/
│   └── css/theme.css
├── content/
│   └── home/
│       ├── hero-title.htm
│       └── hero-description.htm
├── layouts/
│   └── default.htm
├── pages/
│   ├── home.htm
│   ├── about.htm
│   └── contact.htm
├── partials/
│   ├── header.htm
│   ├── footer.htm
│   └── hero.htm
└── theme.yaml
```

## Local Setup

1. Clone the repository.
2. Run `composer install`.
3. Copy `.env.example` to `.env`.
4. Configure the database values in `.env`.
5. Run `php artisan key:generate`.
6. Run `php artisan october:migrate`.
7. Activate the theme using `php artisan theme:use nexatech-training`.
8. Start the application using `php artisan serve`.
9. Open `http://127.0.0.1:8000`.

The administration area is available at `/admin`. Create your own local administrator account; credentials and environment files are not included in the repository.

## Dynamic Content

The Home page hero title and description are stored as October CMS Content Files. They can be edited through:

`Administration Area → Editor → Content Files → home`

The changes appear on the public Home page without modifying its page template.

## CMS Concepts

The implementation follows the same reusable-content concepts explored in Tasks 18 and 19, but October CMS provides these features through a real CMS structure:

* Pages define public routes and page-specific content.
* Layouts provide the shared HTML structure.
* Partials contain reusable interface sections.
* Content Files allow administrators to edit content separately from templates.
* Assets contain the theme styling and frontend resources.

## Responsive Testing

The Home, About, and Contact pages were tested on desktop and mobile viewport sizes. Navigation, headings, buttons, sections, and form fields remain readable without horizontal overflow.

## Challenge Resolved

The project initially encountered Windows and OneDrive file-locking and permission issues inside `storage/framework`. The project was moved to the Laragon web directory, writable framework folders were recreated, and the October CMS cache was cleared successfully.

## Security Notes

* `.env`, authentication files, dependencies, sessions, cache files, and project-license information are excluded from Git.
* No passwords, database credentials, administrator credentials, or license keys are stored in the repository.

## Author

Ziad Ikhraiwesh
Blue University Field Training Program — Task 20

## Task 21: Dynamic Services Plugin

Task 21 extends the October CMS website with a custom database-backed plugin that allows administrators to manage services and display them dynamically on the public website.

### Plugin Information

- Plugin namespace: `Ziad.Services`
- Plugin name: `NexaTech Services`
- Location: `plugins/ziad/services`
- Purpose: Manage structured Service records through the October CMS backend and render active records using a reusable CMS component.

### Main Plugin Structure

- `Plugin.php`: Registers the plugin, backend navigation, permissions, and CMS component.
- `models/Service.php`: Defines the Service model, database table, validation rules, casts, and query scopes.
- `updates/create_services_table.php`: Creates the Services database table.
- `updates/version.yaml`: Registers the plugin version and migration.
- `controllers/Services.php`: Provides backend Create, Read, Update, and Delete management.
- `models/service/fields.yaml`: Configures the backend form fields.
- `models/service/columns.yaml`: Configures the backend list columns.
- `components/ServiceList.php`: Retrieves active services from the database.
- `components/servicelist/default.htm`: Renders reusable service cards and the empty state.

### Service Model Fields

- `title`: Service name.
- `short_description`: Short public summary.
- `content`: Detailed service content.
- `is_active`: Controls whether the service appears publicly.
- `sort_order`: Controls the public display order.
- `created_at` and `updated_at`: Record timestamps.

### Backend Management

Administrators can manage Services through:

`Administration Area → Services`

The backend supports:

- Viewing the Services list.
- Creating and editing Services.
- Deleting Services.
- Activating or deactivating Services.
- Setting the display order.
- Searching and sorting records.
- Required-field validation with meaningful feedback.

### Dynamic Services Component

Component alias:

`serviceList`

The component retrieves only active Services and orders them using the `sort_order` field.

Available properties:

- `maxItems`: Maximum number of Services displayed.
- `orderDirection`: Ascending or descending display order.
- `showTitle`: Shows or hides the section heading.

Example page configuration:

    [serviceList]
    maxItems = 3
    orderDirection = "asc"
    showTitle = 1

The component is rendered using:

    {% component "serviceList" %}

### Dynamic Content Flow

`October CMS Backend → Database → ServiceList Component → Public Home Page`

Changes made to a Service in the backend appear on the public website after refreshing the page. Inactive Services are hidden automatically. If no active Services exist, the component displays a clear empty-state message.

### Database Setup

After installing project dependencies and configuring `.env`, run:

    php artisan october:migrate

This installs the `Ziad.Services` plugin migration and creates the `ziad_services_services` table.

### Task 21 Verification

The completed verification included:

- Three Services with different display orders.
- Two active Services displayed publicly.
- One inactive Service hidden publicly.
- Correct ascending display order.
- Backend edits reflected on the public website.
- `maxItems` property tested with a value of one.
- Empty-state behavior tested.
- Desktop and mobile responsive layouts verified.
## Task 22: Relationships, Images, and Advanced Service Management

Task 22 extends the `Ziad.Services` plugin with related Service Categories, image attachments, category filtering, and dynamic Service Details pages.

### Service Category Model

Service Categories are stored in the `ziad_services_service_categories` database table.

Category fields:

- `name`: Category display name.
- `slug`: Unique value used for filtering.
- `is_active`: Controls whether the category and its Services are publicly visible.
- `sort_order`: Controls backend and public ordering.
- `created_at` and `updated_at`: Record timestamps.

Administrators can manage Categories through:

`Administration Area → Services → Categories`

The backend supports listing, creating, editing, deleting, activating, and ordering Categories.

### Service and Category Relationship

Each Service belongs to one Service Category, while each Category can contain multiple Services.

The relationship is implemented using:

- `Service::$belongsTo`
- `ServiceCategory::$hasMany`
- The `category_id` foreign key in the Services table.

The Service backend form uses a database-backed Category dropdown instead of manually entered category IDs.

### Service Image Attachment

Each Service supports one image using October CMS `attachOne` file attachment functionality.

The backend file upload field accepts:

- JPG
- JPEG
- PNG
- WebP

Images can be uploaded, changed, and removed through the Service form. The public component loads and displays the attached image with the related Service.

### Public Category Filtering

The `ServiceList` component includes a configurable `categorySlug` property.

Example:

    [serviceList]
    maxItems = 6
    orderDirection = "asc"
    showTitle = 1
    categorySlug = "cms-solutions"

Leaving `categorySlug` empty displays Services from all active Categories. Providing a Category slug displays only Services related to that Category.

### Published Content Rules

A Service appears publicly only when:

- The Service is active.
- Its related Category is active.
- The Service matches the configured Category filter, when used.

Inactive Services, Services without a valid Category, and Services belonging to inactive Categories are excluded from the public query.

### Service Details Page

Each published Service has a dynamic details page:

    /services/:id

The `ServiceDetails` component retrieves one active Service with its Category and image. The page displays:

- Service image.
- Category name.
- Service title.
- Short description.
- Detailed content.

A missing Service, inactive Service, or Service belonging to an inactive Category returns a not-found response.

### Database Update

Task 22 adds plugin version `v1.0.2` with:

- `create_service_categories_table.php`
- `add_category_id_to_services_table.php`

After pulling the latest project changes, run:

    composer install
    php artisan october:migrate
    php artisan cache:clear

### Task 22 Verification

The completed verification included:

- Three Categories with unique slugs and different display orders.
- Multiple Services assigned to different Categories.
- Images uploaded for Services.
- Category relationships displayed in backend and frontend views.
- Category filtering tested using `categorySlug`.
- Dynamic Service Details page tested.
- Duplicate Category slug validation tested.
- Inactive Service and inactive Category behavior tested.
- Missing Service URL returned a not-found response.
- Desktop and mobile layouts verified.
## Task 23 - Permissions, Settings & AJAX Contact Management

Task 23 extends the existing `Ziad.Services` plugin with backend permissions, configurable contact settings, and a database-backed AJAX contact workflow.

### Backend Permissions

The plugin defines separate permissions for:

- `ziad.services.manage_services`: manage Services.
- `ziad.services.manage_categories`: manage Service Categories.
- `ziad.services.manage_contact_messages`: view, update, and delete Contact Messages.
- `ziad.services.manage_settings`: manage public contact settings.

A non-superuser `Service Editor` role was tested with access to Services and Categories but without access to Contact Messages or Contact Settings. Restricted sections return an Access Denied response.

### Contact Settings

The **Settings ? NexaTech ? Contact Settings** section allows administrators to configure:

- Contact email.
- Phone number.
- Address.
- Optional help text.

These values are loaded dynamically on the public Contact page through the `Settings` model, so normal contact information changes do not require editing theme files.

### Contact Message Model

Contact messages are stored in the `ziad_services_contact_messages` table with:

- Name.
- Email.
- Subject.
- Message.
- Status (`new` or `read`).
- Created and updated timestamps.

Messages can be searched, opened, marked as New or Read, and deleted through the October CMS backend.

### AJAX Contact Flow

The public Contact page uses the reusable `ContactForm` component and October CMS AJAX framework.

1. The visitor submits the Contact form.
2. The AJAX handler validates all input on the server.
3. Invalid requests return clearly associated validation errors.
4. Valid messages are stored with the `new` status.
5. A success message appears without reloading the page.
6. Authorized administrators can review and update messages.

### Validation and Anti-Spam

Server-side validation checks required fields, email format, text lengths, and allowed status values. A hidden honeypot rejects automated submissions. Rate limiting allows a maximum of three valid submissions per IP address per minute. Twig output escaping helps render submitted data safely.

Permissions limit each backend user to the sections required for their role. Server-side validation is essential because browser-side validation can be bypassed.

### Database Update

After pulling the project, run:

```bash
php artisan october:migrate
```

Task 23 installs plugin version `v1.0.3` and creates the Contact Messages table.

### Task 23 Evidence

Screenshots are available in `screenshots/task-23/` and include plugin settings, public dynamic contact information, validation errors, successful AJAX submission, backend message management, permission configuration and restriction, and responsive mobile behavior.
## Task 24 - Dynamic Page Builder and Reusable Content Sections

Task 24 adds a database-backed Page Builder to the existing `Ziad.Services` plugin. Administrators can create public pages using approved reusable sections without writing page HTML manually.

### Dynamic Page Model

Each dynamic page stores:

- Page title.
- Unique URL slug.
- Status: Draft or Published.
- SEO title and description.
- Navigation visibility and order.
- Structured page sections.
- Created and updated timestamps.

### Page Builder Sections

The backend Page Builder uses a structured repeater with four approved section types:

- **Hero / Banner:** title, subtitle, background image, button label, and button URL.
- **Text Content:** heading and body content.
- **Image + Text:** heading, body, image, and image position.
- **Call to Action:** heading, supporting text, button label, and button URL.

Each section also includes an Active switch. Administrators can add, edit, reorder, disable, and remove sections.

### Theme Partial Mapping

Saved section types are rendered through reusable theme partials:

- `hero` maps to `partials/page-builder/hero.htm`
- `text_content` maps to `partials/page-builder/text-content.htm`
- `image_text` maps to `partials/page-builder/image-text.htm`
- `cta` maps to `partials/page-builder/cta.htm`

This keeps content separate from presentation and avoids duplicating page markup.

### Public Dynamic Route

Published pages are available through:

```text
/pages/:slug
```

Example URLs:

```text
/pages/cloud-solutions
/pages/digital-experience
```

Unknown slugs and Draft pages return a Not Found response.

### Dynamic Navigation and SEO

Published pages with **Show in Navigation** enabled are loaded dynamically into the main website navigation. Navigation order is controlled from the backend.

The public renderer uses the configured SEO title and SEO description. If the SEO title is empty, the normal page title is used as a fallback.

### Permission and Validation

The permission `ziad.services.manage_dynamic_pages` protects the Dynamic Pages backend controller and navigation item.

Validation requires a page title, unique slug, valid status, non-negative navigation order, and at least one approved section. Public output is escaped by Twig, media files use October CMS Media Manager paths, and CTA buttons accept internal website paths.

### Sample Pages

Two pages were created with different section combinations:

- **Cloud Solutions:** Hero, CTA, and Text Content.
- **Digital Experience:** Hero, Image + Text, Text Content, and CTA.

Section reordering, Draft behavior, unknown slugs, dynamic navigation, SEO metadata, desktop display, and mobile responsiveness were tested.

### Database Update

After pulling the project, run:

```bash
php artisan october:migrate
```

Task 24 installs plugin version `v1.0.4` and creates the Dynamic Pages table.

Reusable approved sections are safer and easier to maintain than unrestricted HTML because editors can manage content while the theme controls markup, layout, responsiveness, and visual consistency.

### Task 24 Evidence

Task 24 screenshots are stored in `screenshots/task-24/`.
