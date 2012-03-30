#Instructions for setting up pagoda deploy

##1) Configure Environment variables
Environment variables are set up on pagodabox.com in the admin panel.  These include DB1_HOST, DB1_USER, etc.etc.  These values are taken from the db admin panel on pagodahost

##2) Read DB Configuration
Modify CI db config to use **$_SERVER['DB1_HOST']** instead of the *raw* username, password, hostname etc.

##3) Deploy to Pagoda
Use 
> git push pagoda master

to push the current revision to pagoda.  wait for it to build

##4) Tunnel into pagoda
Navigate to the repo root in terminal.  Type
> pagoda tunnel -c db1 

(where *db1* is the component name specified in the boxfile).  Take a note of the connection information provided here (host and port)

##5) Open mysql CLI
Enter user pass, host, port.  You can select the DB by typing 
> connect grades 127.0.0.1

Then you can run your fixtures import by typing
> source /var/www/grades/pagoda/db_fixtures.sql
