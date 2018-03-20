readme

Introduction
What does your API do?

GET -http://localhost:8000/api/authors
Shows all authors details from authors table

GET - http://localhost:8000/api/authors/id
Params 
    -id int
Displays details of all authors with a particular ID

POST - http://localhost:8000/api/authors/create
Params 
   email_address string
   first_name string
   last_name  string
Creates new authors in the database

DELETE -http://localhost:8000/api/authors/delete/id
Params 
   id int

PUT -http://localhost:8000/api/authors/update/id
Params
   id int
updates magazines

POST http://localhost:8000/api/authors/readCSV
Params
   file type file(.csv)
Accepts file.csv as regioj params File type(.csv) mandatory fields in file email_address,first_namelast_name

-------magazines
GET - http://localhost:8000/api/magazines
-Shows all magazines in the database

GET - http://localhost:8000/api/magazines/id
Params
   id int
Shows magazines with a particuler ID.

POST - http://localhost:8000/magazines/create
Params 
   title  string
   ISBN_number  interger
   author  string
   publication_date  datetime
-Creates new magazine.

DELETE -http://localhost:8000/api/magazines/delete/id
Params 
   id int

PUT - http://localhost:8000/api/magazines/update
params 
   id integer
   column  string
-Updates magazine details.
Database columns (title,ISBN_number,author,publication_date)


GET - http://localhost:8000/api/magazines/search/isbn/sort
Params
   isbn - integer (isbn_number)
   sort - string (either by title,authorisbn_number or publication_date)
-Gets all magazines with a particular isbn sorted by either title,ISBN_number,author or publication date

GET - http://localhost:8000/api/magazines/searchauthor
Params
   name - integer (isbn_number)
   sort - string (either by title,author,isbn_number)
-Gets all magazines with a particular name sorted by either title,ISBN_number,author


POST -http://localhost:8000/api/magazines/readCSV
Recieces a CSV file and extracts data into database params
Params
   file
file type .csv The file should have fields title, ISBN_number, author, publication_date

------books
DELETE -http://localhost:8000/api/books/delete/id
Params 
   id int

PUT - http://localhost:8000/api/books/update
params 
   id integer
   column  string
-Updates magazine details.
Database columns (title,ISBN_number,author,description)


POST -http://localhost:8000/api/books/create_bk
Params
   titlesome
   ISBN_number
   author
   description 

GET - http://localhost:8000/api/books/searchauthor
Params
   name - integer (isbn-number)
   sort - string (either by title,author,isbn_number)
-Gets all books with a particular name sorted by either title,ISBN_number,author


GET - http://localhost:8000/api/books/search/isbn/sort
Params
   isbn - integer (isbn-number)
   sort - string (either by title,authorisbn_number)
-Gets all magazines with a particular ID which can be sorted by either title,ISBN_number,author


POST -http://localhost:8000/api/books/readCSV
Recieces a CSV file and extracts data into database params
Params
   file
file type .csv The file should have fields title, ISBN_number, author, description


