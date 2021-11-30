BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL READ COMMITTED;

INSERT INTO report (id, id_author, motive)
    VALUES ($id, $id_author, $motive);

INSERT INTO event_report (id_report, target)
    VALUES ($id, $target);

END TRANSACTION;