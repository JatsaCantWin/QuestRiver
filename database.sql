create table "Roles"
(
    "Role_ID"  serial
        constraint roles_pk
            primary key,
    "RoleName" varchar not null
);

create table "Users"
(
    "User_ID"  serial
        constraint users_pk
            primary key,
    "Email"    varchar(255)      not null,
    "Password" varchar(255)      not null,
    "Username" varchar(255)      not null,
    "Role_ID"  integer default 1 not null
        constraint users_roles_role_id_fk
            references "Roles"
            on update cascade
);

create unique index users_email_uindex
    on "Users" ("Email");

create unique index users_id_uindex
    on "Users" ("User_ID");

create table "Sessions"
(
    session_id          uuid      default gen_random_uuid()                          not null
        constraint sessions_pk
            primary key,
    "User_ID"           integer                                                      not null
        constraint sessions_users_user_id_fk
            references "Users"
            on update cascade on delete cascade,
    "CreationTimestamp" timestamp default CURRENT_TIMESTAMP                          not null,
    "ExpiryTimestamp"   timestamp default (CURRENT_TIMESTAMP + '01:00:00'::interval) not null
);

create unique index sessions_session_id_uindex
    on "Sessions" (session_id);

create unique index sessions_user_id_uindex
    on "Sessions" ("User_ID");

create table "User_Stats"
(
    "Stat_ID"           serial
        constraint user_stats_pk
            primary key,
    "User_ID"           integer             not null
        constraint user_stats_users_user_id_fk
            references "Users"
            on update cascade on delete cascade,
    "Strength"          integer default 1   not null,
    "Dexterity"         integer default 1   not null,
    "Constitution"      integer default 1   not null,
    "Intelligence"      integer default 1   not null,
    "Wisdom"            integer default 1   not null,
    "Charisma"          integer default 1   not null,
    "Health"            integer default 100 not null,
    "Magic"             integer default 100 not null,
    "Stamina"           integer default 100 not null,
    "XP"                integer default 0   not null,
    "Gold"              integer default 0   not null,
    "Bills"             integer default 0   not null,
    "Gems"              integer default 0   not null,
    "Level"             integer default 1   not null,
    "AttributeUpgrades" integer default 0
);

create unique index user_stats_stat_id_uindex
    on "User_Stats" ("Stat_ID");

create unique index user_stats_user_id_uindex
    on "User_Stats" ("User_ID");

create table "Users_Skills"
(
    "Skill_ID"      serial
        constraint users_skills_pk
            primary key,
    "User_ID"       integer                             not null
        constraint users_skills_users_user_id_fk
            references "Users"
            on update cascade on delete cascade,
    "SkillName"     varchar(255)                        not null,
    "LastPracticed" timestamp default CURRENT_TIMESTAMP not null
);

create unique index users_skills_skill_id_uindex
    on "Users_Skills" ("Skill_ID");

create unique index users_skills_user_id_skillname_uindex
    on "Users_Skills" ("User_ID", "SkillName");

create table "Users_Quests"
(
    "Quest_ID"  serial
        constraint users_quests_pk
            primary key,
    "User_ID"   integer               not null
        constraint users_quests_users_user_id_fk
            references "Users"
            on update cascade on delete cascade,
    "QuestName" varchar               not null,
    "Finished"  boolean default false not null,
    constraint users_quests_pk_2
        unique ("User_ID", "QuestName")
);

create unique index users_quests_quest_id_uindex
    on "Users_Quests" ("Quest_ID");

create table "Users_Friends"
(
    "ID_Relationship" serial
        constraint users_friends_pk
            primary key,
    "ID_First_User"   integer not null
        constraint users_friends_users_user_id_fk
            references "Users"
            on update cascade on delete cascade,
    "ID_Second_User"  integer not null
        constraint users_friends_users_user_id_fk_2
            references "Users",
    constraint users_friends_pk_2
        unique ("ID_First_User", "ID_Second_User")
);

create unique index users_friends_id_relationship_uindex
    on "Users_Friends" ("ID_Relationship");

create unique index roles_role_id_uindex
    on "Roles" ("Role_ID");

create unique index roles_name_uindex
    on "Roles" ("RoleName");

create function getuserbysessionid(sessionid uuid) returns integer
    language plpgsql
