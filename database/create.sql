-----------------------------------------
-- Types
-----------------------------------------

CREATE TYPE votes AS ENUM ('Upvote', 'Downvote');

-----------------------------------------
-- Tables
-----------------------------------------

-- Note that a plural 'users' name was adopted because user is a reserved word in PostgreSQL.

CREATE TABLE administrator (
    id SERIAL PRIMARY KEY,
    username TEXT NOT NULL constraint administrator_username_uk UNIQUE KEY,
    password TEXT NOT NULL,
    last_login DATE NOT NULL DEFAULT GETDATE() constraint check_last_login CHECK last_login <= GETDATE()
);

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username TEXT NOT NULL constraint user_username_uk UNIQUE KEY,
    email TEXT NOT NULL constraint user_email_uk UNIQUE KEY constraint emailFormat CHECK (email LIKE “%@%.%”) 
    -- TODO
);

CREATE TABLE unblock_appeal (
    id_user FOREIGN KEY users,
    message TEXT NOT NULL
);

CREATE TABLE event (
   id SERIAL PRIMARY KEY,
   id_host SERIAL NOT NULL UNIQUE REFERENCES user(id), -- Add ON UPDATE / Stuff
   event_image TEXT NOT NULL, -- Maybe not null?
   description TEXT NOT NULL,
   location TEXT NOT NULL,
   --creation_date 
   --realization_date
   is_visible BOOLEAN NOT NULL,
   is_acessible BOOLEAN NOT NULL,
   capacity INT NOT NULL CHECK capacity > 0,
   price DECIMAL NOT NULL CHECK price >= 0,-- TODO: I'm not sure of the format to use
);

CREATE TABLE tag (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL constraint name_uk UNIQUE KEY
);

CREATE TABLE post (
    id SERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    creation_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL constraint date_check CHECK creation_date <= now(),
    id_event INTEGER NOT NULL REFERENCES event(id) ON UPDATE CASCADE
);

CREATE TABLE poll (
    id_post SERIAL FOREIGN KEY post
);

CREATE TABLE option (
    id SERIAL PRIMARY KEY,
    id_poll SERIAL FOREIGN KEY poll NOT NULL
    text TEXT NOT NULL,
    votes INTEGER NOT NULL constraint check_votes CHECK votes >= 0
);

CREATE TABLE comment (
    id SERIAL PRIMARY KEY,
    id_author INTEGER NOT NULL REFERENCES user(id) ON UPDATE CASCADE,
    id_event INTEGER NOT NULL REFERENCES event(id) ON UPDATE CASCADE,
    text TEXT NOT NULL,
    creation_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL constraint date_check CHECK creation_date <= now()
);

CREATE TABLE rating (
    id_comment SERIAL FOREIGN KEY comment,
    id_reader SERIAL FOREIGN KEY user,
    vote ENUM votes NOT NULL constraint check_vote CHECK vote IN votes
    PRIMARY KEY(id_comment, id_reader)
); 

CREATE TABLE file (
    id_comment SERIAL PRIMARY KEY FOREIGN KEY comment,
    path TEXT NOT NULL constraint path_uk UNIQUE KEY
);

CREATE TABLE inquiry (
    id SERIAL PRIMARY KEY,
    id_event INTEGER NOT NULL REFERENCES event(id) ON UPDATE CASCADE,
    creation_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL constraint date_check CHECK creation_date <= now()
    accepted BOOLEAN NOT NULL DEFAULT 0
);

CREATE TABLE request (
    id 
);

CREATE TABLE invite (

);

CREATE TABLE report (

);

CREATE TABLE user_report (

);

CREATE TABLE transaction (
    
);

CREATE TABLE event_cancelled_notification (
    
);

CREATE TABLE event_cancelled_notification_user (

);

CREATE TABLE attendee (

);

CREATE TABLE vote (

);

CREATE TABLE tag_event (
    
);