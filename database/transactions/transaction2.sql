BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ; -- TODO: Check this

INSERT INTO report (id, id_author, motive)
    VALUES ($id, $id_author, $motive);

INSERT INTO user_report (id_report, target)
    VALUES ($id, $target);

END TRANSACTION;