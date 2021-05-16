# camagru
## Instagram like web application to share your photos.

Hive Helsinki Web Branch project where we allow users to see others images and share their own ones if they are logged in.
Frontend can be done with HTML/CSS/JS(vanilla) and backend has to be done with PHP. CSS is result of my own google, trial and error process,
although it is allowed to use bootstrap etc for the looks.

I'm using MVC Framework that I learned from Youtube tutorial since MVC or some other structuring framework was suggested (not mandatory).
Also MySQL queries had to be done with PDO, and safety had to be taken care of so that users can't inject SQL or send malicious javascript etc.

### TODO's

* User Regsitration and Login system
  * :heavy_check_mark: Register with email verification
  * :heavy_check_mark: Login
  * :heavy_check_mark: Logout
  * :x: Recover forgotten password
* Post images
  * :heavy_check_mark: Upload new gif, png, jpg, jpeg or bmp
  * :heavy_check_mark: Preview image before uploading
  * :heavy_check_mark: Display image on home page
  * :heavy_check_mark: Dispkay image on uploaders profile
  * :bangbang: Add Stickers (Currently on work)
  * :x: Take images with webcam
* Comment system
  * :heavy_check_mark: Add comment to photo
  * :x: Send email notification to pictures uploader
  * :heavy_check_mark: Display comments
  * :x: Remove comments from own pictures
* Likes
  * :x: Like images
  * :heavy_check_mark: Display likes
* User Settings
  * :heavy_check_mark: Change email/username/password
  * :x: Change profile picture and description
  * :x: Disable notifications
  * :x: Remove own images
* Miscallenious
  * :x: Create Database and tables if doesn't exist (yeah simple, but haven't done it yet:)
  * :x: Search users with username
  * :x: Ajaxify
