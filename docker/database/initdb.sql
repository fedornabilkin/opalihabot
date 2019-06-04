create table "user"
(
  id       serial not null
    constraint user_pk
    primary key,
  chatid   integer,
  email    varchar(100),
  auth     varchar(150),
  username varchar(50),
  fullname varchar(150)
);

alter table "user"
  owner to root;

create table "group"
(
  id     integer default nextval('user_id_seq' :: regclass) not null
    constraint group_pkey
    primary key,
  chatid integer,
  title  varchar(100)
);

alter table "group"
  owner to root;

create table role
(
  id   serial not null
    constraint role_pk
    primary key,
  role varchar(100)
);

INSERT  INTO role (id, role) VALUES (3, 'Admin'), (2, 'Moderator'), (1, 'User');

alter table role
  owner to root;

create table roleauth
(
  id     serial not null
    constraint roleauth_pk
    primary key,
  roleid integer
    constraint roleauth_role_fk
    references role
    on update cascade on delete cascade,
  auth   varchar(50)
);

alter table roleauth
  owner to root;

create table roleuser
(
  id     serial not null
    constraint roleuser_pk
    primary key,
  roleid integer
    constraint role_role_fk
    references role
    on update cascade on delete cascade,
  userid integer
    constraint role_user_fk
    references "user"
    on update cascade on delete cascade
);

alter table roleuser
  owner to root;

create table rolegroup
(
  id      integer default nextval('roleuser_id_seq' :: regclass) not null
    constraint rolegroup_pkey
    primary key,
  roleid  integer,
  groupid integer
);

alter table rolegroup
  owner to root;

create table userstory
(
  id       serial not null
    constraint userstory_pk
    primary key,
  userid   integer,
  text     text,
  datetime timestamp default now()
);

alter table userstory
  owner to root;

