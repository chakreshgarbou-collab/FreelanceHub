FREELANCEHUB - PROFILE MANAGEMENT MODULE
========================================

Author : Subratty Iba Tazeema
Branch : feat/profile-management


1. WHAT THIS MODULE DOES
------------------------
- Client profile      : create, edit and view a client profile
                        (industry, current job, bio, address, currently hiring)
- Freelancer profile  : create, edit and view a freelancer profile
                        (professional title, bio, skills, location, hourly rate, availability)
- Public profiles     : anyone can view a freelancer or client profile
                        (a client's address is never shown publicly)
- Dashboards          : a freelancer dashboard (with profile strength %) and a client dashboard


2. FILES I CREATED OR CHANGED
-----------------------------
Database
  database/migrations/..._create_client_profiles_table.php
  database/migrations/..._create_freelancer_profiles_table.php

Models
  app/Models/ClientProfile.php
  app/Models/FreelancerProfile.php
  app/Models/User.php                     (added clientProfile() and freelancerProfile())

Validation (server side)
  app/Http/Requests/UpdateClientProfileRequest.php
  app/Http/Requests/UpdateFreelancerProfileRequest.php

Controllers
  app/Http/Controllers/ClientProfileController.php
  app/Http/Controllers/FreelancerProfileController.php
  app/Http/Controllers/ClientDashboardController.php
  app/Http/Controllers/FreelancerDashboardController.php

Middleware
  app/Http/Middleware/NoIndex.php         (hides private pages from search engines)

Views
  resources/views/layouts/app.blade.php   (shared layout and navbar)
  resources/views/profiles/client-edit.blade.php
  resources/views/profiles/client-show.blade.php
  resources/views/profiles/freelancer-edit.blade.php
  resources/views/profiles/freelancer-show.blade.php
  resources/views/dashboards/client.blade.php
  resources/views/dashboards/freelancer.blade.php

Styles and other
  public/css/freelancehub.css             (shared stylesheet: colours, fonts, components)
  public/robots.txt                       (asks search engines to skip private pages)
  routes/web.php                          (routes for this module)


3. ROUTES
---------
Public (no login needed)
  GET  /freelancers/{id}           View a freelancer's public profile
  GET  /clients/{id}               View a client's public profile

Private (login required, hidden from search engines)
  GET  /dashboard                  Sends the user to the correct dashboard
  GET  /freelancer/dashboard       Freelancer dashboard
  GET  /client/dashboard           Client dashboard
  GET  /freelancer/profile/edit    Edit own freelancer profile
  PUT  /freelancer/profile         Save own freelancer profile
  GET  /client/profile/edit        Edit own client profile
  PUT  /client/profile             Save own client profile


4. DATABASE DESIGN
------------------
- USER (1) -> (0..1) CLIENT_PROFILE
- USER (1) -> (0..1) FREELANCER_PROFILE
- user_id is a foreign key AND unique, so a user can have at most one
  profile of each type. This is enforced by the database.
- cascadeOnDelete: deleting a user also deletes their profiles.
- hourly_rate uses decimal(8, 2) so money is stored exactly.


5. SECURITY
-----------
Client side
- HTML5 validation (required, maxlength, min, max) on every form
- Skill tags are created with textContent (not innerHTML) to prevent XSS
- @csrf on every form to prevent cross-site request forgery

Server side
- Form Requests validate every field again on the server
- The profile is always taken from the logged-in user, never from an ID in
  the URL, so users can only edit their own profile (OWASP: broken
  object-level authorization)
- $fillable on the models blocks mass assignment
- Blade {{ }} escapes all output
- Private pages: auth middleware + NoIndex middleware (X-Robots-Tag header)
  + meta robots tag + robots.txt
- Public profiles are left indexable on purpose so clients can find freelancers


6. HOW TO RUN
-------------
1. git checkout feat/profile-management
2. composer install
3. php artisan migrate
4. Open the site (php artisan serve, or Laravel Herd)
