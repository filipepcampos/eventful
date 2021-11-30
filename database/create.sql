SET search_path TO lbaw2122;

-----------------------------------------
-- Drop Tables and Types
----------------------------------------- 

DROP TABLE IF EXISTS tag_event;
DROP TABLE IF EXISTS vote;
DROP TABLE IF EXISTS attendee;
DROP TABLE IF EXISTS event_cancelled_notification_user;
DROP TABLE IF EXISTS event_cancelled_notification;
DROP TABLE IF EXISTS transaction;
DROP TABLE IF EXISTS event_report;
DROP TABLE IF EXISTS comment_report;
DROP TABLE IF EXISTS user_report;
DROP TABLE IF EXISTS report;
DROP TABLE IF EXISTS file;
DROP TABLE IF EXISTS rating;
DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS option;
DROP TABLE IF EXISTS poll;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS invite;
DROP TABLE IF EXISTS request;
DROP TABLE IF EXISTS event;
DROP TABLE IF EXISTS unblock_appeal;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS administrator;

-----------------------------------------
-- Types
-----------------------------------------

DROP TYPE IF EXISTS comment_rating CASCADE;
CREATE TYPE comment_rating AS ENUM ('Upvote', 'Downvote');

-----------------------------------------
-- Tables
-----------------------------------------

-- Note that a plural 'users' name was adopted because user is a reserved word in PostgreSQL.

CREATE TABLE administrator (
    id SERIAL PRIMARY KEY,
    username TEXT NOT NULL CONSTRAINT administrator_username_uk UNIQUE,
    password TEXT NOT NULL,
    last_login TIMESTAMP NOT NULL DEFAULT NOW() CONSTRAINT administrator_last_login_check CHECK (last_login <= NOW())
);

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username TEXT NOT NULL CONSTRAINT user_username_uk UNIQUE,
    email TEXT NOT NULL CONSTRAINT user_email_uk UNIQUE CONSTRAINT user_email_check CHECK (email LIKE '%@%.%'),
    password TEXT NOT NULL,
    name TEXT NOT NULL,
    profile_pic TEXT,
    account_creation_date TIMESTAMP NOT NULL DEFAULT NOW() CONSTRAINT user_account_creation_date_check CHECK (account_creation_date <= NOW()),
    birthdate DATE NOT NULL,
    description TEXT,
    block_motive TEXT,
    CONSTRAINT user_birthdate_check CHECK (birthdate <= account_creation_date)
);

CREATE TABLE unblock_appeal (
    id_user SERIAL PRIMARY KEY REFERENCES users ON UPDATE CASCADE,
    message TEXT NOT NULL
);

CREATE TABLE event (
   id SERIAL PRIMARY KEY,
   id_host INTEGER NOT NULL REFERENCES users ON UPDATE CASCADE,
   title TEXT NOT NULL,
   event_image TEXT NOT NULL,
   description TEXT NOT NULL,
   location TEXT NOT NULL,
   creation_date TIMESTAMP NOT NULL DEFAULT NOW() CONSTRAINT event_creation_date_check CHECK (creation_date <= NOW()),
   realization_date TIMESTAMP NOT NULL,
   is_visible BOOLEAN NOT NULL,
   is_accessible BOOLEAN NOT NULL,
   capacity INT NOT NULL CHECK (capacity > 0),
   price DECIMAL(2) NOT NULL CHECK (price >= 0),
   number_attendees INT NOT NULL DEFAULT 0 CONSTRAINT event_number_attendees CHECK (number_attendees >= 0 AND number_attendees <= capacity),
   CONSTRAINT check_realization_date CHECK (creation_date < realization_date)
);

CREATE TABLE tag (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL CONSTRAINT tag_name_uk UNIQUE
);

