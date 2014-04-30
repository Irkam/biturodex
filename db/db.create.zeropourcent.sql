-- Parse::SQL::Dia          version 0.23                              
-- Documentation            http://search.cpan.org/dist/Parse-Dia-SQL/
-- Environment              Perl 5.016001, perl.exe                   
-- Architecture             MSWin32-x86-multi-thread                  
-- Target Database          mysql-innodb                              
-- Input file               db.zeropourcent.dia                       
-- Generated at             Tue Apr 29 03:37:21 2014                  
-- Typemap for mysql-innodb not found in input file                   

-- get_permissions_drop 

-- get_view_drop

-- get_schema_drop
drop table if exists user;
drop table if exists establishment;
drop table if exists employees;
drop table if exists establishment_type;
drop table if exists event;
drop table if exists event_participation;
drop table if exists event_type;
drop table if exists conversation;
drop table if exists conversation_subscribe;
drop table if exists message;
drop table if exists event_wall;
drop table if exists user_options;

-- get_smallpackage_pre_sql 

-- get_schema_create
create table user (
   uid         int          not null,
   name        varchar(30)          ,
   firstname   varchar(30)          ,
   username    varchar(60)          ,
   mailaddress varchar(64)          ,
   passwd      varchar(256)         ,
   sesstoken   varchar(60)          ,
   pushtoken   varchar(60)          ,
   latitude    double               ,
   longitude   double               ,
   constraint pk_user primary key (uid)
)   ENGINE=InnoDB DEFAULT CHARSET=latin1;
create table establishment (
   id_establishment int         not null,
   id_type          int                 ,
   name             varchar(60)         ,
   address0         varchar(60)         ,
   address2         varchar(60)         ,
   city             varchar(30)         ,
   postcode         varchar(6)          ,
   latitude         double              ,
   longitude        double              ,
   constraint pk_establishment primary key (id_establishment)
)   ENGINE=InnoDB DEFAULT CHARSET=latin1;
create table employees (
   uid              int         not null,
   id_establishment int         not null,
   rights           int         not null,
   label            varchar(60) not null,
   constraint pk_employees primary key (uid,id_establishment)
)   ENGINE=InnoDB DEFAULT CHARSET=latin1;
create table establishment_type (
   id_type_establishment int         not null,
   label_type            varchar(30)         ,
   constraint pk_establishment_type primary key (id_type_establishment)
)   ENGINE=InnoDB DEFAULT CHARSET=latin1;
create table event (
   id_event         int          not null,
   name             varchar(64)          ,
   owner_uid        int          not null,
   id_establishment int                  ,
   latitude         double               ,
   longitude        double               ,
   radius           int                  ,
   begins           datetime             ,
   ends             datetime             ,
   id_type          int                  ,
   address          varchar(250)         ,
   constraint pk_event primary key (id_event)
)   ENGINE=InnoDB DEFAULT CHARSET=latin1;
create table event_participation (
   id_participation int     not null,
   id_event         int             ,
   uid              int             ,
   yesnomaybe       tinyint         ,
   confirmed        boolean         ,
   constraint pk_event_participation primary key (id_participation)
)   ENGINE=InnoDB DEFAULT CHARSET=latin1;
create table event_type (
   id_type_event int         not null,
   label_type    varchar(30)         ,
   constraint pk_event_type primary key (id_type_event)
)   ENGINE=InnoDB DEFAULT CHARSET=latin1;
create table conversation (
   id_conversation int     not null,
   closed          boolean         ,
   constraint pk_conversation primary key (id_conversation)
)   ENGINE=InnoDB DEFAULT CHARSET=latin1;
create table conversation_subscribe (
   id_conversation int not null,
   uid             int not null,
   constraint pk_conversation_subscribe primary key (id_conversation,uid)
)   ENGINE=InnoDB DEFAULT CHARSET=latin1;
create table message (
   id_message      int           not null,
   id_conversation int                   ,
   from_uid        int                   ,
   message         varchar(4096)         ,
   constraint pk_message primary key (id_message)
)   ENGINE=InnoDB DEFAULT CHARSET=latin1;
create table event_wall (
   id_wall_post int           not null,
   id_event     int           not null,
   op_uid       int           not null,--  OP IS A FAG
   message      varchar(4096) not null,
   constraint pk_event_wall primary key (id_wall_post)
)   ENGINE=InnoDB DEFAULT CHARSET=latin1;
create table user_options (
   id_option    int          not null,
   uid          int                  ,
   option_name  varchar(128)         ,
   option_value varchar(128)         ,
   constraint pk_user_options primary key (id_option)
)   ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- get_view_create

-- get_permissions_create

-- get_inserts

-- get_smallpackage_post_sql

-- get_associations_create
alter table employees add constraint employees_fk_Uid 
    foreign key (uid)
    references user (uid) ;
alter table employees add constraint employees_fk_Id_establishment 
    foreign key (id_establishment)
    references establishment (id_establishment) ;
alter table establishment add constraint establishment_fk_Id_type 
    foreign key (id_type)
    references establishment_type (id_type_establishment) ;
alter table event add constraint event_fk_Id_type 
    foreign key (id_type)
    references event_type (id_type_event) ;
alter table event add constraint event_fk_Id_establishment 
    foreign key (id_establishment)
    references establishment (id_establishment) ;
alter table event_participation add constraint evnt_prtcptn_fk_Id_event 
    foreign key (id_event)
    references event (id_event) ;
alter table event_participation add constraint event_participation_fk_Uid 
    foreign key (uid)
    references user (uid) ;
alter table message add constraint message_fk_From_uid 
    foreign key (from_uid)
    references user (uid) ;
alter table message add constraint message_fk_Id_conversation 
    foreign key (id_conversation)
    references conversation (id_conversation) ;
alter table conversation_subscribe add constraint cnvrstn_sbscrb_fk_Id_cnvrstn 
    foreign key (id_conversation)
    references conversation (id_conversation) ;
alter table conversation_subscribe add constraint conversation_subscribe_fk_Uid 
    foreign key (uid)
    references user (uid) ;
alter table event_wall add constraint event_wall_fk_Op_uid 
    foreign key (op_uid)
    references user (uid) ;
alter table event_wall add constraint event_wall_fk_Id_event 
    foreign key (id_event)
    references event (id_event) ;
alter table user_options add constraint user_options_fk_Uid 
    foreign key (uid)
    references user (uid) ;
alter table event add constraint event_fk_Owner_uid 
    foreign key (owner_uid)
    references user (uid) ;
