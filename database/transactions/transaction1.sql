BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;

-- Remove unblock_appeals
DELETE FROM unblock_appeal WHERE id_user=$id;

-- Remove pending event_cancelled_notifications
DELETE FROM event_cancelled_notification_user WHERE id_user=$id;

-- Remove pending requests
DELETE FROM request WHERE id_requester=$id;

-- Remove pending invites (where the user is the invitee)
DELETE FROM invite WHERE id_invitee=$id;

-- Update user to anonymous in invites where the user is the inviter
UPDATE invite SET id_inviter=0 WHERE id_inviter=$id;

-- Update user to anonymous in transactions so that the data is kept in the database
UPDATE transaction SET id_user=0 WHERE id_user=$id;

-- Update user to anonymous in votes
UPDATE vote SET id_user=0 WHERE id_user=$id;

-- Update user to anonymous in comments
UPDATE comment SET id_author=0 WHERE id_author=$id;

-- Update user to anonymous in ratings
UPDATE rating SET id_reader=0 WHERE id_reader=$id;

-- Removing all the reports authored by the user, as well as the reports where the user is the target 
DELETE FROM user_report WHERE id_report IN (SELECT id FROM report WHERE id_author=$id) OR target=$id;
DELETE FROM comment_report WHERE id_report IN (SELECT id FROM report WHERE id_author=$id);
DELETE FROM event_report WHERE id_report IN (SELECT id FROM report WHERE id_author=$id);
DELETE FROM report WHERE id_author=$id;
DELETE FROM report WHERE id NOT IN (SELECT id_report FROM user_report UNION SELECT id_report FROM comment_report UNION SELECT id_report FROM event_report);

-- Removing the events hosted by the user, comments, ratings, posts, polls, options and votes will be removed as well (ON DELETE CASCADE)
DELETE FROM event WHERE id_host=$id;

-- Removing all the attendee status of the user
DELETE FROM attendee WHERE id_user=$id;

-- Remove the user
DELETE FROM users WHERE id=$id;

END TRANSACTION;