create table URL
(
    id       int auto_increment
        primary key,
    long_url text         not null,
    hash     varchar(255) not null,
    constraint URL_short_url_uindex
        unique (hash),
    constraint table_name_id_uindex
        unique (id)
);
