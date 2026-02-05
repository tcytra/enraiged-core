# Enraiged Core Release Notes

2026-02-03 : 0.4.0-beta.10 (prerelease)  
Update: 

- Added Enraiged\Geo system for handling countries,regions,timeszones
- Corrected issue preventing protected administrator editing,updating
- Corrections,improvements to the User Roles enum
- Corrections,improvements to the Profile Salutations enum
- Improvements to the user context attributes
- Rebuild the user form template; Readded original sections
- Refactored Enraiged\NetworkAddresses namespace to Enraiged\Network

---

2026-01-30 : 0.4.0-beta.9 (prerelease)  
Update: Round of corrections, updates; Testing in hosting environment

- Added auth.providers.roles. config namespace for defining Roles
- Added users.timezone to the validation rules,model fillable
- Added verified_at to the IpAddress model fillable array
- Correct handling of the lowest role when seeding factory users
- Correct how model builder is called in the user index query()
- Correct issue identifying user myself in the validation rules
- Moved Roles enum into the Enraiged\Users\Roles namespace
- Resync enraiged-core publishable assets
- Temporarily remove user delete from UserInertiaResponse $actions
- Use correct ProvidesActions contract in core user tables

---

2025-10-27 : 0.4.0-beta.8 (prerelease)  
Update: Added forms,roles handling to the Enraiged User system

- Added role handling to the Enraiged User system
- Require enraiged-{forms,tables} from enraiged-core
- Resync enraiged-core publishable assets

---

2025-10-25 : 0.4.0-beta.7 (prerelease)  
Update: Added table,actions handling to the Enraiged User system

- Added Active,Deleted scopes to the Enraiged User model
- Added Enraiged Users Tables system
- Added Files relation to the User model
- Added User Actions Collection for templating actions
- Added UserInertiaResponse to provide inertia component handling
- Resync enraiged-core publishable assets
- Updated Users UserResource to provide more robust information

---

2025-10-18 : 0.4.0-beta.6 (prerelease)  
Update: Added User Profiles,Avatars,Files systems; Improved User handling

- Improved User Profile handling; Improved validation rules
- Ported original enraiged-laravel Profiles system into enraiged-core
- Updated the User system
  - Added Avatars morph (avatarable) relation to the User Profile
  - Added context attributes to the User model
  - Added UserFormResource for populating form data
  - Added User Policies
- Updated,verified package publishable assets

---

2025-11-12 : 0.4.0-beta.5 (prerelease)  
Update: Added theme column to the users database table

- Added 'theme' to the User::fillable
- Added UserObserver json encoding to the theme attribute when saving

---

2025-07-08 : 0.4.0-beta.4 (prerelease)  
Update: Improvements to the UserObserver::{saving,updated} handlers

- Ensure the email,secondary notifications are sent when user updated
- Ensure the verified_at dates are reset when necessary

---

2025-03-27 : 0.4.0-beta.3 (prerelease)  
Update: Added core structure for ip address tracking, notifications

- Added Enraiged\NetworkAddresses namespace
  - Added Enraiged\NetworkAddresses\Events\LoginAddress event
  - Added Enraiged\NetworkAddresses\Models\IpAddress model
- Added Enraiged\Users\Listeners\LoginAddressListener
  - Updated UserServiceProvider
- Added Enraiged\Users\Notifications\LoginAddressNotification
- Added User::notificationChannels method to return default channels
    - Updated all notifications to call User::notificationChannels()
- Updated User model; Added relation to IpAddress
- Updated publish directory with current auth,users systems

---

2025-03-26 : 0.4.0-beta.2 (prerelease)  
Update: Added verification requirement for secondary email address

- Added 'enraiged.auth.must_verify_secondary' config option
- Added 'enraiged.auth.reject_unverified_secondary' config option
- Added mail.auth templates for secondary address notifications
- Removed accidental duplicate views from the publish directory
- Updated language files as necessary

---

2025-03-23 : 0.4.0-beta.1 (prerelease)  
Update: Completed assembling initial enraiged-core library
