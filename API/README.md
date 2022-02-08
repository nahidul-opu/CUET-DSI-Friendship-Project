## Book-API

1. (GET method)Get All Book information
   /api/books

2. (GET method)Get a Book information having id 'x'
   /api/books/x

3. (GET method)Get a Book's specific column informations having id 'x'
   /api/books/x/?columns=column1,column2.....

4. (GET method)Get information according to search (suppose user typed 'keyword' in search box)

4.1. specify column, value ( to match exact with operator =)
/api/books/?column=column_name&value=keyword

4.2. specify column, value ( to match with 'LIKE')
/api/books/?column=column_name&value=keyword&like=true

4.3. search on all over the table
/api/books/?value=keyword

4.4. search category wise with another column
/api/books/?category_id=?&column=?&value=?

5. (GET method) Get a specific number of rows from book

5.1. specify limit only
/api/books/?limit=10

5.1. specify limit and offset (offset means get rows after offset number)
/api/books/?limit=10&offset=5

6. (GET method) Get sorted data on a specific column

6.1. ascending order
/api/books/?sort&column=column_name

6.2. descending order
/api/books/sort&column=column_name&desc=true

6.3. You can also use limit and offset with sorting

6. (POST method)Insert a book
   /api/books (with post request)

7. (PUT method)Update a Book information having id 'x'
   /api/books/x (with put request)

8. (DELETE method)Delete a Book information having id 'x'
   /api/books/x (with delete request)

## Category-API

1. (GET method)Get All Category information
   /api/category

2. (GET method)Get a Category information having id 'x'
   /api/category/x

3. (POST method)Insert a Category
   /api/category (with post request)

4. (PUT method)Update a Category information having id 'x'
   /api/category/x (with put request)

5. (DELETE method)Delete a Category information having id 'x'
   /api/category/x (with delete request)

## User-API

1. (GET method)Get All User information
   /api/users

2. (GET method)Get a User information having id 'x'
   /api/users/x

3. (POST method)Insert a User
   /api/users (with post request)

4. (PUT method)Update a User information having id 'x'
   /api/users/x (with put request)

5. (DELETE method)Delete a User information having id 'x'
   /api/users/x (with delete request)
