
Authentication: Basic Authencation (username,password)

Credentials:
   Admin: username = name
	  password = password
   Client: username = user
           password = pass
		   
Using Postman: Under Authorization choose under Type Basic Auth and add credentials

Permission:
    Admin: create
	       update
		   delete

	Client: read
	        read_all


Usage:


Points---------------------------------------------------------------------------------------------------------------------------------------------------------------------------

Method      |   Route                                                     | Params                      |   Action/Response
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
GET	        |  http://localhost/newroutesapi/api/point/read.php           | NONE              		    | List of all points
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
POST        |  http://localhost/newroutesapi/api/point/create.php         | {"name":"x"}                | Creates point x
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
PUT         |  http://localhost/newroutesapi/api/point/update.php         | {"id":27,"name":"v"}        | Updates the point name that corresponds to the id with new inputed name
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
DELETE      |  http://localhost/newroutesapi/api/point/delete.php         | {"name":"v"}                | Deletes the point equal to name param                                  
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


Routes---------------------------------------------------------------------------------------------------------------------------------------------------------------------------

Method      |   Route                                                     | Params                                                         |   Action/Response
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
GET         |  http://localhost/newroutesapi/api/route/read_all.php       | NONE                                                           |  List of all routes
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
POST        |  http://localhost/newroutesapi/api/route/create.php         | {"from_point":"e","to_point":"i","time":"20","cost":"45"}      |  Creates route from point 'e' to 
																	                                                                           point 'i' with time equal to '20' 
																																			   and cost equal to '45'
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
PUT         |  http://localhost/newroutesapi/api/route/update.php         | {"from_point":"e","to_point":"i","time":45,"cost":60}          |  Updates the from 'e' to 'i' route's 
																	                                                                          time to 45 and cost to 60
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
DELETE      |  http://localhost/newroutesapi/api/route/delete.php         | {"from_point":"e","to_point":"i"}                              |  Deletes the 'e' to 'i' route
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
GET         |  http://localhost/newroutesapi/api/route/getBestRoute.php   | ?origin=a&destination=g (add this to the url)                  |  Returns the best route for a to g 
																		                                                                      with time and cost
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


User---------(for admin access only)---------------------------------------------------------------------------------------------------------------------------------------------

Method      |   Route                                                     | Params                                                          |   Action/Response
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
GET         |  http://localhost/newroutesapi/api/user/read.php            | NONE                                                            | Returns List of users
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
POST        |  http://localhost/newroutesapi/api/user/create.php          | {"name":"user","password":"pass","role":"client"}               | Creates a user with user as name and
                                                                                                                                              pass as password with client role
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
PUT         |  http://localhost/newroutesapi/api/user/update.php          | {"id":3,"name":"newuser","password":"newpass","role":"client"}  | Updates the user corresponds to the
                                                                                                                                              with new name,password, and role
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
DELETE      |  http://localhost/newroutesapi/api/user/delete.php          | {"id":3}                                                        | Deletes the user that corresponds 
																	                                                                          to the id
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
