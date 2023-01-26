#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
CREATE TABLE authors (
   author_id serial primary key,
   author_name varchar(200) not null
);

CREATE TABLE books (
   book_id varchar(100) primary key,
   book_name varchar(200) not null,
   book_author INT not null,
   foreign key (book_author)
   	references authors (author_id)
);
COMMIT;
EOSQL