CREATE TABLE post (
    id SERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    creation_date TIMESTAMP NOT NULL DEFAULT NOW() CONSTRAINT post_creation_date_check CHECK (creation_date <= NOW()),
    id_event INTEGER NOT NULL REFERENCES event ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE poll (
    id_post INTEGER PRIMARY KEY REFERENCES post ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE option (
    id SERIAL PRIMARY KEY,
    id_poll INTEGER NOT NULL REFERENCES poll ON UPDATE CASCADE ON DELETE CASCADE,
    description TEXT NOT NULL,
    votes INTEGER NOT NULL DEFAULT 0 CONSTRAINT option_votes_check CHECK (votes >= 0)
);

CREATE TABLE comment (
    id SERIAL PRIMARY KEY,
    id_author INTEGER REFERENCES users ON UPDATE CASCADE,
    id_event INTEGER NOT NULL REFERENCES event ON UPDATE CASCADE ON DELETE CASCADE,
    content TEXT NOT NULL,
    number_upvotes INTEGER NOT NULL DEFAULT 0 CONSTRAINT comment_number_upvotes CHECK (number_upvotes >= 0),
    number_downvotes INTEGER NOT NULL DEFAULT 0 CONSTRAINT comment_number_downvotes CHECK (number_downvotes >= 0),
    creation_date TIMESTAMP NOT NULL DEFAULT NOW() CONSTRAINT comment_creation_date_check CHECK (creation_date <= NOW())
);

CREATE TABLE rating (
    id_comment INTEGER REFERENCES comment ON UPDATE CASCADE,
    id_reader INTEGER REFERENCES users ON UPDATE CASCADE,
    vote comment_rating NOT NULL,
    PRIMARY KEY (id_comment, id_reader)
);

CREATE TABLE file (
    id_comment INTEGER PRIMARY KEY REFERENCES comment ON UPDATE CASCADE ON DELETE CASCADE,
    path TEXT NOT NULL CONSTRAINT file_path_uk UNIQUE
);

CREATE TABLE request (
    id SERIAL PRIMARY KEY,
    id_event INTEGER NOT NULL REFERENCES event ON UPDATE CASCADE ON DELETE CASCADE,
    date TIMESTAMP NOT NULL DEFAULT NOW() CONSTRAINT request_date_check CHECK (date <= NOW()),
    accepted BOOLEAN NOT NULL DEFAULT false,
    id_requester INTEGER NOT NULL REFERENCES users ON UPDATE CASCADE
);

CREATE TABLE invite (
    id SERIAL PRIMARY KEY,
    id_event INTEGER NOT NULL REFERENCES event ON UPDATE CASCADE ON DELETE CASCADE,
    date TIMESTAMP NOT NULL DEFAULT NOW() CONSTRAINT invite_date_check CHECK (date <= NOW()),
    accepted BOOLEAN NOT NULL DEFAULT false,
    id_inviter INTEGER NOT NULL REFERENCES users ON UPDATE CASCADE,
    id_invitee INTEGER NOT NULL REFERENCES users ON UPDATE CASCADE,
    CONSTRAINT invite_invitter_invitee_id_check CHECK (id_inviter <> id_invitee)
);

CREATE TABLE report (
    id SERIAL PRIMARY KEY,
    id_author INTEGER NOT NULL REFERENCES users ON UPDATE CASCADE,
    report_date TIMESTAMP NOT NULL DEFAULT NOW() CONSTRAINT report_date_check CHECK (report_date <= NOW()),
    motive TEXT NOT NULL,
    dismissal_date TIMESTAMP CONSTRAINT report_dismissal_date_check1 CHECK (dismissal_date <= NOW()),
    CONSTRAINT report_dismissal_date_check2 CHECK (dismissal_date IS NULL OR (dismissal_date >= report_date AND dismissal_date <= NOW()))
);

CREATE TABLE user_report (
    id_report INTEGER PRIMARY KEY REFERENCES report ON UPDATE CASCADE,
    target INTEGER NOT NULL REFERENCES users ON UPDATE CASCADE
);

CREATE TABLE comment_report (
    id_report INTEGER PRIMARY KEY REFERENCES report,
    target INTEGER NOT NULL REFERENCES comment ON UPDATE CASCADE
);

CREATE TABLE event_report (
    id_report INTEGER PRIMARY KEY REFERENCES report ON UPDATE CASCADE,
    target INTEGER NOT NULL REFERENCES event ON UPDATE CASCADE
);

CREATE TABLE transaction (
    id SERIAL PRIMARY KEY,
    id_user INTEGER NOT NULL REFERENCES users ON UPDATE CASCADE,
    amount DECIMAL(2) NOT NULL CONSTRAINT transaction_amount_check CHECK(amount > 0),
    date TIMESTAMP NOT NULL DEFAULT NOW() CONSTRAINT transaction_date_check CHECK (date <= NOW())
);

CREATE TABLE event_cancelled_notification (
    id SERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    notification_date TIMESTAMP NOT NULL DEFAULT NOW() CONSTRAINT event_cancelled_notification_check CHECK (notification_date <= NOW())
);

CREATE TABLE attendee (
    id_user INTEGER REFERENCES users ON UPDATE CASCADE,
    id_event INTEGER REFERENCES event ON UPDATE CASCADE,
    PRIMARY KEY (id_user, id_event)
);

CREATE TABLE vote (
    id_user INTEGER REFERENCES users,
    id_option INTEGER REFERENCES option ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (id_user, id_option)
);

CREATE TABLE event_cancelled_notification_user (
    id_notification INTEGER REFERENCES event_cancelled_notification ON UPDATE CASCADE ON DELETE CASCADE,
    id_user INTEGER REFERENCES users ON UPDATE CASCADE,
    PRIMARY KEY (id_notification, id_user)
);

CREATE TABLE tag_event (
    id_tag INTEGER REFERENCES tag ON UPDATE CASCADE,
    id_event INTEGER REFERENCES event ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (id_tag, id_event)
);