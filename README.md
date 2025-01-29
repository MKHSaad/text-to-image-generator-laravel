<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Set up
1. Controllers
    ApiController.php
     - Handles the API call to generate the image.
     - Stores the generated image in `storage/app/public/Assets`.
     - Passes the public URL of the stored image to the `display-image` view.

   ImageController.php
     - Handles the form submission and generates a prompt based on user input.
     - Redirects to the `ApiController` to trigger image generation.

   StorageController.php
     - Serves images stored in the `storage/app/public/Assets` directory via a route.

2. Blade View
   display-image.blade.php
     - Dynamically displays the image passed via `$imageUrl`.
     - Fallback message displays if no image URL is available.

3. Routes
   Routes correctly link to:
     - Generate the image (`/generate`).
     - Call the Stability API with the prompt (`/api/generate/{prompt}`).
     - Display the stored image (`/display-image`).
     - Serve the image from storage (`/storage/Assets/{filename}`).

4. File Storage
   - Images generated are saved in the `storage/app/public/Assets` directory.
   - Laravel's `asset()` function is used to generate the correct public URL for these images.


---

How It All Works Together

1. Step 1: Generate Prompt via Form
   - User fills out a form handled by `ImageController`.
   - `ImageController` creates the prompt and redirects to `/api/generate/{prompt}`.

2. Step 2: Generate Image via API
   - `ApiController` calls the Stability API, saves the generated image to `storage/app/public/Assets`, and redirects to `/display-image`.

3. Step 3: Display Image
   - The `display-image.blade.php` view receives the URL of the stored image and displays it.

4. Step 4: Serve Image
   - Images are served via the `/storage/Assets/{filename}` route, handled by `StorageController`.

---

Testing Checklist

Environment Configuration:
  - Ensure `.env` has the `STABILITY_API_URL` and `STABILITY_API_KEY` values.

Storage Link:
  - Run `php artisan storage:link` to ensure the `public/storage` symlink is created.

Test Form Submission:
  - Visit `/generate`, fill out the form, and submit it.
  - Confirm the image is generated, stored, and displayed on `/display-image`.

Direct Image Access:
  - Verify that accessing `/storage/Assets/{filename}` directly displays the image.



{For local host user}
Set up your host :
  - Verify that accessing `/storage/Assets/{filename}` directly displays the image.

