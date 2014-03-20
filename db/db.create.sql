-- Parse::SQL::Dia          version 0.27                              
-- Documentation            http://search.cpan.org/dist/Parse-Dia-SQL/
-- Environment              Perl 5.018001, /usr/bin/perl              
-- Architecture             x86_64-linux-gnu-thread-multi             
-- Target Database          mysql-innodb                              
-- Input file               db.dia                                    
-- Generated at             Wed Feb 26 15:58:06 2014                  
-- Typemap for mysql-innodb not found in input file                   

-- get_schema_create
create table user (
   uid       int          not null,
   name      varchar(30)          ,
   firstname varchar(30)          ,
   username  varchar(60)          ,
   passwd    varchar(256)         ,
   sesstoken varchar(60)          ,
   pushtoken varchar(60)          ,
   latitude  double               ,
   longitude double               ,
   constraint pk_user primary key (uid)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table friendlist (
   uid        int not null,
   friend_uid int not null,
   constraint pk_friendlist primary key (uid,friend_uid)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table employees (
   uid              int         not null,
   id_establishment int         not null,
   rights           int         not null,
   label            varchar(60) not null,
   constraint pk_employees primary key (uid,id_establishment)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table establishment_type (
   id_type_establishment int         not null,
   label_type            varchar(30)         ,
   constraint pk_establishment_type primary key (id_type_establishment)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table event (
   id_event         int          not null,
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
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table event_participation (
   id_participation int     not null,
   id_event         int             ,
   uid              int             ,
   yesnomaybe       tinyint         ,
   confirmed        boolean         ,
   constraint pk_event_participation primary key (id_participation)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table user_stats (
   id_stat_user int          not null,
   uid          int          not null,
   from_uid     int          not null,
   rating       tinyint      not null,
   comment      varchar(250) not null,
   constraint pk_user_stats primary key (id_stat_user)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table event_stats (
   id_stat_event int          not null,
   id_event      int                  ,
   from_uid      int                  ,
   rating        tinyint              ,
   comment       varchar(150)         ,
   constraint pk_event_stats primary key (id_stat_event)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table establishment_stats (
   id_stat_establishment int          not null,
   id_establishment      int                  ,
   from_uid              int                  ,
   rating                tinyint              ,
   comment               varchar(150)         ,
   constraint pk_establishment_stats primary key (id_stat_establishment)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table event_type (
   id_type_event int         not null,
   label_type    varchar(30)         ,
   constraint pk_event_type primary key (id_type_event)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table conversation (
   id_conversation int     not null,
   closed          boolean         ,
   constraint pk_conversation primary key (id_conversation)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table conversation_subscribe (
   id_conversation int not null,
   uid             int not null,
   constraint pk_conversation_subscribe primary key (id_conversation,uid)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table message (
   id_message      int           not null,
   id_conversation int                   ,
   from_uid        int                   ,
   message         varchar(4096)         ,
   constraint pk_message primary key (id_message)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table event_invite (
   id_event_invite int     not null,
   from_uid        int             ,
   to_uid          int             ,
   event_id        int             ,
   seen            boolean         ,
   constraint pk_event_invite primary key (id_event_invite)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table friend_invite (
   id_friend_invite int     not null,
   from_uid         int             ,
   to_uid           int             ,
   seen             boolean         ,
   constraint pk_friend_invite primary key (id_friend_invite)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- get_view_create

-- get_permissions_create

-- get_inserts

-- get_smallpackage_post_sql

-- get_associations_create
alter table user_stats add constraint user_stats_fk_Uid 
    foreign key (uid)
    references user (uid) ;
alter table employees add constraint employees_fk_Uid 
    foreign key (uid)
    references user (uid) ;
alter table employees add constraint employees_fk_Id_establishment 
    foreign key (id_establishment)
    references establishment (id_establishment) ;
alter table establishment add constraint establishment_fk_Id_type 
    foreign key (id_type)
    references establishment_type (id_type_establishment) ;
alter table establishment_stats add constraint estblshmnt_sts_fk_Id_stblshmnt 
    foreign key (id_establishment)
    references establishment (id_establishment) ;
alter table event add constraint event_fk_Id_type 
    foreign key (id_type)
    references event_type (id_type_event) ;
alter table event add constraint event_fk_Id_establishment 
    foreign key (id_establishment)
    references establishment (id_establishment) ;
alter table friendlist add constraint friendlist_fk_Friend_uid 
    foreign key (friend_uid)
    references user (uid) ;
alter table friend_invite add constraint friend_invite_fk_To_uid 
    foreign key (to_uid)
    references user (uid) ;
alter table event_invite add constraint event_invite_fk_To_uid 
    foreign key (to_uid)
    references user (uid) ;
alter table event_stats add constraint event_stats_fk_Id_event 
    foreign key (id_event)
    references event (id_event) ;
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
