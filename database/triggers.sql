SET search_path TO lbaw2122;

-- =========================================== TRIGGER01 ===========================================

DROP TRIGGER IF EXISTS event_attendee_dif_host ON attendee;
DROP FUNCTION IF EXISTS event_attendee_dif_host;
CREATE FUNCTION event_attendee_dif_host() RETURNS TRIGGER AS 
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM event WHERE NEW.id_event = event.id AND NEW.id_user = event.id_host) THEN
        RAISE EXCEPTION 'The user you''re trying to add to attendees is the event host';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER event_attendee_dif_host
    BEFORE INSERT OR UPDATE ON attendee
    FOR EACH ROW
    EXECUTE PROCEDURE event_attendee_dif_host();

-- =========================================== TRIGGER02 ===========================================

DROP TRIGGER IF EXISTS event_request ON request;
DROP FUNCTION IF EXISTS event_request;
CREATE FUNCTION event_request() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM event WHERE (event.id=NEW.id_event AND is_accessible)) THEN
        RAISE EXCEPTION 'Cannot send request to an accessible event';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER event_request
    BEFORE INSERT OR UPDATE ON request
    FOR EACH ROW
    EXECUTE PROCEDURE event_request();

-- =========================================== TRIGGER03 ===========================================

DROP TRIGGER IF EXISTS user_report_trigger ON user_report;
DROP FUNCTION IF EXISTS user_report;
CREATE FUNCTION user_report() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM report WHERE (id=NEW.id_report AND id_author=NEW.target)) THEN
        RAISE EXCEPTION 'Users can not report themselves.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER user_report_trigger
    BEFORE INSERT OR UPDATE ON user_report
    FOR EACH ROW
    EXECUTE PROCEDURE user_report();

-- =========================================== TRIGGER04 ===========================================

DROP TRIGGER IF EXISTS comment_report_trigger ON comment_report;
DROP FUNCTION IF EXISTS comment_report;
CREATE FUNCTION comment_report() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT * FROM comment
            WHERE (comment.id=NEW.target AND comment.id_author
                IN (SELECT id_author FROM report WHERE id=NEW.id_report))        
    ) THEN
        RAISE EXCEPTION 'Users can not report their own comment.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER comment_report_trigger
    BEFORE INSERT OR UPDATE ON comment_report
    FOR EACH ROW
    EXECUTE PROCEDURE comment_report();

-- =========================================== TRIGGER05 ===========================================

DROP TRIGGER IF EXISTS event_report_trigger ON event_report;
DROP FUNCTION IF EXISTS event_report;
CREATE FUNCTION event_report() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT * FROM event 
            WHERE (event.id=NEW.target AND event.id_host 
                IN (SELECT id_author FROM report WHERE id=NEW.id_report))        
    ) THEN
        RAISE EXCEPTION 'Users can not report their own event.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER event_report_trigger
    BEFORE INSERT OR UPDATE ON event_report
    FOR EACH ROW
    EXECUTE PROCEDURE event_report();

-- =========================================== TRIGGER06 ===========================================

DROP TRIGGER IF EXISTS host_invite ON invite;
DROP FUNCTION IF EXISTS host_invite;
CREATE FUNCTION host_invite() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM event WHERE (NEW.id_event = id AND NEW.id_invitee = id_host))
        THEN
            RAISE EXCEPTION 'Host cannot be invited to his own event.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER host_invite
    BEFORE INSERT OR UPDATE ON invite
    FOR EACH ROW
    EXECUTE PROCEDURE host_invite();

-- =========================================== TRIGGER07 ===========================================

DROP TRIGGER IF EXISTS vote_increase ON vote;
DROP FUNCTION IF EXISTS vote_increase;
CREATE FUNCTION vote_increase() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE option SET votes = votes + 1 WHERE NEW.id_option = option.id;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER vote_increase
    AFTER INSERT ON vote
    FOR EACH ROW
    EXECUTE PROCEDURE vote_increase();

-- =========================================== TRIGGER08 ===========================================

DROP TRIGGER IF EXISTS user_report_disjoint ON user_report;
DROP FUNCTION IF EXISTS user_report_disjoint;
CREATE FUNCTION user_report_disjoint() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT id_report FROM comment_report WHERE id_report = NEW.id_report
        UNION
        SELECT id_report FROM event_report WHERE id_report = NEW.id_report)
        THEN
            RAISE EXCEPTION 'A report cannot have multiple types';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER user_report_disjoint
    BEFORE INSERT OR UPDATE ON user_report
    FOR EACH ROW
    EXECUTE PROCEDURE user_report_disjoint();
    
-- =========================================== TRIGGER09 ===========================================

