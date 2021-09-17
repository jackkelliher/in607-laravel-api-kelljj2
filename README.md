Larvel Api Project

Link to heroku site: http://in607-laravel-api-kelljj2.herokuapp.com
Postman Documentation: https://documenter.getpostman.com/view/16919242/U16qHNcw

To access the api, add /api to the end of the url. Make sure to also add /v1 after this to use the latest api verison. Add any single one of these extensions to this depending on your request:

/(table) - Substitute (table) for the table you would like to interact with. Used to store(post) and show(get) a table.
    /(table)/(id) - Substitute (id) for the id of an entry on the (table) table. Used to update(put), read a single entry(get) and delete(delete) a table entry

/register - Used to register a user, check postman documentation for more information.

/login - Used to log in a registered user.

/logout - Used to log out a user that is currently logged in.

----------------------------------------------------

To launch the application in development mode, update the .env file contained in the project with your own local server and url (Often 127.0.0.1:8000 if using 'php artisan serve'). Migrate the models using 'php artisan migrate' and seed with json data by using 'php artisan db:seed'.
