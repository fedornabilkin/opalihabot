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

-- group
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

-- role
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

-- roleauth
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

-- roleuser
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

-- rolegroup
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

-- userstory
create table if not exists userstory
(
	id serial not null
		constraint userstory_pk
			primary key,
	userid integer
		constraint userstory_userid_user_id_fk
			references "user"
				on update cascade on delete cascade,
	text text,
	datetime timestamp default now()
);

alter table userstory
  owner to root;

-- notes
create table if not exists notes
(
	id serial not null
		constraint notes_pk
			primary key,
	text text,
	userid integer
		constraint notes_userid_user_id_fk
			references "user"
				on update cascade on delete cascade,
	status integer default 1
);

alter table notes owner to root;

create index if not exists notes_status__idx
	on notes (status);

-- notify
create table if not exists notify
(
	id serial not null
		constraint notify_pk
			primary key,
	notesid integer
		constraint notify_notesid_notes_id_fk
			references notes
				on update cascade on delete cascade,
	timecode integer,
	daycode integer,
	datecode integer
);

alter table notify
  owner to root;