-- Execute this after installing via Doctrine
-- MySQL only for the moment - need to move to a Doctrine script

DELIMITER $$

-- Add a procedure to recalculate a post's score and store in post.score
DROP PROCEDURE IF EXISTS recalculate_score;
CREATE PROCEDURE recalculate_score (post_id INT)
BEGIN
    UPDATE post AS p SET p.score = IFNULL((SELECT SUM(v.score) FROM vote AS v WHERE v.post_id = post_id), 0), p.scoreUpdatedAt = NOW();
END;

-- Add the score to the post after a new vote
DROP TRIGGER IF EXISTS post_vote_new;
CREATE TRIGGER post_vote_new AFTER INSERT ON vote
FOR EACH ROW
BEGIN
    UPDATE post AS p SET
        p.score = p.score + NEW.score,
        p.scoreUpdatedAt = NOW()
    WHERE p.id = NEW.post_id
    LIMIT 1;
END;

-- Remove the old score and add the new score after a vote is modified
DROP TRIGGER IF EXISTS post_vote_upd;
CREATE TRIGGER post_vote_upd AFTER UPDATE ON vote
FOR EACH ROW
BEGIN
    -- Only if the post_id and user_id are the same, and the score is different
    IF OLD.score <> NEW.score AND OLD.post_id = NEW.post_id AND OLD.user_id = NEW.user_id THEN
        UPDATE post AS p SET
            p.score = (p.score - OLD.score) + NEW.score,
            p.scoreUpdatedAt = NOW()
        WHERE p.id = NEW.post_id
        LIMIT 1;
    END IF;
END;

-- Remove the score when a vote is removed
DROP TRIGGER IF EXISTS post_vote_del;
CREATE TRIGGER post_vote_del AFTER DELETE ON vote
FOR EACH ROW
BEGIN
    UPDATE post AS p SET
        p.score = (p.score - OLD.score),
        p.scoreUpdatedAt = NOW()
    WHERE p.id = OLD.post_id
    LIMIT 1;
END;

$$
