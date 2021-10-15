# trestle-backend
## Code Output
![alt text](https://github.com/GentleHome/trestle-backend-Google-Classroom-API-PHP/blob/master/output.JPG)
## Video Output
- https://www.youtube.com/watch?v=3pfZLs-4cNw
## Prerequisites 
### 1. Create a project on Google Console
- Go to https://console.cloud.google.com
- On the left side click the dropdown
- And select new project
- Fill up the fields and click create
### 2. Enable the API
- Navigate to hamburger menu, hover to API's and Services and select LIBRARY
- Search for Google Classroom API
- Select Enable
### 3. Create a OAuth Credential
- click CREATE CREDENTIALS
- Select OAuth Client ID choose application type (in our case Web application)
- On Authorized redirect URIs put the URI your localhost uses that you will be using to call the api
- Example: http://localhost/trestle-backend/index.php
### 4. Set up OAuth consent screen
- Navigate to OAuth consent screen
- Choose internal
- Fill up the required fields
### 5. We need a composer
- Get composer https://getcomposer.org/download/
### 6. Excecute this on your terminal to put the Google Api Client Library in the folder you're working on. This will create composer.json and composer.lock files
     composer require google/apiclient:^2.11
## FAQ:
### Where to get 'client_secret.json'?
- if you navigate back to creating the OAuth credential, you can download the file there.
### Why am i getting 'Authorization error'?
- The User type is internal which means only those who are in the same organization can access it
- To change User Type navigate back to OAuth consent screen
- Under the User type choose MAKE EXTERNAL
- Choose testing and confirm
- On Test users add the emails you will use for testing your app.
### Why cant i get/access the data from objects but i can see it when i var_dump()?
- The email you're trying to access the data from is managed by an organization and restricted the data access see https://support.google.com/edu/classroom/answer/6250906?hl=en
- Organizations do this to protect their materials.

## Remember:
- Run the program with xampp/wampp started

## References:
- https://github.com/googleapis/google-api-php-client/blob/master/docs/oauth-web.md
- https://developers.google.com/classroom/quickstart/php
- https://developers.google.com/resources/api-libraries/documentation/classroom/v1/php/latest/
