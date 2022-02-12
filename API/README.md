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
/api/books/?sort_on=column_name

6.2. descending order
/api/books/sort_on=column_name&desc=true

You can also use limit and offset with sorting and use all of these with other GET APIs

6. (POST method)Insert a book
   /api/books (with post request)

7. (PUT method)Update a Book information having id 'x'
   /api/books/x (with put request)

8. (DELETE method)Delete a Book information having id 'x'
   /api/books/x (with delete request)

9. Get Book Count
   /api/books/?count

10.1 GET book count for a specific category
/api/books/?count&category_id=x

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

## Borrow-API

1. (GET method)Get All borrow history
   /api/borrow

2. (GET method)Get a borrow history where book id is 'x' and user id is 'y'
   /api/borrow?book_id=x&user_id=y

3. (GET method)Get a borrow history where book id is 'x'
   /api/borrow?book_id=x

4. (GET method)Get a borrow history where user id is 'x'
   /api/borrow?user_id=x
5. (GET method)Get a borrow history where book title is 'x'(x could be a sub string)
   a./api/borrow?title=x
   b.with sort(ASC) by y column /api/borrow?title=x&sort=y
   c.with sort(DESC) by y column /api/borrow?title=x&sort=y&desc=1

6. (GET method)Get a borrow history where user name is 'x'(x could be a sub string)
   a./api/borrow?name=x
   b.with sort(ASC) by y column /api/borrow?name=x&sort=y
   c.with sort(DESC) by y column /api/borrow?name=x&sort=y&desc=1

7. (GET method)Get a borrow history where book title is 'x' and user name is 'y'
   /api/borrow?title=x&name=y
8. (GET method)Get a borrow history with limit 'x'
   /api/borrow?limit=x

9. (GET method)Get a borrow history with limit 'x' and offset 'y'
   /api/borrow?limit=x&offset=y
10. (GET method)Get a borrow history sorted(ASC) by any column name 'x'
    a. /api/borrow?sort=x
    b. with limit 'y' /api/borrow?sort=x&limit=y
    c. with limit 'y' and offset 'z' /api/borrow?sort=x&limit=y&offset=z

11. (GET method)Get a borrow history sorted(DESC) by any column name 'x'
    a. /api/borrow?sort=x&desc=1
    b. with limit 'y' /api/borrow?sort=x&limit=y&desc=1
    c. with limit 'y' and offset 'z' /api/borrow?sort=x&limit=y&offset=z$desc=1

12. (DELETE method)Delete a borrow history where book id is 'x' and user id is 'y'
    /api/borrow?book_id=x&user_id=y (with delete request)

13. (POST method) Create a borrow history
    /api/borrow

14. (PUT method) Send user_id and book_id using put method
    7.1. Update due date
    /api/borrow/?renew
    7.2. Update borrow status to returned (default status is borrowed) (status=0 means borrowed and status=1 means returned)
    /api/borrow/?return