DROP TRIGGER IF EXISTS comment_report_disjoint ON comment_report;
DROP FUNCTION IF EXISTS comment_report_disjoint;
CREATE FUNCTION comment_report_disjoint() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT id_report FROM user_report WHERE id_report=NEW.id_report
        UNION
        SELECT id_report from event_report WHERE id_report=NEW.id_report)
        THEN
            RAISE EXCEPTION 'A report cannot have multiple types';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER comment_report_disjoint
    BEFORE INSERT OR UPDATE ON comment_report
    FOR EACH ROW
    EXECUTE PROCEDURE comment_report_disjoint();

-- =========================================== TRIGGER10 ===========================================

DROP TRIGGER IF EXISTS event_report_disjoint ON event_report;
DROP FUNCTION IF EXISTS event_report_disjoint;
CREATE FUNCTION event_report_disjoint() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT id_report FROM comment_report WHERE id_report=NEW.id_report
        UNION 
        SELECT id_report FROM user_report WHERE id_report=NEW.id_report)
        THEN
            RAISE EXCEPTION 'A report cannot have multiple types';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER event_report_disjoint
    BEFORE INSERT OR UPDATE ON event_report
    FOR EACH ROW
    EXECUTE PROCEDURE event_report_disjoint();

-- =========================================== TRIGGER11 ===========================================

DROP TRIGGER IF EXISTS comment_author_belongs_to_event ON comment;
DROP FUNCTION IF EXISTS comment_author_belongs_to_event;
CREATE FUNCTION comment_author_belongs_to_event() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.id_author = 0 -- Anonymous user
    THEN
        RETURN NEW;
    END IF;
    IF
        EXISTS (SELECT * FROM event WHERE id_host=NEW.id_author AND id=NEW.id_event) 
        OR 
        EXISTS (SELECT * FROM attendee WHERE id_user=NEW.id_author AND id_event=NEW.id_event)
        THEN
            RETURN NEW;
    END IF;
    RAISE EXCEPTION 'Comment author must be a part of the event the comment belongs to';
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER comment_author_belongs_to_event
    BEFORE INSERT OR UPDATE ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE comment_author_belongs_to_event();

-- =========================================== TRIGGER12 ===========================================

DROP TRIGGER IF EXISTS comment_reader_belongs_to_event ON rating;
DROP FUNCTION IF EXISTS comment_reader_belongs_to_event;
CREATE FUNCTION comment_reader_belongs_to_event() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.id_reader = 0 -- Anonymous user
    THEN
        RETURN NEW;
    END IF;
    IF 
        EXISTS (SELECT * FROM ((SELECT id_event FROM comment WHERE id = NEW.id_comment) AS event_comment JOIN event ON (id_event=event.id)) WHERE id_host=NEW.id_reader)
        OR
        EXISTS (SELECT * FROM ((SELECT id_event FROM comment WHERE id = NEW.id_comment) AS event_comment JOIN attendee ON (event_comment.id_event=attendee.id_event)) WHERE id_user=NEW.id_reader)
        THEN
            RETURN NEW;
    END IF;
    RAISE EXCEPTION 'Comment reader must be a part of the event the comment belongs to';
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER comment_reader_belongs_to_event
    BEFORE INSERT OR UPDATE ON rating
    FOR EACH ROW
    EXECUTE PROCEDURE comment_reader_belongs_to_event();

-- =========================================== TRIGGER13 ===========================================

DROP TRIGGER IF EXISTS attendee_cannot_send_request ON request;
DROP FUNCTION IF EXISTS attendee_cannot_send_request;
CREATE FUNCTION attendee_cannot_send_request() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM attendee WHERE attendee.id_user = NEW.id_requester AND attendee.id_event = NEW.id_event)
        THEN RAISE EXCEPTION 'Attendee can''t send request to join the event';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER attendee_cannot_send_request
    BEFORE INSERT OR UPDATE ON request
    FOR EACH ROW
    EXECUTE PROCEDURE attendee_cannot_send_request();

-- =========================================== TRIGGER14 ===========================================

DROP TRIGGER IF EXISTS vote_made_by_attendee ON vote;
DROP FUNCTION IF EXISTS vote_made_by_attendee;
CREATE FUNCTION vote_made_by_attendee() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.id_user = 0 -- Anonymous user
    THEN
        RETURN NEW;
    END IF;
    IF
        NEW.id_user IN (
            SELECT id_user FROM attendee WHERE id_event IN (
                SELECT post.id_event FROM
                    post 
                    JOIN 
                    (SELECT * FROM option WHERE (id=NEW.id_option)) AS opt
                    ON (opt.id_poll = post.id)
            )
        )
        THEN
            RETURN NEW;
    END IF;
    RAISE EXCEPTION 'Vote wasn''t made by an event attendee';
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER vote_made_by_attendee
    BEFORE INSERT OR UPDATE ON vote
    FOR EACH ROW
    EXECUTE PROCEDURE vote_made_by_attendee();

