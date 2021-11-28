SET search_path TO lbaw2122;

-- ===== TRIGGER01 =====
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

-- ===== TRIGGER02 =====
DROP TRIGGER IF EXISTS event_request ON request;
DROP FUNCTION IF EXISTS event_request;
CREATE FUNCTION event_request() RETURNS TRIGGER AS
$BODY$
BEGIN
        --IF EXISTS (SELECT * FROM (NEW LEFT JOIN event ON (id_event = id)) WHERE is_visible AND NOT is_acessible) THEN -- TODO:What if isn't visible and not acessible? I think whe should only check NOT is_acessible
        --   RAISE EXCEPTION 'TODO: ERROR MESSAGE';
        --END IF;
        --RETURN NEW;
        IF EXISTS (SELECT * FROM event WHERE (event.id=NEW.id_event AND is_acessible)) THEN -- TODO: Proposed change
           RAISE EXCEPTION 'Cannot send request to an acessible event';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER event_request
    BEFORE INSERT OR UPDATE ON request
    FOR EACH ROW
    EXECUTE PROCEDURE event_request();

-- ===== TRIGGER03 =====
DROP TRIGGER IF EXISTS user_report_trigger ON user_report;
DROP FUNCTION IF EXISTS user_report;
CREATE FUNCTION user_report() RETURNS TRIGGER AS
$BODY$
BEGIN
    --IF EXISTS (SELECT * FROM (NEW LEFT JOIN report ON (user_report = id)) WHERE id_author = target) THEN
    --    RAISE EXCEPTION 'Users can not report themselves.';
    --END IF;
    --RETURN NEW;
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

-- ===== TRIGGER04 =====
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

-- -- ===== TRIGGER05 =====
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

-- ===== TRIGGER06 =====
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