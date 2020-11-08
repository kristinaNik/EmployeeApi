#Employee' Api

###Installation steps:  
 - Run `composer install`
 - copy .env.local file and add .env file
 - Add `DATABASE_URL` in .env for connecting to your database
 - Run `bin/console migrations:migrate`
 - Run `bin/console debug:router` to see the api routes
 

###API Endpoints

  -  `{hostname}/api/save/employees` - Consume API data and save the list to the database
  -  `{hostname}/api/employees` method `GET` - Get all employees
  -  `{hostname}/api/employees/{id}` method `GET` - Show employee by id    
  -  `{hostname}/api/employees` method `POST` - Create a new employee

   Param Body:
    
        {
            "company": "Company Name",
            "bio": "Lorem Ipsum",
            "name": "Some Name",
            "title": "Some Title",
            "avatar": "http://test.png"
        }        
        
  -  `{hostname}/api/employees/{id}`  method `PUT` - Update an employee
 
   Param Body:

         {
             "company": "Company Name",
             "bio": "Lorem Ipsum",
             "name": "Some Name",
             "title": "Some Title",
             "avatar": "http://test.png"
         }
         
   - `{hostname}/api/employees/{id}`  method `DELETE` - Delete an employee
 