as
$$
begin
    IF ((NOT EXISTS(SELECT 1 FROM "Sessions" WHERE "session_id" = sessionid)) OR ((SELECT "ExpiryTimestamp" FROM "Sessions" WHERE "session_id" = sessionid) < current_timestamp)) THEN
        RETURN NULL;
    end if;

    UPDATE "Sessions" SET "ExpiryTimestamp" = CURRENT_TIMESTAMP + interval '1 hour' WHERE "session_id" = sessionID;
    RETURN (SELECT "Users"."User_ID" from "Users" INNER JOIN "Sessions" on "Users"."User_ID" = "Sessions"."User_ID" WHERE "session_id" = sessionID);
end;
$$;

create function startsession(email character varying) returns uuid
    language plpgsql
as
$$
DECLARE
    userID int;
begin
    SELECT "User_ID" INTO userID FROM "Users" WHERE "Email" = email;
    IF (userID is NULL) THEN
        RETURN NULL;
    end if;

    DELETE FROM "Sessions" WHERE ("User_ID") = userID;
    INSERT INTO "Sessions" ("User_ID") VALUES (userID);
    RETURN(
    SELECT "session_id" FROM "Sessions" WHERE "User_ID" = userID
    );
end;
$$;

create function "trigger_addUserStats"() returns trigger
    language plpgsql
as
$$
BEGIN
    INSERT INTO "User_Stats" ("User_ID") VALUES (new."User_ID");
    RETURN NEW;
END;
$$;

create trigger "Users_AFTER_INSERT_addUserStats"
    after insert
    on "Users"
    for each row
execute procedure "trigger_addUserStats"();

create function trigger_levelup() returns trigger
    language plpgsql
as
$$
begin
    IF NEW."XP" > 100 THEN
        NEW."XP" = NEW."XP" - 100;
        NEW."Level" = NEW."Level" + 1;
        NEW."AttributeUpgrades" = NEW."AttributeUpgrades" + 1;
    end if;
    RETURN NEW;
end;
$$;

create trigger user_stats_before_update_levelup
    before update
    on "User_Stats"
    for each row
execute procedure trigger_levelup();

create procedure advattribute(attributename character varying, email character varying)
    language plpgsql
as
$$
DECLARE updateAttribute TEXT := FORMAT('UPDATE "User_Stats" SET "%1$s" = "%1$s" + 1 FROM "Users"
        WHERE "Users"."User_ID" = "User_Stats"."User_ID" AND "Users"."Email" = ''%2$s'';', attributename, email);
begin
    IF (SELECT "AttributeUpgrades" FROM "User_Stats" INNER JOIN "Users" ON "Users"."User_ID" = "User_Stats"."User_ID"
    WHERE "Email" = email) < 0 THEN
        RETURN;
    end if;
    EXECUTE updateAttribute;
    UPDATE "User_Stats" SET "AttributeUpgrades" = "AttributeUpgrades" - 1 FROM "Users"
    WHERE "Users"."User_ID" = "User_Stats"."User_ID" AND "Users"."Email" = email;
end;
$$;

create procedure finishquest(questname character varying, email character varying)
    language plpgsql
as
$$
begin
    IF (SELECT "Finished" FROM "Users_Quests" INNER JOIN "Users" ON "Users"."User_ID" = "Users_Quests"."User_ID"
    WHERE "Email" = email AND "QuestName" = questname) = true THEN
        RETURN;
    end if;
    UPDATE "Users_Quests" SET "Finished" = true FROM "Users"
    WHERE "Users"."User_ID" = "Users_Quests"."User_ID" AND "Users"."Email" = email AND "QuestName" = questname;
    UPDATE "User_Stats" SET "XP" = "XP" + 50 FROM "Users"
    WHERE "Users"."User_ID" = "User_Stats"."User_ID" AND
            "Email" = email;
end;
$$;

create procedure dailyjob()
    language plpgsql
as
$$
DECLARE
    unfinishedquest RECORD;
begin
    FOR unfinishedquest IN
        SELECT * FROM "Users_Quests" WHERE "Finished" = FALSE
    LOOP
        UPDATE "User_Stats" SET "Health" = "Health" - 2 WHERE "User_ID" = unfinishedquest."User_ID";
    end loop;

    UPDATE "Users_Quests" SET "Finished" = False;
    UPDATE "User_Stats" SET "Level" = "Level" - 1 WHere "Health" < 0;
    UPDATE "User_Stats" SET "AttributeUpgrades" = "AttributeUpgrades" - 1 WHERE "Health" < 0;
    UPDATE "User_Stats" SET "Health" = 100 WHERE "Health" < 0;
end;
$$;