-- =========================================== TRIGGER15 ===========================================

DROP TRIGGER IF EXISTS attendees_vote_once ON vote;
DROP FUNCTION IF EXISTS attendees_vote_once;
CREATE FUNCTION attendees_vote_once() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM poll, option, vote WHERE poll.id_post = option.id_poll AND option.id = vote.id_option AND NEW.id_user = vote.id_user)
    THEN RAISE EXCEPTION 'An attendee can''t vote twice in the same poll';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER attendees_vote_once
    BEFORE INSERT ON vote
    FOR EACH ROW
    EXECUTE PROCEDURE attendees_vote_once();

-- =========================================== TRIGGER16 ===========================================

DROP TRIGGER IF EXISTS cant_invite_attendee ON invite;
DROP FUNCTION IF EXISTS cant_invite_attendee;
CREATE FUNCTION cant_invite_attendee() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT * FROM attendee WHERE (id_event=NEW.id_event AND id_user=NEW.id_invitee)
    )
    THEN
        RAISE EXCEPTION 'An user cannot be invited to an event he''s already attending';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER cant_invite_attendee
    BEFORE INSERT OR UPDATE ON invite
    FOR EACH ROW
    EXECUTE PROCEDURE cant_invite_attendee();

-- =========================================== TRIGGER17 ===========================================

DROP TRIGGER IF EXISTS increment_number_attendees ON attendee;
DROP FUNCTION IF EXISTS increment_number_attendees;
CREATE FUNCTION increment_number_attendees() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE event SET number_attendees = number_attendees + 1 WHERE NEW.id_event = event.id;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER increment_number_attendees
    BEFORE INSERT ON attendee
    FOR EACH ROW
    EXECUTE PROCEDURE increment_number_attendees();

-- =========================================== TRIGGER18 ===========================================

DROP TRIGGER IF EXISTS decrement_number_attendees ON attendee;
DROP FUNCTION IF EXISTS decrement_number_attendees;
CREATE FUNCTION decrement_number_attendees() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE event SET number_attendees = number_attendees - 1 WHERE OLD.id_event = event.id;
    RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER decrement_number_attendees
    AFTER DELETE ON attendee
    FOR EACH ROW
    EXECUTE PROCEDURE decrement_number_attendees();

-- =========================================== TRIGGER19 ===========================================

DROP TRIGGER IF EXISTS increment_number_upvotes ON rating;
DROP FUNCTION IF EXISTS increment_number_upvotes;
CREATE FUNCTION increment_number_upvotes() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE comment SET number_upvotes = number_upvotes + 1 WHERE NEW.id_comment = comment.id;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER increment_number_upvotes
    BEFORE INSERT ON rating
    FOR EACH ROW
    EXECUTE PROCEDURE increment_number_upvotes();

-- =========================================== TRIGGER20 ===========================================

DROP TRIGGER IF EXISTS increment_number_downvotes ON rating;
DROP FUNCTION IF EXISTS increment_number_downvotes;
CREATE FUNCTION increment_number_downvotes() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE comment SET number_downvotes = number_downvotes + 1 WHERE NEW.id_comment = comment.id;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER increment_number_downvotes
    BEFORE INSERT ON rating
    FOR EACH ROW
    EXECUTE PROCEDURE increment_number_downvotes();

-- =========================================== TRIGGER21 ===========================================

DROP TRIGGER IF EXISTS decrement_number_upvotes ON rating;
DROP FUNCTION IF EXISTS decrement_number_upvotes;
CREATE FUNCTION decrement_number_upvotes() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE comment SET number_upvotes = number_upvotes - 1 WHERE OLD.id_comment = comment.id;
    RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER decrement_number_upvotes
    AFTER DELETE ON rating
    FOR EACH ROW
    EXECUTE PROCEDURE decrement_number_upvotes();

-- =========================================== TRIGGER22 ===========================================

DROP TRIGGER IF EXISTS decrement_number_downvotes ON rating;
DROP FUNCTION IF EXISTS decrement_number_downvotes;
CREATE FUNCTION decrement_number_downvotes() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE comment SET number_downvotes = number_downvotes - 1 WHERE OLD.id_comment = comment.id;
    RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER decrement_number_downvotes
    AFTER DELETE ON rating
    FOR EACH ROW
    EXECUTE PROCEDURE decrement_number_downvotes();