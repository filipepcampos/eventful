BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ; -- TODO: Check this

-- Delete ao utilizador
-- Coisas relacionadas:
--      - Report (author): eliminar talvez add um on delete cascade?
--      - Event (host): eliminar, talvez add um on delete cascade?
--      - User Report (target): eliminar 
--      x Rating: manter anónimo
--      x Comment (author): manter anónimo
--      x Unblock appeal: eliminar
--      x Event cancelled notification: eliminar
--      x Transaction: manter anónimo
--      x Request: eliminar
--      x Invite: manter anónimo se for inviter, eliminar se for invitee (?)s
--      x Vote: manter anónimo

DELETE FROM unblock_appeal WHERE id_user=$id;
DELETE FROM event_cancelled_notification WHERE id_user=$id;
DELETE FROM request WHERE id_requester=$id;
DELETE FROM invite WHERE id_invitee=$id;
UPDATE invite SET id_inviter=0 WHERE id_inviter=$id;
UPDATE transaction SET id_user=0 WHERE id_user=$id;
UPDATE vote SET id_user=0 WHERE id_user=$id;
UPDATE comment SET id_author=0 WHERE id_author=$id;
UPDATE rating SET id_reader=0 WHERE id_reader=$id;

DELETE FROM user_report WHERE id_report IN (SELECT id FROM report WHERE id_author=$id); -- TODO: Could this be more efficient?
DELETE FROM comment_report WHERE id_report IN (SELECT id FROM report WHERE id_author=$id);
DELETE FROM event_report WHERE id_report IN (SELECT id FROM report WHERE id_author=$id);
DELETE FROM report WHERE id_author=$id;

-- Dar delete reports a este user...
--DELETE FROM 

END TRANSACTION;