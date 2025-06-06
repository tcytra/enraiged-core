# Release Notes

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
