###LaraBlog a Vue SPA + Laravel Blog
By: Karthik Sekar

####Instructions to run the app
 1. Run the ``./start-app.sh`` command to pull docker images and to get the containers up and running.
 2. Run ``./init-app.sh``. I modified the command to run the migrations, seeders and to create passport keys etc.
 3. Once the scripts are run, app is accessible on ``localhost:8080``
 
###User flow
Visitors can't read posts, you need to signup as a user to read posts.<br>
Only admin users can perform CRUD operation on posts. I have already seeded an admin user.<br>

><b>Admin Credentials</b><br>
> Email: admin@figured.com<br>
> Password: secret

Use the above credentials to login as admin to perform CRUD.

####Highlights
1. Vue is used as a SPA and Laravel as an API backend
2. I've tried to follow SOLID principles as much as I can to separate concerns through contracts<br>
and inject dependencies.
3. Usage of Services and Repositories.
4. Vuex used for better state management on client side.

####Things to improve.
 1. Overall UX of the application can be improved.
 2. Specifically I can add client side validations <br>
 and add user feedback upon form submissions through success/failure toasts or Sweetalert.
 3. I have written Feature tests to test the ACL for posts, I should further unit test the services.
 
