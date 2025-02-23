use php_project2;
alter table blogs_comments
add column posting_date TIMESTAMP default CURRENT_TIMESTAMP();