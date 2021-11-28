SET search_path TO lbaw2122;

-- ===== TRIGGER01 =====
DROP TRIGGER IF EXISTS event_attendee_dif_host ON attendee;
DROP FUNCTION IF EXISTS event_attendee_dif_host;
CREATE FUNCTION event_attendee_dif_host() RETURNS TRIGGER AS $$
BEGIN
    IF EXISTS (SELECT * FROM event WHERE NEW.id_event = event.id AND NEW.id_user = event.id_host) THEN
        RAISE EXCEPTION 'The user you''re trying to add to attendees is the event host';
    END IF;
    RETURN NEW;
END
$$
LANGUAGE plpgsql;

CREATE TRIGGER event_attendee_dif_host
    BEFORE INSERT OR UPDATE ON attendee
    FOR EACH ROW
    EXECUTE PROCEDURE event_attendee_dif_host();

-- ===== TRIGGER02 =====
DROP TRIGGER IF EXISTS event_request ON request;
DROP FUNCTION IF EXISTS event_request;
CREATE FUNCTION event_request() RETURNS TRIGGER AS $$
BEGIN
        IF EXISTS (SELECT * FROM (OLD LEFT JOIN event ON (id_event = id)) WHERE is_visible AND NOT is_acessible) THEN
           RAISE EXCEPTION 'TODO: ERROR MESSAGE';
        END IF;
        RETURN NEW;
END
$$
LANGUAGE plpgsql;

CREATE TRIGGER event_request
        BEFORE INSERT OR UPDATE ON request
        FOR EACH ROW
        EXECUTE PROCEDURE event_request();

-- ===== TRIGGER03 =====
DROP TRIGGER IF EXISTS user_report_trigger ON user_report;
DROP FUNCTION IF EXISTS user_report;
CREATE FUNCTION user_report() RETURNS TRIGGER AS $$
BEGIN
    IF EXISTS (SELECT * FROM (OLD LEFT JOIN report ON (user_report = id)) WHERE id_author = target) THEN
        RAISE EXCEPTION 'Users can not report themselves.';
    END IF;
    RETURN NEW;
END
$$
LANGUAGE plpgsql;

CREATE TRIGGER user_report_trigger
    BEFORE INSERT OR UPDATE ON user_report
    FOR EACH ROW
    EXECUTE PROCEDURE user_report();

-- ===== TRIGGER04 =====

-- -- ===== TRIGGER05 =====
-- DROP TRIGGER IF EXISTS event_report_trigger ON event_report;
-- DROP FUNCTION IF EXISTS event_report_trigger;
-- 
-- CREATE FUNCTION event_report() RETURNS TRIGGER AS
-- BEGIN
--     IF EXISTS (SELECT * FROM (OLD LEFT JOIN ))
-- END