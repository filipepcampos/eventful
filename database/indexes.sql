SET search_path TO lbaw2122;

DROP INDEX IF EXISTS user_event_attendee;
DROP INDEX IF EXISTS event_comment;
DROP INDEX IF EXISTS comment_rating;
DROP INDEX IF EXISTS search_idx;
DROP TRIGGER IF EXISTS event_search_update ON event;
DROP FUNCTION IF EXISTS event_search_update;
ALTER TABLE event DROP COLUMN IF EXISTS tsvectors;


CREATE INDEX user_event_attendee ON attendee USING btree (id_user, id_event);
CREATE INDEX event_comment ON comment USING hash (id_event);
CREATE INDEX comment_rating ON rating USING hash (id_comment);


ALTER TABLE event ADD COLUMN tsvectors TSVECTOR;


CREATE FUNCTION event_search_update() RETURNS TRIGGER AS $$
BEGIN
  IF TG_OP = 'INSERT' THEN
    NEW.tsvectors = (
      setweight(to_tsvector('english', NEW.title), 'A') ||
      setweight(to_tsvector('english', NEW.description), 'B')
    );
  END IF;
  IF TG_OP = 'UPDATE' THEN
      IF (NEW.title <> OLD.title OR NEW.description <> OLD.description) THEN
        NEW.tsvectors = (
          setweight(to_tsvector('english', NEW.title), 'A') ||
          setweight(to_tsvector('english', NEW.description), 'B')
        );
      END IF;
  END IF;
  RETURN NEW;
END $$
LANGUAGE plpgsql;


CREATE TRIGGER event_search_update
  BEFORE INSERT OR UPDATE ON event
  FOR EACH ROW
  EXECUTE PROCEDURE event_search_update();

CREATE INDEX search_idx ON event USING GIN (tsvectors);