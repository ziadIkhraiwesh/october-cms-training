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
