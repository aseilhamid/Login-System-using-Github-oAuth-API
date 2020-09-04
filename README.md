# Login-System-using-Github-oAuth-API
Create a login system using GitHub OAuth API, so users can login to your system without completed registration. So all you have to do is to find a way to integrate your system with GitHub using PHP and you have to store the user’s profile data to MySQL database.
- System should have login page contains login with email/username and password and register with GitHub option only.
- No registration form are required.
- Once user click on GitHub register icon system should redirect him to GitHub OAuth once the user finish he will redirect back to your system to choose a password for your system.
- You have to store user GitHub profile data and the password he chose to your MySQL database so next time he can login with email/username (GitHub) and the password.
- On successful login user should redirect to the home page contains Hello {username}
- Use session or cookies.
- Create a logout action through a button.
-----------------------------------------------------------------------------------------------------------------------------
Local setup:
- localhost : ex:XAMPP
- connection database:
  - $server = "localhost"
  - $username = "root"
  - $password = ""
  - $db = "task5db"
  
Creating oAuth App (https://docs.github.com/en/developers/apps/creating-an-oauth-app)
Authorizing oAuth App (https://docs.github.com/en/developers/apps/authorizing-oauth-apps)
